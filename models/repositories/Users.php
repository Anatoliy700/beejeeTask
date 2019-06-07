<?php


namespace app\models\repositories;


use app\models\entity\User;
use app\Services\Db;
use Framework\Registry;

class Users implements IRepository
{
    /**
     * @var string
     */
    private $tableName = 'users';

    /**
     * @var Db
     */
    private $db;

    /**
     * @var User
     */
    private $model;

    public function __construct(?User $model = null)
    {
        if ($model) {
            $this->model = $model;
        }
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function getById(int $id, $params = [])
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = :id";
        return $this->getDb()->queryOne($sql, [':id' => $id], User::class);
    }

    /**
     * @param string $username
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function getByUsername(string $username, $params = [])
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE username = :username";
        return $this->getDb()->queryOne($sql, [':username' => $username], User::class);
    }

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function getAll($params = [])
    {
        $sql = "SELECT * FROM {$this->tableName}";
        return $this->getDb()->queryAll($sql, [], User::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array $params
     */
    public function getRange(int $limit, int $offset = 0, $params = [])
    {
        // TODO: Implement getRange() method.
    }

    /**
     *
     */
    public function getAmount()
    {
        // TODO: Implement getAmount() method.
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
