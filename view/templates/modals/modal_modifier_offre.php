<!-- Modal    Offre -->
<div class="modal fade" id="modifierModalOffre" tabindex="-1" aria-labelledby="modifierModalOffreLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="index2.php?page=modifierOffre" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modifierModalOffreLabel">Modifier une offre</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="offreId" name="idof">


        <div class="mb-3">
          <label for="modifTitre" class="form-label">Titre</label>
          <input type="text" class="form-control" id="modifTitre" name="titre" required>
        </div>

        <div class="mb-3">
          <label for="modifDescription" class="form-label">Description</label>
          <input type="text" class="form-control" id="modifDescription" name="description" required>
        </div>

        <div class="mb-3">
          <label for="modifLieu" class="form-label">Lieu</label>
          <input type="text" class="form-control" id="modifLieu" name="lieu" required>
        </div>

<div class="mb-3">
  <label for="modifType" class="form-label">Type</label>
  <select class="form-control" id="modifType" name="type" required>
    <option value="" disabled>-- Choisissez un type --</option>
    <option value="CDD">CDD</option>
    <option value="Stage">Stage</option>
    <option value="CDI">CDI</option>
    <option value="Alternance">Alternance</option>
    <option value="Freelance">Freelance</option>
  </select>
</div>

        <div class="mb-3">
          <label for="modifContrat" class="form-label">Contrat</label>
          <input type="text" class="form-control" id="modifContrat" name="contrat" required>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Modifier</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modifierModalOffre = document.getElementById('modifierModalOffre');

  modifierModalOffre.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    document.getElementById('offreId').value = button.getAttribute('data-id');
    document.getElementById('modifTitre').value = button.getAttribute('data-titre');
    document.getElementById('modifDescription').value = button.getAttribute('data-description');
    document.getElementById('modifLieu').value = button.getAttribute('data-lieu');
    document.getElementById('modifType').value = button.getAttribute('data-type');
    document.getElementById('modifContrat').value = button.getAttribute('data-contrat');
  });
});
</script>
