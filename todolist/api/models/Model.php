<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'configs/Database.php';

class Model {
  public $connection;
  
  public function __construct() {
    $this->connection = $this->getConnection();
  }

  public function getConnection() {
    try {
      $connection = new PDO(Database::DB_DSN, Database::DB_USERNAME, Database::DB_PASSWORD);
    } catch (PDOException $e) {
      die("Kết nối CSDL thất bại: " . $e->getMessage());
    }

    return $connection;
  }

  public function closeConnection() {
    $this->connection = null;
  }
}