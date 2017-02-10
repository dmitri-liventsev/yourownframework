<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework\Db;

use YourOwnFramework\Exception\ErzatsORMException;

/**
 * Class ErzatsORM
 *
 * @package YourOwnFramework\Db
 *
 * @method setDeletedAt($deletedAt)
 */
abstract class ErzatsORM implements ErzatsORMInterface
{
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var array
     */
    private $paramsValue = [];

    /**
     * @var string
     */
    protected $primaryKey;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var bool
     */
    private $wasChanged = false;

    /**
     * @var Executor
     */
    private $executor;

    /**
     * @var array
     */
    protected $utilFields = ['id'];

    /**
     * ErzatsORM constructor.
     * @param Executor $executor
     */
    public function __construct(Executor $executor)
    {
        $this->executor = $executor;
        $this->clear();
    }

    public function refresh()
    {
        if ($this->isNew()) {
            $this->clear();
        } else {
            $where = $this->primaryKey .' = :' . $this->primaryKey;
            $params = [$this->primaryKey => $this->getPrimaryKeyValue()];

            $this->paramsValue = $this->executor->select($this->table, $where, $params);
        }
    }

    public function save()
    {
        $params = array_diff_key($this->paramsValue, array_flip($this->utilFields));
        if ($this->isNew()) {
            $isSuccess = $this->insert($params);
        } else {
            $isSuccess = $this->update($params);
        }

        if (!$isSuccess ) {
            throw new ErzatsORMException();
        }
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    private function insert(array $params)
    {
        $primaryKey = $this->executor->insert($this->table, $params);
        $this->paramsValue[$this->getPrimaryKey()] = $primaryKey;

        return !!$primaryKey;
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    private function update(array $params)
    {
        $params[$this->getPrimaryKey()] = $this->getPrimaryKeyValue();
        return $this->executor->update($this->table, $this->primaryKey, $params);
    }

    /**
     * @return int
     */
    public function getPrimaryKeyValue()
    {
        return $this->paramsValue[$this->primaryKey];
    }

    /**
     * @return string
     */
    public function getPrimaryKey() : string
    {
        return $this->primaryKey;
    }

    /**
     * @return bool
     */
    public function isNew() : bool
    {
        return $this->getPrimaryKeyValue() === null;
    }

    private function clear()
    {
        foreach ($this->params as $param) {
            $this->paramsValue[$param] = null;
        }
    }

    /**
     * @param $methodName
     * @param null $arguments
     * @return bool|int|null|string
     * @throws ErzatsORMException
     */
    public function __call($methodName, $arguments = null)
    {
        $prefix = substr($methodName, 0, 3);
        $param = lcfirst(substr($methodName, 3));
        $value = $arguments[0] ?? null;

        if ($prefix == 'get') { // get
            return $this->getParam($param);
        } elseif ($prefix == 'set') { // set
            return $this->setParam($param, $value);
        }

        throw new ErzatsORMException("Method '$methodName' is not exists");
    }

    /**
     * @param string $param
     * @return int|string|bool|null
     */
    private function getParam($param)
    {
        return $this->paramsValue[$param] ?? null;
    }

    /**
     * @param string $sql
     * @param array $params
     *
     * @return bool
     */
    public function query(string $sql, array $params = [])
    {
        return $this->executor->query($sql, $params);
    }

    /**
     * @return array
     */
    public function getParams() : array
    {
        return $this->paramsValue;
    }

    /**
     * @param string $param
     * @param string|int|null|bool $value
     * @return bool
     * @throws ErzatsORMException
     */
    private function setParam($param, $value) : bool
    {
        if (!in_array($param, $this->params)) {
            throw new ErzatsORMException('Param not exists');
        }

        $this->wasChanged = true;
        $this->paramsValue[$param] = $value;

        return true;
    }

    /**
     * @return array
     */
    public function getListOfFields() : array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function load(array $params = [])
    {
        foreach($params as $fieldName => $param) {
            $this->paramsValue[$fieldName] = $param;
        }
    }

    /**
     * @return array
     */
    public function getUtilFields(): array
    {
        return $this->utilFields;
    }

    public function delete()
    {
        $this->setDeletedAt(date('Y-m-d'));
    }
}
