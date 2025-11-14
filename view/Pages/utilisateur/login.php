<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="login-wrapper">
        <div class="login-left-panel">
            <span class="text-large">CONNEXION</span>
            <span class="text-medium">SE CONNECTER</span>
        </div>

        <div class="login-right-panel">
            <span class="logo-text">MadaRec</span> 
            <h3>CONNEXION</h3>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="" style="width: 100%; max-width: 350px;">
                <div class="login-input-group">
                    <i class="bi bi-envelope input-icon"></i> <input type="email" name="email" class="form-control" placeholder="Email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>

                <div class="login-input-group">
                    <i class="bi bi-lock input-icon"></i> <input type="password" name="motdepasse" class="form-control" placeholder="Password" required>
                </div>

                <a href="#" class="forgot-password">Mot de passe oublié ?</a> <button type="submit" class="login-button">SE connecter</button>
            </form>

            <div class="social-login-separator">Ou connectez-vous avec</div>

            <div class="social-buttons">
                <a href="#" class="social-button">
                    <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google"> Google
                </a>
                <a href="#" class="social-button">
                    <img src="https://img.icons8.com/color/48/000000/facebook-new.png" alt="Facebook"> Facebook
                </a>
            </div>
        </div>
    </div>

    </body>
</html>