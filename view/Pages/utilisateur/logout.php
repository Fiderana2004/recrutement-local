<?php
// Démarrer la session (nécessaire pour accéder aux variables de session existantes)
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Si tu utilises des cookies de session, détruire également le cookie de session
// Note : Cela détruira le cookie de session et pas nécessairement les autres cookies.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page de connexion ou la page d'accueil
header("Location: /recrutement-local/index.php?page=login"); // Remplace login.php par la page où tu veux rediriger l'utilisateur après la déconnexion
exit();
?>