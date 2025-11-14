<?php
require_once './config/database.php';
require_once './model/Utilisateur.php';
require_once './model/Recruteur.php';
require_once './model/Candidat.php';

class UtilisateurController {

    public function index() {
        include './view/Pages/utilisateur/register.php';
    }

    public function ajouterUtilisateur() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mdputil = $_POST['mdputil'];
            $Emailutil = $_POST['Emailutil'];
            $role = $_POST['role'];

            $utilisateurModel = new Utilisateur();

            $idUtil = $utilisateurModel->ajouterUtilisateur($mdputil, $Emailutil, $role);

            if ($idUtil) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['utilisateur'] = [
                    'idutil' => $idUtil,
                    'Emailutil' => $Emailutil,
                    'role' => $role
                ];

                if ($role === 'recruteur') {
                    $recruteurModel = new Recruteur();
                    $recruteurModel->ajouterRecruteur(null, null, $Emailutil, null, $idUtil, null, null, null);

                    $recruteurData = $recruteurModel->getByUtilisateur($idUtil);
                    // === CORRECTION ICI ===
                    // S'assurer que $recruteurData est un tableau avant de fusionner
                    if ($recruteurData === null) {
                        $recruteurData = []; // Initialiser à un tableau vide si null
                    }
                    $_SESSION['utilisateur'] = array_merge($_SESSION['utilisateur'], $recruteurData);

                    header('Location: index2.php?page=profilrecru');
                } elseif ($role === 'candidat') {
                    $candidatModel = new Candidat();
                    $candidatModel->ajouterCandidat('default.png', null, null, null, null, $idUtil, null, null, null);

                    $candidatData = $candidatModel->getByUtilisateur($idUtil);
                    // === CORRECTION ICI ===
                    // S'assurer que $candidatData est un tableau avant de fusionner
                    if ($candidatData === null) {
                        $candidatData = []; // Initialiser à un tableau vide si null
                    }
                    $_SESSION['utilisateur'] = array_merge($_SESSION['utilisateur'], $candidatData);

                    header('Location: index1.php?page=profilcand');
                }
                exit();
            } else {
                $error = "Erreur lors de l'inscription.";
                require './view/Pages/utilisateur/register.php';
            }
        } else {
            require './view/Pages/utilisateur/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $mdp = $_POST['motdepasse'];

            $utilisateurModel = new Utilisateur();
            $utilisateur = $utilisateurModel->login($email, $mdp);

            if ($utilisateur) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['utilisateur'] = [
                    'idutil' => $utilisateur['idutil'],
                    'Emailutil' => $utilisateur['Emailutil'],
                    'role' => $utilisateur['role']
                ];

                if ($utilisateur['role'] === 'recruteur') {
                    $recruteurModel = new Recruteur();
                    $recruteurData = $recruteurModel->getByUtilisateur($utilisateur['idutil']);

                    // === CORRECTION ICI ===
                    // S'assurer que $recruteurData est un tableau avant de fusionner
                    if ($recruteurData === null) {
                        $recruteurData = []; // Initialiser à un tableau vide si null
                    }
                    $_SESSION['utilisateur'] = array_merge($_SESSION['utilisateur'], $recruteurData);

                    if (empty($_SESSION['utilisateur']['nomrecru']) || empty($_SESSION['utilisateur']['photorecru'])) {
                        header('Location: index2.php?page=profilrecru');
                    } else {
                        header('Location: index2.php?page=dashboard');
                    }
                    exit;

                } elseif ($utilisateur['role'] === 'candidat') {
                    $candidatModel = new Candidat();
                    $candidatData = $candidatModel->getByUtilisateur($utilisateur['idutil']);

                    if ($candidatData === null) {
                        $candidatData = [];
                    }

                    $_SESSION['utilisateur'] = array_merge($_SESSION['utilisateur'], $candidatData);

                    

                    if (empty($_SESSION['utilisateur']['nomcand']) || empty($_SESSION['utilisateur']['photocand'])) {
                        header('Location: index1.php?page=profilcand');
                    } else {
                        header('Location: index1.php?page=dashboardcand');
                    }
                    exit;
                }
                 else {
                    session_destroy();
                    $error = "Rôle utilisateur non reconnu.";
                    require './view/Pages/utilisateur/login.php';
                }
            } else {
                $error = "Identifiants incorrects";
                require './view/Pages/utilisateur/login.php';
            }
        } else {
            require './view/Pages/utilisateur/login.php';
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();

        header('Location: index.php?page=login');
        exit;
    }
}