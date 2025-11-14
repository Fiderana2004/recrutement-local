<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'candidat') {
    echo "Accès refusé.";
    exit;
}

$idutil = $_SESSION['utilisateur']['idutil'] ?? null;
?>

<?php if (isset($profil) && $profil): ?>
    <head>
    <link rel="stylesheet" href="./assets/css/profil.css">
</head>
<div class="container profile-form-container">
    <div class="profile-section-title">Photo de profil du Candidat</div>
    <div class="profile-photo-wrapper">
        <img src="uploads/<?php echo htmlspecialchars($profil['photocand'] ?? 'user.jpg'); ?>" class="profile-photo" alt="Profil du Candidat">
        <div class="profile-photo-buttons">
            <form method="POST" action="index1.php?page=gererProfil" enctype="multipart/form-data" class="d-inline-block">
                <label for="photoUpload" class="btn btn-light-outline">Changer</label>
                <input type="file" id="photoUpload" name="photocand" hidden onchange="this.form.submit()">
                <input type="hidden" name="idutil" value="<?php echo htmlspecialchars($idutil); ?>">
            </form>
            <button class="btn btn-light-outline">Supprimer</button>
        </div>
    </div>

    <form method="POST" action="index1.php?page=gererProfil" enctype="multipart/form-data">
        <input type="hidden" name="idutil" value="<?php echo htmlspecialchars($idutil); ?>">

        <div class="row">
            <div class="col-md-6">
                <label for="nomcand" class="form-label-custom">Nom</label>
                <input type="text" id="nomcand" class="form-control-custom" name="nomcand" value="<?php echo htmlspecialchars($profil['nomcand'] ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="prncand" class="form-label-custom">Prénom</label>
                <input type="text" id="prncand" class="form-control-custom" name="prncand" value="<?php echo htmlspecialchars($profil['prncand'] ?? ''); ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="ecand" class="form-label-custom">Email</label>
                <input type="text" id="ecand" class="form-control-custom" name="ecand" value="<?php echo htmlspecialchars($profil['ecand'] ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="numtelcand" class="form-label-custom">Téléphone</label>
                <input type="text" id="numtelcand" class="form-control-custom" name="numtelcand" value="<?php echo htmlspecialchars($profil['numtelcand'] ?? ''); ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="sexe" class="form-label-custom">Sexe</label>
                <select id="sexe" class="form-control-custom" name="sexe">
                    <option value="Homme" <?php echo (isset($profil['sexe']) && $profil['sexe'] == 'Homme') ? 'selected' : ''; ?>>Homme</option>
                    <option value="Femme" <?php echo (isset($profil['sexe']) && $profil['sexe'] == 'Femme') ? 'selected' : ''; ?>>Femme</option>
                    <option value="Autre" <?php echo (isset($profil['sexe']) && $profil['sexe'] == 'Autre') ? 'selected' : ''; ?>>Autre</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="adrscand" class="form-label-custom">Adresse complète</label>
                <input type="text" id="adrscand" class="form-control-custom" name="adrscand" value="<?php echo htmlspecialchars($profil['adrscand'] ?? ''); ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label for="poste" class="form-label-custom">Poste recherché</label>
                <input type="text" id="poste" class="form-control-custom" name="poste" value="<?php echo htmlspecialchars($profil['poste'] ?? ''); ?>">
            </div>
        </div>

        <div class="profile-actions">
            <button type="submit" class="btn btn-save">Enregistrer</button>
        </div>
    </form>
</div>

<?php else: ?>
    <div class="alert alert-danger mt-5 text-center">Impossible de charger le profil du candidat.</div>
    <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'candidat'): ?>
        <p class="text-center mt-3"><a href="index1.php?page=gererProfil" class="btn btn-primary">Créer votre profil candidat</a></p>
    <?php endif; ?>
<?php endif; ?>

<script>
// Sélection de tous les champs
const nomInput = document.getElementById('nomcand');
const prenomInput = document.getElementById('prncand');
const emailInput = document.getElementById('ecand');
const telInput = document.getElementById('numtelcand');
const adresseInput = document.getElementById('adrscand');
const posteInput = document.getElementById('poste');

// Fonction pour n'autoriser que les lettres (et les espaces)
function lettresSeulement(event) {
    const char = String.fromCharCode(event.which);
    if (!/[a-zA-ZÀ-ÿ\s]/.test(char)) {
        event.preventDefault();
    }
}

// Fonction pour n'autoriser que les chiffres
function chiffresSeulement(event) {
    const char = String.fromCharCode(event.which);
    if (!/[0-9]/.test(char)) {
        event.preventDefault();
    }
}

// Assignation des fonctions aux champs correspondants
nomInput.addEventListener('keypress', lettresSeulement);
prenomInput.addEventListener('keypress', lettresSeulement);
posteInput.addEventListener('keypress', lettresSeulement);

// Téléphone uniquement chiffres
telInput.addEventListener('keypress', chiffresSeulement);

// Optionnel : empêcher les caractères spéciaux dans l'adresse (autoriser lettres, chiffres, espaces, virgules et tirets)
adresseInput.addEventListener('keypress', function(event) {
    const char = String.fromCharCode(event.which);
    if (!/[a-zA-Z0-9\s,.-]/.test(char)) {
        event.preventDefault();
    }
});
</script>
