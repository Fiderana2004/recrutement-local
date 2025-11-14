<?php
// On s'assure que les dépendances sont bien chargées
require_once './config/database.php';
require_once './model/Candidat.php';
require_once './model/Utilisateur.php'; 
require_once './model/Offre.php';
require_once './model/Recruteur.php'; // Ce modèle n'est pas utilisé dans ce contrôleur, mais c'est bien de le garder
require_once './model/Candidature.php';
require_once './model/Notification.php';

class CandidatController {
    
    private $candidatModel;
    private $candidatureModel;
    private $offreModel;
    private $notificationModel;

    public function __construct() {
        $this->candidatModel = new Candidat();
        $this->candidatureModel = new Candidature();
        $this->offreModel = new Offre();
        $this->notificationModel = new Notification();
    }

    /**
     * Affiche le tableau de bord du candidat avec toutes les données nécessaires.
     */
    public function afficherDashboard() {
        if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'candidat') {
            header('Location: index.php?page=login');
            exit();
        }

        $candidatSession = $_SESSION['utilisateur'];

        $idcand = $candidatSession['idcand'] ?? null;
        
        $candidat = [];
        $nbCandidatures = 0;
        $nbNouvellesOffres = 0;
        $nbNotifications = 0;
        $pourcentageProfil = 0;
        $candidaturesRecentes = [];
        $statutCandidatures = [];
        $offresParContrat = [];

        if ($idcand) {
            // Récupère les données complètes du profil pour l'affichage (photo, nom)
            $candidat = $this->candidatModel->getCandidatParId($idcand);

            // Statistiques clés
            $nbCandidatures = $this->candidatureModel->compterCandidaturesEnCours($idcand);
            $nbNouvellesOffres = $this->offreModel->compterNouvellesOffres(); 
            $nbNotifications = $this->notificationModel->compterNotificationsNonLues($idcand);
            $pourcentageProfil = $this->candidatModel->calculerPourcentageProfil($idcand);

            // Candidatures récentes (pour le tableau)
            $candidaturesRecentes = $this->candidatureModel->getCandidaturesRecentes($idcand, 5);

            // Données pour les graphiques
            $statutCandidatures = $this->candidatureModel->compterCandidaturesParStatut($idcand);
            $offresParContrat = $this->offreModel->compterOffresParContrat();
            
        }

        // Afficher la vue du tableau de bord
        include './view/Pages/candidat/dashboard.php';
    }

    /**
     * Traite la soumission du formulaire de profil (ajout ou modification).
     */
    public function gererProfil() {
        if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'candidat') {
            header('Location: index.php?page=login');
            exit();
        }

        $idutil = $_SESSION['utilisateur']['idutil'];
        $candidatData = $this->candidatModel->getByUtilisateur($idutil);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nomcand = $_POST['nomcand'] ?? '';
            $prncand = $_POST['prncand'] ?? '';
            $ecand = $_POST['ecand'] ?? '';
            $numtelcand = $_POST['numtelcand'] ?? '';
            $sexe = $_POST['sexe'] ?? '';
            $adrscand = $_POST['adrscand'] ?? '';
            $poste = $_POST['poste'] ?? '';
            
            $photoName = $candidatData['photocand'] ?? 'default.png'; // Définir une valeur par défaut

            // Gérer l'upload de la nouvelle photo
            if (isset($_FILES['photocand']) && $_FILES['photocand']['error'] == 0) {
                // Supprimer l'ancienne photo si elle existe et n'est pas la photo par défaut
                if ($photoName !== 'default.png' && file_exists('./uploads/' . $photoName)) {
                    unlink('./uploads/' . $photoName);
                }
                $photoName = uniqid() . '_' . $_FILES['photocand']['name'];
                move_uploaded_file($_FILES['photocand']['tmp_name'], './uploads/' . $photoName);
            }

            // Mettre à jour le profil
            if ($candidatData) {
                $success = $this->candidatModel->modifier($idutil, $nomcand, $prncand, $ecand, $numtelcand, $photoName, $sexe, $adrscand, $poste);
            } else {
                // Créer un nouveau profil si il n'existe pas
                $success = $this->candidatModel->ajouter($nomcand, $prncand, $ecand, $numtelcand, $photoName, $idutil, $sexe, $adrscand, $poste);
            }
            
            if ($success) {
                // Mettre à jour la session avec les nouvelles données
                $updatedCandidat = $this->candidatModel->getByUtilisateur($idutil);
                $_SESSION['utilisateur'] = array_merge($_SESSION['utilisateur'], $updatedCandidat);
                $_SESSION['success_message'] = "Profil mis à jour avec succès.";
            } else {
                 $_SESSION['error_message'] = "Erreur lors de la mise à jour du profil.";
            }

            header('Location: index1.php?page=profilcand');
            exit();
            } else {
            // Si la requête est en GET, on affiche le formulaire
                 $profil = $candidatData; // Pour l'affichage dans la vue
                   include './view/Pages/candidat/profilcand.php';
             }
      }

    /**
     * Affiche les offres d'emploi correspondant au poste du candidat.
     */
    public function voirOffresPoste() {
        if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'candidat') {
            header('Location: index.php?page=login');
            exit();
        }

        $idutil = $_SESSION['utilisateur']['idutil'];
        $candidat = $this->candidatModel->getByUtilisateur($idutil);
        $poste = $candidat['poste'] ?? null;

        $offres = [];
        if ($poste) {
            $offres = $this->offreModel->getOffresParPoste($poste); 
        }

        include './view/Pages/candidat/offres_poste.php';
    }

    /**
     * Affiche la liste des candidatures du candidat.
     */
    public function mesCandidatures() {
        if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'candidat') {
            header('Location: index.php?page=login');
            exit();
        }
        $idcand = $_SESSION['utilisateur']['idcand'];
        $mesCandidatures = $this->candidatureModel->getCandidaturesParCandidat($idcand); // Implémenter cette méthode
        include './view/Pages/candidat/mesCandidatures.php';
    }

    /**
     * Marque toutes les notifications du candidat comme lues.
     */
    public function marquerNotifsLues() {
        if (!isset($_SESSION['utilisateur']['idcand'])) {
            header('Location: index.php?page=login');
            exit();
        }
        $idcand = $_SESSION['utilisateur']['idcand'];
        $this->notificationModel->marquerCommeLues($idcand);

        // Redirection vers le tableau de bord
        header("Location: index1.php?page=dashboard");
        exit();
    }
}