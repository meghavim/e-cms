<?php

namespace Page\Form;

 use Zend\Form\Form;

 class PageForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('page');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'title',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Title',
             ),
         ));
         $this->add(array(
             'name' => 'description',
             'type' => 'Textarea',
             'attributes'=> array(
                'rows' => '20', 
                ),
             'options' => array(
                 'label' => 'Description',
             ),
         ));
          $this->add(array(
             'type' => 'Radio',
             'name' => 'publish',
             'options' => array(
                     'label' => 'Published',
                     'value_options' => array(
                             '1' => 'Yes',
                             '0' => 'No',
                     ),
             )
     ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }
?>