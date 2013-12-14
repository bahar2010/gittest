<?php

class UserController extends Zend_Controller_Action {

    private $_auth;
    private $user;

    public function init() {
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction() {
        $this->_redirect('/user/login');
    }

    public function loginAction() {
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
        $member = new Default_Model_DbTable_Members();
        $this->view->data =$member->find($this->_auth->getIdentity()->member_id)->current()->toArray();
    }

    public function registerAction() {
        $form = new Default_Form_Member();

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
    
}

