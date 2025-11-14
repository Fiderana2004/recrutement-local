<?php
require_once './config/database.php';

class Utilisateur {
    private $conn;

    public function __construct() {
        $db = new database();
        $this->conn = $db->connect();
    }

    public function getAllUtilisateur() {
        $sql = "SELECT * FROM utilisateur";
        return $this->conn->query($sql);
    }

    public function ajouterUtilisateur($mdp, $email, $role) {
        // Idéalement, hacher le mot de passe ici avant l'insertion
        // $hashedMdp = password_hash($mdp, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO utilisateur (mdputil, Emailutil, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $mdp, $email, $role); // Utilisez $hashedMdp si vous hachez
        $stmt->execute();
        $lastId = $stmt->insert_id;
        $stmt->close(); // Fermer le statement
        return $lastId; 
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateur WHERE idutil = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close(); // Fermer le statement
        return $result;
    }

    public function login($email, $mdp) {
        // Si vous hachez les mots de passe, la logique de vérification sera différente:
        // 1. Récupérer l'utilisateur par email
        // 2. Vérifier le mot de passe hashé avec password_verify()
        $stmt = $this->conn->prepare("SELECT * FROM utilisateur WHERE Emailutil = ? AND mdputil = ?");
        $stmt->bind_param("ss", $email, $mdp);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close(); // Fermer le statement
        return $result;
    }

    public function getRecruteur($idutil) { // Utiliser $idutil pour la clarté
        $stmt = $this->conn->prepare("SELECT * FROM recruteur WHERE idutil = ?");
        $stmt->bind_param("i", $idutil);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close(); // Fermer le statement
        // var_dump($_SESSION['recruteur']); exit; // <-- Supprimez cette ligne de débogage !
        return $result;
    }

    public function getCandidat($idutil) { // Utiliser $idutil pour la clarté
        $stmt = $this->conn->prepare("SELECT * FROM candidat WHERE idutil = ?");
        $stmt->bind_param("i", $idutil);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close(); // Fermer le statement
        return $result;
    }

    public function close() {
        // $this->conn->close(); // C'est une bonne pratique, mais pas toujours nécessaire en fin de script PHP.
    }
}