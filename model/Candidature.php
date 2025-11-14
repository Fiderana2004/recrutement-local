<?php
require_once './config/database.php';
require_once './model/NotificationRecruteur.php';
require_once './model/Candidat.php';
require_once './model/Recruteur.php';

class Candidature {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function ajouterCandidature($cv, $ltr, $idof, $idcand) {
        $sql = "INSERT INTO candidature (cv, ltrmotivation, idof, idcand)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $cv, $ltr, $idof, $idcand);
        return $stmt->execute();
    }

  
    public function existeCandidature($idof, $idcand) {
    $sql = "SELECT COUNT(*) as count FROM candidature WHERE idof = ? AND idcand = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $idof, $idcand);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] > 0;
}

public function getCandidaturesPourRecruteur($idrecru) {
    $sql = "SELECT c.idcandidature, c.cv, c.ltrmotivation, c.statut, o.titre, 
                   cand.nomcand, cand.prncand, cand.ecand AS emailcand, cand.photocand
            FROM candidature c
            JOIN offre o ON c.idof = o.idof
            JOIN candidat cand ON c.idcand = cand.idcand
            WHERE o.idrecru = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idrecru);
    $stmt->execute();
    return $stmt->get_result();
}

public function changerStatut($idcandidature, $statut) {
    $sql = "UPDATE candidature SET statut = ? WHERE idcandidature = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("si", $statut, $idcandidature);
    return $stmt->execute();
}
public function getCandidatureDetails($id) {
    $sql = "SELECT c.idcand, o.titre 
            FROM candidature c
            JOIN offre o ON c.idof = o.idof
            WHERE c.idcandidature = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
public function getCandidatureById($id) {
    $sql = "SELECT c.*, o.titre, cand.nomcand, cand.prncand, cand.ecand AS email
            FROM candidature c 
            JOIN offre o ON c.idof = o.idof
            JOIN candidat cand ON c.idcand = cand.idcand
            WHERE c.idcandidature = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


public function changerStatutCandidature($idcandidature, $statut) {
    $sql = "UPDATE candidature SET statut = ? WHERE idcandidature = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("si", $statut, $idcandidature);
    return $stmt->execute();
}
public function getCandidatIdByCandidature($idcandidature) {
    $sql = "SELECT idcand FROM candidature WHERE idcandidature = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idcandidature);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['idcand'];
    }
    return null;
}
public function getCandidaturesByCandidat($idcand) {
    $sql = "SELECT c.*, o.titre 
            FROM candidature c 
            JOIN offre o ON o.idof = c.idof 
            WHERE c.idcand = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idcand);
    $stmt->execute();
    return $stmt->get_result();
}



public function supprimerCandidature($idcandidature) {
    $sql = "DELETE FROM candidature WHERE idcandidature = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idcandidature);
    return $stmt->execute();
}

 public function compterCandidaturesEnCours($idcand) {
        $sql = "SELECT COUNT(*) as total FROM candidature WHERE idcand = ? AND statut = 'En attente'";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Erreur de préparation de la requête: " . $this->conn->error);
            return 0;
        }
        
        $stmt->bind_param("i", $idcand);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }
        
        return 0;
    }

     public function getCandidaturesRecentes($idcand, $limit) {
        $sql = "SELECT c.statut, c.date_candidature, o.titre 
                FROM candidature c 
                INNER JOIN offre o ON c.idof = o.idof 
                WHERE c.idcand = ? 
                ORDER BY c.date_candidature DESC 
                LIMIT ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Erreur de préparation de la requête: " . $this->conn->error);
            return [];
        }
        
        $stmt->bind_param("ii", $idcand, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $candidatures = [];
        while ($row = $result->fetch_assoc()) {
            $candidatures[] = $row;
        }

        return $candidatures;
    }

    /**
     * Retourne la classe CSS de badge Bootstrap en fonction du statut.
     * Cette méthode est utilisée dans la vue dashboard.php.
     * @param string $statut Le statut de la candidature.
     * @return string La classe CSS de couleur Bootstrap.
     */
    public static function getBadgeColor($statut) {
        switch (strtolower($statut)) {
            case 'en attente':
                return 'warning';
            case 'acceptée':
                return 'success';
            case 'refusée':
                return 'danger';
            case 'en cours':
                return 'info';
            default:
                return 'secondary';
        }
    }

     public function compterCandidaturesParStatut($idcand) {
        $sql = "SELECT statut, COUNT(*) as total FROM candidature WHERE idcand = ? GROUP BY statut";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Erreur de préparation de la requête: " . $this->conn->error);
            return [];
        }
        
        $stmt->bind_param("i", $idcand);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[$row['statut']] = (int) $row['total'];
        }
        
        return $data;
    }

     public function getCandidaturesParCandidat($idcandidat) {
    $sql = "SELECT c.idcand, o.titre, o.description, o.date_pub, o.lieu, o.type, r.nomrecru AS nom_recruteur
            FROM candidature c
            JOIN offre o ON c.idof = o.idof
            JOIN recruteur r ON o.idrecru = r.idrecru
            WHERE c.idcand = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idcandidat);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

public function compterCandidatureParStatut($idRecruteur, $statut) {
    $sql = "SELECT COUNT(*) AS total 
            FROM candidature c
            INNER JOIN offre o ON c.idof = o.idof
            WHERE o.idrecru = ? AND c.statut = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("is", $idRecruteur, $statut);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['total'];
    }
    return 0;
}
    

    public function getCandidaturesRecentesParRecruteur($idrecru, $limit = 5) {
        $query = "SELECT c.idcandidature, c.date_candidature, ca.nomcand, ca.prncand, o.titre, c.statut 
                  FROM candidature c 
                  JOIN offre o ON c.idof = o.idof 
                  JOIN candidat ca ON c.idcand = ca.idcand
                  WHERE o.idrecru = ?
                  ORDER BY c.date_candidature DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idrecru, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

public function compterCandidatureParRecruteur($idRecruteur) {
    $sql = "SELECT COUNT(*) AS total FROM candidature c
            JOIN offre o ON c.idof = o.idof
            WHERE o.idrecru = ?";
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        error_log("Erreur SQL : " . $this->conn->error);
        return 0;
    }
    $stmt->bind_param("i", $idRecruteur);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result['total'] ?? 0;
}




    public function getLastError() {
    return $this->conn->error;
}

    
}
