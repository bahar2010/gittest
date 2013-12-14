<?php

class ProcessController extends Zend_Controller_Action
{

    public function init()
    {
	
    }

    public function indexAction()
    {

	  $this->_helper->layout->disableLayout();
        $location = new Zend_Db_Table('location');
	  $user_id    = $this->_request->getParam('user_id', 1); 
	  $latitude   = $this->_request->getParam('latitude', null);
	  $longitude = $this->_request->getParam('longitude', null);
	  $location->insert( array( 'user_id'=>$user_id,  'latitude'=>$latitude,   'longitude'=>$longitude ) );

    }



    public function processAction()
    {
 		$this->view->headTitle()->prepend('Test Form');

    }


}