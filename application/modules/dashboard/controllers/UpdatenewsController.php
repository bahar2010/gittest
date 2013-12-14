<?php

class Dashboard_UpdatenewsController extends Zend_Controller_Action
{
    public function init()
    {
       
    }


	public function indexAction()
    {
      
	   $id = $this->_getParam('id');
        $form = new Admin_Form_News();
        $data = $this->_data->fetchRow("news_id = ${id}");
        $form->getElement('title')->setValue($data->news_title);
        $form->getElement('text')->setValue($data->news_text);
          if($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if($form->isValid($post)) {
                $news = array(
                    'news_title' => $post['title'],
                    'news_text' => $post['text'],
                );
                $this->_data->update($news,  "news_id = ${id}");
                $this->_redirect('/admin/news');
            } else {
                $form->populate($post);
            }
          }
        $this->view->form = $form;
     
   }


	
}





