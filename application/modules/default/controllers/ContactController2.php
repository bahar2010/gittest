<?php

class ContactController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function doneAction()
    {
        $this->view->headTitle()->prepend('Thankyou for writing us at Phone Tracker');
    }

    public function indexAction()
    {
		$this->view->headTitle()->prepend('Ask Us anything about Phone Tracker Phone App and Web App');
    	$smtpConfigs = array(
            
            'auth'          =>      'login',
            'username'      =>      'phonetrackerdotnet@gmail.com',
            'password'      =>      'ERzZzxxs3CVMxZje2',
            'ssl'           =>      'ssl',
            'port'          =>       465
            
        );
        
        $smtpTransportObject = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $smtpConfigs);
        
        $mail = new Zend_Mail();

        $form = new Default_Form_ContactUs();

        $this->view->ContactForm = $form;


        
        	
        	if ($this->getRequest()->isPost())
        	{
        	 $formData = $this->getRequest()->getPost();
                   if($form->isValid($formData))
                    {
        	    		$mail->addTo('phonetrackerdotnet@gmail.com')
                         ->setFrom('phonetrackerdotnet@gmail.com', "Phone-Tracker.net ")
             		 	 ->setSubject('Query at Phone-Tracker.net')
            			 ->setBodyText(" <br /> Name : ".$form->getValue('name')." <br /> Email : ".$form->getValue('email')." <br /> Phone Number : ".$form->getValue('phone')."  <br /> Message : ".$form->getValue('description'))
             		     ->send($smtpTransportObject);

                         $this->_redirect('contact/done');
           
                        $this->view->message = "your email has been sent";
                    
                    } 
                }
                        
                    }                   
                        
 }