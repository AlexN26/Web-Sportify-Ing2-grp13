<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Votre_compte.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Admin - Sportify</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-btn {
            display: inline-block;
            padding: 1rem 2rem;
            background-color: #1c66af;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 2rem;
        }
        .admin-btn:hover {
            background-color: #15527a;
        }
    </style>
</head>
<body>
<header>
    <img src="Images/Logo-sportify.png" alt="Sportify Logo" height="150">
</header>

<nav>
    <a href="Accueil.php">Accueil</a>
    <a href="Tout_parcourir.php">Tout parcourir</a>
    <a href="recherche.html">Recherche</a>
    <a href="rendez-vous.html">Rendez-vous</a>
    <a href="Votre_compte.php">Votre compte</a>
</nav>

<main style="text-align:center; padding: 2rem;">
    <h1>Bienvenue <?php echo $_SESSION['username']; ?> !</h1>
    <p>Vous êtes connecté en tant que <strong>ADMIN</strong></p>
    <a href="logout.php">Déconnexion</a>

    <br><br>
    <a href="gerer_coachs.php" class="admin-btn">Gérer les coachs</a>
</main>

<footer>
    <div class="contact-info">
        <h3>Contactez-nous</h3>
        <p>33 Rue des sportifs de l'ECE<br>
        team.sportify@onnes.com<br>
        06 33 16 22 31</p>
    </div>
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="100%" style="border:0;" allowfullscreen></iframe>
    </div>
</footer>
</body>
</html>
