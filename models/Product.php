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

    // Methode pour requêter un produit

    public function readAll($id) {
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

    // Methode pour requêter tous les produits d'une catégorie pour la page liste de produits

    public function readByCategory($category_fk) {
        $query = "SELECT p.*, c.name AS category_name 
              FROM " . $this->tables[0] . " p
              LEFT JOIN " . $this->tables[1] . " c
              ON p.category_fk = c.id
              WHERE p.category_fk = :category_fk";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_fk', $category_fk);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    // Methode pour récupérer les produits recommandés de la même catégorie
    public function getRecommendations($category_fk, $current_product_id, $limit = 4) {
        $query = "SELECT p.*, c.name AS category_name 
              FROM " . $this->tables[0] . " p
              LEFT JOIN " . $this->tables[1] . " c
              ON p.category_fk = c.id
              WHERE p.category_fk = :category_fk
              AND p.id != :current_id
              ORDER BY RAND()
              LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_fk', $category_fk, \PDO::PARAM_INT);
        $stmt->bindParam(':current_id', $current_product_id, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>