<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Recruteur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/dashboard_recruteur_style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container-fluid py-4">
    <h1 class="mb-5 text-center dashboard-title">Tableau de bord Recruteur</h1>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card p-4 shadow-sm h-100 stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="icon-circle bg-primary-light text-primary">
                        <i class="bi bi-briefcase-fill fs-4"></i>
                    </div>
                    <span class="fs-6 text-muted">Offres actives</span>
                </div>
                <h5 class="card-title text-muted fw-bold">Offres d'emploi</h5>
                <p class="display-4 fw-bold mb-0 text-dark"><?= $nbOffres ?? 0 ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm h-100 stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="icon-circle bg-success-light text-success">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <span class="fs-6 text-muted">Candidatures totales</span>
                </div>
                <h5 class="card-title text-muted fw-bold">Total candidatures</h5>
                <p class="display-4 fw-bold mb-0 text-dark"><?= $nbCandidatures ?? 0 ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm h-100 stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="icon-circle bg-warning-light text-warning">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <span class="fs-6 text-muted">En attente</span>
                </div>
                <h5 class="card-title text-muted fw-bold">Candidatures en attente</h5>
                <p class="display-4 fw-bold mb-0 text-dark">
<?php 
if (is_array($nbCandidaturesEnAttente)) {
    echo $nbCandidaturesEnAttente['total'] ?? 0;
} else {
    echo $nbCandidaturesEnAttente ?? 0;
}
?>
</p>
            </div>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100 list-card">
                <div class="card-header bg-white fw-bold list-header">
                    <h5 class="mb-0">Dernières offres publiées</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($offresRecentes)): ?>
                        <p class="text-muted text-center">Aucune offre récente.</p>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($offresRecentes as $offre): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center list-item">
                                    <span><?= htmlspecialchars($offre['titre']) ?></span>
                                    <small class="text-muted"><?= htmlspecialchars(date('d M Y', strtotime($offre['date_pub']))) ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm h-100 list-card">
                <div class="card-header bg-white fw-bold list-header">
                    <h5 class="mb-0">Dernières candidatures reçues</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($candidaturesRecentes)): ?>
                        <p class="text-muted text-center">Aucune candidature récente.</p>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($candidaturesRecentes as $candidature): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center list-item">
                                    <div>
                                        <strong><?= htmlspecialchars($candidature['nomcand'] . ' ' . $candidature['prncand']) ?></strong>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars($candidature['titre']) ?></small>
                                    </div>
                                    <?php 
                                        $badgeColor = '';
                                        switch(strtolower($candidature['statut'])) {
                                            case 'acceptée': $badgeColor = 'success'; break;
                                            case 'refusée': $badgeColor = 'danger'; break;
                                            case 'en attente': $badgeColor = 'warning'; break;
                                            default: $badgeColor = 'secondary';
                                        }
                                    ?>
                                    <span class="badge bg-<?= $badgeColor ?>"><?= htmlspecialchars($candidature['statut']) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>