<?php
require_once './config/database.php';
require_once './model/Recruteur.php';
require_once './model/Utilisateur.php'; 
require_once './model/Offre.php';
require_once './model/Candidature.php';


class RecruteurController {
    private $recruteurModel;

    public function __construct() {
        $this->recruteurModel = new Recruteur();
    }

    public function afficherDashboard() {
        if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'recruteur') {
            header('Location: index.php?page=login');
            exit();
        }

        $idrecru = $_SESSION['utilisateur']['idrecru'];
        
        $offreModel = new Offre();
        $candidatureModel = new Candidature();

        $nbOffres = $offreModel->compterOffresParRecruteur($idrecru);
        $nbCandidatures = $candidatureModel->compterCandidatureParRecruteur($idrecru);
        $nbCandidaturesEnAttente = $candidatureModel->compterCandidatureParStatut($idrecru, 'En attente');
        
        $offresRecentes = $offreModel->getOffresRecentes($idrecru);
        $candidaturesRecentes = $candidatureModel->getCandidaturesRecentesParRecruteur($idrecru);
        
        include './view/Pages/recruteur/dashboard.php';
    }

    public function index2() {
        $recruteurModel = new Recruteur();
        $result = $recruteurModel->getAllRecruteur(); 
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'recruteur') {
            header('Location: index.php?page=login'); 
            exit();
        }

        $currentutilisateur = $_SESSION['utilisateur']; 
        
        include './view/Pages/recruteur/dashboard.php';
    }

   public function gererProfilRecruteur() {
    if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'recruteur') {
        header('Location: index.php?page=login');
        exit();
    }

    $idutil = $_SESSION['utilisateur']['idutil'];
    $recruteurData = $this->recruteurModel->getByUtilisateur($idutil);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nomrecru = $_POST['nomrecru'] ?? '';
        $email = $_POST['email'] ?? '';
        $numtelrecru = $_POST['numtelrecru'] ?? '';
        $secteur = $_POST['secteur'] ?? '';
        $adrsrecru = $_POST['adrsrecru'] ?? '';
        $siteweb = $_POST['siteweb'] ?? '';

        $photoName = $recruteurData['photorecru'] ?? 'default.png';

        // Gestion de la photo
        if (isset($_FILES['photorecru']) && $_FILES['photorecru']['error'] === 0) {
            if ($photoName !== 'default.png' && file_exists('./uploads/' . $photoName)) {
                unlink('./uploads/' . $photoName);
            }
            $photoName = uniqid() . '_' . $_FILES['photorecru']['name'];
            move_uploaded_file($_FILES['photorecru']['tmp_name'], './uploads/' . $photoName);
        }

        // Mise à jour ou ajout
        if ($recruteurData) {
            $success = $this->recruteurModel->modifierRecruteur($idutil, $nomrecru, $email, $numtelrecru, $photoName, $secteur, $adrsrecru, $siteweb);
        } else {
            $success = $this->recruteurModel->ajouterRecruteur($nomrecru, $email, $photoName, $numtelrecru, $idutil, $secteur, $adrsrecru, $siteweb);
        }

        if ($success) {
            $updatedRecruteur = $this->recruteurModel->getByUtilisateur($idutil);
            $_SESSION['utilisateur'] = array_merge($_SESSION['utilisateur'], $updatedRecruteur);
            $_SESSION['success_message'] = "Profil recruteur mis à jour avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la mise à jour du profil.";
        }

        header('Location: index2.php?page=profilrecru');
        exit();
    } else {
        $profil = $recruteurData;
        include './view/Pages/recruteur/profilrecru.php';
    }
}


    public function uploadPhoto() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'recruteur') {
            header('Location: login.php'); 
            exit();
        }

        $idutil = $_SESSION['utilisateur']['idutil']; 
        
        if ($idutil && isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $photo = $_FILES['photo'];
            $nomFichier = uniqid() . '_' . $photo['name']; 
            $chemin = 'uploads/' . $nomFichier;

            $recruteurModel = new Recruteur();
            $currentRecruteurData = $recruteurModel->getByUtilisateur($idutil);

            if (move_uploaded_file($photo['tmp_name'], $chemin)) {
                if ($currentRecruteurData['photorecru'] && $currentRecruteurData['photorecru'] !== 'default.png' && file_exists('./uploads/' . $currentRecruteurData['photorecru'])) {
                    unlink('./uploads/' . $currentRecruteurData['photorecru']);
                }
                $recruteurModel->modifierPhoto($idutil, $nomFichier); 
                
                $_SESSION['utilisateur']['photorecru'] = $nomFichier;
            }
        }
        header("Location: index2.php?page=profilrecru");
        exit();
    }
    public function getRecruteurById($id) {
    $recruteurModel = new Recruteur(); // Assure-toi que le modèle est bien inclus
    return $recruteurModel->getRecruteurById($id);
}
}
