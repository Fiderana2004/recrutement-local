<?php
require_once './model/NotificationRecruteur.php';

class NotificationRecruteurController {
    private $notifModel;

    public function __construct() {
        $this->notifModel = new NotificationRecruteur();
    }

    public function ajouter($id_recruteur, $message) {
        return $this->notifModel->ajouterNotification($id_recruteur, $message);
    }

    public function getNonLues($id_recruteur) {
        return $this->notifModel->getNotificationsNonLues($id_recruteur);
    }

    public function getAll($id_recruteur) {
        return $this->notifModel->getAllNotifications($id_recruteur);
    }

    public function supprimer($id) {
        return $this->notifModel->supprimerNotification($id);
    }
    public function getNotificationsByRecruteur($idRecruteur) {
        return $this->notifModel->getNotificationsByRecruteur($idRecruteur);
    } 

    public function marquerCommeLues() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $idRecruteur = $_SESSION['utilisateur']['idrecru'] ?? null;
        if ($idRecruteur) {
            $this->notifModel->marquerCommeLues($idRecruteur);
        }
    }

    public function marquerCommeLu($id_recruteur) {
        return $this->notifModel->marquerToutCommeLu($id_recruteur);
    }

    public function getNotificationsByRecruteurNonLues($idRecruteur) {
        return $this->notifModel->getNonLuesByRecruteurId($idRecruteur); 
    }
}
