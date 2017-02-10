<?php

namespace Test\YourOwnFramework\Db;

use PHPUnit\Framework\TestCase;
use YourOwnFramework\Db\ErzatsQueryBuilder;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class ErzatsQueryBuilderTest extends TestCase
{
    public function testInsertQuery()
    {
        $builder = new ErzatsQueryBuilder();
        $query = $builder->getInsertQuery(['id'], 'table');

        $this->assertEquals("                INSERT INTO table (id) VALUES (:id)", $query);
    }

    public function testUpdateQuery()
    {
        $builder = new ErzatsQueryBuilder();
        $query = $builder->getUpdateQuery(['id'], 'table', 'id');

        $this->assertEquals("            UPDATE table SET  WHERE id = :id;", $query);
    }

    public function testSelectQuery()
    {
        $builder = new ErzatsQueryBuilder();
        $query = $builder->getSelectQuery(['id'], 'table', 'id');

        $this->assertEquals("            SELECT * FROM table WHERE id", $query);
    }
}
