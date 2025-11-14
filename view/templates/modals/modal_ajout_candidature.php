<?php
// Assurez-vous que l'utilisateur est connecté
$idcand = $_SESSION['utilisateur']['idcand'] ?? null;
$nom_candidat = $_SESSION['utilisateur']['nomcand'] ?? ''; // Utiliser 'nomcand'
?>
<div class="modal fade" id="modalAjoutCandidature" tabindex="-1" aria-labelledby="modalAjoutCandidatureLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content custom-modal-content">
      <form action="index1.php?page=ajouterCandidature" method="post" enctype="multipart/form-data" class="d-flex flex-column h-100">
        <div class="modal-header custom-modal-header">
          <h5 class="modal-title" id="modalAjoutCandidatureLabel">
            <i class="fas fa-file-signature me-2 icon-pulse"></i> Candidature pour l'Offre
          </h5>
          <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>

        <div class="modal-body custom-modal-body flex-grow-1">
          <input type="hidden" name="id_offre" id="input_id_offre">
          <input type="hidden" name="id_candidat" value="<?= htmlspecialchars($idcand) ?>">

          <div class="mb-4 form-group-animated">
            <label for="titre_offre" class="form-label d-flex align-items-center">
              <i class="fas fa-briefcase me-2 text-success"></i> Offre concernée
            </label>
            <input type="text" id="titre_offre" class="form-control custom-file-input" readonly>
          </div>

          <div class="mb-4 form-group-animated">
            <label for="nom_candidat" class="form-label d-flex align-items-center">
              <i class="fas fa-user me-2 text-secondary"></i> Vous postulez en tant que :
            </label>
            <input type="text" id="nom_candidat" class="form-control custom-file-input" value="<?= htmlspecialchars($nom_candidat) ?>" readonly>
          </div>

          <div class="mb-4 form-group-animated">
            <label for="cv" class="form-label d-flex align-items-center">
              <i class="fas fa-file-upload me-2 text-primary"></i> Votre CV <span class="text-muted ms-2">(Format PDF requis)</span>
            </label>
            <input type="file" name="cv" id="cv" accept="application/pdf" class="form-control custom-file-input" required>
            <small class="form-text text-muted mt-1">Veuillez télécharger votre curriculum vitae en format PDF.</small>
          </div>

          <div class="mb-4 form-group-animated">
            <label for="ltrmotivation" class="form-label d-flex align-items-center">
              <i class="fas fa-envelope me-2 text-info"></i> Votre Lettre de Motivation <span class="text-muted ms-2">(Format PDF requis)</span>
            </label>
            <input type="file" name="ltrmotivation" id="ltrmotivation" accept="application/pdf" class="form-control custom-file-input" required>
            <small class="form-text text-muted mt-1">N'oubliez pas d'inclure votre lettre de motivation en format PDF.</small>
          </div>
        </div>

        <div class="modal-footer custom-modal-footer">
          <button type="button" class="btn btn-outline-secondary custom-btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-2"></i> Annuler
          </button>
          <button type="submit" name="ajouter_candidature" class="btn-submit-candidature">
             <i class="fas fa-paper-plane me-2"></i> Envoyer ma candidature
          </button>
        </div>
      </form>
    </div>
  </div>
</div>