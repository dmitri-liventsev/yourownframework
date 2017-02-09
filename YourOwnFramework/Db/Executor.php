<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */

namespace YourOwnFramework\Db;

use PDO;

class Executor
{
    const CONTAINER_KEY = 'executor';

    /**
     * @var PDO
     */
    private $db;

    /**
     * Executor constructor.
     * @param PDO $db
     * @param ErzatsQueryBuilder $queryBuilder
     */
    public function __construct(PDO $db, ErzatsQueryBuilder $queryBuilder)
    {
        $this->db = $db;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param string $table
     * @param string|array $where
     * @param array $params
     *
     * @return array
     */
    public function select(string $table, $where, array $params = [])
    {
        $query = $this->queryBuilder->getSelectQuery($where, $table);
        $sth = $this->db->prepare($query);

        $sth->execute($params);

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $table
     * @param array $params
     *
     * @return bool
     */
    public function insert(string $table, array $params) : bool
    {
        $query = $this->queryBuilder->getInsertQuery(array_keys($params), $table);
        $sth = $this->db->prepare($query);
        $isInserted = $sth->execute($params);

        $result = false;
        if ($isInserted) {
            $result = $this->db->lastInsertId();
        }

        return $result;
    }

    /**
     * @param string $table
     * @param string $primaryKey
     * @param array $params
     *
     * @return bool
     */
    public function update(string $table, string $primaryKey, array $params) : bool
    {
        $query = $this->queryBuilder->getUpdateQuery(array_keys($params), $table, $primaryKey);
        $sth = $this->db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        return $sth->execute($params);
    }

    /**
     * @param string $query
     *
     * @return \PDOStatement
     */
    public function query($query, $params)
    {
        $prepStatement = $this->db->prepare($query);

        return $prepStatement->execute($params);
    }
}