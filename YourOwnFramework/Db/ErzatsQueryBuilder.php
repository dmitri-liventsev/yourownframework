<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace YourOwnFramework\Db;


class ErzatsQueryBuilder
{
    const CONTAINER_KEY = 'query_builder';

    /**
     * @param $fields
     *
     * @return string
     */
    public function getInsertQuery($fields, string $table) : string
    {
        $fieldNames = implode(',', $fields);

        $values = [];
        foreach ($fields as $field) {
            $values[] = ":" . $field;
        }

        $values = implode(",", $values);

        return "INSERT INTO " . $table . " (". $fieldNames . ") VALUES (" . $values  . ")";
    }

    /**
     * @param array $fields
     * @param string $table
     * @param string $primaryKey
     *
     * @return string
     */
    public function getUpdateQuery(array $fields, string $table, string $primaryKey) : string
    {
        $fieldValues = [];
        foreach ($fields as $field) {
            if ($field == $primaryKey) {
                continue;
            }

            $fieldValues[] = $field . " = :" . $field. ' ';
        }

        return "UPDATE " . $table . " SET " . implode(',', $fieldValues) . " WHERE " . $primaryKey . " = :" . $primaryKey;
    }

    /**
     * @param string|array$where
     * @param string $table
     * @return string
     */
    public function getSelectQuery($where, string $table) : string
    {
        if (is_array($where)) {
            $where = implode(' AND ', $where);
        }

        return "SELECT * FROM " . $table . " WHERE " . $where;
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
}