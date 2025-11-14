<?php
// Assurez-vous que la session est démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification de sécurité pour s'assurer que le candidat est connecté
if (!isset($_SESSION['utilisateur']['idcand'])) {
    header('Location: index.php?page=login');
    exit();
}

require_once './model/Notification.php';

$notifModel = new Notification();
$idcand = $_SESSION['utilisateur']['idcand'];
$toutesNotif = $notifModel->getAllNotifications($idcand);
?>
<head>
    <link rel="stylesheet" href="./assets/css/notifications.css">
</head>
<div class="container-fluid notifications-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title"><i class="bi bi-bell-fill me-2"></i>Mes Notifications</h1>
        <div>
            <a href="index1.php?page=supprimerToutesNotifs" class="btn btn-outline-danger btn-sm me-2"
               onclick="return confirm('Êtes-vous sûr de vouloir supprimer toutes vos notifications ? Cette action est irréversible.')">
                <i class="bi bi-trash-fill me-1"></i> Supprimer tout
            </a>
            <a href="index1.php?page=marquerNotifsLues" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-check-all me-1"></i> Marquer toutes comme lues
            </a>
        </div>
    </div>

    <div class="card shadow-sm notifications-card">
        <div class="card-body">
            <?php if ($toutesNotif && $toutesNotif->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover notifications-table">
                        <thead class="table-light">
                            <tr>
                                <th><i class="bi bi-chat-square-dots me-2"></i>Message</th>
                                <th style="width: 150px;"><i class="bi bi-calendar-event me-2"></i>Date</th>
                                <th style="width: 100px;"><i class="bi bi-check-circle me-2"></i>Statut</th>
                                <th style="width: 80px;"><i class="bi bi-trash me-2"></i>Action</th> </tr>
                        </thead>
                        <tbody>
                            <?php while ($notif = $toutesNotif->fetch_assoc()): ?>
                                <tr class="<?= $notif['est_lu'] ? 'notif-read' : 'notif-unread' ?>">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-info-circle me-3 fs-5 text-secondary"></i>
                                            <?= htmlspecialchars($notif['message']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= htmlspecialchars($notif['date_notif']) ?></small>
                                    </td>
                                    <td>
                                        <?php if ($notif['est_lu']): ?>
                                            <span class="badge bg-secondary text-white notif-badge"><i class="bi bi-check me-1"></i> Lu</span>
                                        <?php else: ?>
                                            <span class="badge bg-success text-white notif-badge"><i class="bi bi-exclamation-circle me-1"></i> Non lu</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="index1.php?page=supprimerNotif&id=<?= $notif['idnotif'] ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')">
                                           <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-notifications-message text-center p-5">
                    <i class="bi bi-bell-slash fs-1 mb-3 text-muted"></i>
                    <p class="fs-5 text-muted">Vous n'avez aucune notification pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>