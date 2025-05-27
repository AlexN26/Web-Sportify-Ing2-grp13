<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'coach') {
    header("Location: votre-compte.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Espace Coach - Sportify</title>
    <!-- [Votre CSS] -->
</head>
<body>
    <!-- [Votre header/nav] -->
    
    <main>
        <h1>Bienvenue Coach <?php echo $_SESSION['username']; ?></h1>
        <section>
            <h2>Mes Séances</h2>
            <!-- Gestion des séances -->
        </section>
        <section>
            <h2>Mes Clients</h2>
            <!-- Liste des clients -->
        </section>
    </main>
    
    <!-- [Votre footer] -->
</body>
</html>