<?php
// view/Pages/recruteur/ajouterOffre.php

include './view/templates/menu/recruteur.php';

// ✅ Vérifie si $result est défini, sinon le définit à null
if (!isset($result)) {
    $result = null;
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Offres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/liste_offres.css">
</head>

<body>
<div class="container my-5">
    <div class="header-container mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
            <form method="GET" action="index2.php" class="d-flex flex-grow-1 gap-2">
                <input type="hidden" name="page" value="ajouterOffre">
                <div class="input-group">
                    <input type="text" name="recherche" class="form-control modern-input" placeholder="🔍 Rechercher par titre ou lieu" value="<?= htmlspecialchars($_GET['recherche'] ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-primary d-none d-sm-inline"><i class="fas fa-search"></i></button>
            </form>
            <button type="button" class="btn btn-primary-alt" data-bs-toggle="modal" data-bs-target="#modalAjoutOffre">
                <i class="fas fa-plus-circle"></i> Ajouter une Offre
            </button>
        </div>
    </div>
    
    <?php include './view/templates/modals/modal_ajout_offre.php'; ?>

    <div class="offers-container">
        <div class="d-none d-md-flex table-header-row row mx-0 mb-2">
            <div class="col-md-1">Code</div>
            <div class="col-md-2">Titre</div>
            <div class="col-md-3">Description</div>
            <div class="col-md-1">Lieu</div>
            <div class="col-md-1">Type</div>
            <div class="col-md-1">Contrat</div>
            <div class="col-md-2 text-end">Action</div>
        </div>

        <?php if ($result instanceof mysqli_result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card modern-card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-1"><span class="d-md-none label">Code: </span><?= htmlspecialchars($row["idof"]) ?></div>
                            <div class="col-md-2"><span class="d-md-none label">Titre: </span><?= htmlspecialchars($row["titre"]) ?></div>
                            <div class="col-md-3 description-cell"><span class="d-md-none label">Description: </span><span class="description-text"><?= htmlspecialchars($row["description"]) ?></span></div>
                            <div class="col-md-1"><span class="d-md-none label">Lieu: </span><?= htmlspecialchars($row["lieu"]) ?></div>
                            <div class="col-md-1"><span class="d-md-none label">Type: </span><?= htmlspecialchars($row["type"]) ?></div>
                            <div class="col-md-1"><span class="d-md-none label">Contrat: </span><?= htmlspecialchars($row["contrat"]) ?></div>
                            <div class="col-md-2 text-end mt-2 mt-md-0">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-icon-edit"
                                       data-bs-toggle="modal"
                                       data-bs-target="#modifierModalOffre"
                                       data-id="<?= htmlspecialchars($row['idof']) ?>"
                                       data-titre="<?= htmlspecialchars($row['titre']) ?>"
                                       data-description="<?= htmlspecialchars($row['description']) ?>"
                                       data-lieu="<?= htmlspecialchars($row['lieu']) ?>"
                                       data-type="<?= htmlspecialchars($row['type']) ?>"
                                       data-contrat="<?= htmlspecialchars($row['contrat']) ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="index2.php?page=ajouterOffre&action=supprimerOffre&id=<?= htmlspecialchars($row['idof']) ?>"
                                       class="btn btn-icon-delete"
                                       onclick="return confirm('Supprimer cette offre ?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info text-center mt-4">
                <i class="fas fa-info-circle me-2"></i> Aucune offre trouvée pour votre compte.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include './view/templates/modals/modal_modifier_offre.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>