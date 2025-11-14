<?php
$page = $_GET['page'] ?? 'Utilisateur';

switch ($page) {
    case 'ajouter':
        require_once './controller/UtilisateurController.php';
        $controller = new UtilisateurController();
        $controller->ajouterUtilisateur();
        break;
    case 'login':
        require_once './controller/UtilisateurController.php';
        $controller = new UtilisateurController();
        $controller->login();
        break;      
  

    default:
        if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['id'])) {
            $id = $_GET['id'];
            require_once './controller/UtilisateurController.php';
            $controller = new UtilsateurController();
            $controller->supprimerUtilisateur($id);  // Appeler la méthode de suppression
        } else {
            require_once './controller/UtilisateurController.php';
            $controller = new UtilisateurController();
             $controller->index();  // Affiche la liste des clients
        }
        break;        
}
?>
