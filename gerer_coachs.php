<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Votre_compte.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "sportify_db");
if ($mysqli->connect_error) {
    die("Erreur BDD : " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $mysqli->query("DELETE FROM coachs WHERE id = $id");
    header("Location: gerer_coachs.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $id = intval($_POST['delete_user_id']);
    $mysqli->query("DELETE FROM users WHERE id = $id AND role = 'coach'");
    header("Location: gerer_coachs.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom']) && isset($_POST['photo'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = intval($_POST['age']);
    $domaine = $_POST['domaine'];
    $diplomes = $_POST['diplomes'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $experience = $_POST['experience'];
    $description = $_POST['description'];
    $photo = $_POST['photo']; 

    $stmt = $mysqli->prepare("INSERT INTO coachs (nom, prenom, age, domaine_expertise, diplomes, telephone, email, experience, description, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissssssss", $nom, $prenom, $age, $domaine, $diplomes, $telephone, $email, $experience, $description, $photo);
    $stmt->execute();
    $stmt->close();
    header("Location: gerer_coachs.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_username'])) {
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];
    $role = 'coach';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $role);
    $stmt->execute();
    $stmt->close();
    header("Location: gerer_coachs.php");
    exit();
}

$coachs = $mysqli->query("SELECT * FROM coachs");
$coach_users = $mysqli->query("SELECT * FROM users WHERE user_type = 'coach'");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Coachs</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 2rem; }
        th, td { border: 1px solid #ccc; padding: 0.5rem; text-align: left; }
        input, textarea { width: 100%; padding: 0.5rem; }
        .form-section { margin-top: 3rem; }
        img.coach-photo { width: 80px; height: auto; }
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

<main style="padding: 2rem;">
    <h2>Liste des coachs</h2>
    <table>
        <tr>
            <th>ID</th><th>Photo</th><th>Nom</th><th>Prénom</th><th>Spécialité</th><th>Email</th><th>Action</th>
        </tr>
        <?php while ($c = $coachs->fetch_assoc()): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><img src="<?= htmlspecialchars($c['photo']) ?>" class="coach-photo" alt="photo"></td>
                <td><?= htmlspecialchars($c['nom']) ?></td>
                <td><?= htmlspecialchars($c['prenom']) ?></td>
                <td><?= htmlspecialchars($c['domaine_expertise']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Supprimer ce coach ?');">
                        <input type="hidden" name="delete_id" value="<?= $c['id'] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="form-section">
        <h2>Ajouter un coach</h2>
        <form method="POST">
            <label>Nom : <input type="text" name="nom" required></label><br>
            <label>Prénom : <input type="text" name="prenom" required></label><br>
            <label>Âge : <input type="number" name="age" required></label><br>
            <label>Domaine expertise : <input type="text" name="domaine" required></label><br>
            <label>Diplômes : <input type="text" name="diplomes" required></label><br>
            <label>Téléphone : <input type="text" name="telephone" required></label><br>
            <label>Email : <input type="email" name="email" required></label><br>
            <label>Expérience : <textarea name="experience" required></textarea></label><br>
            <label>Description : <textarea name="description" required></textarea></label><br>
            <label>Chemin image (ex: Images/....jpeg) : <input type="text" name="photo" required></label><br>
            <button type="submit">Ajouter le coach</button>
        </form>
    </div>

    <h2 style="margin-top: 4rem;">Comptes coachs</h2>
    <table>
        <tr>
            <th>ID</th><th>Nom d'utilisateur</th><th>Rôle</th><th>Date création</th><th>Action</th>
        </tr>
        <?php while ($user = $coach_users->fetch_assoc()): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['user_type']) ?></td>
                <td><?= htmlspecialchars($user['created_at']) ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Supprimer ce compte coach ?');">
                        <input type="hidden" name="delete_user_id" value="<?= $user['id'] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="form-section">
        <h2>Ajouter un compte coach</h2>
        <form method="POST">
            <label>Nom d'utilisateur : <input type="text" name="new_username" required></label><br>
            <label>Mot de passe : <input type="password" name="new_password" required></label><br>
            <button type="submit">Créer le compte coach</button>
        </form>
    </div>
</main>

<footer>
    <div class="contact-info">
        <h3>Contactez-nous</h3>
        <p>33 Rue des sportifs de l'ECE<br>
        team.sportify@onnes.com<br>
        06 33 16 22 31</p>
    </div>
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="100%" style="border:0;" allowfullscreen></iframe>
    </div>
</footer>
</body>
</html>
