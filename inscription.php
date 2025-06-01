<?php
$errorMessage = '';
if (isset($_GET['error']) && $_GET['error'] == 'username') {
    $errorMessage = "Ce nom d'utilisateur est déjà pris. Veuillez en choisir un autre.";
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Sportify</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="Images/Logo-sportify.png" alt="Sportify Logo" height="150">
    </header>
    
    <nav>
        <a href="Accueil.php">Accueil</a>
        <a href="Tout_parcourir.php">Tout parcourir</a>
        <a href="recherche.php">Recherche</a>
        <a href="rendez-vous.php">Rendez-vous</a>
        <a href="Votre_compte.php" class="active">Votre compte</a>
    </nav>
    <div class="login-container">
        <h2>Créer un compte</h2>
        <?php if (!empty($errorMessage)) : ?>
            <div style="color: red; font-weight: bold; text-align: center; margin-bottom: 1rem;">
                <?= htmlspecialchars($errorMessage) ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur *</label>
                <input type="text" id="username" name="username" required minlength="3">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe *</label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>
            <div class="form-group">
                <label for="user_type">Rôle *</label>
                <select id="user_type" name="user_type" required>
                    <option value="client">Client</option>
                    
                </select>
            </div>
            <button type="submit" class="login-btn">S'inscrire</button>
        </form>
        <div class="register-link">
            <p>Déjà un compte ? <a href="Votre_compte.php">Se connecter</a></p>
        </div>
    </div>

    <footer>
        <div class="contact-info">
            <h3>Contactez-nous</h3>
            <p>33 Rue des sportifs de l'ECE<br>
            team.sportify@onnes.com<br>
            06 33 16 22 31</p>
        </div>

        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22430.496030717993!2d6.1113383!3d45.8992476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478b8f8e3da7e0f9%3A0x408ab2ae4bcf230!2sAnnecy!5e0!3m2!1sfr!2sfr!4v1748474890001!5m2!1sfr!2sfr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </footer>

</body>
</html>
