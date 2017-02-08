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
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @param string $primaryKey
     * @return array
     */
    public function getOneByPrimaryKey($primaryKey)
    {
        $where = 'id = :id';
        $result = $this->select($where, ['id' => $primaryKey]);

        return isset($result[0]) ? $result[0] : null;
    }

    /**
     * @param string $where
     * @param array $params
     * @return array
     */
    public function select(string $where, array $params = [])
    {
        $sth = $this->db->prepare("SELECT * FROM" . $this->table . "WHERE " . $where);

        foreach ($params as $fieldName => $param) {
            $sth->bindParam($fieldName, $params);
        }

        return $sth->fetchAll($sth, PDO::FETCH_ASSOC);
    }

    /**
     * @param $params
     *
     * @return bool
     */
    public function insert($params)
    {
        $query = $this->getInsertQuery(array_keys($params));
        $sth = $this->db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        return $sth->execute($this->getParamMap($params));
    }

    /**
     * @param $fields
     *
     * @return string
     */
    private function getInsertQuery($fields)
    {
        $fieldNames = implode(',', $fields);

        $values = [];
        foreach ($fields as $field) {
            $values = ":" . $field;
        }

        $values = implode(",", $values);

        return "INSERT INTO " . $this->table . " (". $fieldNames . ") VALUES (" . $values  . ")";
    }

    /**
     * @param $params
     *
     * @return array
     */
    private function getParamMap($params)
    {
        $paramMap = [];

        foreach ($params as $fieldName => $value) {
            $paramMap[":" . $fieldName] = $value;
        }

        return $paramMap;
    }

    /**
     * @param $primaryKey
     * @param $params
     *
     * @return bool
     */
    public function update($primaryKey, $params)
    {
        $query = $this->getUpdateQuery(array_keys($params));
        $sth = $this->db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $params['id'] = $primaryKey;

        return $sth->execute($this->getParamMap($params));
    }

    /**
     * @param array $fields
     *
     * @return string
     */
    private function getUpdateQuery(array $fields)
    {
        $fieldValues = [];
        foreach ($fields as $field) {
            $fieldValues = $field . " = :" . $field;
        }

        return "UPDATE " . $this->table . " SET " . $fieldValues . " WHERE id = :id";
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