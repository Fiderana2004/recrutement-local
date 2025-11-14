<?php

session_start();
require_once './model/Candidature.php';
require_once './model/Notification.php';
require_once './model/Candidat.php';
require_once './controller/CandidatController.php';
require_once './controller/CandidatureController.php';


if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'candidat') {
    header('Location: index.php?page=login');
    exit();
}

$page = $_GET['page'] ?? 'dashboard';

$candidatureController = new CandidatureController();
$candidatController = new CandidatController(); 
$notifModel = new Notification();

if ($page === 'gererProfil' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidatController->gererProfil();
    exit;
}

switch ($page) {
    case 'supprimerCandidature':
        if (isset($_GET['id'])) {
            $idcandidature = $_GET['id'];
            $candidatureController->supprimerCandidature($idcandidature);
        } else {
            header('Location: index1.php?page=mesCandidatures');
        }
        exit;
    case 'ajouterCandidature':
        $candidatureController->ajouterCandidature();
        exit;
    case 'uploadphotocand':
        $candidatController->uploadPhoto();
        exit;
    case 'marquerNotifsLues':
        $candidatController->marquerNotifsLues();
        exit;
    case 'supprimerNotif':
        if (isset($_GET['id'])) {
            $idnotif = $_GET['id'];
            if ($notifModel->supprimerNotification($idnotif, $_SESSION['utilisateur']['idcand'])) {
                 $_SESSION['message'] = "Notification supprimée avec succès.";
            } else {
                 $_SESSION['message'] = "Erreur: Notification introuvable ou vous n'êtes pas autorisé.";
            }
        }
        header('Location: index1.php?page=notification');
        exit;
    case 'supprimerToutesNotifs':
        if ($notifModel->supprimerToutesNotifications($_SESSION['utilisateur']['idcand'])) {
             $_SESSION['message'] = "Toutes les notifications ont été supprimées.";
        } else {
             $_SESSION['message'] = "Erreur lors de la suppression des notifications.";
        }
        header('Location: index1.php?page=notification');
        exit;
}

$candidat = $_SESSION['utilisateur'];
$nbNotif = $notifModel->compterNotificationsNonLues($candidat['idcand']);
$notifications = $notifModel->getNotificationsNonLues($candidat['idcand']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MadaRec | Candidat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/icons/bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background-color: #F6F6F6; margin:0; padding:0; }
        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background-color: #111111;
            color: white;
            padding-top: 20px;
            transition: left 0.3s ease;
            z-index: 1100;
        }

        /* Main content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* Topbar */
        .topbar {
            background-color: #ffffff;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Bouton burger dans la topbar */
        #sidebarToggle {
            display: none; /* caché par défaut */
            border: none;
            background: none;
            font-size: 1.5rem;
            cursor: pointer;
            margin-right: 1rem;
        }

        .topbar .notif-icon {
            font-size: 1.5rem;
            color: #333;
            transition: color 0.3s ease;
        }
        
        .topbar .notif-icon:hover {
            color: #0d6efd;
        }

        .topbar .profile-pic-container {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #ddd;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .card-box {
            background-color: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                left: -250px;
            }
            .sidebar.active {
                left: 0;
            }
            #sidebarToggle {
                display: inline-block;
            }
            .main-content {
                margin-left: 0 !important;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1050;
            }
            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
</head>
<body>

    <?php include './view/templates/menu/candidat.php'; ?>

    <div class="sidebar-overlay"></div>

    <div class="main-content">
        <div class="topbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <!-- Bouton burger (visible sur mobile) -->
                <button id="sidebarToggle" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="m-0">MadaRec</h5>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown me-3">
                    <a class="text-dark position-relative notif-icon" href="#" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-4"></i>
                        <?php if ($nbNotif > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $nbNotif ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown">
                        <?php if ($nbNotif > 0): ?>
                            <?php while ($notif = $notifications->fetch_assoc()): ?>
                                <li class="dropdown-item small">
                                    <?= htmlspecialchars($notif['message']) ?><br>
                                    <small class="text-muted"><?= htmlspecialchars($notif['date_notif']) ?></small>
                                </li>
                            <?php endwhile; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a href="index1.php?page=marquerNotifsLues" class="dropdown-item text-primary">Marquer comme lues</a></li>
                        <?php else: ?>
                            <li class="dropdown-item text-muted">Aucune nouvelle notification</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="profile-pic-container"> 
                    <img src="uploads/<?= htmlspecialchars($candidat['photocand'] ?? 'default.png') ?>" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;" alt="Photo Candidat">
                </div>
            </div>
        </div>

        <div class="content mt-4">
            <?php
            switch ($page) {
                case 'dashboard':
                    $candidatController->afficherDashboard();
                    break;
                case 'offresCandidat':
                    $candidatController->voirOffresPoste();
                    break;
                case 'profilcand':
                case 'gererProfil':
                    $candidatController->gererProfil();
                    break;
                case 'mesCandidatures':
                    $candidatController->mesCandidatures(); 
                    break;
                case 'notifications':
                    include './view/Pages/candidat/notification.php';
                    break;
                default:
                    $candidatController->afficherDashboard();
                    break;
            }
            ?>
        </div>
    </div>

<script>
    // Toggle sidebar and overlay on small screens
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const toggleBtn = document.getElementById('sidebarToggle');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });

    // Déconnexion avec confirmation
    document.getElementById('logoutButton')?.addEventListener('click', function(event) {
        event.preventDefault();
        if (confirm("Êtes-vous sûr de vouloir quitter votre session ?")) {
            window.location.href = './view/Pages/utilisateur/logout.php';
        }
    });
</script>

</body>
</html>
