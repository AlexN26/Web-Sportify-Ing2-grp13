<?php

session_start();

$mysqli = new mysqli("localhost", "root", "", "sportify_db");
if ($mysqli->connect_error) {
    die("Erreur BDD : " . $mysqli->connect_error);
}

$username = $_SESSION['username'] ?? '';
$role = $_SESSION['role'] ?? '';

if ($role === 'client') {
    
    $rdvs = $mysqli->prepare("SELECT r.*, c.nom, c.prenom FROM rendez_vous r JOIN coachs c ON r.coach_id = c.id WHERE r.client_username = ?");
    $rdvs->bind_param("s", $username);
} elseif ($role === 'coach') {
  
    $coach_info = $mysqli->prepare("SELECT id FROM coachs WHERE username = ?");
    $coach_info->bind_param("s", $username);
    $coach_info->execute();
    $coach_result = $coach_info->get_result();
    
    if ($coach_result->num_rows > 0) {
        $coach_data = $coach_result->fetch_assoc();
        $coach_id = $coach_data['id'];
        
        $rdvs = $mysqli->prepare("SELECT r.*, r.client_username as client_nom FROM rendez_vous r WHERE r.coach_id = ?");
        $rdvs->bind_param("i", $coach_id);
    } else {
        $rdvs = null;
    }
} else {
    $rdvs = null;
}

if ($rdvs) {
    $rdvs->execute();
    $result = $rdvs->get_result();
}

// Annulation (uniquement pour clients)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['annuler_id']) && ($role === 'client' || $role === 'coach'))  {
    $id = intval($_POST['annuler_id']);
    $mysqli->query("DELETE FROM rendez_vous WHERE id = $id");
    header("Location: rendez-vous.php");
    exit();
}

// Prise de rendez-vous (clients uniquement)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['coach_id'], $_POST['dispo_id']) && $role === 'client') {
    $coach_id = intval($_POST['coach_id']);
    $dispo_id = intval($_POST['dispo_id']);

    $verif = $mysqli->prepare("
        SELECT d.jour, d.heure_debut, d.heure_fin
        FROM disponibilite d
        WHERE d.id = ? AND d.disponible = 1
        AND NOT EXISTS (
            SELECT 1 FROM rendez_vous r
            WHERE r.coach_id = d.coach_id AND r.date_rdv = CURDATE() AND r.heure_rdv = d.heure_debut
        )
    ");
    $verif->bind_param("i", $dispo_id);
    $verif->execute();
    $verif_result = $verif->get_result();

    if ($verif_result->num_rows > 0) {
        $row = $verif_result->fetch_assoc();
        $stmt = $mysqli->prepare("INSERT INTO rendez_vous (client_username, coach_id, date_rdv, heure_rdv, lieu) VALUES (?, ?, CURDATE(), ?, 'Salle Omnes')");
        $stmt->bind_param("sis", $username, $coach_id, $row['heure_debut']);
        $stmt->execute();
        $stmt->close();
        header("Location: rendez-vous.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes rendez-vous</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .paiement-btn {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            text-decoration: none;
           
        }
        .paiement-btn:hover {
            background-color: #45a049;
        }
    </style>
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
<?php if (isset($result) && $result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <?php if ($role === 'client'): ?>
                    <th>Coach</th>
                <?php else: ?>
                    <th>Client</th>
                <?php endif; ?>
                <th>Date</th>
                <th>Heure</th>
                <th>Lieu</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rdv = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?php if ($role === 'client'): ?>
                            <?= htmlspecialchars($rdv['prenom'] . ' ' . $rdv['nom']) ?>
                        <?php else: ?>
                            <?= htmlspecialchars($rdv['client_nom']) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($rdv['date_rdv']) ?></td>
                    <td><?= htmlspecialchars($rdv['heure_rdv']) ?></td>
                    <td><?= htmlspecialchars($rdv['lieu']) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="annuler_id" value="<?= $rdv['id'] ?>">
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?')">Annuler</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucun rendez-vous confirmé pour le moment.</p>
<?php endif; ?>
 <h2>Prendre un nouveau rendez-vous</h2>

<?php if ($role !== 'client'): ?>
    <p style="color:red;">Seuls les clients peuvent prendre un rendez-vous. Veuillez vous connecter avec un compte client.</p>
<?php else: ?>
    <form method="POST">
        <label>Choisir un coach :
            <select name="coach_id" required onchange="this.form.submit()">
                <option value="">-- Sélectionnez --</option>
                <?php
                $coachs = $mysqli->query("SELECT id, nom, prenom FROM coachs");
                while ($c = $coachs->fetch_assoc()) {
                    $selected = (isset($_POST['coach_id']) && $_POST['coach_id'] == $c['id']) ? "selected" : "";
                    echo "<option value='{$c['id']}' $selected>{$c['prenom']} {$c['nom']}</option>";
                }
                ?>
            </select>
        </label>
    </form>

    <?php if (isset($_POST['coach_id'])): ?>
    <?php
    $coach_id = intval($_POST['coach_id']);
    
    // Récupérer les disponibilités du coach
    $dispos = $mysqli->query("
        SELECT d.id, d.jour, d.heure_debut, d.heure_fin 
        FROM disponibilite d 
        WHERE d.coach_id = $coach_id 
        AND d.disponible = 1 
        AND NOT EXISTS (
            SELECT 1 FROM rendez_vous r 
            WHERE r.coach_id = d.coach_id 
            AND r.date_rdv = CURDATE() 
            AND r.heure_rdv = d.heure_debut
        )
    ");
    
    // Organiser les disponibilités par jour (en minuscules pour uniformiser)
    $disponibilites_par_jour = array_fill_keys(
        ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'], 
        []
    );
    
    while ($d = $dispos->fetch_assoc()) {
        $jour = strtolower($d['jour']);
        if (array_key_exists($jour, $disponibilites_par_jour)) {
            $disponibilites_par_jour[$jour][] = $d;
        }
    }
    
    // Jours de la semaine avec première lettre en majuscule
    $jours_semaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    ?>
    
    <style>
        .calendar-container {
            max-width: 1000px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        .calendar-header, .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }
        .calendar-header {
            background: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .calendar-day-header, .calendar-day-slots {
            padding: 10px;
            border: 1px solid #ddd;
            min-height: 40px;
        }
        .calendar-day-slots {
            min-height: 150px;
        }
        .time-slot {
            margin: 5px 0;
            padding: 8px;
            background: #e9f7fe;
            border: 1px solid #b3e0ff;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }
        .time-slot:hover {
            background: #d0ebff;
        }
        .time-slot.selected {
            background: #4CAF50;
            color: white;
            border-color: #3e8e41;
        }
        .no-availability {
            color: #999;
            text-align: center;
            padding: 10px;
        }
        #confirm-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        #confirm-btn:disabled {
            background: #cccccc;
            cursor: not-allowed;
        }
    </style>
    
    <div class="calendar-container">
        <h2>Choisissez un créneau horaire</h2>
        
        <form method="POST" id="booking-form">
            <input type="hidden" name="coach_id" value="<?= $coach_id ?>">
            <input type="hidden" name="dispo_id" id="selected-slot" value="">
            
            <div class="calendar-header">
                <?php foreach ($jours_semaine as $jour): ?>
                    <div class="calendar-day-header"><?= $jour ?></div>
                <?php endforeach; ?>
            </div>
            
            <div class="calendar-body">
                <?php foreach ($jours_semaine as $jour): ?>
                    <div class="calendar-day-slots">
                        <?php 
                        $dispos_jour = $disponibilites_par_jour[strtolower($jour)];
                        if (!empty($dispos_jour)): 
                        ?>
                            <?php foreach ($dispos_jour as $dispo): ?>
                                <div class="time-slot" 
                                     data-dispo-id="<?= $dispo['id'] ?>"
                                     onclick="selectTimeSlot(this, <?= $dispo['id'] ?>)">
                                    <?= substr($dispo['heure_debut'], 0, 5) ?> - <?= substr($dispo['heure_fin'], 0, 5) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-availability">Aucune disponibilité</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button type="submit" id="confirm-btn" disabled>Confirmer le rendez-vous</button>
        </form>
    </div>
    
    <script>
        function selectTimeSlot(element, dispoId) {
            // Désélectionner tous les créneaux
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.classList.remove('selected');
            });
            
            // Sélectionner le créneau cliqué
            element.classList.add('selected');
            
            // Mettre à jour l'ID de disponibilité sélectionné
            document.getElementById('selected-slot').value = dispoId;
            
            // Activer le bouton de confirmation
            document.getElementById('confirm-btn').disabled = false;
        }
    </script>
<?php endif; ?>
<?php endif; ?>

<h2>Payer</h2>
<?php if ($role !== 'client'): ?>
    <p style="color:red;">Seuls les clients peuvent payer. Veuillez vous connecter avec un compte client.</p>
<?php else: ?>
     <a href="paiement.php" class="paiement-btn">Procéder au paiement</a>
<?php endif; ?>

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