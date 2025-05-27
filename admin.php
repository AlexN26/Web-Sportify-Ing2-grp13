<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: Votre-compte.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Espace Admin</title></head>
<body>
    <h1>Bienvenue <?php echo $_SESSION['username']; ?> !</h1>
    <p>Vous êtes connecté en tant que ADMIN</p>
    <a href="logout.php">Déconnexion</a>
</body>
</html>