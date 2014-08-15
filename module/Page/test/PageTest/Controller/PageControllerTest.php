<?php

namespace PageTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class PageControllerTest extends AbstractHttpControllerTestCase
{
	
	protected $traceError = true;

    public function setUp()
    {
        $this->setApplicationConfig(
            include '/config/application.config.php'
        );
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
	{
		$pageTableMock = $this->getMockBuilder('Page\Model\PageTable')
                            ->disableOriginalConstructor()
                            ->getMock();

    $pageTableMock->expects($this->once())
                    ->method('fetchAll')
                    ->will($this->returnValue(array()));

    $serviceManager = $this->getApplicationServiceLocator();
    $serviceManager->setAllowOverride(true);
    $serviceManager->setService('Page\Model\PageTable', $pageTableMock);


	    $this->dispatch('/page');
	    $this->assertResponseStatusCode(200);

	    $this->assertModuleName('Page');
	    $this->assertControllerName('Page\Controller\Page');
	    $this->assertControllerClass('PageController');
	    $this->assertMatchedRouteName('page');
	}

	public function testAddActionRedirectsAfterValidPost()
	{
	    $pageTableMock = $this->getMockBuilder('Page\Model\PageTable')
	                            ->disableOriginalConstructor()
	                            ->getMock();

	    $pageTableMock->expects($this->once())
	                    ->method('savePage')
	                    ->will($this->returnValue(null));

	    $serviceManager = $this->getApplicationServiceLocator();
	    $serviceManager->setAllowOverride(true);
	    $serviceManager->setService('Page\Model\PageTable', $pageTableMock);

	 /* 
it was giving error 
	   $postData = array(
	        'title'  => 'Led Zeppelin III',
	        'artist' => 'Led Zeppelin',
	    );*/

	    $postData = array(
'id' => '',
'title' => 'Led Zeppelin III',
'artist' => 'Led Zeppelin',
);


	    $this->dispatch('/page/add', 'POST', $postData);
	    $this->assertResponseStatusCode(302);

	   // $this->assertRedirectTo('/page');

	    $this->assertRedirectTo('/page/');
	}


}