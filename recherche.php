<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "sportify_db");
if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

$resultats = [];
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["query"])) {
    $query = $mysqli->real_escape_string($_GET["query"]);
    $search_term = "%" . $query . "%";

    // 1. Recherche dans les coachs
    $sql_coachs = "SELECT * FROM coachs WHERE 
                  nom LIKE ? OR 
                  prenom LIKE ? OR 
                  domaine_expertise LIKE ? OR 
                  diplomes LIKE ? OR 
                  description LIKE ?";
    $stmt = $mysqli->prepare($sql_coachs);
    $stmt->bind_param("sssss", $search_term, $search_term, $search_term, $search_term, $search_term);
    $stmt->execute();
    $coachs_results = $stmt->get_result();

    // 2. Recherche dans le contenu des pages (simulé)
    $pages_content = [
        'Tout_parcourir.php' => file_get_contents('Tout_parcourir.php'),
        'activites-sportives.php' => file_get_contents('activites-sportives.php'),
        'salle-sport.php' => file_get_contents('salle-sport.php'),
        'sport_competition.php' => file_get_contents('sport_competition.php')
    ];

    $pages_results = [];
    foreach ($pages_content as $page => $content) {
        if (stripos($content, $query) !== false) {
            $pages_results[] = $page;
        }
    }

    // 3. Recherche dans d'autres tables si nécessaire (salles, compétitions etc.)
    // ... (à implémenter selon votre structure de base de données)
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche Sportify</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .result-section {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .result-item {
            margin: 10px 0;
            padding: 10px;
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <header>
        <img src="Images/Logo-sportify.png" alt="Sportify Logo" height="150">
    </header>
    
    <nav>
        <a href="Accueil.php">Accueil</a>
        <a href="Tout_parcourir.php">Tout parcourir</a>
        <a href="recherche.php" class="active">Recherche</a>
        <a href="rendez-vous.php">Rendez-vous</a>
        <a href="Votre_compte.php">Votre compte</a>
    </nav>

    <div class="container">
        <h1>Recherche</h1>
        <form method="GET" class="search-form">
            <input type="text" name="query" placeholder="Nom, spécialité, établissement..." required 
                   value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
            <button type="submit">Rechercher</button>
        </form>

        <?php if (isset($_GET["query"])): ?>
            <h2>Résultats pour "<?= htmlspecialchars($_GET["query"]) ?>"</h2>

            <?php if ($coachs_results->num_rows > 0): ?>
                <div class="result-section">
                    <h3>Coachs</h3>
                    <?php while ($row = $coachs_results->fetch_assoc()): ?>
                        <div class="result-item">
                            <h4><?= htmlspecialchars($row['prenom'] . ' ' . $row['nom']) ?></h4>
                            <p><strong>Spécialité:</strong> <?= htmlspecialchars($row['domaine_expertise']) ?></p>
                            <p><strong>Description:</strong> <?= htmlspecialchars(substr($row['description'], 0, 150)) ?>...</p>
                            <a href="rendez-vous.php?coach=<?= urlencode($row['prenom'].' '.$row['nom']) ?>">Prendre rendez-vous</a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($pages_results)): ?>
                <div class="result-section">
                    <h3>Pages contenant le terme</h3>
                    <?php foreach ($pages_results as $page): ?>
                        <div class="result-item">
                            <h4><?= htmlspecialchars($page) ?></h4>
                            <a href="<?= htmlspecialchars($page) ?>?highlight=<?= urlencode($_GET['query']) ?>">
                                Voir la page
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($coachs_results->num_rows === 0 && empty($pages_results)): ?>
                <p>Aucun résultat trouvé.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <footer>
        <!-- Votre footer existant -->
    </footer>
</body>
</html>