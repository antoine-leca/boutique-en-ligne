<?php
namespace Demetech;
use Demetech\ConnectionToDB;

class Product {
    private $conn;
    private $tables = ['products', 'categories'];
    private $id;

    public function __construct() {
        $this->conn = (new ConnectionToDB('localhost', 'demetech', 'root', ''))->connectDB();
    }

    public function read($id) {
        $query = "SELECT p.*, c.name AS category_name 
              FROM " . $this->tables[0] . " p
              LEFT JOIN " . $this->tables[1] . " c
              ON p.category_fk = c.id
              WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
?>