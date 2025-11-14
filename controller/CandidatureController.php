<?php

require_once './model/Candidature.php';
require_once './model/Offre.php';
require_once './model/Candidat.php';
require_once './model/NotificationRecruteur.php'; 
require_once './model/Notification.php'; 
require_once './model/Recruteur.php';

class CandidatureController {
public function ajouterCandidature() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idof = $_POST['id_offre'] ?? null;
        $idcand = $_POST['id_candidat'] ?? null;

        $cvFile = $_FILES['cv'] ?? null;
        $ltrFile = $_FILES['ltrmotivation'] ?? null;

        if (!$cvFile || !$ltrFile || !$idof || !$idcand) {
            $_SESSION['error_message'] = "Champs manquants (offre, candidat ou fichiers).";
            header('Location: index1.php?page=offresCandidat');
            exit;
        }

        // Vérifie que les fichiers sont bien des PDF
        $cvExt = strtolower(pathinfo($cvFile['name'], PATHINFO_EXTENSION));
        $ltrExt = strtolower(pathinfo($ltrFile['name'], PATHINFO_EXTENSION));
        if ($cvExt !== 'pdf' || $ltrExt !== 'pdf') {
            $_SESSION['error_message'] = "Les fichiers doivent être au format PDF.";
            header('Location: index1.php?page=offresCandidat');
            exit;
        }

        $candidatureModel = new Candidature();

        // Vérifier si une candidature existe déjà
        if ($candidatureModel->existeCandidature($idof, $idcand)) {
            $_SESSION['error_message'] = "Vous avez déjà postulé à cette offre.";
            header('Location: index1.php?page=offresCandidat');
            exit;
        }

        // Générer les chemins de fichiers
        $timestamp = time();
        $cvPath = "uploads/cv/{$timestamp}_" . basename($cvFile['name']);
        $ltrPath = "uploads/ltr/{$timestamp}_" . basename($ltrFile['name']);

        // Déplacer les fichiers uploadés
        if (!move_uploaded_file($cvFile['tmp_name'], $cvPath)) {
            $_SESSION['error_message'] = "Erreur lors du téléchargement du CV.";
            header('Location: index1.php?page=offresCandidat');
            exit;
        }

        if (!move_uploaded_file($ltrFile['tmp_name'], $ltrPath)) {
            $_SESSION['error_message'] = "Erreur lors du téléchargement de la lettre de motivation.";
            header('Location: index1.php?page=offresCandidat');
            exit;
        }

        // Enregistrer la candidature
        $success = $candidatureModel->ajouterCandidature($cvPath, $ltrPath, $idof, $idcand);

        if ($success) {
            // Envoyer notification au recruteur
            $offreModel = new Offre();
            $offreDetails = $offreModel->getOffreById($idof);

            if ($offreDetails && isset($offreDetails['idrecru'], $offreDetails['titre'])) {
                $idrecru = $offreDetails['idrecru'];
                $titreOffre = $offreDetails['titre'];

                // Récupération des infos candidat
                $candidatModel = new Candidat();
                $candidatDetails = $candidatModel->getCandidatById($idcand);

                $nomCandidat = $candidatDetails['nom'] ?? 'Un candidat';
                $prenomCandidat = $candidatDetails['prenom'] ?? '';

                $message = "$nomCandidat $prenomCandidat a postulé à votre offre \"$titreOffre\".";

                // Ajouter notification
                $notifModel = new NotificationRecruteur();
                $notifModel->ajouterNotification($idrecru, $message);
            }

            $_SESSION['success_message'] = "Votre candidature a été envoyée avec succès.";
            header('Location: index1.php?page=mesCandidatures');
            exit;
        } else {
            $_SESSION['error_message'] = "Erreur SQL : " . $candidatureModel->getLastError();
            header('Location: index1.php?page=offresCandidat');
            exit;
        }
    }
}

public function changerStatut() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idcandidature = $_POST['idcandidature'];
        $nouveauStatut = $_POST['statut'];

        require_once './model/Candidature.php';
        $model = new Candidature();
        $model->changerStatutCandidature($idcandidature, $nouveauStatut);

        // 🔔 Envoyer une notification au candidat
        require_once './model/Notification.php';
        require_once './model/Candidature.php';
        $candidatureModel = new Candidature();
        $candidature = $candidatureModel->getCandidatureById($idcandidature); // tu dois avoir cette méthode

        if ($candidature) {
             require_once './services/MailService.php';
            $mailService = new MailService();
            $destinataire = $candidature['email'];
            $nomComplet = $candidature['nomcand'] . ' ' . $candidature['prncand'];
            $titreOffre = $candidature['titre'];
            $idcand = $candidature['idcand'];
            $message = "Le statut de votre candidature à l'offre \"" . $candidature['titre'] . "\" a été changé en " . strtoupper($nouveauStatut) . ".";
            
            $notifModel = new Notification();
            $notifModel->ajouterNotification($idcand, $message);
            $mailService->envoyerEmailCandidature($destinataire, $nomComplet, $titreOffre, $nouveauStatut);
        }

        header("Location: index2.php?page=candidatsOffres"); // Redirige après
        exit();
    }
}

 // Dans CandidatureController.php
public function supprimerCandidature($idcandidature) {
    session_start();

    $candidatureModel = new Candidature();
    $idcand_session = $_SESSION['utilisateur']['idcand'];

    // Sécurité : Vérifiez que la candidature appartient bien au candidat connecté
    $candidature_details = $candidatureModel->getCandidatureDetails($idcandidature);

    if ($candidature_details && $candidature_details['idcand'] == $idcand_session) {
        // Si la vérification passe, procéder à la suppression
        if ($candidatureModel->supprimerCandidature($idcandidature)) {
            $_SESSION['message'] = "Candidature supprimée avec succès.";
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression de la candidature.";
        }
    } else {
        $_SESSION['message'] = "Erreur: Candidature introuvable ou vous n'êtes pas autorisé.";
    }

    // Rediriger vers la page des candidatures après l'action
    header('Location: index1.php?page=mesCandidatures');
    exit;
}





}
