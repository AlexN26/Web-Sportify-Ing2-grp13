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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportify - Consultation sportive en ligne</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="Images/Logo-sportify.png" alt="Sportify Logo" height="150">
    </header>
    
    <nav>
        <a href="Accueil.php" class="active">Accueil</a>
        <a href="Tout_parcourir.php" >Tout parcourir</a>
        <a href="recherche.php">Recherche</a>
        <a href="rendez-vous.php">Rendez-vous</a>
        <a href="Votre_compte.php">Votre compte</a>
    </nav>
    
    <div class="carousel-container">
        <div class="carousel">
            <img src="Images/Carroussel-salle-sport.jpeg"  alt="Salle de sport">
            <img src="Images/Caroussel-terrain-foot.jpeg" alt="Terrain de football">
            <img src="Images/Caroussel-fitness.jpg" alt="Fitness">
        </div>
        <button class="carousel-btn" id="prevBtn">&#10094;</button>
        <button class="carousel-btn" id="nextBtn">&#10095;</button>
    </div>
    
    <section class="welcome">
        <h2>Votre plateforme de consultation sportive en ligne</h2>
        <p>Sportify vous connecte avec des professionnels du sport pour améliorer vos performances, prévenir les blessures et atteindre vos objectifs sportifs.</p>
    </section>
    
    <section class="event-section">
        <h2>Événement de la semaine</h2>
        
        <div class="event-card">
            <h3>Le PSG gagne la ligue des champions</h3>
            <img src="Images/Semaine-psg.jpeg" alt="PSG victoire">
            <p>Revivez les moments forts de cette victoire historique.</p>
            <a href="article_psg.php" class="en-savoir-plus">En savoir plus</a>
        </div>
        
        <div class="event-card">
            <h3>Victoire du coureur Vincent au 100km</h3>
            <img src="Images/Semaine-Vincent.jpg" alt="Vincent victoire">
            <p>Découvrez le parcours exceptionnel de cet athlète.</p>
            <a href="article_vincent.php" class="en-savoir-plus">En savoir plus</a>
        </div>
    </section>
    
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


    <script>
       document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.carousel');
    const carouselContainer = document.querySelector('.carousel-container');
    const images = document.querySelectorAll('.carousel img');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    let counter = 0;
    const size = carouselContainer.clientWidth;  
    
    carousel.style.transform = 'translateX(' + (-size * counter) + 'px)';
    
    nextBtn.addEventListener('click', function() {
        if (counter >= images.length - 1) return;
        carousel.style.transition = "transform 0.5s ease";
        counter++;
        carousel.style.transform = 'translateX(' + (-size * counter) + 'px)';
    });
    
    prevBtn.addEventListener('click', function() {
        if (counter <= 0) return;
        carousel.style.transition = "transform 0.5s ease";
        counter--;
        carousel.style.transform = 'translateX(' + (-size * counter) + 'px)';
    });
    
    setInterval(function() {
        if (counter >= images.length - 1) counter = -1;
        carousel.style.transition = "transform 0.5s ease";
        counter++;
        carousel.style.transform = 'translateX(' + (-size * counter) + 'px)';
    }, 5000);
});
    </script>
</body>
</html>