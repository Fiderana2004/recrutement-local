<!-- Modale pour ajouter une offre -->
<div class="modal fade" id="modalAjoutOffre" tabindex="-1" aria-labelledby="modalAjoutOffreLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="index2.php?page=ajouterOffre" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAjoutOffreLabel">Ajouter une Offre</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="ajoutTitre" class="form-label">Titre</label>
          <input type="text" class="form-control" name="titre" id="ajoutTitre" required>
        </div>
        <div class="mb-3">
          <label for="ajoutDescription" class="form-label">Description</label>
          <input type="text" class="form-control" name="description" id="ajoutDescription" required>
        </div>
        <div class="mb-3">
          <label for="ajoutLieu" class="form-label">Lieu</label>
          <input type="text" class="form-control" name="lieu" id="ajoutLieu" required>
        </div>
         <div class="mb-3">
            <label for="ajoutType" class="form-label">Type</label>
            <select class="form-control" name="type" id="ajoutType" required>
               <option value="" disabled selected>-- Choisissez un type --</option>
              <option value="CDD">CDD</option>
              <option value="Stage">Stage</option>
              <option value="CDI">CDI</option>
              <option value="Alternance">Alternance</option>
             <option value="Freelance">Freelance</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="ajoutContrat" class="form-label">Contrat</label>
          <input type="text" class="form-control" name="contrat" id="ajoutContrat" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
      </div>
    </form>
  </div>
</div>

<script>
// Sélection des champs
const titreInput = document.getElementById('ajoutTitre');
const descriptionInput = document.getElementById('ajoutDescription');
const lieuInput = document.getElementById('ajoutLieu');
const contratInput = document.getElementById('ajoutContrat');

// Fonction pour n'autoriser que lettres, chiffres et espaces de base
function lettresChiffresEspaces(event) {
    const char = String.fromCharCode(event.which);
    if (!/[a-zA-Z0-9À-ÿ\s]/.test(char)) {
        event.preventDefault();
    }
}

// Fonction pour n'autoriser que lettres et espaces (utile pour titre ou lieu si tu veux)
function lettresSeulement(event) {
    const char = String.fromCharCode(event.which);
    if (!/[a-zA-ZÀ-ÿ\s]/.test(char)) {
        event.preventDefault();
    }
}

// Assignation des validations
titreInput.addEventListener('keypress', lettresChiffresEspaces);
descriptionInput.addEventListener('keypress', lettresChiffresEspaces);
lieuInput.addEventListener('keypress', lettresSeulement);
contratInput.addEventListener('keypress', lettresChiffresEspaces);

// Optionnel : tu peux ajouter un contrôle pour le select type si nécessaire (mais le select est déjà limité)
</script>

