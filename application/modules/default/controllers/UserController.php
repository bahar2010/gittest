<?php

class UserController extends Zend_Controller_Action {

    private $_auth;
    private $user;
	const _famount = 4.99; // 4$ for family account
	const _bamount = 24.99; // 10$ for bussiness account
    public function init() {
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction() {
        $this->_redirect('/user/login');
    }

    public function loginAction() {
		
		$this->view->headTitle()->prepend('Login to your Account ');
		
        $form = new Default_Form_Login();
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $member = new Default_Model_DbTable_Members();
                if (true === $message = $member->login($form->getValue('username'),
                                                       $form->getValue('password'))) {
                    $this->_redirect('/dashboard/');
                } else {
                    $this->view->error = $message;
                }
            }
        }
		
        $this->view->form = $form;
    }

    public function logoutAction() {
        $this->_auth->clearIdentity();
        $this->_redirect('/');
    }

    public function profileAction() {
		
		$this->view->headTitle()->prepend('Your Profile at Phone Tracker ');
		
        $member = new Default_Model_DbTable_Members();
        $this->view->data =$member->find($this->_auth->getIdentity()->member_id)->current()->toArray();
    }
	
	private function CreateForm($type = 1)
	{
		switch($type)
		{
			case 1: // free account
				return new Default_Form_Member();
			case 2: // family account
				$form = new Default_Form_Familymember();
				$form->populate(array('amount' => self::_famount, 'account_type' => 3));
				return $form;
			case 3: // bussiness account
				$form = new Default_Form_Familymember();			
				$form->populate(array('amount' => self::_bamount, 'account_type' => 5));
				return $form;
			default:
				break;
		}
	}
	
	public function familyregisterAction() {
		
		$this->view->headTitle()->prepend('Register for Family Phone Tracker account ');
		
		$form = $this->CreateForm(2);
		
		if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $member = new Default_Model_DbTable_Members();
                //if((!$this->user->checkUsername($form->getValue('username'))) && (!$this->user->checkUsername($form->getValue('email')))) {
                $data = array(
                    'member_username' => $form->getValue('username'),
                    'member_pass' => $form->getValue('password'),
                    'member_email' => $form->getValue('email'),
                    'member_role' => $form->getValue('account_type'),
					//'member_city' => $form->getValue('city'),
					//'member_fullname' => $form->getValue('fullname'),
					//'member_familynumbers' => $form->getValue('familymembers')
                );
                $member->insert($data);
                $this->_redirect('/user/login');
            }
        }
        $this->view->form = $form;
	}
	
	public function businessregisterAction() {
		
		$this->view->headTitle()->prepend('Register for business Phone Tracker account ');
		
		$form = $this->CreateForm(3);
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $member = new Default_Model_DbTable_Members();
                //if((!$this->user->checkUsername($form->getValue('username'))) && (!$this->user->checkUsername($form->getValue('email')))) {
                $data = array(
                    'member_username' => $form->getValue('username'),
                    'member_pass' => $form->getValue('password'),
                    'member_email' => $form->getValue('email'),
                    'member_role' => $form->getValue('account_type'),
					//'member_city' => $form->getValue('city'),
					//'member_fullname' => $form->getValue('fullname'),
					//'member_familynumbers' => $form->getValue('familymembers')
                );
                $member->insert($data);
                $this->_redirect('/user/login');
            }
        }
        $this->view->form = $form;
	}
	
	public function registerAction() {
	
	}
	
    public function freeregisterAction() {
		
		$this->view->headTitle()->prepend('Register for free Phone Tracker account ');
		
		
        $form = $this->CreateForm();
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $member = new Default_Model_DbTable_Members();
                //if((!$this->user->checkUsername($form->getValue('username'))) && (!$this->user->checkUsername($form->getValue('email')))) {
                $data = array(
                    'member_username' => $form->getValue('username'),
                    'member_pass' => $form->getValue('password'),
                    'member_email' => $form->getValue('email'),
                    'member_role' => $form->getValue('account_type'),
					//'member_city' => $form->getValue('city'),
					//'member_fullname' => $form->getValue('fullname'),
					//'member_familynumbers' => $form->getValue('familymembers')
                );
                $member->insert($data);
                $this->_redirect('/user/login');
            }
        }
        $this->view->form = $form;
		
    }
	
    public function changePasswordAction()
    {
		
		$this->view->headTitle()->prepend('change your Phone Tracker account password here');
		
    	$form = new Default_Form_Password();
    	if ($this->_request->isPost()) {
    		if ($form->isValid($this->_request->getPost())) {
    			$member = new Default_Model_DbTable_Members();
    			$data = array('member_pass' => $form->getValue('new'));
    			$where = 'member_id = ' . Zend_Auth::getInstance()->getIdentity()->member_id . ' ';
    			$member->update($data, $where);
    			$this->_redirect('/user/profile');
    		}
    	}
    	$this->view->form = $form;
    }
 	
	public function changeEmailAction()
    {
    
    }
    /**
	 * Ajax action that returns the dynamic form field
	 */
	public function newfieldAction() {	 
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
		$ajaxContext->addActionContext('newfield', 'html')->initContext();

		//$id = $this->_getParam('id', null);

		$element = new Zend_Form_Element_Text("newName");
		$element->setRequired(true)->setLabel('Name');

		$this->view->field = $element->__toString();
		return $element->__toString();
	}
	
	private function processPaypal()
	{	
		// Live URL: https://api-3t.paypal.com/nvp
		// Test URL: https://api-3t.sandbox.paypal.com/nvp
		$url = 'https://api-3t.paypal.com/nvp';

		$amount = $this->getRequest()->getParam('amount');; // Obviously, we would sum up the contents of some cart to fill in this value.
		$credit_card_type = $this->getRequest()->getParam('cardtype');
		$credit_card_number = $this->getRequest()->getParam('cardnumber');
		$expiration_month = $this->getRequest()->getParam('expiration_month');
		$expiration_year = $this->getRequest()->getParam('expiration_year');
		$cvv2 = $this->getRequest()->getParam('cvv2');

		$first_name = $this->getRequest()->getParam('firstname');
		$last_name = $this->getRequest()->getParam('lastname');
		$address1 = $this->getRequest()->getParam('addressline1');
		$address2 = $this->getRequest()->getParam('addressline2');
		$city = $this->getRequest()->getParam('city');
		$state = $this->getRequest()->getParam('state');
		$zip = $this->getRequest()->getParam('zip');

		$country = 'US'; // Assuming we are only accepting transactions within the United States.
		$currency_code = 'USD'; // Assuming we are using the United States Dollar
		$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP Address, assuming we are in a LAMP environment

		// Create an instance of our PayPal NVP client
		$client = new Zend_Paypal_Client($url);

		// Send our API request!
		$result = $client->doDirectPayment(
			$amount,
			$credit_card_type,
			$credit_card_number,
			$expiration_month,
			$expiration_year,
			$cvv2,
			$first_name,
			$last_name,
			$address1,
			$address2,
			$city,
			$state,
			$zip,
			$country,
			$currency_code,
			$ip_address);

		// Remember to store the transaction ID! You'll need it 
		// to lookup the transaction details. For now, let's just
		// display the results.
		echo $result->getBody();	
	}
}

