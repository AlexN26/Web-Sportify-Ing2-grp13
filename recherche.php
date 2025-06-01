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

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche Sportify</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }

        header, nav, footer {
            background-color: #004aad;
            color: white;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a.active {
            border-bottom: 2px solid #fff;
        }

        .container {
            padding: 30px;
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .search-form input {
            flex: 1;
            padding: 10px;
            border: 1px solid #aaa;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-form button {
            padding: 10px 20px;
            background-color: #004aad;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #00337f;
        }

        .result-section {
            margin-bottom: 30px;
        }

        .result-item {
            padding: 15px;
            background: #f9f9f9;
            border-left: 5px solid #004aad;
            border-radius: 5px;
            margin: 10px 0;
        }

        .result-item h4 {
            margin: 0;
            color: #004aad;
        }

        .result-item p {
            margin: 5px 0;
        }

        footer {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 50px;
            padding: 30px 15px;
        }

        .contact-info, .map {
            width: 45%;
            min-width: 300px;
        }

        iframe {
            width: 100%;
            height: 200px;
            border: none;
        }

        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
            }

            .contact-info, .map {
                width: 100%;
            }
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
        <div class="contact-info">
            <h3>Contactez-nous</h3>
            <p>33 Rue des sportifs de l'ECE<br>
            team.sportify@onnes.com<br>
            06 33 16 22 31</p>
        </div>

        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22430.496030717993!2d6.1113383!3d45.8992476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478b8f8e3da7e0f9%3A0x408ab2ae4bcf230!2sAnnecy!5e0!3m2!1sfr!2sfr!4v1748474890001!5m2!1sfr!2sfr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </footer>
</body>
</html>