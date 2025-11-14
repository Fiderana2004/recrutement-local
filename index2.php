<?php
require_once './model/Recruteur.php';
require_once './controller/RecruteurController.php';
require_once './controller/OffreController.php';
require_once './controller/CandidatureController.php';
require_once './controller/NotificationRecruteurController.php';

session_start();

$recruteurController = new RecruteurController();
$offreController = new OffreController();
$candidatureController = new CandidatureController();
$notificationRecruteurController = new NotificationRecruteurController();

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'recruteur') {
    header('Location: index2.php?page=dashboard');
    exit();
}

$recruteur = $_SESSION['utilisateur'] ?? null;

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'marquerCommeLues') {
        $notificationRecruteurController->marquerCommeLues();
        exit;
    }
    if ($_GET['action'] === 'getNotifications' && isset($_SESSION['utilisateur']['idrecru'])) {
        $notifications = $notificationRecruteurController->getNotificationsByRecruteur($_SESSION['utilisateur']['idrecru']);
        header('Content-Type: application/json');
        echo json_encode($notifications);
        exit;
    }
    if ($_GET['action'] === 'supprimerOffre' && isset($_GET['id'])) {
        $offreController->supprimerOffre($_GET['id']);
        exit;
    }
}

$page = $_GET['page'] ?? 'dashboard';

$nbNotif = 0;
if (isset($_SESSION['utilisateur']['idrecru'])) {
    $notificationsNonLues = $notificationRecruteurController->getNotificationsByRecruteurNonLues($_SESSION['utilisateur']['idrecru']);
    $nbNotif = is_array($notificationsNonLues) ? count($notificationsNonLues) : 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($page) {
        case 'gererProfilRecruteur': $recruteurController->gererProfilRecruteur(); exit;
        case 'uploadPhoto': $recruteurController->uploadPhoto(); exit;
        case 'changerStatutCandidature': $candidatureController->changerStatut(); exit;
        case 'ajouterOffre': $offreController->ajouterOffre(); exit;
        case 'modifierOffre': $offreController->modifierOffre(); exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MadaRec | Recruteur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/icons/bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background-color: #F6F6F6; margin:0; padding:0; }

        /* Sidebar */
        .sidebar { width:250px; height:100vh; position:fixed; top:0; left:0; background-color:#111111; color:white; padding-top:20px; transition:left 0.3s ease; z-index:1100; }

        /* Main content */
        .main-content { margin-left:250px; padding:20px; transition:margin-left 0.3s ease; }

        /* Topbar */
        .topbar { background-color:#ffffff; padding:1rem 2rem; border-bottom:1px solid #e0e0e0; display:flex; justify-content:space-between; align-items:center; box-shadow:0 2px 10px rgba(0,0,0,0.05); }

        #sidebarToggle { display:none; border:none; background:none; font-size:1.5rem; cursor:pointer; margin-right:1rem; }

        .topbar .notif-icon { font-size:1.5rem; color:#333; transition: color 0.3s ease; }
        .topbar .notif-icon:hover { color:#0d6efd; }

        .topbar .profile-pic-container { width:45px; height:45px; border-radius:50%; overflow:hidden; border:2px solid #ddd; box-shadow:0 0 5px rgba(0,0,0,0.1); }
        .profile-pic-container img { width:100%; height:100%; object-fit:cover; }

        .card-box { background-color:#fff; border-radius:15px; padding:20px; box-shadow:0 0 10px rgba(0,0,0,0.1); }

        /* Responsive */
        @media (max-width:992px) {
            .sidebar { left:-250px; }
            .sidebar.active { left:0; }
            #sidebarToggle { display:inline-block; }
            .main-content { margin-left:0 !important; }
            .sidebar-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1050; }
            .sidebar-overlay.active { display:block; }
        }
    </style>
</head>
<body>

<?php include './view/templates/menu/recruteur.php'; ?>
<div class="sidebar-overlay"></div>

<div class="main-content">
    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button id="sidebarToggle" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <h5 class="m-0">MadaRec</h5>
        </div>
        <div class="d-flex align-items-center">
            <!-- Notifications -->
            <div class="dropdown me-3">
                <a class="nav-link position-relative" href="#" role="button" id="notificationDropdownToggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell-fill fs-4 text-dark"></i>
                    <?php if ($nbNotif > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge"><?= $nbNotif ?></span>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" id="notificationMenu"></ul>
            </div>
            <!-- Profil -->
            <div class="profile-pic-container">
                <img src="uploads/<?= htmlspecialchars($recruteur['photorecru']) ?>" alt="Photo Recruteur">
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="content mt-4">
        <?php
        switch ($page) {
            case 'dashboard': $recruteurController->afficherDashboard(); break;
            case 'ajouterOffre': $offreController->index(); break;
            case 'profilrecru':
            case 'gererProfilRecruteur': $recruteurController->gererProfilRecruteur(); break;
            case 'uploadPhoto': $recruteurController->uploadPhoto(); break;
            case 'modifierOffre': $offreController->modifierOffre(); break;
            case 'supprimerOffre': $offreController->supprimerOffre(); break;
            case 'candidatsOffres': include './view/Pages/recruteur/candidatsOffres.php'; break;
            case 'changerStatutCandidature': $candidatureController->changerStatut(); break;
            case 'notification': include './view/Pages/recruteur/notifications.php'; break;
            default: echo "Page non trouvée.";
        }
        ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const toggleBtn = document.getElementById('sidebarToggle');

    function openSidebar() { sidebar.classList.add('active'); overlay.classList.add('active'); document.body.style.overflow='hidden'; }
    function closeSidebar() { sidebar.classList.remove('active'); overlay.classList.remove('active'); document.body.style.overflow=''; }

    toggleBtn.addEventListener('click', () => sidebar.classList.contains('active') ? closeSidebar() : openSidebar());
    overlay.addEventListener('click', closeSidebar);
    window.addEventListener('resize', () => { if(window.innerWidth>992) closeSidebar(); });

    // Notifications
    const notificationDropdownToggle = document.getElementById('notificationDropdownToggle');
    const notificationMenu = document.getElementById('notificationMenu');
    const notificationBadge = document.getElementById('notificationBadge');

    notificationDropdownToggle.addEventListener('click', function(event) {
        event.preventDefault();
        if (!notificationMenu.classList.contains('show')) fetchNotifications();
    });

    

    function fetchNotifications() {
        fetch('index2.php?action=getNotifications')
        .then(res => res.json())
        .then(notifs => {
            let html = '';
            if(notifs.length > 0){
                notifs.forEach(n => { html += `<li><a class="dropdown-item" href="#">${n.message}</a></li>`; });
                html += '<li><hr class="dropdown-divider"></li><li><a class="dropdown-item text-center text-primary" href="#" id="marquerLuesButton">Marquer tout comme lu</a></li>';
            } else {
                html = '<li><a class="dropdown-item" href="#">Aucune nouvelle notification</a></li>';
            }
            notificationMenu.innerHTML = html;

            const btn = document.getElementById('marquerLuesButton');
            if(btn) btn.addEventListener('click', function(e){
                e.preventDefault();
                fetch('index2.php?action=marquerCommeLues')
                .then(r => { if(r.ok){ if(notificationBadge) notificationBadge.style.display='none'; notificationMenu.innerHTML='<li><a class="dropdown-item" href="#">Aucune nouvelle notification</a></li>'; } });
            });
        }).catch(e => console.error(e));
    }
    
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
