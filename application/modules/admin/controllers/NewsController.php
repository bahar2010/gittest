<?php
/**
 * @author Darius
 */
class Admin_NewsController extends Zend_Controller_Action
{

    protected $_data = null;

    public function init()
    {
        if($this->_data === null) {
            $this->_data = new Default_Model_DbTable_News();
        }
    }

    public function indexAction()
    {
        $this->view->data = $this->_data->fetchAll();
    }

    public function addAction()
    {
        $form = new Admin_Form_News();
        if($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if($form->isValid($data)) {
                $news = array(
                    'news_title' => $data['title'],
                    'news_text' => $data['text'],
                );
                $this->_data->insert($news);
                $this->_redirect('/admin/news');
            } else {
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

    public function editAction()
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

    public function deleteAction()
    {
        $id = (int)$this->_getParam('id');
        echo $id;
        $this->_data->delete("news_id = ${id}");
        $this->_redirect('/admin/news');
    }
}
