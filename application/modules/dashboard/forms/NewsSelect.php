<?php

class  Dashboard_Form_NewsSelect extends Zend_Form_Element_Select {

    public function init() {
        $newsTb = new Dashboard_Model_DbTable_NewsCategories();
        $this->setLabel('News Categories')
                //->addValidator('Count', false, 0)
            ->setValidators(array('NotEmpty'));
        //$this->addMultiOption(0, 'Please select...');
        foreach ($newsTb->fetchAll() as $news) {
            $this->addMultiOption($news->id, $news->name);
        }
    }

}
