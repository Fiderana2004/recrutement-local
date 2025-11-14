<?php
require_once './config/database.php';

class Offre {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Obtenir toutes les offres (utile pour l'admin éventuellement)
    public function getAllOffre() {
        $sql = "SELECT * FROM offre";
        return $this->conn->query($sql);
    }

    // Obtenir les offres publiées par un recruteur spécifique
    public function getOffresByRecruteurId($idrecru) {
        $sql = "SELECT * FROM offre WHERE idrecru = ?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("i", $idrecru);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }
        error_log("Erreur dans getOffresByRecruteurId : " . $this->conn->error);
        return false;
    }

public function getOffreById($id) {
    $stmt = $this->conn->prepare("SELECT * FROM offre WHERE idof = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result;
}

    // Ajouter une offre
    public function ajouterOffre($titre, $description, $lieu, $type, $contrat, $idrecru) {
        $sql = "INSERT INTO offre (titre, description, lieu, type, contrat, idrecru)
                VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("sssssi", $titre, $description, $lieu, $type, $contrat, $idrecru);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        error_log("Erreur dans ajouterOffre : " . $this->conn->error);
        return false;
    }

    // Modifier une offre
    public function modifierOffre($id, $titre, $description, $lieu, $type, $contrat) {
        $sql = "UPDATE offre
         SET titre = ?, description = ?, lieu = ?, type = ?, contrat = ?
                WHERE idof = ?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("sssssi", $titre, $description, $lieu, $type, $contrat, $id);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        error_log("Erreur dans modifierOffre : " . $this->conn->error);
        return false;
    }

    // Supprimer une offre
     public function supprimerOffre($id) {
        $sql = "DELETE FROM offre WHERE idof = ?";

        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("i", $id);  // Le paramètre doit être de type entier
            $stmt->execute();
        }
    }

    // Récupérer une offre par son ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM offre WHERE idof = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function rechercherOffresParMotCle($idrecru, $motCle) {
    $motCle = "%{$motCle}%";
    $sql = "SELECT * FROM offre WHERE idrecru = ? AND (titre LIKE ? OR lieu LIKE ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("iss", $idrecru, $motCle, $motCle);
    $stmt->execute();
    return $stmt->get_result();
}


    // Fermer la connexion (optionnel)
    public function close() {
        $this->conn->close();
    }

    // Compter le nombre d'offres d'un recruteur
    public function countOffresByRecruteur($idrecru) {
        $sql = "SELECT COUNT(*) AS total FROM offre WHERE idrecru = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idrecru);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['total'] ?? 0;
    }

    // Compter le nombre d'offres par type pour un recruteur
    public function countOffresByType($type, $idrecru) {
        $sql = "SELECT COUNT(*) AS total FROM offre WHERE contrat = ? AND idrecru = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $type, $idrecru);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['total'] ?? 0;
    }

    // Compter le nombre de types de contrat différents pour un recruteur
    public function countContratsDifferentsByRecruteur($idrecru) {
        $sql = "SELECT COUNT(DISTINCT contrat) AS total_contrats FROM offre WHERE idrecru = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idrecru);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['total_contrats'] ?? 0;
    }

    public function getOffresParPoste($poste) {
        $sql = "SELECT * FROM offre WHERE titre LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $like = "%$poste%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getOffreParId($idof) {
        $sql = "SELECT * FROM offre WHERE idof = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idof);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function compterNouvellesOffres() {
    // Cette requête fonctionnera maintenant car la colonne date_pub existe
    $sql = "SELECT COUNT(*) AS total FROM offre WHERE DATEDIFF(CURDATE(), date_pub) <= 7";
    
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        error_log("Erreur de préparation de la requête: " . $this->conn->error);
        return 0;
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $row = $result->fetch_assoc()) {
        return $row['total'];
    }
    
    return 0;
}

public function compterOffresParContrat() {
    $sql = "SELECT contrat, COUNT(*) as total FROM offre GROUP BY contrat";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['contrat']] = $row['total'];
    }
    return $data;
}

    public function compterOffresParRecruteur($idrecru) {
        $query = "SELECT COUNT(*) FROM offre WHERE idrecru = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idrecru);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_row()[0] ?? 0;
    }
    
    public function getOffresRecentes($idrecru, $limit = 5) {
        $query = "SELECT * FROM offre WHERE idrecru = ? ORDER BY date_pub DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idrecru, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    
}
