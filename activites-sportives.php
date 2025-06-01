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

function getCoachInfo($conn, $discipline) {
    $stmt = $conn->prepare("SELECT * FROM coachs WHERE domaine_expertise = ? LIMIT 1");
    $stmt->bind_param("s", $discipline);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getCoachDisponibilites($conn, $coach_id) {
    $disponibilites = [];
    $stmt = $conn->prepare("SELECT * FROM disponibilite WHERE coach_id = ? AND disponible = 1 ORDER BY jour, heure_debut");
    $stmt->bind_param("i", $coach_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $disponibilites[] = [
            "Jour" => ucfirst($row['jour']),
            "Heures" => substr($row['heure_debut'], 0, 5) . " - " . substr($row['heure_fin'], 0, 5)
        ];
    }
    return $disponibilites;
}

function renderCoach($conn, $coach) {
    if (!$coach) return "<p>Aucun coach trouvé pour cette discipline.</p>";

    $horaires = getCoachDisponibilites($conn, $coach['id']);

    $horaires_html = "<table style='width:100%; border-collapse: collapse; margin-top: 1rem;'>
        <tr><th style='border-bottom: 1px solid #ccc; text-align: left;'>Jour</th><th style='border-bottom: 1px solid #ccc; text-align: left;'>Horaires</th></tr>";
    
    if (empty($horaires)) {
        $horaires_html .= "<tr><td colspan='2'>Aucune disponibilité enregistrée</td></tr>";
    } else {
        foreach ($horaires as $h) {
            $horaires_html .= "<tr><td>{$h['Jour']}</td><td>{$h['Heures']}</td></tr>";
        }
    }
    $horaires_html .= "</table>";

    return "
    <div style='display: flex; align-items: flex-start; gap: 20px;'>
        <img src='" . htmlspecialchars($coach['photo']) . "' alt='Photo de " . htmlspecialchars($coach['prenom']) . "' style='width:120px;height:120px;border-radius:10px;object-fit:cover;'>
        <div>
            <p><strong>Prénom :</strong> " . htmlspecialchars($coach['prenom']) . "</p>
            <p><strong>Nom :</strong> " . htmlspecialchars($coach['nom']) . "</p>
            <p><strong>Salle :</strong> " . htmlspecialchars($coach['salle']) . "</p>
            <p><strong>Téléphone :</strong> " . htmlspecialchars($coach['telephone']) . "</p>
            <p><strong>Email :</strong> " . htmlspecialchars($coach['email']) . "</p>
            <p><strong>Spécialité :</strong> " . htmlspecialchars($coach['domaine_expertise']) . "</p>
        </div>
    </div>
    <div style='margin-top: 1rem;'>
        <h3>Disponibilités</h3>
        $horaires_html
    </div>";
}
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
    .sports-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      padding: 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }
    .sport-card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 1.5rem;
      text-align: center;
      cursor: pointer;
      transition: transform 0.2s ease;
    }
    .sport-card:hover {
      transform: translateY(-5px);
    }
    .sport-card h2 {
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
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.3);
}

.popup {
    display: none;
    position: fixed;
    z-index: 1001;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.popup-content {
    background-color: white;
    margin: 10% auto;
    padding: 20px;
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
  <div class="sports-grid">
    <div class="sport-card" onclick="openModal('musculation')">
      <h2>Musculation</h2>
      <p>Renforcez votre corps avec nos programmes personnalisés</p>
    </div>
    <div class="sport-card" onclick="openModal('fitness')">
      <h2>Fitness</h2>
      <p>Améliorez votre condition physique dans une ambiance motivante</p>
    </div>
    <div class="sport-card" onclick="openModal('biking')">
      <h2>Biking</h2>
      <p>Un entraînement cardio intense sur vélo pour brûler des calories en rythme avec la musique.</p>
    </div>
    <div class="sport-card" onclick="openModal('cardio')">
      <h2>Cardio-Training</h2>
      <p>Optimisez votre endurance avec des machines modernes et des sessions personnalisées.</p>
    </div>
    <div class="sport-card" onclick="openModal('cours-collectifs')">
      <h2>Cours Collectifs</h2>
      <p>ejoignez nos cours en groupe pour booster votre motivation et varier les plaisirs.</p>
    </div>
  </div>

  <div id="musculation" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('musculation')">&times;</span>
        <h2>Musculation</h2>
        <?php 
        $coach = getCoachInfo($conn, 'Musculation');
        echo renderCoach($conn, $coach); 
        ?>
        <div class="button-container">
            <a href="rendez-vous.php">
                <button class="rdv-button">Prendre rendez-vous</button>
            </a>
            <a href="<?= ($_SESSION['role'] === 'client') ? 'client.php' : 'coach.php' ?>">
                <button class="msg-button">Envoyer un message</button>
            </a>
            <a href="javascript:void(0);" onclick="afficherPopupCV(<?= $coach['id'] ?? 'null' ?>)">
                <button class="msg-button">CV</button>
            </a>
        </div>
    </div>
</div>

  <div id="fitness" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('fitness')">&times;</span>
        <h2>Fitness</h2>
        <?php 
        $coach = getCoachInfo($conn, 'Fitness');
        echo renderCoach($conn, $coach); 
        ?>
        <div class="button-container">
            <a href="rendez-vous.php">
                <button class="rdv-button">Prendre rendez-vous</button>
            </a>
            <a href="<?= ($_SESSION['role'] === 'client') ? 'client.php' : 'coach.php' ?>">
                <button class="msg-button">Envoyer un message</button>
            </a>
            <a href="javascript:void(0);" onclick="afficherPopupCV(<?= $coach['id'] ?? 'null' ?>)">
                <button class="msg-button">CV</button>
            </a>
        </div>
    </div>
</div>

  <div id="biking" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('biking')">&times;</span>
        <h2>Biking</h2>
        <?php 
        $coach = getCoachInfo($conn, 'Biking');
        echo renderCoach($conn, $coach); 
        ?>
        <div class="button-container">
            <a href="rendez-vous.php">
                <button class="rdv-button">Prendre rendez-vous</button>
            </a>
            <a href="<?= ($_SESSION['role'] === 'client') ? 'client.php' : 'coach.php' ?>">
                <button class="msg-button">Envoyer un message</button>
            </a>
            <a href="javascript:void(0);" onclick="afficherPopupCV(<?= $coach['id'] ?? 'null' ?>)">
                <button class="msg-button">CV</button>
            </a>
        </div>
    </div>
</div>

  <div id="cardio" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('cardio')">&times;</span>
        <h2>Cardio-training</h2>
        <?php 
        $coach = getCoachInfo($conn, 'Cardio-training');
        echo renderCoach($conn, $coach); 
        ?>
        <div class="button-container">
            <a href="rendez-vous.php">
                <button class="rdv-button">Prendre rendez-vous</button>
            </a>
            <a href="<?= ($_SESSION['role'] === 'client') ? 'client.php' : 'coach.php' ?>">
                <button class="msg-button">Envoyer un message</button>
            </a>
            <a href="javascript:void(0);" onclick="afficherPopupCV(<?= $coach['id'] ?? 'null' ?>)">
                <button class="msg-button">CV</button>
            </a>
        </div>
    </div>
</div>

  <div id="cours-collectifs" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('cours-collectifs')">&times;</span>
        <h2>Cours Collectifs</h2>
        <?php 
        $coach = getCoachInfo($conn, 'Cours Collectifs');
        echo renderCoach($conn, $coach); 
        ?>
        <div class="button-container">
            <a href="rendez-vous.php">
                <button class="rdv-button">Prendre rendez-vous</button>
            </a>
            <a href="<?= ($_SESSION['role'] === 'client') ? 'client.php' : 'coach.php' ?>">
                <button class="msg-button">Envoyer un message</button>
            </a>
            <a href="javascript:void(0);" onclick="afficherPopupCV(<?= $coach['id'] ?? 'null' ?>)">
                <button class="msg-button">CV</button>
            </a>
        </div>
    </div>
</div>

  <div id="popupCV" class="popup" style="display:none;">
    <div class="popup-content">
        <span class="close" onclick="fermerPopupCV()">&times;</span>
        <h2>CV du coach</h2>
        <div id="cv-content">
          <script>
function afficherPopupCV(coachId) {
    if (!coachId) {
        alert("Aucun coach sélectionné");
        return;
    }
    
    fetch('get_cv_coach.php?id=' + coachId)
        .then(response => {
            if (!response.ok) throw new Error('Erreur réseau');
            return response.json();
        })
        .then(data => {
            const content = 
                `<div style="display: flex; gap: 20px; margin-bottom: 20px;">
                    <img src="${data.photo}" alt="Photo" style="width:120px;height:120px;border-radius:10px;object-fit:cover;">
                    <div>
                        <p><strong>Nom :</strong> ${data.nom} ${data.prenom}</p>
                        <p><strong>Spécialité :</strong> ${data.domaine_expertise}</p>
                        <p><strong>Salle :</strong> ${data.salle}</p>
                    </div>
                </div>
                <div>
                    <h3>Informations professionnelles</h3>
                    <p><strong>Expérience :</strong> ${data.experience}</p>
                    <p><strong>Diplômes :</strong> ${data.diplomes}</p>
                    <p><strong>Description :</strong><br>${data.description}</p>
                </div>`;
            document.getElementById('cv-content').innerHTML = content;
            document.getElementById('popupCV').style.display = 'block';
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert("Erreur lors du chargement du CV");
        });
}

function fermerPopupCV() {
    document.getElementById('popupCV').style.display = 'none';
}
</script>
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