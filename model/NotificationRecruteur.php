<?php
require_once './config/database.php';

class NotificationRecruteur {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function ajouterNotification($id_recruteur, $message) {
        $stmt = $this->conn->prepare("INSERT INTO notification_recruteur (idrecru, message) VALUES (?, ?)");
        $stmt->bind_param("is", $id_recruteur, $message);
        return $stmt->execute();
    }

    public function getNotificationsNonLues($id_recruteur) {
        $stmt = $this->conn->prepare("SELECT * FROM notification_recruteur WHERE idrecru = ? AND lu = 0");
        $stmt->bind_param("i", $id_recruteur);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllNotifications($id_recruteur) {
        $stmt = $this->conn->prepare("SELECT * FROM notification_recruteur WHERE idrecru = ? ORDER BY date_notif DESC");
        $stmt->bind_param("i", $id_recruteur);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function supprimerNotification($id) {
        $stmt = $this->conn->prepare("DELETE FROM notification_recruteur WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
        public function getNotificationsByRecruteur($idRecruteur) {
        $stmt = $this->conn->prepare("SELECT * FROM notification_recruteur WHERE idrecru = ? ORDER BY date_notif DESC");
        $stmt->bind_param("i", $idRecruteur);
        $stmt->execute();
        $result = $stmt->get_result();
        $notifications = [];
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
        return $notifications;
    }

    public function marquerToutCommeLu($id_recruteur) {
        $stmt = $this->conn->prepare("UPDATE notification_recruteur SET lu = 1 WHERE idrecru = ?");
        $stmt->bind_param("i", $id_recruteur);
        return $stmt->execute();
    }

        public function marquerCommeLues($idRecruteur) {
        $stmt = $this->conn->prepare("UPDATE notification_recruteur SET lu = 1 WHERE idrecru = ?");
        $stmt->bind_param("i", $idRecruteur);
        $stmt->execute();
    }

    // Fichier : model/NotificationRecruteur.php


    public function marquerCommeLuesParRecruteur($idRecruteur) {
         $stmt = $this->conn->prepare("UPDATE notificationrecruteur SET status = 'lu' WHERE id_recruteur = ?");
        
    
        
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $idRecruteur);
        $stmt->execute();
    }

    // La méthode pour récupérer les notifications non lues (appelée par le contrôleur)
    public function getNonLuesByRecruteurId($idRecruteur) {
        // Utiliser $this->conn au lieu de $db
        $stmt = $this->conn->prepare("SELECT * FROM notification_recruteur WHERE idrecru = ? AND lu = 0 ORDER BY date_notif DESC");
        $stmt->bind_param("i", $idRecruteur);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $notifications = [];
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
        return $notifications;
    }
}

