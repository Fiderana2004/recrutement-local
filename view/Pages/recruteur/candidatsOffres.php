<?php
require_once './model/Candidature.php';
$idrecru = $_SESSION['utilisateur']['idrecru'];


$model = new Candidature();
$candidatures = $model->getCandidaturesPourRecruteur($idrecru);
?>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/liste_candidatures.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    </head>
<div class="container-fluid candidatures-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title"><i class="bi bi-people-fill me-2"></i>Candidatures Reçues</h1>
        <div class="candidatures-actions">
            <input type="search" class="form-control search-input" placeholder="Rechercher un candidat...">
            <button class="btn btn-outline-secondary filter-btn">
                <i class="bi bi-filter"></i> Filtrer
            </button>
            <button id="exportBtn" class="btn btn-primary export-btn">
                <i class="bi bi-box-arrow-up"></i> Exporter
            </button>
        </div>
    </div>

    <div class="candidatures-list-container">
        <?php if ($candidatures && $candidatures->num_rows > 0): ?>
            <div class="candidatures-header-row">
                <div class="header-cell candidate-info-header">Candidat</div>
                <div class="header-cell">Offre Postulée</div>
                <div class="header-cell">Documents</div>
                <div class="header-cell">Statut</div>
                <div class="header-cell actions-header">Action</div>
            </div>

            <?php while ($c = $candidatures->fetch_assoc()): ?>
                <div class="candidature-item">
                    <div class="candidate-info">
                        <div class="candidate-photo-wrapper">
                            <?php 
                            $photoPath = './uploads/' . htmlspecialchars($c['photocand']);
                            if (isset($c['photocand']) && file_exists($photoPath) && !empty($c['photocand'])):
                            ?>
                                <img src="<?= $photoPath ?>" alt="Photo de <?= htmlspecialchars($c['nomcand']) ?>" class="candidate-photo">
                            <?php else: ?>
                                <img src="/recrutement-local/assets/images/user.jpg" alt="Photo par défaut" class="candidate-photo">
                            <?php endif; ?>
                        </div>
                        <div class="candidate-details">
                            <div class="candidate-name"><?= htmlspecialchars($c['nomcand'] . ' ' . $c['prncand']) ?></div>
                            <div class="candidate-email"><?= htmlspecialchars($c['emailcand']) ?></div>
                        </div>
                    </div>
                    <div class="offer-title"><?= htmlspecialchars($c['titre']) ?></div>
                    <div class="documents-links">
                        <a href="<?= htmlspecialchars($c['cv']) ?>" target="_blank" class="document-link">
                            <i class="bi bi-file-earmark-text"></i> CV
                        </a>
                        <a href="<?= htmlspecialchars($c['ltrmotivation']) ?>" target="_blank" class="document-link">
                            <i class="bi bi-file-earmark-text"></i> Lettre
                        </a>
                    </div>
                    <div class="status-cell">
                        <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $c['statut'])) ?>">
                            <?= ucfirst($c['statut']) ?>
                        </span>
                    </div>
                    <div class="action-cell">
                        <form method="post" action="index2.php?page=changerStatutCandidature">
                            <input type="hidden" name="idcandidature" value="<?= $c['idcandidature'] ?>">
                            <select name="statut" class="form-select form-select-sm status-select" onchange="this.form.submit()">
                                <option <?= $c['statut'] == 'en attente' ? 'selected' : '' ?> value="en attente">En attente</option>
                                <option <?= $c['statut'] == 'accepté' ? 'selected' : '' ?> value="accepté">Accepté</option>
                                <option <?= $c['statut'] == 'refusé' ? 'selected' : '' ?> value="refusé">Refusé</option>
                            </select>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-candidatures-message">
                <i class="bi bi-inbox fs-1 mb-3 text-muted"></i>
                <p class="fs-5 text-muted">Aucune candidature reçue pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
if (isset($conn)) {
    $conn->close();
}
// include_once './view/templates/footer.php'; // Incluez votre footer si nécessaire
?>

<script>
document.querySelector('.search-input').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const items = document.querySelectorAll('.candidature-item');
    
    items.forEach(item => {
        const candidateName = item.querySelector('.candidate-name').textContent.toLowerCase();
        const offerTitle = item.querySelector('.offer-title').textContent.toLowerCase();
        
        if (candidateName.includes(searchTerm) || offerTitle.includes(searchTerm)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});

document.getElementById('exportBtn').addEventListener('click', () => {
    // Importer jsPDF (dans la version UMD on utilise window.jspdf.jsPDF)
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Construire les données pour le tableau dans le PDF
    const headers = [['Nom candidat', 'Email', 'Offre postulée', 'Statut']];

    // Récupérer les candidatures visibles (non masquées)
    const visibleItems = Array.from(document.querySelectorAll('.candidature-item'))
      .filter(item => item.style.display !== 'none');

    const data = visibleItems.map(item => {
        const nom = item.querySelector('.candidate-name').textContent.trim();
        const email = item.querySelector('.candidate-email').textContent.trim();
        const offre = item.querySelector('.offer-title').textContent.trim();
        const statut = item.querySelector('.status-badge').textContent.trim();

        return [nom, email, offre, statut];
    });

    if(data.length === 0) {
      alert("Aucune candidature à exporter.");
      return;
    }

    // Ajouter un titre au PDF
    doc.setFontSize(18);
    doc.text("Liste des candidatures reçues", 14, 22);

    // Ajouter la table dans le PDF
    doc.autoTable({
        startY: 30,
        head: headers,
        body: data,
        styles: { fontSize: 10 },
        headStyles: { fillColor: [22, 160, 133] },
        alternateRowStyles: { fillColor: [238, 238, 238] },
        margin: { left: 14, right: 14 }
    });

    // Sauvegarder le PDF
    doc.save('candidatures.pdf');
});


</script>
