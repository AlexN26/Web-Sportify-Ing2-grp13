<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "sportify_db");
if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

$resultats = [];
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["query"])) {
    $query = "%" . $mysqli->real_escape_string($_GET["query"]) . "%";
    $sql = "SELECT * FROM coachs WHERE nom LIKE ? OR prenom LIKE ? OR domaine_expertise LIKE ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $query, $query, $query);
    $stmt->execute();
    $resultats = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche Sportify</title>
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
    <h1>Recherche</h1>
    <form method="GET">
        <input type="text" name="query" placeholder="Nom, spécialité..." required>
        <button type="submit">Rechercher</button>
    </form>

    <?php if (!empty($resultats) && $resultats->num_rows > 0): ?>
        <h2>Résultats :</h2>
        <ul>
            <?php while ($row = $resultats->fetch_assoc()): ?>
                <li><?= htmlspecialchars($row['prenom'] . ' ' . $row['nom']) ?> - <?= htmlspecialchars($row['domaine_expertise']) ?></li>
            <?php endwhile; ?>
        </ul>
    <?php elseif (isset($_GET["query"])): ?>
        <p>Aucun résultat trouvé.</p>
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
