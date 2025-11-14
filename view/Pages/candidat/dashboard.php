<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Candidat</title>
    <link rel="stylesheet" href="./assets/css/dashboard_candidat_style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<div class="container-fluid dashboard-container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center">
            <img src="uploads/<?= htmlspecialchars($candidat['photocand'] ?? 'default.png') ?>" 
                 class="profile-pic-large me-3" alt="Photo de profil">
            <h1 class="welcome-title">Bonjour, <?= htmlspecialchars($candidat['nomcand']) ?> !</h1>
        </div>
        <p class="text-muted mb-0">Bienvenue sur votre tableau de bord.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted mb-2">Candidatures en cours</h5>
                            <h2 class="display-4 fw-bold text-primary"><?= $nbCandidatures ?></h2>
                        </div>
                        <i class="bi bi-person-workspace stat-icon text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted mb-2">Nouvelles offres</h5>
                            <h2 class="display-4 fw-bold text-success"><?= $nbNouvellesOffres ?></h2>
                        </div>
                        <i class="bi bi-briefcase stat-icon text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted mb-2">Notifications</h5>
                            <h2 class="display-4 fw-bold text-danger"><?= $nbNotifications ?></h2>
                        </div>
                        <i class="bi bi-bell stat-icon text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <div class="card p-4 shadow-sm border-0 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Mes dernières candidatures</h4>
                    <a href="index1.php?page=mesCandidatures" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Offre</th>
                                <th>Statut</th>
                                <th>Date de candidature</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($candidaturesRecentes)): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Aucune candidature récente.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($candidaturesRecentes as $candidature): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($candidature['titre']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= Candidature::getBadgeColor($candidature['statut']) ?>">
                                                <?= htmlspecialchars($candidature['statut']) ?>
                                            </span>
                                        </td>
                                        <td><small class="text-muted"><?= htmlspecialchars($candidature['date_candidature']) ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card p-4 shadow-sm border-0 h-100">
                <h4 class="card-title mb-3">Complétez votre profil</h4>
                <p class="text-muted">
                    Un profil complet augmente vos chances d'être contacté par les recruteurs.
                </p>
                <div class="progress mb-3" style="height: 25px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" 
                         style="width: <?= $pourcentageProfil ?>%;" aria-valuenow="<?= $pourcentageProfil ?>" 
                         aria-valuemin="0" aria-valuemax="100">
                        <?= $pourcentageProfil ?>%
                    </div>
                </div>
                <a href="index1.php?page=profilcand" class="btn btn-outline-primary mt-auto">
                    Mettre à jour mon profil
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-5">
        <div class="col-lg-6">
            <div class="card p-4 shadow-sm border-0 h-100">
                <h4 class="card-title mb-4">Répartition des candidatures</h4>
                <canvas id="candidaturePieChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card p-4 shadow-sm border-0 h-100">
                <h4 class="card-title mb-4">Offres par type de contrat</h4>
                <canvas id="contratBarChart"></canvas>
            </div>
        </div>
    </div>
    </div>

<script>
    // 1. Graphique en camembert (répartition des candidatures)
    const statutData = <?= json_encode($statutCandidatures) ?>;
    const labelsPie = Object.keys(statutData);
    const dataValuesPie = Object.values(statutData);

    const ctxPie = document.getElementById('candidaturePieChart');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: labelsPie,
            datasets: [{
                label: 'Nombre de candidatures',
                data: dataValuesPie,
                backgroundColor: [
                    'rgba(255, 193, 7, 0.7)',  // warning (jaune)
                    'rgba(25, 135, 84, 0.7)',  // success (vert)
                    'rgba(220, 53, 69, 0.7)',  // danger (rouge)
                    'rgba(13, 110, 253, 0.7)', // primary (bleu)
                    'rgba(108, 117, 125, 0.7)' // secondary (gris)
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                const total = dataValuesPie.reduce((a, b) => a + b, 0);
                                label += context.parsed + ' (' + ((context.parsed / total) * 100).toFixed(2) + '%)';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    // 2. Graphique en histogramme (offres par type de contrat)
    const contratData = <?= json_encode($offresParContrat) ?>;
    const labelsBar = Object.keys(contratData);
    const dataValuesBar = Object.values(contratData);

    const ctxBar = document.getElementById('contratBarChart');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labelsBar,
            datasets: [{
                label: 'Nombre d\'offres',
                data: dataValuesBar,
                backgroundColor: 'rgba(13, 110, 253, 0.7)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>