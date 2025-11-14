<?php
$page = $_GET['page'] ?? 'recruteur';

switch ($page) {
    case 'login':
        require_once '../controller/UtilisateurController.php';
        $controller = new UtilisateurController();
        $controller->login();
        break;  
       
}
?>
