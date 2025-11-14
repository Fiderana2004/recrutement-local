<?php
require_once './config/database.php';

class Notification {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function ajouterNotification($idcand, $message) {
    $sql = "INSERT INTO notification (idcand, message, est_lu, date_notif) VALUES (?, ?, 0, NOW())";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("is", $idcand, $message);
    return $stmt->execute();
}


    public function getNotificationsNonLues($idcand) {
        $sql = "SELECT * FROM notification WHERE idcand = ? AND est_lu = 0 ORDER BY date_notif DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idcand);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getAllNotifications($idcand) {
    $sql = "SELECT * FROM notification WHERE idcand = ? ORDER BY date_notif DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idcand);
    $stmt->execute();
    return $stmt->get_result();
}


    public function marquerCommeLues($idcand) {
        $sql = "UPDATE notification SET est_lu = 1 WHERE idcand = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idcand);
        return $stmt->execute();
    }
    public function compterNotificationsNonLues($idCandidat) {
    $sql = "SELECT COUNT(*) AS nb FROM  notification WHERE idcand = ? AND est_lu = 0";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idCandidat);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return (int)$row['nb'];
    }
    return 0;
}
// Dans votre modèle Notification.php
// ...

// Méthode pour supprimer une seule notification par son ID
public function supprimerNotification($idnotif, $idcand) {
    // Sécurité : Vérifier que la notification appartient bien au candidat
    $sql = "DELETE FROM notification WHERE idnotif = ? AND idcand = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $idnotif, $idcand);
    return $stmt->execute();
}

// Méthode pour supprimer toutes les notifications d'un candidat
public function supprimerToutesNotifications($idcand) {
    $sql = "DELETE FROM notification WHERE idcand = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idcand);
    return $stmt->execute();
}

// ...

}
