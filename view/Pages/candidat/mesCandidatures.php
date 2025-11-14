<?php
require_once './model/Candidature.php';


// Assurez-vous que l'utilisateur est connecté et que l'ID du candidat est disponible
if (!isset($_SESSION['utilisateur']['idcand'])) {
    echo "<div class='alert alert-danger'>Erreur: ID candidat non trouvé.</div>";
    exit;
}

$idcand = $_SESSION['utilisateur']['idcand'];
$nomCompletCandidat = htmlspecialchars($_SESSION['utilisateur']['nomcand'] . ' ' . $_SESSION['utilisateur']['prncand']);

$candModel = new Candidature();
$candidatures = $candModel->getCandidaturesByCandidat($idcand);
?>
<link rel="stylesheet" href="assets/css/mes_candidature.css">

<div class="container-fluid my-candidatures-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title"><i class="bi bi-person-check me-2"></i>Mes Candidatures</h1>
    </div>

    <div class="card shadow-sm my-candidatures-card">
        <div class="card-body">
            <?php if ($candidatures && $candidatures->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover my-candidatures-table">
                        <thead class="table-light">
                            <tr>
                                <th><i class="bi bi-briefcase me-2"></i>Offre Postulée</th>
                                <th><i class="bi bi-person me-2"></i>Nom du Candidat</th>
                                <th><i class="bi bi-file-earmark-text me-2"></i>Documents</th>
                                <th><i class="bi bi-info-circle me-2"></i>Statut</th>
                                <th><i class="bi bi-trash me-2"></i>Action</th> </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $candidatures->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <span class="offre-titre"><?= htmlspecialchars($row['titre']) ?></span>
                                    </td>
                                    <td>
                                        <span class="candidat-nom"><?= $nomCompletCandidat ?></span>
                                    </td>
                                    <td>
                                        <div class="document-links">
                                            <a href="<?= htmlspecialchars($row['cv']) ?>" target="_blank" class="document-link-table">
                                                <i class="bi bi-file-earmark-pdf"></i> CV
                                            </a>
                                            <a href="<?= htmlspecialchars($row['ltrmotivation']) ?>" target="_blank" class="document-link-table">
                                                <i class="bi bi-file-earmark-text"></i> Lettre
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (isset($row['statut'])): ?>
                                            <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $row['statut'])) ?>">
                                                <?= ucfirst($row['statut']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="index1.php?page=supprimerCandidature&id=<?= $row['idcandidature'] ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?')">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-candidatures-message text-center p-5">
                    <i class="bi bi-inbox fs-1 mb-3 text-muted"></i>
                    <p class="fs-5 text-muted">Vous n'avez postulé à aucune offre pour le moment.</p>
                    <a href="index.php?page=offres" class="btn btn-primary mt-3">Découvrir les offres</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>