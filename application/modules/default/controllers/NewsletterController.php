<?php

class NewsletterController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        $this->view->headTitle()->prepend('Signup For Newletter');

        $newsletterForm = new Default_Form_Newsletter();
        Zend_Registry::set('newsletterForm', $newsletterForm);

        if ($this->getRequest()->isPost()) {
            if ($newsletterForm->isValid($this->_request->getPost())) {
                $n_email = $this->getRequest()->getParam('news_email', null);
                $n_data = array('email' => $n_email);
                $this->insert($n_data);
                $this->_redirect('/wwwroot/newsletter/');
            }else{ 
                $this->view->ErrorMsg='Error';
            }
        }
    }

    private function insert($insertdata) {
        $data = new Default_Model_DbTable_Newsletters();
        $data->insert($insertdata);
    }

    private function checkemail() {
        $data = new Default_Model_DbTable_Newsletters();
        $select = $data->select();
        $select->from($data, array('email'));
        $rows = $data->fetchAll($select);
        return $rows;
    }

}