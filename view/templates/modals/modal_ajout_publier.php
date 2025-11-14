<!-- Modale pour ajouter un publiert -->
<?php
include_once './model/Recruteur.php';
$recruteurModel = new Recruteur(); // instanciation
$recruteurs = $recruteurModel->getAllRecruteur(); // appel de la méthode


include_once './model/Offre.php';
$offreModel = new Offre(); // instanciation
$offres = $offreModel->getAllOffre(); 

?>
<div class="modal fade" id="modalAjoutPublier" tabindex="-1" aria-labelledby="modalAjoutPublierLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="index2.php?page=publierOffre" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAjoutPublierLabel">Publication</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="idrecru" class="form-label">Recruteur</label>
          <select class="form-select" name="idrecru" required>
            <?php while ($row = $recruteurs->fetch_assoc()): ?>
              <option value="<?= $row['idrecru'] ?>"><?= htmlspecialchars($row['nomrecru']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="idof" class="form-label">Offre</label>
          <select class="form-select" name="idof" required>
            <?php while ($row = $offres->fetch_assoc()): ?>
              <option value="<?= $row['idof'] ?>"><?= htmlspecialchars($row['titre']) ?></option>
            <?php endwhile; ?>
          </select>

        </div>
        <div class="mb-3">
          <label for="datepub" class="form-label">Date de publication</label>
          <input type="date" class="form-control" name="datepub" required>
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Publier</button>
      </div>
    </form>
  </div>
</div>