<?php
class Dashboard_Form_NewsCategories extends Zend_Form {

    public function init() {
        //news title, news text
        $title = new Zend_Form_Element_Text('name');
        $title->setLabel('Name')
                ->setRequired(true)
                ->addFilter(new Zend_Filter_Alpha(true))
                ->setOptions(array('style'=>'width:618px;'))
                ->setValidators(array('NotEmpty'));
        $title->class = "wpcf7";

        $submit = new Zend_Form_Element_Submit('submit', 'Create');
        $submit->class = "wpcf7-submit";

        $this->addElements(array(
            $title,
            $submit
        ));
    }

}