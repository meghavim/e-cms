<?php
namespace PageTest\Model;

use Page\Model\PageTable;
use Page\Model\Page;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class PageTableTest extends PHPUnit_Framework_TestCase
{
    public function testFetchAllReturnsAllPages()
    {
        $resultSet = new ResultSet();
        $mockTableGateway = $this->getMock(
            'Zend\Db\TableGateway\TableGateway',
            array('select'),
            array(),
            '',
            false
        );
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with()
                         ->will($this->returnValue($resultSet));

        $pageTable = new PageTable($mockTableGateway);

        $this->assertSame($resultSet, $pageTable->fetchAll());
    }



public function testCanRetrieveAnPageByItsId()
{
    $page = new Page();
    $page->exchangeArray(array('id'     => 123,
                                'artist' => 'The Military Wives',
                                'title'  => 'In My Dreams'));

    $resultSet = new ResultSet();
    $resultSet->setArrayObjectPrototype(new Page());
    $resultSet->initialize(array($page));

    $mockTableGateway = $this->getMock(
        'Zend\Db\TableGateway\TableGateway',
        array('select'),
        array(),
        '',
        false
    );
    $mockTableGateway->expects($this->once())
                     ->method('select')
                     ->with(array('id' => 123))
                     ->will($this->returnValue($resultSet));

    $pageTable = new PageTable($mockTableGateway);

    $this->assertSame($page, $pageTable->getPage(123));
}

public function testCanDeleteAnPageByItsId()
{
    $mockTableGateway = $this->getMock(
        'Zend\Db\TableGateway\TableGateway',
        array('delete'),
        array(),
        '',
        false
    );
    $mockTableGateway->expects($this->once())
                     ->method('delete')
                     ->with(array('id' => 123));

    $pageTable = new PageTable($mockTableGateway);
    $pageTable->deletePage(123);
}

public function testSavePageWillInsertNewPagesIfTheyDontAlreadyHaveAnId()
{
    $pageData = array(
        'artist' => 'The Military Wives',
        'title'  => 'In My Dreams'
    );
    $page     = new Page();
    $page->exchangeArray($pageData);

    $mockTableGateway = $this->getMock(
        'Zend\Db\TableGateway\TableGateway',
        array('insert'),
        array(),
        '',
        false
    );
    $mockTableGateway->expects($this->once())
                     ->method('insert')
                     ->with($pageData);

    $pageTable = new PageTable($mockTableGateway);
    $pageTable->savePage($page);
}

public function testSavePageWillUpdateExistingPagesIfTheyAlreadyHaveAnId()
{
    $pageData = array(
        'id'     => 123,
        'artist' => 'The Military Wives',
        'title'  => 'In My Dreams',
    );
    $page     = new Page();
    $page->exchangeArray($pageData);

    $resultSet = new ResultSet();
    $resultSet->setArrayObjectPrototype(new Page());
    $resultSet->initialize(array($page));

    $mockTableGateway = $this->getMock(
        'Zend\Db\TableGateway\TableGateway',
        array('select', 'update'),
        array(),
        '',
        false
    );
    $mockTableGateway->expects($this->once())
                     ->method('select')
                     ->with(array('id' => 123))
                     ->will($this->returnValue($resultSet));
    $mockTableGateway->expects($this->once())
                     ->method('update')
                     ->with(
                        array(
                            'artist' => 'The Military Wives',
                            'title'  => 'In My Dreams'
                        ),
                        array('id' => 123)
                     );

    $pageTable = new PageTable($mockTableGateway);
    $pageTable->savePage($page);
}

public function testExceptionIsThrownWhenGettingNonExistentPage()
{
    $resultSet = new ResultSet();
    $resultSet->setArrayObjectPrototype(new Page());
    $resultSet->initialize(array());

    $mockTableGateway = $this->getMock(
        'Zend\Db\TableGateway\TableGateway',
        array('select'),
        array(),
        '',
        false
    );
    $mockTableGateway->expects($this->once())
                     ->method('select')
                     ->with(array('id' => 123))
                     ->will($this->returnValue($resultSet));

    $pageTable = new PageTable($mockTableGateway);

    try {
        $pageTable->getPage(123);
    }
    catch (\Exception $e) {
        $this->assertSame('Could not find row 123', $e->getMessage());
        return;
    }

    $this->fail('Expected exception was not thrown');
}

}