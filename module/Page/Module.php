<?php

namespace Page;


 use Page\Model\Page;
 use Page\Model\PageTable;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;

class Module
{
   
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


      // Add this method:
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Page\Model\PageTable' =>  function($sm) {
                     $tableGateway = $sm->get('PageTableGateway');
                     $table = new PageTable($tableGateway);
                     return $table;
                 },
                 'PageTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Page());
                     return new TableGateway('e_page', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
}

?>