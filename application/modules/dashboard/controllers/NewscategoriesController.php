<?php

class Dashboard_NewscategoriesController extends Zend_Controller_Action {

    protected $_data = null;

    public function init() {
        if ($this->_data === null) {
            $this->_data = new Dashboard_Model_DbTable_NewsCategories();
        }
    }

    public function indexAction() {
        $Identity = Zend_Auth::getInstance()->getIdentity()->member_id;

        $db = Zend_Db::factory('Pdo_Mysql', array(
                    'host' => 'localhost',
                    'username' => 'root',
                    'password' => '',
                    'dbname' => 'winwinhost'
                ));

        $this->_data = new Dashboard_Model_DbTable_NewsCategories();
        $this->view->data = $this->_data->fetchAll();
    }

    public function addAction() {
        $form = new Dashboard_Form_NewsCategories();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                /* $upload = new Zend_File_Transfer_Adapter_Http();
                  $fileinfo = $upload->getFileInfo();
                  $upload->setDestination('uploads/newsimages/');
                  $fname=rand().'_'.$fileinfo['file']['name'];
                  $upload->addFilter('Rename','uploads/newsimages/'.$fname);
                  //print_r($fname);
                  $upload->receive(); */
                //exit('444444444');

                $news = array(
                    'name' => $data['name'],
                );
                $this->_data->insert($news);
                $this->_redirect('/dashboard/newscategories');
            } else {
                $form->populate($data);
            }
        }
        $this->view->form = $form;
    }

    public function editAction() {
        $id = $this->_getParam('id');
        $form = new Dashboard_Form_NewsCategories();
        $data = $this->_data->fetchRow("id = ${id}");
        $form->getElement('name')->setValue($data->name);
        /* $form->getElement('text')->setValue($data->news_text);
          $form->getElement('file')->setRequired(false)
          ->setValidators(array()); */
        $form->getElement('submit')->setLabel('Save');

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            $upload = new Zend_File_Transfer_Adapter_Http();
            //echo '<pre>';
            $fileinfo = $upload->getFileInfo();
            //print_r($fileinfo);
            /* if($fileinfo['file']['name']!=''){
              $form->getElement('file')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->addValidator('Extension', false, 'jpg,png,gif,jpeg')
              ->addValidator('Count', false, 1);

              } */

            if ($form->isValid($post)) {

                /* if($fileinfo['file']['name']!=''){

                  $upload->setDestination('uploads/newsimages/');
                  $fname=rand().'_'.$fileinfo['file']['name'];
                  $upload->addFilter('Rename','uploads/newsimages/'.$fname);
                  //print_r($fname);
                  $upload->receive();
                  $news = array(
                  'name' => $post['name'],
                  //'news_text' => $post['text'],
                  //'image' => $fname
                  );
                  }  else { */
                $news = array(
                    'name' => $post['name'],
                );
                // }

                $this->_data->update($news, "id = ${id}");
                $this->_redirect('/dashboard/newscategories');
            } else {
                $form->populate($post);
            }
        }
        $this->view->form = $form;
    }

    public function deleteAction() {
        $id = (int) $this->_getParam('id');
        echo $id;
        $this->_data->delete("id = ${id}");
        $this->_redirect('/dashboard/newscategories');
    }

}