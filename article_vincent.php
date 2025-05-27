<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Votre_compte.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles - Sportify</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <img src="Images/Logo-sportify.png" alt="Sportify Logo" height="150">
</header>

<nav>
    <a href="Accueil.php">Accueil</a>
    <a href="Tout_parcourir.php" class="active">Tout parcourir</a>
    <a href="recherche.php">Recherche</a>
    <a href="rendez-vous.php">Rendez-vous</a>
    <a href="Votre_compte.php">Votre compte</a>
</nav>

<main class="articles-container" style="padding: 2rem; max-width: 1000px; margin: auto;">

    
    <article>
        <h2>Victoire de Vincent sur les 100 km</h2>
        <img src="Images/Semaine-Vincent.jpg" alt="Coureur Vincent" style="width:100%; max-height:400px; object-fit:cover; border-radius: 8px;">
        <p style="margin-top:1rem; line-height:1.6;">
            L'athlète Vincent Martin a triomphé sur la mythique épreuve des 100 km de Millau avec un temps impressionnant
            de 7h45. C'est sa troisième victoire consécutive sur cette distance. Malgré une météo capricieuse et un
            parcours exigeant, Vincent a su imposer un rythme constant et une stratégie de course implacable.
            <br><br>
            Cette performance renforce sa place de leader dans l’ultra-endurance française. Prochaine étape : les
            championnats d’Europe à Florence en septembre.
        </p>
    </article>

</main>

<footer>
    <div class="contact-info">
        <h3>Contactez-nous</h3>
        <p>33 Rue des sportifs de l'ECE<br>
        team.sportify@onnes.com<br>
        06 33 16 22 31</p>
    </div>

    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46125.16715836869!2d3.6489429259873885!3d43.735004800892554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12b3fe268b01f953%3A0x4078821166ab9b0!2s34380%20Viols-le-Fort!5e0!3m2!1sfr!2sfr!4v1748268041768!5m2!1sfr!2sfr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</footer>

</body>
</html>
