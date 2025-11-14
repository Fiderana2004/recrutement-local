<?php
require_once './config/database.php';

class Recruteur {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllRecruteur() {
        $sql = "SELECT * FROM recruteur";
        $result = $this->conn->query($sql);
        return $result; 
    }

    public function getByUtilisateur($idutil) {
        $stmt = $this->conn->prepare("SELECT * FROM recruteur WHERE idutil = ?");
        $stmt->bind_param("i", $idutil);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function ajouterRecruteur($nomrecru, $email, $photorecru, $numtelrecru, $idutil, $secteur, $adrsrecru, $siteweb) {
        $sql = "INSERT INTO recruteur (nomrecru, email, photorecru, numtelrecru, idutil, secteur, adrsrecru, siteweb) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssisss", $nomrecru, $email, $photorecru, $numtelrecru, $idutil, $secteur, $adrsrecru, $siteweb);
        return $stmt->execute();
    }

    // ✅ CORRECTION : Mettez à jour la méthode pour accepter tous les champs
    public function modifierRecruteur($idutil, $nomrecru, $email, $numtelrecru, $photorecru, $secteur, $adrsrecru, $siteweb) {
        $sql = "UPDATE recruteur SET nomrecru=?, email=?, numtelrecru=?, photorecru=?, secteur=?, adrsrecru=?, siteweb=? WHERE idutil=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssi", $nomrecru, $email, $numtelrecru, $photorecru, $secteur, $adrsrecru, $siteweb, $idutil);
        return $stmt->execute();
    }


    public function getRecruteurById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM recruteur WHERE idrecru = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function getRecruteurParId($id) {
        $sql = "SELECT * FROM recruteur WHERE idrecru = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // ou fetch_object() selon ce que tu préfères
    }
    

   


    public function modifierPhoto($idutil, $cheminPhoto) {
        $sql = "UPDATE recruteur SET photorecru = ? WHERE idutil = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $cheminPhoto, $idutil);
        $stmt->execute();
        $stmt->close();
    }

    

    public function close() {
        // La fermeture explicite peut être faite avec mysqli_close($this->conn);
    }
}
