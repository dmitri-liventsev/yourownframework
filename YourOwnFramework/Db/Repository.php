<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace YourOwnFramework\Db;


abstract class Repository
{
    private $executor;

    private $entityClassName;

    protected $table;

    public function __construct(Executor $executor, string $entityClassName)
    {
        $this->executor = $executor;
        $this->entityClassName = $entityClassName;
    }

    /**
     * @return ErzatsORMInterface
     */
    public function create()
    {
        return $this->buildEntity();
    }

    /**
     * @param ErzatsORMInterface $originalEntity
     *
     * @return ErzatsORMInterface
     */
    public function clone(ErzatsORMInterface $originalEntity)
    {
        $params = array_diff_key($originalEntity->getParams(), array_flip($originalEntity->getUtilFields()));

        $newEntity = $this->buildEntity();
        $newEntity->load($params);

        return $newEntity;
    }

    /**
     * @param string|array $where
     * @param array $params
     * @return null|ErzatsORMInterface
     */
    protected function findOne($where, array $params = [])
    {
        $result = $this->findAll($where, $params);

        return $result[0] ?? null;
    }

    /**
     * @param string|array $where
     * @param array $params
     * @return ErzatsORMInterface[]
     */
    protected function findAll($where, array $params)
    {
        $rows = $this->executor->select($this->table, $where, $params);

        $result = [];
        if ($rows !== false) {
            foreach ($rows as $row) {
                $result[] = $this->buildEntity($row);
            }
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
