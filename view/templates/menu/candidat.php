<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$candidat = $_SESSION['utilisateur'];
$page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Candidat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/sidebar_candidat.css">
</head>
<body>

<div class="sidebar d-flex flex-column" id="sidebar-menu">
    <div class="sidebar-header">
        <a href="index1.php?page=profilcand" class="user-profile-link">
            <div class="user-profile">
                <div class="profile-image">
                    <?php if (isset($candidat['photocand']) && file_exists('./uploads/' . $candidat['photocand'])): ?>
                        <img src="./uploads/<?= $candidat['photocand'] ?>" alt="Profil" class="rounded-circle">
                    <?php else: ?>
                        <img src="./assets/images/user.jpg" alt="Profil par défaut" class="rounded-circle">
                    <?php endif; ?>
                </div>
                <div class="profile-info">
                    <h6 class="username"><?= htmlspecialchars($candidat['nomcand']) ?></h6>
                    <p class="user-role">Mon compte</p>
                </div>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="index1.php?page=dashboard" class="nav-link <?= ($page === 'dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-grid-1x2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index1.php?page=offresCandidat" class="nav-link <?= ($page === 'offresCandidat') ? 'active' : '' ?>">
                    <i class="bi bi-briefcase"></i>
                    <span>Offres</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index1.php?page=mesCandidatures" class="nav-link <?= ($page === 'mesCandidatures') ? 'active' : '' ?>">
                    <i class="bi bi-journal-check"></i>
                    <span>Candidatures</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index1.php?page=notifications" class="nav-link <?= ($page === 'notifications') ? 'active' : '' ?>">
                    <i class="bi bi-bell"></i>
                    <span>Notifications</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <hr class="separator">
        <ul class="nav flex-column">
            <li class="nav-item logout-link">
                <a href="#"id="logoutButton" class="nav-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Déconnexion</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>