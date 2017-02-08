<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework;

use YourOwnFramework\Exception\ErzatsORMException;

class ErzatsORM
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
     * ErzatsORM constructor.
     * @param Executor $executor
     */
    public function __construct(Executor $executor)
    {
        $executor->setTable($this->table);
        $this->executor = $executor;
        $this->clear();
    }

    public function refresh()
    {
        if ($this->isNew()) {
            $this->clear();
        } else {
            $this->paramsValue = $this->executor->getAll();
        }
    }

    public function save()
    {
        if ($this->isNew()) {
            $this->executor->insert($this->paramsValue);
        } else {
            $this->executor->update($this->getPrimaryKey(), $this->paramsValue);
        }
    }

    /**
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->paramsValue[$this->primaryKey];
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->getPrimaryKey() !== null;
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
        $param = substr($methodName, 3);
        $value = $arguments[0] ?? null;

        if ($prefix == 'get') { // get
            return $this->getParam($param);
        } elseif ($prefix == 'set') { // set
            return $this->setParam($param, $value);
        }

        throw new ErzatsORMException('Method not exists');
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
     * @param string $param
     * @param string|int|null|bool $value
     * @return bool
     * @throws ErzatsORMException
     */
    private function setParam($param, $value)
    {
        if (!isset($this->params[$param])) {
            throw new ErzatsORMException('Param not exists');
        }

        $this->wasChanged = true;
        $this->paramsValue[$param] = $value;

        return true;
    }
}
