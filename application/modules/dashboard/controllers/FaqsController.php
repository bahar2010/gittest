<?php

class Dashboard_FaqsController extends Zend_Controller_Action
{

    protected $_data = null;

    public function init()
    {
       if($this->_data === null) {
            $this->_data = new Default_Model_DbTable_Faqs();
        }
    }

    public function indexAction()
    {
       $Identity = Zend_Auth::getInstance()->getIdentity()->member_id;
          
                 $db = Zend_Db::factory('Pdo_Mysql', array(
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'winwinhost'
            ));
         
           $this->_data = new Default_Model_DbTable_Faqs();
   		   $this->view->data = $this->_data->fetchAll();
    }

    public function addAction()
    {
        $form = new Dashboard_Form_Faqs();
        if($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if($form->isValid($data)) {
                $news = array(
                    'faq_title' => $data['title'],
                    'faq_text' => $data['text'],
					'faq_category' => $data['category'],
                );
                $this->_data->insert($news);
                $this->_redirect('/dashboard/faqs');
            } else {
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

    public function editAction()
    {
        $id = $this->_getParam('id');
        $form = new Dashboard_Form_Faqs();
        $data = $this->_data->fetchRow("faq_id = ${id}");
        $form->getElement('title')->setValue($data->faq_title);
        $form->getElement('text')->setValue($data->faq_text);
          if($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if($form->isValid($post)) {
                $news = array(
                    'faq_title' => $post['title'],
                    'faq_text' => $post['text'],
					'faq_category' => $post['category'],
                );
                $this->_data->update($news,  "faq_id = ${id}");
                $this->_redirect('/dashboard/faqs');
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
        $this->_data->delete("faq_id = ${id}");
        $this->_redirect('/dashboard/faq');
    }
}
