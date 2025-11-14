<?php
// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté ET qu'il a le rôle de recruteur
// Il est crucial de vérifier 'utilisateur' puis son 'role'
if (!isset($_SESSION['utilisateur']) || !isset($_SESSION['utilisateur']['role']) || $_SESSION['utilisateur']['role'] !== 'recruteur') {
    echo "Accès refusé. Veuillez vous connecter en tant que recruteur.";
    exit;
}

// Si la vérification d'accès passe, vous pouvez attribuer les données de session en toute sécurité
$profil = $_SESSION['utilisateur']; // Utilisez $profil car c'est cohérent avec l'utilisation de votre vue
$idutil = $profil['idutil']; // Extrayez idutil si nécessaire pour les formulaires
?>

<?php if ($profil): ?>
    <head>
    <link rel="stylesheet" href="./assets/css/profil.css">
</head>
<div class="container profile-form-container">
    <div class="profile-section-title">Logo de l'entreprise</div>
    <div class="profile-photo-wrapper">
        <img src="uploads/<?php echo htmlspecialchars($profil['photorecru']); ?>" class="profile-photo" alt="Profil">
        <div class="profile-photo-buttons">
            <form method="POST" action="index2.php?page=uploadPhoto" enctype="multipart/form-data" class="d-inline-block">
                <label for="photoUpload" class="btn btn-light-outline">Change</label>
                <input type="file" id="photoUpload" name="photo" hidden onchange="this.form.submit()">
                <input type="hidden" name="idutil" value="<?php echo htmlspecialchars($idutil); ?>">
                <link rel="stylesheet" href="./assets/images/user.jpg">
            </form>
            <button class="btn btn-light-outline">Remove</button>
        </div>
    </div>

     <form method="POST" action="index2.php?page=gererProfilRecruteur">
        <input type="hidden" name="idutil" value="<?php echo htmlspecialchars($idutil); ?>">

        <div class="row">
            <div class="col-md-6">
                <label for="firstName" class="form-label-custom">Nom de l'entreprise</label>
                <input type="text" id="firstName" class="form-control-custom" name="nomrecru" value="<?php echo htmlspecialchars($profil['nomrecru'] ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label-custom">Téléphone professionnel</label>
                <input type="text" id="phone" class="form-control-custom" name="numtelrecru" value="<?php echo htmlspecialchars($profil['numtelrecru'] ?? ''); ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="adrsrecru" class="form-label-custom">Adresse complète</label>
                <input type="text" id="adrsrecru" class="form-control-custom" name="adrsrecru" value="<?php echo htmlspecialchars($profil['adrsrecru'] ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label-custom">E-mail professionnel</label>
                <input type="email" id="email" class="form-control-custom" name="email" value="<?php echo htmlspecialchars($profil['email'] ?? ''); ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="siteweb" class="form-label-custom">Site Web officiel</label>
                <input type="text" id="siteweb" class="form-control-custom" name="siteweb" value="<?php echo htmlspecialchars($profil['siteweb'] ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="secteur" class="form-label-custom">Secteur d'activité</label>
                <input type="text" id="secteur" class="form-control-custom" name="secteur" value="<?php echo htmlspecialchars($profil['secteur'] ?? ''); ?>">
            </div>
        </div>

        <div class="profile-actions">
            <button type="submit" class="btn btn-save">Enregistrer</button>
        </div>
    </form>
</div>

<?php else: ?>
    <div class="alert alert-danger mt-5 text-center">Impossible de charger le profil du candidat.</div>
    <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'recruteur'): ?>
        <p class="text-center mt-3"><a href="index1.php?page=gererProfilRecruteur" class="btn btn-primary">Créer votre profil recruteur</a></p>
    <?php endif; ?>
<?php endif; ?>

<script>
// Sélection des champs
const nomEntrepriseInput = document.getElementById('firstName');
const telProInput = document.getElementById('phone');
const adresseInput = document.getElementById('adrsrecru');
const siteWebInput = document.getElementById('siteweb');
const secteurInput = document.getElementById('secteur');

// Fonction pour n'autoriser que les lettres et espaces
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

// Fonction pour l'adresse : lettres, chiffres, espaces, virgules et tirets
function adresseValide(event) {
    const char = String.fromCharCode(event.which);
    if (!/[a-zA-Z0-9\s,.-]/.test(char)) {
        event.preventDefault();
    }
}

// Assignation des validations
nomEntrepriseInput.addEventListener('keypress', lettresSeulement);
secteurInput.addEventListener('keypress', lettresSeulement);

telProInput.addEventListener('keypress', chiffresSeulement);

adresseInput.addEventListener('keypress', adresseValide);

// Optionnel : validation site web pour éviter caractères interdits
siteWebInput.addEventListener('keypress', function(event){
    const char = String.fromCharCode(event.which);
    // Autoriser lettres, chiffres, points, tirets et slash
    if (!/[a-zA-Z0-9./:-]/.test(char)) {
        event.preventDefault();
    }
});
</script>


