<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Votre_compte.php");
    exit();
}
?>

<?php
if (isset($_GET['highlight'])) {
    $highlight = $_GET['highlight'];
    function highlightText($text) {
        global $highlight;
        return preg_replace("/($highlight)/i", '<span style="background-color:yellow;">$1</span>', $text);
    }
    ob_start();
}
?>


<?php
if (isset($_GET['highlight'])) {
    $content = ob_get_clean();
    echo highlightText($content);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tout Parcourir - Sportify</title>
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
    
    <main class="categories-container">
        <article class="category-card">
            <h2>Activités Sportives</h2>
            <div class="category-description">
                <p>Découvrez nos activités sportives variées pour tous les niveaux. Que vous soyez débutant ou confirmé, nos coachs vous accompagnent dans votre pratique sportive.</p>
                <p><strong>Exemples :</strong> Yoga, Natation, Zumba, Pilates, Danse</p>
            </div>
            <a href="activites-sportives.php" class="btn-category">Voir les activités</a>
        </article>
        
        <article class="category-card">
            <h2>Sports de Compétition</h2>
            <div class="category-description">
                <p>Pratiquez votre sport favori en compétition avec nos équipes et tournois organisés. Encadrement professionnel pour progresser et performer.</p>
                <p><strong>Exemples :</strong> Football, Basketball, Tennis, Rugby, Volley</p>
            </div>
            <a href="sport_competition.php" class="btn-category">Découvrir les sports</a>
        </article>
        
        <article class="category-card">
            <h2>Salle de Sport Omnes</h2>
            <div class="category-description">
                <p>Notre salle de sport haut de gamme propose des équipements modernes et un accompagnement personnalisé pour atteindre vos objectifs.</p>
                <p><strong>Services :</strong> Musculation, Cardio, CrossFit, Coaching, Cours collectifs</p>
            </div>
            <a href="salle-sport.php" class="btn-category">Visiter la salle</a>
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
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22430.496030717993!2d6.1113383!3d45.8992476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478b8f8e3da7e0f9%3A0x408ab2ae4bcf230!2sAnnecy!5e0!3m2!1sfr!2sfr!4v1748474890001!5m2!1sfr!2sfr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </footer>
</body>
</html>