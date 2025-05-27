<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: Votre_compte.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sports de Compétition - Sportify</title>
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

    /* Modal Styles */
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

  </style>
</head>
<body>
  <a href="Tout_parcourir.php" class="back-arrow">Retour</a>
  <h1>Nos Sports de Compétition</h1>
  <div class="sports-grid">
    <div class="sport-card" onclick="openModal('basketball')">
      <h2>Basketball</h2>
      <p>Équipe des Dunk Masters – Niveau Universitaire</p>
    </div>
    <div class="sport-card" onclick="openModal('football')">
      <h2>Football</h2>
      <p>Club des Tireurs Précis – Ligue Régionale 1</p>
    </div>
    <div class="sport-card" onclick="openModal('rugby')">
      <h2>Rugby</h2>
      <p>Les Plaqueurs Sauvages – Fédérale 2</p>
    </div>
    <div class="sport-card" onclick="openModal('tennis')">
      <h2>Tennis</h2>
      <p>Team Ace Breakers – Circuit Universitaire</p>
    </div>
    <div class="sport-card" onclick="openModal('natation')">
      <h2>Natation</h2>
      <p>Les Requins Bleus – Compétitions Inter-Universitaires</p>
    </div>
    <div class="sport-card" onclick="openModal('plongeon')">
      <h2>Plongeon</h2>
      <p>Les Voltigeurs Aquatiques – Niveau National Espoirs</p>
    </div>
    <div class="sport-card" onclick="openModal('triathlon')">
      <h2>Triathlon</h2>
      <p>Les Machines de Fer – Équipe Open Élites</p>
    </div>
  </div>

  <!-- Modals -->
  <div id="basketball" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('basketball')">&times;</span>
      <h2>Basketball</h2>
      <p>L'équipe des Dunk Masters affronte régulièrement les meilleures universités du pays. Un collectif qui monte au dunk comme on monte au front — sauvagement et avec panache.</p>
    </div>
  </div>

  <div id="football" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('football')">&times;</span>
      <h2>Football</h2>
      <p>Les Tireurs Précis n'ont pas peur de tirer... des lucarnes. Ils jouent en Ligue Régionale 1 et matent leur adversaire comme Zidane matait la Juventus en 2002.</p>
    </div>
  </div>

  <div id="rugby" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('rugby')">&times;</span>
      <h2>Rugby</h2>
      <p>Les Plaqueurs Sauvages portent bien leur nom. Leurs adversaires finissent au sol plus souvent qu’un étudiant en partiels sans sommeil.</p>
    </div>
  </div>

  <div id="tennis" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('tennis')">&times;</span>
      <h2>Tennis</h2>
      <p>La team Ace Breakers distribue les services gagnants comme des pains un lundi matin. Jeu, set et match en 2 frappes chrono.</p>
    </div>
  </div>

  <div id="natation" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('natation')">&times;</span>
      <h2>Natation</h2>
      <p>Les Requins Bleus nagent plus vite que leur ombre. En bassin, ils dominent comme Phelps en 2008. Sauvagement.</p>
    </div>
  </div>

  <div id="plongeon" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('plongeon')">&times;</span>
      <h2>Plongeon</h2>
      <p>Voltige, élégance, et des plongeons qui claquent comme une copie de partiel parfaite — une vraie leçon de style.</p>
    </div>
  </div>

  <div id="triathlon" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('triathlon')">&times;</span>
      <h2>Triathlon</h2>
      <p>Les Machines de Fer enchaînent nage, vélo et course avec la précision d’un robot programmé pour mater ses concurrents… littéralement.</p>
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
