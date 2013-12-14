<?php

class Dashboard_NewsController extends Zend_Controller_Action
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
       $Identity = Zend_Auth::getInstance()->getIdentity()->member_id;
          
                 $db = Zend_Db::factory('Pdo_Mysql', array(
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'winwinhost'
            ));
         
           $this->_data = new Default_Model_DbTable_News();
   		   $this->view->data = $this->_data->fetchAll();
    }

    public function addAction()
    {
        $form = new Dashboard_Form_News();
        if($this->_request->isPost()) {
            $data = $this->_request->getPost();
           
            if($form->isValid($data)) {
                //
                 $id = (int) $form->getValue('id');
                //
                $upload = new Zend_File_Transfer_Adapter_Http();
                $fileinfo = $upload->getFileInfo();
                $upload->setDestination('uploads/newsimages/');
                $fname=rand().'_'.$fileinfo['file']['name'];
                $upload->addFilter('Rename','uploads/newsimages/'.$fname);
                //print_r($fname);
                $upload->receive();
                //exit('444444444');
                
                $news = array(
                    'news_title' => $data['title'],
                    'news_text' => $data['text'],
                    'image' => $fname,
                    'cat_id' =>$data['cat_id'],
                    'member_id' => Zend_Auth::getInstance()->getIdentity()->member_id
                );
                $this->_data->insert($news);
                $this->_redirect('/dashboard/news');
            } else {
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

    public function editAction()
    {
        $id = $this->_getParam('id');
        $form = new Dashboard_Form_News();
        $data = $this->_data->fetchRow("news_id = ${id}");
        $form->getElement('title')->setValue($data->news_title);
        $form->getElement('text')->setValue($data->news_text);
        $form->getElement('cat_id')->setValue($data->cat_id);
       $form->getElement('file')->setRequired(false)
                                  ->setValidators(array());  
        $form->getElement('submit')->setLabel('Save');
        
          if($this->_request->isPost()) {
            $post = $this->_request->getPost();
            $upload = new Zend_File_Transfer_Adapter_Http();
            //echo '<pre>';
            $fileinfo = $upload->getFileInfo();
             //print_r($fileinfo);
            if($fileinfo['file']['name']!=''){
                $form->getElement('file')
                        ->setRequired(true)
                        ->addValidator('NotEmpty')
                        ->addValidator('Extension', false, 'jpg,png,gif,jpeg')
                        ->addValidator('Count', false, 1);
            
            } 
            
            if($form->isValid($post)) {
                
             if($fileinfo['file']['name']!=''){
               
            $upload->setDestination('uploads/newsimages/');
                $fname=rand().'_'.$fileinfo['file']['name'];
                $upload->addFilter('Rename','uploads/newsimages/'.$fname);
                //print_r($fname);
                $upload->receive();
                $news = array(
                    'news_title' => $post['title'],
                    'news_text' => $post['text'],
                    'image' => $fname,
                    'cat_id' =>$post['cat_id']
                );
            }  else {
            $news = array(
                    'news_title' => $post['title'],
                    'news_text' => $post['text'],
                'cat_id' =>$post['cat_id']
                );    
            }
                
                $this->_data->update($news,  "news_id = ${id}");
                $this->_redirect('/dashboard/news');
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
        $this->_redirect('/dashboard/news');
    }
}