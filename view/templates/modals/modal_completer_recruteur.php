<!-- Modal -->
<div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="index.php?page=sauverProfilRecruteur" method="POST" enctype="multipart/form-data">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title"><?= $recruteurExiste ? 'Modifier' : 'Compléter' ?> le profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="idutil" value="<?= $_SESSION['idutil'] ?? '' ?>">
          <div class="mb-3">
            <label for="nomrecru" class="form-label">Nom</label>
            <input type="text" name="nomrecru" class="form-control" value="<?= $recruteur['nomrecru'] ?? '' ?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $recruteur['email'] ?? '' ?>" required>
          </div>
          <div class="mb-3">
            <label for="numtelrecru" class="form-label">Téléphone</label>
            <input type="text" name="numtelrecru" class="form-control" value="<?= $recruteur['numtelrecru'] ?? '' ?>" required>
          </div>
          <div class="mb-3">
            <label for="photorecru" class="form-label">Photo</label>
            <input type="file" name="photorecru" class="form-control" accept="image/*">
            <?php if (!empty($recruteur['photorecru'])): ?>
              <small class="text-muted">Photo actuelle : <?= basename($recruteur['photorecru']) ?></small>
            <?php endif; ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-dark">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>
