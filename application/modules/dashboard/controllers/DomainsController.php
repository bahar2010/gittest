<?php

class Dashboard_DomainsController extends Zend_Controller_Action
{

    protected $_data = null;

    public function init()
    {
       if($this->_data === null) {
            $this->_data = new Default_Model_DbTable_domainPrices();
        }
    }

    public function indexAction()
    {

           $this->_data = new Default_Model_DbTable_domainPrices();
   		   $this->view->data = $this->_data->fetchAll();
    }

 public function addAction()
    {
        $form = new Dashboard_Form_Domains();
        if($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if($form->isValid($data)) {
                $domains = array(
                    'ext' => $data['ext'],
                    'price' => $data['price'],
					'price_renew' => $data['price_renew'],
                    'price_2years' => $data['price_2years'],
					'price_3years' => $data['price_3years'],
                    'price_5years' => $data['price_5years'],
					'price_10years' => $data['price_10years'],
                );
                $this->_data->insert($domains);
                $this->_redirect('/dashboard/domains');
            } else {
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

    public function editAction()
    {
        $id = $this->_getParam('id');
        $form = new Dashboard_Form_Domains();
        $data = $this->_data->fetchRow($this->_data->select()->where('id = ?', $id));
		if (empty($data)) {
			 $this->_redirect('/dashboard/domains');
			 exit(1);
		}
        $form->getElement('ext')->setValue($data->ext);
        $form->getElement('price')->setValue($data->price);
		$form->getElement('price_renew')->setValue($data->price_renew);
        $form->getElement('price_2years')->setValue($data->price_2years);
		$form->getElement('price_3years')->setValue($data->price_3years);
        $form->getElement('price_5years')->setValue($data->price_5years);
		$form->getElement('price_10years')->setValue($data->price_10years);
        $form->getElement('price')->setValue($data->price);
        if($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if($form->isValid($post)) {
                $domains = array(
                    'ext' => $post['ext'],
                    'price' => $post['price'],
					'price_renew' => $post['price_renew'],
					'price_2years' => $post['price_2years'],
					'price_3years' => $post['price_3years'],
					'price_5years' => $post['price_5years'],
					'price_10years' => $post['price_10years'],
                );
                $this->_data->update($domains, array('id = ?' => $id));
                $this->_redirect('/dashboard/domains');
            } else {
                $form->populate($post);
            }
        }
        $this->view->form = $form;
    }
	
    public function deleteAction()
    {
        $id = (int)$this->_getParam('id');
        echo $id;
        $this->_data->delete("id = ${id}");
        $this->_redirect('/dashboard/domains');
    }
}
