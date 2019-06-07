<?php

namespace app\Services;


class Db
{
  private $config;

  private $conn = null;

  /**
   * Db constructor.
   * @param $driver
   * @param $host
   * @param $login
   * @param $password
   * @param $database
   * @param string $charset
   */
  public function __construct($driver, $host, $login, $password, $database, $charset = 'utf8') {
    $this->config['driver'] = $driver;
    $this->config['host'] = $host;
    $this->config['login'] = $login;
    $this->config['password'] = $password;
    $this->config['database'] = $database;
    $this->config['charset'] = $charset;
  }


  private function getConnection() {
    if (is_null($this->conn)) {
      $this->conn = new \PDO(
        $this->prepareDnsString(),
        $this->config['login'],
        $this->config['password']
      );
      $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }
    return $this->conn;
  }

  private function prepareDnsString() {
    return sprintf("%s:host=%s;dbname=%s;charset=%s",
      $this->config['driver'],
      $this->config['host'],
      $this->config['database'],
      $this->config['charset']
    );
  }

  private function query($sql, $params = []) {
      try {
          $pdoStatement = $this->getConnection()->prepare($sql);
          $pdoStatement->execute($params);
          return $pdoStatement;
      } catch (\Exception $e) {
         //TODO: error
      }
  }

  public function execute($sql, $params = []) {
    return $this->query($sql, $params);
  }

  public function queryOne($sql, $params = [], $className = null) {
    return $this->queryAll($sql, $params, $className)[0];
  }

  public function queryAll($sql, $params = [], $className = null) {
    $pdoStatement = $this->query($sql, $params);
    if (!is_null($className)) {
      $pdoStatement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $className);
    }
    return $pdoStatement->fetchAll();
  }

  public function lastInsertId() {
    return $this->getConnection()->lastInsertId();
  }

}
