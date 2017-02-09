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
     * @var string
     */
    private $table;

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
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @param string|array $where
     * @param array $params
     * @return array
     */
    public function select($where, array $params = [])
    {
        $query = $this->queryBuilder->getSelectQuery($where, $this->table);
        $sth = $this->db->prepare($query);
        $sth->execute($params);

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $params
     *
     * @return bool
     */
    public function insert($params)
    {
        $query = $this->queryBuilder->getInsertQuery(array_keys($params), $this->table);
        $sth = $this->db->prepare($query);

        $sth->execute($params);

        return $sth->execute($params);
    }

    /**
     * @param $primaryKey
     * @param $params
     *
     * @return bool
     */
    public function update($primaryKey, $params)
    {
        $query = $this->queryBuilder->getUpdateQuery(array_keys($params), $this->table, $primaryKey);
        $sth = $this->db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        return $sth->execute($params);
    }

    /**
     * @param string $query
     * @return \PDOStatement
     */
    public function query($query)
    {
        $args = func_get_args();
        array_shift($args);

        $reponse = $this->db->prepare($query);
        $reponse->execute($args);

        return $reponse;
    }
}