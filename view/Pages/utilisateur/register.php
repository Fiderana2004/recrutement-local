<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire | MadaRec</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>

    <div class="login-wrapper">

        <div class="login-left-panel">
            <h2 class="text-large">Inscription</h2>
            <p class="text-medium">Créez votre compte</p>
        </div>

        <div class="login-right-panel">
            
            <h1 class="logo-text">MadaRec</h1>
            
            <form action="index.php?page=ajouter" method="POST">
                
                <div class="login-input-group">
                    <i class="input-icon fas fa-envelope"></i>
                    <input type="email" name="Emailutil" placeholder="Email" required>
                </div>
                
                <div class="login-input-group">
                    <i class="input-icon fas fa-lock"></i>
                    <input type="password" name="mdputil" id="mdputil" placeholder="Mot de passe" required>
                </div>
                
                <div class="login-input-group">
                    <i class="input-icon fas fa-user-tag"></i>
                    <select name="role">
                        <option value="" disabled selected>Choisissez votre rôle</option>
                        <option value="candidat">Candidat</option>
                        <option value="recruteur">Recruteur</option>
                    </select>
                </div>

                <button type="submit" class="login-button">S'INSCRIRE</button>
            </form>

            <div class="social-login-separator">ou s'inscrire avec</div>

            <div class="social-buttons">
                <a href="#" class="social-button">
                    <i class="fab fa-google"></i>
                    Google
                </a>
                <a href="#" class="social-button">
                    <i class="fab fa-facebook-f"></i>
                    Facebook
                </a>
            </div>
            
            <p class="text-center mt-3">
                Vous avez déjà un compte ? <a href="login.php" class="link-custom">Se connecter</a>
            </p>

        </div>

    </div>

</body>
</html>