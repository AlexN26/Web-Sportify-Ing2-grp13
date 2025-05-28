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

// Tableau associatif email => username des coachs
$coach_map = [
    "vincent.triathlon@sportify.fr" => "vincent1",
    "coach2@sportify.fr" => "coach2",
    "coach3@sportify.fr" => "coach3"
];

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_username = $_SESSION['username'];
    $receiver_email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $message = trim($_POST['message'] ?? '');

    if (!$receiver_email) {
        $error = "Adresse email du coach invalide.";
    } elseif (empty($message)) {
        $error = "Veuillez écrire un message.";
    } elseif (!array_key_exists($receiver_email, $coach_map)) {
        $error = "Adresse email du coach non autorisée.";
    } else {
        $receiver_username = $coach_map[$receiver_email];

        $sql = "INSERT INTO messages (sender_username, receiver_username, message, timestamp) 
                VALUES (:sender, :receiver, :message, NOW())";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':sender' => $sender_username,
                ':receiver' => $receiver_username,
                ':message' => $message,
            ]);
            $success = "Message envoyé avec succès au coach $receiver_username.";
        } catch (Exception $e) {
            $error = "Erreur lors de l'envoi du message : " . $e->getMessage();
        }
    }
}
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 30px;
            flex: 1;
        }
        header img {
            height: 150px;
        }
        nav {
            padding: 0 30px;
        }
        nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
        }
        nav a:hover {
            text-decoration: underline;
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
        form {
            margin-top: 20px;
            width: 100%;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            resize: vertical;
        }
        button {
            background-color: #1c66af;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        button:hover {
            background-color: #1c66af;
        }
        footer {
            background-color: #1c66af;
            width: 100%;
            padding: 20px 0;
            margin-top: 40px;
            font-size: 0.9em;
            color: white; /* Couleur du texte en blanc */
        }
        .contact-info {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
            color: white; /* Couleur du texte en blanc */
        }
        .contact-info h3 {
            margin-bottom: 10px;
            color: white; /* Couleur du texte en blanc */
        }
        .contact-info p {
            color: white; /* Couleur du texte en blanc */
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

<header class="content">
    <img src="Images/Logo-sportify.png" alt="Sportify Logo">
</header>

<nav class="content">
    <a href="Accueil.php">Accueil</a>
    <a href="Tout_parcourir.php">Tout parcourir</a>
    <a href="recherche.php">Recherche</a>
    <a href="rendez-vous.php">Rendez-vous</a>
    <a href="Votre_compte.php">Votre compte</a>
    <a href="logout.php" style="color: #d33;">Déconnexion</a>
</nav>

<main class="content">
    <h1>Bienvenue <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
    <p>Vous êtes connecté en tant que CLIENT</p>

    <hr>

    <h2>Envoyer un message à un coach</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" action="client.php">
        <label for="email">Choisissez le coach (email) :</label>
        <select name="email" id="email" required>
            <option value="">-- Sélectionnez un coach --</option>
            <?php foreach ($coach_map as $email => $username): ?>
                <option value="<?= htmlspecialchars($email) ?>" <?= (isset($_POST['email']) && $_POST['email'] === $email) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($email) ?> (<?= htmlspecialchars($username) ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label for="message">Message :</label>
        <textarea name="message" id="message" rows="6" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>

        <button type="submit">Envoyer</button>
    </form>
</main>

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