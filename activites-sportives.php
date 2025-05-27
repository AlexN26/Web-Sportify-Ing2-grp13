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
  </style>
</head>
<body>
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
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sit amet risus vitae elit bibendum fermentum. (Coachs à venir)</p>
    </div>
  </div>

  <div id="fitness" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('fitness')">&times;</span>
      <h2>Fitness</h2>
      <p>Blablabla musclé de remplacement en attendant du contenu qui va soulever de la fonte virtuelle. (Coachs à venir)</p>
    </div>
  </div>

  <div id="biking" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('biking')">&times;</span>
      <h2>Biking</h2>
      <p>On pédale dans le vide ici pour l’instant, mais bientôt les coachs feront transpirer le HTML. (Coachs à venir)</p>
    </div>
  </div>

  <div id="cardio" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('cardio')">&times;</span>
      <h2>Cardio-Training</h2>
      <p>Cardio intensif de mots sans oxygène pour meubler cette pop-up. (Coachs à venir)</p>
    </div>
  </div>

  <div id="cours-collectifs" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('cours-collectifs')">&times;</span>
      <h2>Cours Collectifs</h2>
      <p>Texte inutile mais motivé, comme un coach qui gueule "encore 10 pompes" juste pour le fun. (Coachs à venir)</p>
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
