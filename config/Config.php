<?php 
namespace Demetech;
    class PDO {
        private $host, $dbname, $username, $password;

        public function __construct($host, $dbname, $username, $password) {
            $this->host = $host;
            $this->dbname = $dbname;
            $this->username = $username;
            $this->password = $password;
        }
        public function connectDB() {
            try {
                $conn = new \PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
                $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch (\PDOException $e) {
                echo "Connexion échouée: " . $e->getMessage();
            }
        }

        public function sessionStart() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }

    $pdo = new PDO('localhost', 'demetech', 'root', '');
    $conn = $pdo->connectDB();
?>