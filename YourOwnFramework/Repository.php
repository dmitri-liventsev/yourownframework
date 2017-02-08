<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace YourOwnFramework;

abstract class Repository
{
    private $executor;

    private $entityClassName;

    public function __construct(Executor $executor, string $entityClassName)
    {
        $this->executor = $executor;
        $this->entityClassName = $entityClassName;
    }

    /**
     * @param string $where
     * @param array $params
     * @return null|ErzatsORMInterface
     */
    protected function findOne(string $where, array $params = [])
    {
        $result = $this->findAll($where, $params);

        return isset($result[0]) ? $result[0] : null;
    }

    /**
     * @param string $where
     * @param array $params
     * @return ErzatsORMInterface[]
     */
    protected function findAll(string $where, array $params)
    {
        $rows = $this->executor->select($where, $params);
        $result = [];

        foreach ($rows as $row) {
            $result = $this->buildEntity($row);
        }

        return $result;
    }

    /**
     * @param array $params
     *
     * @return ErzatsORMInterface
     */
    private function buildEntity(array $params = [])
    {
        /** @var ErzatsORMInterface $entity */
        $entity = new $this->entityClassName($this->executor);
        $entity->load($params);

        return $entity;
    }
}
