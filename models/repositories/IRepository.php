<?php

declare(strict_types = 1);

namespace app\models\repositories;

interface IRepository
{
    public function getById(int $id, $params = []);

    public function getAll($params = []);

    public function getRange(int $limit, int $offset = 0, $params = []);

    public function getAmount();
}
