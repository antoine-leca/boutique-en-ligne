<?php
// ajouter au fichier view si besoin d'utiliser la la User
// require_once __DIR__ . '/../config/Config.php';
// require_once __DIR__ . '/../controllers/Autoloader.php';
// \Demetech\Autoloader::register();

// use Demetech\User;

namespace Demetech;
use Demetech\connectionToDB;

class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($lastname, $firstname, $mail, $password) {
        try {
            // Vérifiez si utilisateur existant
            $query = "SELECT * FROM " . $this->table . " WHERE mail = :mail";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':mail', $mail);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return false;
            }
    
            // créer le nouveau
            $query = "INSERT INTO " . $this->table . " (lastname, firstname, mail, password) VALUES (:lastname, :firstname, :mail, :password)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT));
            return $stmt->execute();
        } catch (\PDOException $e) {
            // message d'erreur
            echo "Erreur lors de la création de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    public function read($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($id, $lastname, $firstname, $mail, $password) {
        $query = "UPDATE " . $this->table . " SET lastname = :lastname, firstname = :firstname, mail = :mail, password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':mail', $mail);
        if ($password) {
            $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT));
        }
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function login($mail, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE mail = :mail;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }
}
?>