<?php
 namespace User\Form;

 use Zend\Form\Form;

 class UserForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('user');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'e_email',
             'type' => 'Email',
             'options' => array(
                 'label' => 'Email: ',
             ),
         ));
         $this->add(array(
             'name' => 'e_password',
             'type' => 'Password',
             'options' => array(
                 'label' => 'Password: ',
             ),
         ));
         $this->add(array(
             'name' => 'retype_password',
             'type' => 'Password',
             'options' => array(
                 'label' => 'Retype Password: ',
             ),
         ));
         $this->add(array(
             'name' => 'e_type',
             'type' => 'select',
             'options' => array(
                 'label' => 'User Type: ',
                 'empty_option' => 'Select User Type',
                 'value_options' => array(
                             '0' => 'superadmin',
                             '1' => 'admin',
                     ),
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Save',
                 'id' => 'usersubmitbutton',
             ),
         ));
     }
 }
?>