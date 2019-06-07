<?php


namespace app\models\repositories;


use app\models\entity\Task;
use app\Services\Db;
use Framework\Registry;

class Tasks implements IRepository
{
    /**
     * @var string
     */
    private $tableName = 'tasks';

    /**
     * @var Db
     */
    private $db;

    /**
     * @var Task
     */
    private $model;


    public function __construct(?Task $model = null)
    {
        if ($model) {
            $this->model = $model;
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function getById(int $id, $params = [])
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = :id";
        return $this->getDb()->queryOne($sql, [':id' => $id], Task::class);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getAll($params = [])
    {
        $sql = "SELECT * FROM {$this->tableName}";
        return $this->getDb()->queryAll($sql, [], Task::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws \Exception
     */
    public function getRange(int $limit, int $offset = 0, $params = [])
    {

        $sql = "SELECT * FROM {$this->tableName}";

        if ($params['sort']) {
            $fieldSort = $params['sort'];
            $sql .= " ORDER BY {$fieldSort}";
        }

        $sql .= " LIMIT {$limit} OFFSET {$offset}";
        return $this->getDb()->queryAll($sql, [], Task::class);
    }

    /**
     * @param Task $model
     * @return string
     * @throws \Exception
     */
    protected function insert(Task $model)
    {
        $db = $this->getDb();

        try {
            $sql = "INSERT INTO {$this->tableName} VALUES (DEFAULT, :username, :email, :description, :status)";
            $db->execute($sql, [
                ':username' => $model->getUsername(),
                ':email' => $model->getEmail(),
                ':description' => $model->getDescription(),
                ':status' => $model->getStatus()
            ]);
        } catch (\PDOException $e) {
            return false;
        }

        return $db->lastInsertId();
    }

    protected function update(Task $model, $prop)
    {
        $db = $this->getDb();

        $getterProp = 'get' . ucfirst($prop);

        try {
            $sql = "UPDATE {$this->tableName} SET {$prop} = :prop WHERE id = :id";
            $db->execute($sql, [
                ':prop' => $model->$getterProp(),
                ':id' => $model->getId()
            ]);
        } catch (\PDOException $e) {
            return false;
        }

        return true;
    }

    /**
     * @param null $prop
     * @throws \Exception
     */
    public function save($prop = null)
    {
        if (!$this->model) {
            return;
        }

        if ($this->model->getId()) {
            $this->update($this->model, $prop);
        } else {
            if ($id = $this->insert($this->model)) {
                $this->model->setId($id);
            }
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getAmount()
    {
        $sql = "SELECT count(*) AS amount FROM {$this->tableName}";
        return (int)$this->getDb()->queryOne($sql)['amount'];
    }

    /**
     * @return Db|object
     * @throws \Exception
     */
    private function getDb()
    {
        if (!$this->db) {
            $this->db = Registry::getService('db');
        }

        return $this->db;
    }
}
