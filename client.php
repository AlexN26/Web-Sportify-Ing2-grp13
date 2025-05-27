<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'client') {
    header("Location: votre-compte.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Espace Client - Sportify</title>
    <!-- [Votre CSS] -->
</head>
<body>
    <!-- [Votre header/nav] -->
    
    <main>
        <h1>Bienvenue, <?php echo $_SESSION['username']; ?></h1>
        <section>
            <h2>Mes Réservations</h2>
            <!-- Liste des réservations -->
        </section>
        <section>
            <h2>Prendre un Rendez-vous</h2>
            <!-- Formulaire de RDV -->
        </section>
    </main>
    
    <!-- [Votre footer] -->
</body>
</html>