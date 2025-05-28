<?php
session_start();

// Sécurité : accès réservé aux coachs
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coach') {
    header("Location: Votre_compte.php");
    exit();
}

// Connexion PDO
$pdo = new PDO('mysql:host=localhost;dbname=sportify_db;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$coach_username = $_SESSION['username']; // username du coach connecté

// Marquer un message comme lu ? (optionnel, mais on supprime la gestion is_read donc on ignore ça)
// On ignore complètement cette partie pour éviter les erreurs

// Lire un message en détail
$message_detail = null;
if (isset($_GET['msg_id'])) {
    $msg_id = (int) $_GET['msg_id'];
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ? AND receiver_username = ?");
    $stmt->execute([$msg_id, $coach_username]);
    $message_detail = $stmt->fetch(PDO::FETCH_ASSOC);

    // On ne fait plus de mise à jour pour is_read
}

// Récupérer tous les messages reçus
$stmt = $pdo->prepare("SELECT * FROM messages WHERE receiver_username = ? ORDER BY timestamp DESC");
$stmt->execute([$coach_username]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Espace Coach - Messagerie</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Plus de style bold pour unread, puisque plus de is_read */
        .message-list { width: 40%; float: left; }
        .message-detail { width: 55%; float: right; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
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
    <a href="Votre_compte.php">Votre compte</a>
</nav>

<h1>Bienvenue <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
<p>Vous êtes connecté en tant que COACH</p>
<a href="logout.php">Déconnexion</a>

<hr>

<div class="clearfix">
    <div class="message-list">
        <h2>Messages reçus</h2>
        <?php if (count($messages) === 0): ?>
            <p>Aucun message reçu.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($messages as $msg): ?>
                    <li>
                        <a href="coach.php?msg_id=<?php echo $msg['id']; ?>">
                            <?php echo htmlspecialchars(substr($msg['message'], 0, 30)) . (strlen($msg['message']) > 30 ? '...' : ''); ?>
                        </a><br>
                        <small>De : <?php echo htmlspecialchars($msg['sender_username']); ?> | Le : <?php echo $msg['timestamp']; ?></small><br>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="message-detail">
        <?php if ($message_detail): ?>
            <h2>Détail du message</h2>
            <p><strong>De :</strong> <?php echo htmlspecialchars($message_detail['sender_username']); ?></p>
            <p><strong>Reçu le :</strong> <?php echo $message_detail['timestamp']; ?></p>
            <hr>
            <p><?php echo nl2br(htmlspecialchars($message_detail['message'])); ?></p>
        <?php else: ?>
            <p>Sélectionnez un message pour le lire.</p>
        <?php endif; ?>
    </div>
</div>

<footer>
    <div class="contact-info">
        <h3>Contactez-nous</h3>
        <p>33 Rue des sportifs de l'ECE<br>
            team.sportify@onnes.com<br>
            06 33 16 22 31</p>
    </div>
</footer>
</body>
</html>
