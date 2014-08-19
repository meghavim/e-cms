<?php
namespace User\Model;

 use Zend\Db\TableGateway\TableGateway;

 class UserTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getUser($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveUser(User $user)
     {
         $data = array(
             'e_email' => $user->e_email,
             'e_password'  => md5($user->e_password),
             'e_type'  => $user->e_type,
         );

 // $data = array($user->email, md5($user->password), $user->type );

         $id = (int) $user->id;
         if ($id == 0) {



               // Get adapter 
        $dbAdapter = $this->tableGateway->getAdapter(); 

        $stmt = $dbAdapter->createStatement(); 
        $stmt->prepare('{CALL SP_E_USER_SAVE(?,?,?,?)}'); 
        $stmt->getResource()->bindParam(1, $data['e_email'], \PDO::PARAM_STR); 
    $stmt->getResource()->bindParam(2, $data['e_password']); 

    $stmt->getResource()->bindParam(3, $data['e_type']); 

    $stmt->getResource()->bindParam(4, $id); 

 $stmt->execute();


        // check is there any error in sql server query/procedure
   //     $stmterror = $stmt->errorInfo();    
     //   print_r($stmterror);
            
//
         //    $this->tableGateway->dbAdapter->query('EXEC SP_E_USER_SAVE(?,?,?)',array('meghavisavlia@gmail.com','123123','1'));
         } else {
             if ($this->getUser($id)) {

                 $dbAdapter = $this->tableGateway->getAdapter(); 

        $stmt = $dbAdapter->createStatement(); 
        $stmt->prepare('{CALL SP_E_USER_SAVE(?,?,?,?)}'); 
        $stmt->getResource()->bindParam(1, $data['e_email']); 
    $stmt->getResource()->bindParam(2, $data['e_password']); 

    $stmt->getResource()->bindParam(3, $data['e_type']); 

    $stmt->getResource()->bindParam(4, $id); 

    $stmt->execute();

              //   $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('User id does not exist');
             }
         }
     }

     public function deleteUser($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
 ?>