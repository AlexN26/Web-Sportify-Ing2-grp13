<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Votre_compte.php");
    exit();
}

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "sportify_db";
$conn = new mysqli($servername, $username_db, $password_db, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

function getResponsables($conn) {
    $sql = "SELECT * FROM responsables_salle";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
$responsables = getResponsables($conn);
?>

<?php
if (isset($_GET['highlight'])) {
    $highlight = $_GET['highlight'];
    function highlightText($text) {
        global $highlight;
        return preg_replace("/($highlight)/i", '<span style="background-color:yellow;">$1</span>', $text);
    }
    ob_start();
}
?>


<?php
if (isset($_GET['highlight'])) {
    $content = ob_get_clean();
    echo highlightText($content);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salle de sport Omnes</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f0f0;
      margin: 0;
      padding: 0;
    }
    h1 {
      background-color: #1c66af;
      color: white;
      text-align: center;
      padding: 1.5rem;
    }
    .content {
      max-width: 1000px;
      margin: auto;
      padding: 2rem;
      background: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    .section {
      margin-bottom: 2rem;
    }
    h2 {
      color: #1c66af;
    }
    ul {
      padding-left: 20px;
    }
    .contact-card {
      margin-top: 1rem;
      padding: 1rem;
      background-color: #e9f3ff;
      border-left: 4px solid #ffffff;
      margin-bottom: 1rem;
    }

    .back-arrow {
  position: absolute;
  top: 20px;
  left: 20px;
  font-size: 1.2rem;
  text-decoration: none;
  color: #ffffff;
  display: flex;
  align-items: center;
  font-weight: bold;
  transition: color 0.3s ease;
}

.back-arrow:hover {
  color: #ffffff;
}

.back-arrow::before {
  content: "←";
  margin-right: 8px;
  font-size: 1.5rem;
}
  </style>
</head>
<body>
  <a href="Tout_parcourir.php" class="back-arrow">Retour</a>
  <h1>Bienvenue dans la Salle de sport Omnes</h1>
  <div class="content">
    <div class="section">
      <h2>Règlement de la salle</h2>
      <ul>
        <li>Utilisez une serviette sur les machines.</li>
        <li>Désinfectez les équipements après usage.</li>
        <li>Respectez les autres utilisateurs.</li>
        <li>Rangez le matériel après usage.</li>
        <li>L'accès est réservé aux membres avec badge valide.</li>
      </ul>
    </div>

    <div class="section">
      <h2>Horaires d'ouverture</h2>
      <p>Lundi à Vendredi : 6h00 - 22h00<br>
      Samedi : 8h00 - 20h00<br>
      Dimanche : 9h00 - 18h00</p>
    </div>

    <div class="section">
      <h2>Questionnaire pour les nouveaux utilisateurs</h2>
      <p>Merci de remplir ce <a href="formulaire.php">formulaire d'inscription</a> avant votre première séance pour évaluer vos besoins et votre condition physique.</p>
    </div>

    <div class="section">
      <h2>Coordonnées des responsables</h2>
      <?php foreach ($responsables as $resp): ?>
        <div class="contact-card">
          <strong>Nom :</strong> <?= htmlspecialchars($resp['prenom']) ?> <?= htmlspecialchars($resp['nom']) ?><br>
          <strong>Téléphone :</strong> <?= htmlspecialchars($resp['telephone']) ?><br>
          <strong>Email :</strong> <?= htmlspecialchars($resp['email']) ?><br>
          <strong>Poste :</strong> <?= htmlspecialchars($resp['poste']) ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
