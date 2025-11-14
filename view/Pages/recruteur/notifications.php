<?php
// Assurez-vous que la session est démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification de sécurité pour s'assurer que le recruteur est connecté
if (!isset($_SESSION['utilisateur']['idrecru'])) {
    header('Location: index.php?page=login');
    exit();
}

// Remplacez par le chemin correct de votre contrôleur
require_once './controller/NotificationRecruteurController.php';

$notifCtrl = new NotificationRecruteurController();
$idRecru = $_SESSION['utilisateur']['idrecru'] ?? null;

if ($idRecru === null) {
    echo "Erreur : recruteur non identifié.";
    exit;
}

$notifications = $notifCtrl->getNotificationsByRecruteur($idRecru);
$notifCtrl->marquerCommeLues($idRecru); // Marquer comme lues
?>

<head>
    <link rel="stylesheet" href="./assets/css/notification_recruteur.css">
</head>
<div class="container-fluid notifications-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title"><i class="bi bi-bell-fill me-2"></i>Notifications Recruteur</h1>
        <div>
            <a href="index2.php?page=supprimerToutesNotifsRecru" class="btn btn-outline-danger btn-sm me-2"
               onclick="return confirm('Êtes-vous sûr de vouloir supprimer toutes vos notifications ? Cette action est irréversible.')">
                <i class="bi bi-trash-fill me-1"></i> Supprimer tout
            </a>
            <a href="index2.php?page=marquerNotifsLuesRecru" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-check-all me-1"></i> Marquer toutes comme lues
            </a>
        </div>
    </div>

    <div class="notifications-list">
        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $notif): ?>
                <div class="notification-item card shadow-sm mb-3 <?= $notif['lu'] ? 'notif-read' : 'notif-unread' ?>">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-check-fill me-3 fs-4 text-primary"></i>
                            <div>
                                <h6 class="notif-message mb-1">
                                    <?= htmlspecialchars($notif['message']) ?>
                                </h6>
                                <p class="notif-date text-muted mb-0">
                                    <i class="bi bi-clock me-1"></i><?= htmlspecialchars($notif['date_notif']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <?php if (!$notif['lu']): ?>
                                <span class="badge bg-success notif-badge me-3"><i class="bi bi-star-fill me-1"></i>Nouvelle</span>
                            <?php endif; ?>
                            <form method="post" action="index2.php?page=notification">
                                <input type="hidden" name="id_notif" value="<?= htmlspecialchars($notif['id']) ?>">
                                <button type="submit" name="supprimer" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-notifications-message text-center p-5">
                <i class="bi bi-bell-slash fs-1 mb-3 text-muted"></i>
                <p class="fs-5 text-muted">Vous n'avez aucune notification pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
    $notifCtrl->supprimer($_POST['id_notif']);
    header("Location: index2.php?page=notification");
    exit;
}
?>