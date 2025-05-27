<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "sportify_db");
if ($mysqli->connect_error) {
    die("Erreur BDD : " . $mysqli->connect_error);
}

$username = $_SESSION['username'];
$rdvs = $mysqli->prepare("SELECT r.*, c.nom, c.prenom FROM rendez_vous r JOIN coachs c ON r.coach_id = c.id WHERE r.client_username = ?");
$rdvs->bind_param("s", $username);
$rdvs->execute();
$result = $rdvs->get_result();

// Annulation
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['annuler_id'])) {
    $id = intval($_POST['annuler_id']);
    $mysqli->query("DELETE FROM rendez_vous WHERE id = $id");
    header("Location: rendez-vous.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes rendez-vous</title>
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
    <h1>Mes rendez-vous confirmés</h1>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr><th>Coach</th><th>Date</th><th>Heure</th><th>Lieu</th><th>Action</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['prenom'] . ' ' . $row['nom']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['heure']) ?></td>
                    <td><?= htmlspecialchars($row['lieu']) ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="annuler_id" value="<?= $row['id'] ?>">
                            <button type="submit">Annuler</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Aucun rendez-vous à venir.</p>
    <?php endif; ?>
    <footer>
        <div class="contact-info">
            <h3>Contactez-nous</h3>
            <p>33 Rue des sportifs de l'ECE<br>
            team.sportify@onnes.com<br>
            06 33 16 22 31</p>
        </div>

        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46125.16715836869!2d3.6489429259873885!3d43.735004800892554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12b3fe268b01f953%3A0x4078821166ab9b0!2s34380%20Viols-le-Fort!5e0!3m2!1sfr!2sfr!4v1748268041768!5m2!1sfr!2sfr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </footer>
</body>
</html>
