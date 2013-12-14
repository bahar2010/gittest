<?php

class Dashboard_Form_News extends Zend_Form {

    public function init() {
        //news title, news text
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title')
                ->setRequired(true)
                ->addFilter(new Zend_Filter_Alpha(true))
                ->setOptions(array('style'=>'width:618px;'))
                ->setValidators(array('NotEmpty'));
        $title->class = "wpcf7";

        $text = new Zend_Form_Element_Textarea('text');
        $text->setRequired(true)
                ->setLabel('Content')
                //->addFilter(new Zend_Filter_Alpha(true))
                ->setOptions(array('cols' => '150', 'rows' => '15','style'=>'width:618px;height:200px;'))
                ->setValidators(array('NotEmpty'));
        $text->class = "span8 jqte";

        $file = new Zend_Form_Element_File('file');
        $file->setLabel('Image')
                //->setDestination(APPLICATION_PATH . '\images')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->addValidator('Extension', false, 'jpg,png,gif,jpeg')
                ->addValidator('Count', false, 1);
        //$this->addElement($file);
         $this->addElement(new Dashboard_Form_NewsSelect('cat_id'));

        $submit = new Zend_Form_Element_Submit('submit', 'Create');
        $submit->class = "wpcf7-submit";

        $this->addElements(array(
            $title,
            $text,
            $file,
            $submit
        ));
    }

}