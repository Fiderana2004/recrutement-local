<?php
// controller/OffreController.php

require_once './model/Offre.php';

class OffreController {
    private $offre;

    public function __construct() {
        $this->offre = new Offre();
    }

 


    // Ajouter une offre (POST)
    public function ajouterOffre() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'recruteur') {
                echo "Accès refusé.";
                exit;
            }

            $idrecru = $_SESSION['utilisateur']['idrecru'];
            $titre = $_POST['titre'] ?? '';
            $description = $_POST['description'] ?? '';
            $lieu = $_POST['lieu'] ?? '';
            $type = $_POST['type'] ?? '';
            $contrat = $_POST['contrat'] ?? '';

            $success = $this->offre->ajouterOffre($titre, $description, $lieu, $type, $contrat, $idrecru);

            if ($success) {
                header('Location: index2.php?page=ajouterOffre');
                exit;
            } else {
                echo "Erreur lors de l'ajout de l'offre.";
            }
        }
    }

    // Afficher les offres du recruteur connecté
    public function index()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'recruteur') {
        echo "Accès refusé.";
        exit;
    }

    $idrecru = $_SESSION['utilisateur']['idrecru'];
    $motCle = $_GET['recherche'] ?? null;

    if ($motCle) {
        $result = $this->offre->rechercherOffresParMotCle($idrecru, $motCle);
    } else {
        $result = $this->offre->getOffresByRecruteurId($idrecru);
    }

    include './view/Pages/recruteur/ajouterOffre.php';
}


    // Modifier une offre
    public function modifierOffre() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['idof'];
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $lieu = $_POST['lieu'];
            $type = $_POST['type'];
            $contrat = $_POST['contrat'];

            $this->offre->modifierOffre($id, $titre, $description, $lieu, $type, $contrat);

            header('Location: index2.php?page=ajouterOffre');
            exit;
        }
    }

    public function supprimerOffre($id) {
        $offreModel = new Offre();
        $offreModel->supprimerOffre($id);  // Supprime le produit

        // Rediriger vers la liste des produit
        header('Location: index2.php?page=ajouterOffre');
        exit();
    }

    
}
