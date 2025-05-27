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

    <article style="margin-bottom: 3rem;">
        <h2>Le PSG remporte la Ligue des Champions</h2>
        <img src="Images/Semaine-psg.jpeg" alt="Victoire du PSG" style="width:100%; max-height:400px; object-fit:cover; border-radius: 8px;">
        <p style="margin-top:1rem; line-height:1.6;">
            Dans une finale historique au Stade de Wembley, le Paris Saint-Germain a remporté la Ligue des Champions
            pour la première fois de son histoire, en s'imposant 2-1 face au Real Madrid. Mbappé et Vitinha ont inscrit
            les buts parisiens, tandis que Vinícius Junior avait ouvert le score pour les Madrilènes.
            <br><br>
            Cette victoire marque une étape importante pour le club parisien, concrétisant enfin des années
            d'investissement et d'efforts. Le coach Luis Enrique a salué la solidarité et la discipline tactique de son
            groupe tout au long de la compétition.
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
