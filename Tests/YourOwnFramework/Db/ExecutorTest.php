<?php

namespace Test\YourOwnFramework\Db;

use PHPUnit\Framework\TestCase;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class ExecutorTest extends TestCase
{
    public function testSelect()
    {
        $queryBuilderMock = $this->getMockBuilder(\YourOwnFramework\Db\ErzatsQueryBuilder::class)->setMethods(['getSelectQuery'])->getMock();

        $sthMock = $this->getMockBuilder(\PDOStatement::class)->setMethods(['execute', 'fetchAll'])->getMock();
        $sthMock->expects($this->once())->method('execute');
        $sthMock->expects($this->once())->method('fetchAll');

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['prepare'])->getMock();
        $dbMock->expects($this->once())->method('prepare')->willReturn($sthMock);

        $executor = new \YourOwnFramework\Db\Executor($dbMock, $queryBuilderMock);
        $executor->select('table', '');
    }

    public function testInsert()
    {
        $expectedId = 100500;

        $queryBuilderMock = $this->getMockBuilder(\YourOwnFramework\Db\ErzatsQueryBuilder::class)->setMethods(['getInsertQuery'])->getMock();

        $sthMock = $this->getMockBuilder(\PDOStatement::class)->setMethods(['execute'])->getMock();
        $sthMock->expects($this->once())->method('execute')->willReturn(true);

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['prepare', 'lastInsertId'])->getMock();
        $dbMock->expects($this->once())->method('prepare')->willReturn($sthMock);
        $dbMock->expects($this->once())->method('lastInsertId')->willReturn($expectedId);

        $executor = new \YourOwnFramework\Db\Executor($dbMock, $queryBuilderMock);
        $result = $executor->insert('table', []);

        $this->assertEquals($result, $expectedId);
    }

    public function testInsertFail()
    {
        $queryBuilderMock = $this->getMockBuilder(\YourOwnFramework\Db\ErzatsQueryBuilder::class)->setMethods(['getInsertQuery'])->getMock();

        $sthMock = $this->getMockBuilder(\PDOStatement::class)->setMethods(['execute'])->getMock();
        $sthMock->expects($this->once())->method('execute')->willReturn(false);

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['prepare', 'lastInsertId'])->getMock();
        $dbMock->expects($this->once())->method('prepare')->willReturn($sthMock);
        $dbMock->expects($this->never())->method('lastInsertId');

        $executor = new \YourOwnFramework\Db\Executor($dbMock, $queryBuilderMock);
        $result = $executor->insert('table', []);

        $this->assertFalse($result);
    }

    public function testUpdate()
    {
        $queryBuilderMock = $this->getMockBuilder(\YourOwnFramework\Db\ErzatsQueryBuilder::class)->setMethods(['getUpdateQuery'])->getMock();

        $sthMock = $this->getMockBuilder(\PDOStatement::class)->setMethods(['execute'])->getMock();
        $sthMock->expects($this->once())->method('execute')->willReturn(false);

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['prepare'])->getMock();
        $dbMock->expects($this->once())->method('prepare')->willReturn($sthMock);

        $executor = new \YourOwnFramework\Db\Executor($dbMock, $queryBuilderMock);
        $executor->update('table', '', []);
    }

    public function testQuery()
    {
        $queryBuilderMock = $this->getMockBuilder(\YourOwnFramework\Db\ErzatsQueryBuilder::class)->getMock();

        $sthMock = $this->getMockBuilder(\PDOStatement::class)->setMethods(['execute'])->getMock();

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['prepare'])->getMock();
        $dbMock->expects($this->once())->method('prepare')->willReturn($sthMock);

        $executor = new \YourOwnFramework\Db\Executor($dbMock, $queryBuilderMock);
        $executor->query('query', []);
    }
}
