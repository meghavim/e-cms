<?php
 namespace User\Model;

 // Add these import statements
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 

 class User implements InputFilterAwareInterface
 {
     public $id;
     public $e_email;
     public $e_password;
     public $e_type;
     protected $inputFilter;                       // <-- Add this variable

     public function exchangeArray($data)
     {
         $this->id     = (isset($data['id']))     ? $data['id']     : null;
         $this->e_email = (isset($data['e_email'])) ? $data['e_email'] : null;
         $this->e_password = (isset($data['e_password'])) ? md5($data['e_password']) : null;
         $this->e_type = (isset($data['e_type'])) ? $data['e_type'] : null;
     }
     
     // Add the following method:
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
     
     
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
             $inputFilter->add(array(
                 'name'     => 'e_email',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'e_password',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 3,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'retype_password',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'Identical',
                         'options' => array(
                             'token' => 'e_password',
                             'encoding' => 'UTF-8',
                             'min'      => 3,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }

 ?>