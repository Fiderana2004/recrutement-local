<?php
require_once './config/database.php'; // Correction ici pour correspondre à votre Recruteur.php

class Candidat {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllCandidats() { // Changement du nom de la fonction
        $sql = "SELECT * FROM candidat"; // Changement du nom de la table
        $result = $this->conn->query($sql);
        return $result;
    }

    public function getByUtilisateur($idutil) {
        $stmt = $this->conn->prepare("SELECT * FROM candidat WHERE idutil = ?"); // Changement du nom de la table
        $stmt->bind_param("i", $idutil);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    // Fonction `ajouterCandidat` strictement basée sur `ajouterRecruteur`
    // Paramètres: photocand, nomcand, prncand, ecand, numtelcand, idutil, sexe, adrscand, poste
    public function ajouterCandidat($photocand, $nomcand, $prncand, $ecand, $numtelcand, $idutil, $sexe, $adrscand, $poste) {
        $stmt = $this->conn->prepare("
            INSERT INTO candidat (photocand, nomcand, prncand, ecand, numtelcand, idutil, sexe, adrscand, poste)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        // Types de paramètres: sssssisss (string, string, string, string, string, integer, string, string, string)
        $stmt->bind_param("sssssisss", $photocand, $nomcand, $prncand, $ecand, $numtelcand, $idutil, $sexe, $adrscand, $poste);
        $stmt->execute();
        $lastId = $this->conn->insert_id;
        $stmt->close();
        return $lastId;
    }

    public function getCandidatById($id) { // Changement du nom de la fonction
        $stmt = $this->conn->prepare("SELECT * FROM candidat WHERE idcand = ?"); // Changement du nom de la table et de la clé primaire
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function getCandidatParIdUtil($idutil) {
          $sql = "SELECT * FROM candidat WHERE idutil = ?";
          $stmt = $this->conn->prepare($sql);
          $stmt->bind_param("i", $idutil);
          $stmt->execute();
         return $stmt->get_result()->fetch_assoc();
    }


    // Fonction `modifier` strictement basée sur la `modifier` de Recruteur
    // Paramètres: idutil (pour le WHERE), nomcand, prncand, ecand, numtelcand, photocand, sexe, adrscand, poste
  // Fichier: model/Candidat.php

// ...

public function modifier($idutil, $nomcand, $prncand, $ecand, $numtelcand, $photocand, $sexe, $adrscand, $poste) {
    $sql = "UPDATE candidat
            SET nomcand = ?, prncand = ?, ecand = ?, numtelcand = ?, photocand = ?,
                sexe = ?, adrscand = ?, poste = ?
            WHERE idutil = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $nomcand, $prncand, $ecand, $numtelcand, $photocand, $sexe, $adrscand, $poste, $idutil);
    $stmt->execute();

    // 🚀 La correction est ici : on récupère le résultat AVANT de fermer la connexion
    $success = $stmt->affected_rows > 0;
    $stmt->close();

    return $success; // On retourne le résultat
}
    // Fonction `modifierPhoto` strictement basée sur la `modifierPhoto` de Recruteur
    public function modifierPhoto($idutil, $cheminPhoto) {
        $sql = "UPDATE candidat SET photocand = ? WHERE idutil = ?"; // Changement de l'attribut photo
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $cheminPhoto, $idutil);
        $stmt->execute();
        $stmt->close();
    }

    public function calculerPourcentageProfil($idcand) {
        // 1. Récupérer les données du candidat
        $candidatData = $this->getCandidatParId($idcand); // Assurez-vous d'avoir cette méthode

        if (!$candidatData) {
            return 0; // Aucun profil trouvé
        }

        // 2. Définir les champs importants pour la complétion du profil
        // Vous pouvez ajuster cette liste et les pourcentages
        $champsImportants = [
            'nomcand' => 10,
            'prncand' => 10,
            'ecand' => 10,
            'numtelcand' => 10,
            'adrscand' => 10,
            'sexe' => 5,
            'poste' => 15,
            'photocand' => 10,
            'cv' => 10, // Supposons que vous avez une colonne 'cv' pour le chemin du fichier
            'lettre_motivation' => 10 // Supposons une colonne 'lettre_motivation' pour le chemin
        ];
        
        $pourcentageTotal = 0;

        // 3. Boucler sur les champs et vérifier s'ils sont renseignés
        foreach ($champsImportants as $champ => $pourcentage) {
            // Pour la photo, on vérifie si c'est la photo par défaut
            if ($champ === 'photocand') {
                if (!empty($candidatData[$champ]) && $candidatData[$champ] !== 'default.png') {
                    $pourcentageTotal += $pourcentage;
                }
            }
            // Pour les autres champs, on vérifie s'ils ne sont pas vides
            else if (!empty($candidatData[$champ])) {
                $pourcentageTotal += $pourcentage;
            }
        }
        
        return min(100, $pourcentageTotal); // S'assurer que le résultat ne dépasse pas 100
    }

    // ... Vos autres méthodes ...
    
    /**
     * Récupère les données d'un candidat par son ID.
     * Cette méthode est nécessaire pour la fonction ci-dessus.
     */
    public function getCandidatParId($idcand) {
        $sql = "SELECT * FROM candidat WHERE idcand = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idcand);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    

    public function close() {
        // La fermeture explicite peut être faite avec mysqli_close($this->conn);
    }
}
?>