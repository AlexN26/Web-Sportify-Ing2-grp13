<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Votre_compte.php");
    exit();
}

// Connexion BDD
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "sportify_db";
$conn = new mysqli($servername, $username_db, $password_db, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

function getCoachInfo($conn, $discipline) {
    $stmt = $conn->prepare("SELECT * FROM coachs WHERE domaine_expertise = ? LIMIT 1");
    $stmt->bind_param("s", $discipline);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function renderCoach($coach) {
    if (!$coach) return "<p>Aucun coach trouvé pour cette discipline.</p>";
    return "
        <img src='" . htmlspecialchars($coach['photo']) . "' alt='Photo de " . htmlspecialchars($coach['prenom']) . "' style='width:100px;border-radius:50%;'><br>
        <strong>Nom :</strong> " . htmlspecialchars($coach['prenom']) . " " . htmlspecialchars($coach['nom']) . "<br>
        <strong>Âge :</strong> " . htmlspecialchars($coach['age']) . " ans<br>
        <strong>Diplômes :</strong> " . htmlspecialchars($coach['diplomes']) . "<br>
        <strong>Téléphone :</strong> " . htmlspecialchars($coach['telephone']) . "<br>
        <strong>Email :</strong> " . htmlspecialchars($coach['email']) . "<br>
        <strong>Expérience :</strong> " . htmlspecialchars($coach['experience']) . "<br>
        <strong>Description :</strong><br><p>" . nl2br(htmlspecialchars($coach['description'])) . "</p>";
}
?>

<?php
// Surligner les résultats si une recherche est passée
if (isset($_GET['highlight'])) {
    $highlight = $_GET['highlight'];
    function highlightText($text) {
        global $highlight;
        return preg_replace("/($highlight)/i", '<span style="background-color:yellow;">$1</span>', $text);
    }
    ob_start();
}
?>

<!-- Votre contenu HTML/PHP normal -->

<?php
if (isset($_GET['highlight'])) {
    $content = ob_get_clean();
    echo highlightText($content);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Activités Sportives - Sportify</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f5f5f5;
    }
    h1 {
      text-align: center;
      padding: 2rem;
      color: #1c66af;
    }
    .activities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      padding: 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }
    .activity-card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 1.5rem;
      text-align: center;
      cursor: pointer;
      transition: transform 0.2s ease;
    }
    .activity-card:hover {
      transform: translateY(-5px);
    }
    .activity-card h2 {
      color: #1c66af;
      margin-bottom: 0.5rem;
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.5);
    }
    .modal-content {
      background-color: white;
      margin: 10% auto;
      padding: 2rem;
      border-radius: 10px;
      width: 80%;
      max-width: 600px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.3);
    }
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    .close:hover {
      color: #000;
    }
    .back-arrow {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 1.2rem;
      text-decoration: none;
      color: #1c66af;
      display: flex;
      align-items: center;
      font-weight: bold;
      transition: color 0.3s ease;
    }
    .back-arrow:hover {
      color: #0d4b8a;
    }
    .back-arrow::before {
      content: "←";
      margin-right: 8px;
      font-size: 1.5rem;
    }
    .button-container {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 20px;
    }
    .button-container a {
      text-decoration: none;
    }
    .button-container button {
      padding: 10px 20px;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .rdv-button {
      background-color: #1c66af;
    }
    .rdv-button:hover {
      background-color: #0d4b8a;
    }
    .msg-button {
      background-color: #1c66af;
    }
    .msg-button:hover {
      background-color: #0d4b8a;
    }
  </style>
</head>
<body>
  <a href="Tout_parcourir.php" class="back-arrow">Retour</a>
  <h1>Nos Activités Sportives</h1>
  <div class="activities-grid">
    <div class="activity-card" onclick="openModal('musculation')">
      <h2>Musculation</h2>
      <p>Renforcez votre corps et gagnez en puissance grâce à des programmes adaptés à tous les niveaux.</p>
    </div>
    <div class="activity-card" onclick="openModal('fitness')">
      <h2>Fitness</h2>
      <p>Des séances dynamiques pour améliorer votre condition physique dans une ambiance motivante.</p>
    </div>
    <div class="activity-card" onclick="openModal('biking')">
      <h2>Biking</h2>
      <p>Un entraînement cardio intense sur vélo pour brûler des calories en rythme avec la musique.</p>
    </div>
    <div class="activity-card" onclick="openModal('cardio')">
      <h2>Cardio-Training</h2>
      <p>Optimisez votre endurance avec des machines modernes et des sessions personnalisées.</p>
    </div>
    <div class="activity-card" onclick="openModal('cours-collectifs')">
      <h2>Cours Collectifs</h2>
      <p>Rejoignez nos cours en groupe pour booster votre motivation et varier les plaisirs.</p>
    </div>
  </div>

  <!-- Modals -->
  <div id="musculation" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('musculation')">&times;</span>
      <h2>Musculation</h2>
      <?= renderCoach(getCoachInfo($conn, 'Musculation')) ?>
      <div class="button-container">
        <a href="rendez-vous.php">
          <button class="rdv-button">Prendre rendez-vous</button>
        </a>
        <a href="<?= ($_SESSION['role'] === 'client') ? 'client.php' : 'coach.php' ?>">
          <button class="msg-button">Envoyer un message</button>
        </a>
      </div>
    </div>
  </div>

  <div id="fitness" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('fitness')">&times;</span>
      <h2>Fitness</h2>
      <?= renderCoach(getCoachInfo($conn, 'Fitness')) ?>
      <div class="button-container">
        <a href="rendez-vous.php">
          <button class="rdv-button">Prendre rendez-vous</button>
        </a>
        <a href="<?= ($_SESSION['role'] === 'client') ? 'client.php' : 'coach.php' ?>">
          <button class="msg-button">Envoyer un message</button>
        </a>
      </div>
    </div>
  </div>

  <div id="biking" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('biking')">&times;</span>
      <h2>Biking</h2>
      <?= renderCoach(getCoachInfo($conn, 'Biking')) ?>
      <div class="button-container">
        <a href="rendez-vous.php">
          <button class="rdv-button">Prendre rendez-vous</button>
        </a>
        <a href="<?= ($_SESSION['role'] === 'client') ? 'client.php' : 'coach.php' ?>">
          <button class="msg-button">Envoyer un message</button>
        </a>
      </div>
    </div>
  </div>

  <div id="cardio" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('cardio')">&times;</span>
      <h2>Cardio-Training</h2>
      <?= renderCoach(getCoachInfo($conn, 'Cardio-Training')) ?>
      <div class="button-container">
        <a href="rendez-vous.php">
          <button class="rdv-button">Prendre rendez-vous</button>
        </a>
        <a href="<?= ($_SESSION['role'] === 'client') ? 'client.php' : 'coach.php' ?>">
          <button class="msg-button">Envoyer un message</button>
        </a>
      </div>
    </div>
  </div>

  <div id="cours-collectifs" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('cours-collectifs')">&times;</span>
      <h2>Cours Collectifs</h2>
      <?= renderCoach(getCoachInfo($conn, 'Cours Collectifs')) ?>
      <div class="button-container">
        <a href="rendez-vous.php">
          <button class="rdv-button">Prendre rendez-vous</button>
        </a>
        <a href="<?= ($_SESSION['role'] === 'client') ? 'client.php' : 'coach.php' ?>">
          <button class="msg-button">Envoyer un message</button>
        </a>
      </div>
    </div>
  </div>

  <script>
    function openModal(id) {
      document.getElementById(id).style.display = 'block';
    }
    function closeModal(id) {
      document.getElementById(id).style.display = 'none';
    }
    window.onclick = function(event) {
      const modals = document.querySelectorAll('.modal');
      modals.forEach(modal => {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      });
    };
  </script>
</body>
</html>