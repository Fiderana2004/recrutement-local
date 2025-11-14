<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres d'emploi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="./assets/css/offres_candidat_style.css">
</head>
<body>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 10px; left: 50%; transform: translateX(-50%); z-index: 1050; width: 90%; max-width: 500px;">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 10px; left: 50%; transform: translateX(-50%); z-index: 1050; width: 90%; max-width: 500px;">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); endif; ?>    

    <div class="container py-4">
        <h2 class="mb-5 text-center section-title">Les offres d'emploi qui vous correspondent</h2>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (empty($offres)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center" role="alert">
                        Aucune offre d'emploi trouvée pour le moment.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($offres as $offre): ?>
                    <?php 
                        $recruteurModel = new Recruteur();
                        $recruteur = $recruteurModel->getRecruteurParId($offre['idrecru']);
                    ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 offre-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-start mb-3">
                                    <img src="uploads/<?= htmlspecialchars($recruteur['photorecru'] ?? 'default_logo.png') ?>" 
                                            class="rounded-circle me-3 offre-logo" 
                                            alt="Logo entreprise">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1 fw-bold"><?= htmlspecialchars($offre['titre']) ?></h5>
                                        <p class="card-subtitle text-muted small"><?= htmlspecialchars($recruteur['nomrecru'] ?? 'Nom entreprise non disponible') ?></p>
                                    </div>
                                </div>
                                <p class="card-text text-muted offre-description">
                                    <?= substr(htmlspecialchars($offre['description']), 0, 150) ?>...
                                </p>

                                <ul class="list-unstyled offre-details mt-auto">
                                    <li class="mb-2">
                                        <i class="bi bi-geo-alt-fill me-2 text-primary"></i> 
                                        <span class="text-secondary"><?= htmlspecialchars($offre['lieu']) ?></span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-briefcase-fill me-2 text-success"></i> 
                                        <span class="text-secondary"><?= htmlspecialchars($offre['type']) ?></span>
                                    </li>
                                </ul>

                                <div class="mt-4">
                                    <button type="button"
                                            class="btn btn-primary w-100 btn-postuler"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalAjoutCandidature"
                                            data-idoffre="<?= $offre['idof'] ?>"
                                            data-titre="<?= htmlspecialchars($offre['titre']) ?>"
                                            data-nom="<?= htmlspecialchars($_SESSION['utilisateur']['nomcand'] ?? '') ?>">
                                        <i class="fas fa-paper-plane me-2"></i> Postuler
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php
    include './view/templates/modals/modal_ajout_candidature.php';
    ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const postulerBtns = document.querySelectorAll('.btn-postuler');
        postulerBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const idOffre = this.getAttribute('data-idoffre');
                const titre = this.getAttribute('data-titre');
                const nom = this.getAttribute('data-nom');

                document.getElementById('input_id_offre').value = idOffre;
                document.getElementById('titre_offre').value = titre;
                document.getElementById('nom_candidat').value = nom;
            });
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>