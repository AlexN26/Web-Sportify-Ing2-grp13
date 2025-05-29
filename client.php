<?php
session_start();

// Vérifier que l'utilisateur est connecté et a le rôle "client"
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
    header("Location: Votre_compte.php");
    exit();
}

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=sportify_db;charset=utf8',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    die("Erreur connexion base de données : " . $e->getMessage());
}

$client_username = $_SESSION['username'];

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_username = $client_username;
    $receiver_username = trim($_POST['receiver_username'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($receiver_username)) {
        $error = "Veuillez saisir un nom d'utilisateur.";
    } elseif (empty($message)) {
        $error = "Veuillez écrire un message.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $receiver_username)) {
        $error = "Nom d'utilisateur invalide. Seuls les lettres, chiffres et underscores sont autorisés.";
    } else {
        // Vérification que le destinataire existe et est un coach
        $stmt = $pdo->prepare("SELECT username, role FROM users WHERE username = ?");
        $stmt->execute([$receiver_username]);
        $user = $stmt->fetch();

        if (!$user) {
            $error = "L'utilisateur $receiver_username n'existe pas.";
        } elseif ($user['role'] !== 'coach') {
            $error = "Vous ne pouvez envoyer des messages qu'aux coachs.";
        } else {
            $sql = "INSERT INTO messages (sender_username, receiver_username, message, timestamp) 
                    VALUES (:sender, :receiver, :message, NOW())";
            $stmt = $pdo->prepare($sql);

            try {
                $stmt->execute([
                    ':sender' => $sender_username,
                    ':receiver' => $receiver_username,
                    ':message' => $message,
                ]);
                $success = "Message envoyé avec succès à $receiver_username.";
            } catch (Exception $e) {
                $error = "Erreur lors de l'envoi du message : " . $e->getMessage();
            }
        }
    }
}

// Lire un message en détail
$message_detail = null;
if (isset($_GET['msg_id'])) {
    $msg_id = (int) $_GET['msg_id'];
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ? AND (receiver_username = ? OR sender_username = ?)");
    $stmt->execute([$msg_id, $client_username, $client_username]);
    $message_detail = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Récupérer tous les messages
$stmt = $pdo->prepare("SELECT * FROM messages WHERE receiver_username = ? OR sender_username = ? ORDER BY timestamp DESC");
$stmt->execute([$client_username, $client_username]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Espace Client - Messagerie</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header img {
            height: 150px;
        }
        nav {
            padding: 10px;
            background: #f0f0f0;
        }
        nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .error {
            color: #d33;
            background: #fdd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .success {
            color: #155724;
            background: #d4edda;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .message-box {
            display: flex;
            margin-top: 20px;
        }
        .message-list {
            width: 40%;
            padding-right: 20px;
        }
        .message-detail {
            width: 60%;
            padding-left: 20px;
            border-left: 1px solid #ddd;
        }
        .message-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }
        .message-item:hover {
            background: #f5f5f5;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background: #1c66af;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        footer {
            background: #1c66af;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
    <img src="Images/Logo-sportify.png" alt="Sportify Logo">
</header>

<nav>
    <a href="Accueil.php">Accueil</a>
    <a href="Tout_parcourir.php">Tout parcourir</a>
    <a href="recherche.php">Recherche</a>
    <a href="rendez-vous.php">Rendez-vous</a>
    <a href="Votre_compte.php">Votre compte</a>
    <a href="logout.php" style="color: #d33;">Déconnexion</a>
</nav>

<div class="container">
    <h1>Bienvenue <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
    <p>Vous êtes connecté en tant que CLIENT</p>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="message-box">
        <div class="message-list">
            <h2>Boîte de messagerie</h2>
            
            <h3>Envoyer un message</h3>
            <form method="post" action="client.php">
                <label for="receiver_username">Destinataire (nom d'utilisateur du coach) :</label>
                <input type="text" name="receiver_username" id="receiver_username" required>
                
                <label for="message">Message :</label>
                <textarea name="message" id="message" rows="4" required></textarea>

                <button type="submit">Envoyer</button>
            </form>
            
            <h3>Messages</h3>
            <?php if (count($messages) === 0): ?>
                <p>Aucun message.</p>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="message-item" onclick="location.href='client.php?msg_id=<?= $msg['id'] ?>'">
                        <strong>
                            <?= ($msg['sender_username'] === $client_username) 
                                ? "À " . htmlspecialchars($msg['receiver_username']) 
                                : "De " . htmlspecialchars($msg['sender_username']) ?>
                        </strong>
                        <p><?= htmlspecialchars(substr($msg['message'], 0, 50)) . (strlen($msg['message']) > 50 ? '...' : '') ?></p>
                        <small><?= $msg['timestamp'] ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="message-detail">
            <?php if ($message_detail): ?>
                <h2>Détail du message</h2>
                <p><strong><?= ($message_detail['sender_username'] === $client_username) ? "À :" : "De :" ?></strong> 
                   <?= ($message_detail['sender_username'] === $client_username) 
                      ? htmlspecialchars($message_detail['receiver_username']) 
                      : htmlspecialchars($message_detail['sender_username']) ?>
                </p>
                <p><strong>Date :</strong> <?= $message_detail['timestamp'] ?></p>
                <hr>
                <p><?= nl2br(htmlspecialchars($message_detail['message'])) ?></p>
            <?php else: ?>
                <p>Sélectionnez un message pour le lire.</p>
            <?php endif; ?>
        </div>
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