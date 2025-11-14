<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "gestionrecruteur"; 

    public $conn;

    public function __construct() {
        $this->connect(); // ⬅ Connexion automatique à la création de l'objet
    }

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            if ($this->conn->connect_error) {
                throw new Exception("Erreur de connexion : " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }

        return $this->conn;
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function fetchAll($sql) {
        $result = $this->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function fetchColumn($sql) {
        $result = $this->query($sql);
        $row = $result ? $result->fetch_row() : null;
        return $row ? $row[0] : null;
    }

public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
