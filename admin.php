<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: votre-compte.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Espace Admin - Sportify</title>
    <!-- [Votre CSS] -->
</head>
<body>
    <!-- [Votre header/nav] -->
    
    <main>
        <h1>Administration - <?php echo $_SESSION['username']; ?></h1>
        <section>
            <h2>Gestion des Utilisateurs</h2>
            <!-- Interface admin -->
        </section>
        <section>
            <h2>Statistiques</h2>
            <!-- Tableau de bord -->
        </section>
    </main>
    
    <!-- [Votre footer] -->
</body>
</html>