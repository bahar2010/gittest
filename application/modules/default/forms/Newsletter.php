<?php

class Default_Form_Newsletter extends Zend_Form {

    public function init() {
        $this->setDisableLoadDefaultDecorators(true);

        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => 'form/newsletterform.phtml')),
            'Form'
        ));
        
        $this->setMethod('post');
        $this->setAction('/newsletter/index');

        $this->addElement('text', 'news_email', array(
            'decorators' => array(
                'ViewHelper',
               'Errors'
            ),
            'required' => TRUE,
            'validators' => array('EmailAddress',array(new Zend_Validate_Db_NoRecordExists(
						'newsletters',
						'email'                   
                        ), TRUE )),
            //'Errors'=>array('Email address is required'),
            'placeholder' => 'Enter your email address'
        ));


        $this->addElement('submit', 'submit-button', array(
            'decorators' => array(
                'ViewHelper'
            ),
            'label' => 'Subscribe',
            'class' => "button expand",
            'style' => "padding: 3px 20px 9px;"
        ));
    }

}