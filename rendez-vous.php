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
        <form method="POST">
            <input type="hidden" name="coach_id" value="<?= intval($_POST['coach_id']) ?>">
            <label>Choisir un créneau :
                <select name="dispo_id" required>
                    <?php
                    $coach_id = intval($_POST['coach_id']);
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
                    while ($d = $dispos->fetch_assoc()) {
                        echo "<option value='{$d['id']}'>".$d['jour']." de ".$d['heure_debut']." à ".$d['heure_fin']."</option>";
                    }
                    ?>
                </select>
            </label>
            <button type="submit">Valider le rendez-vous</button>
        </form>
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
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46125.16715836869!2d3.6489429259873885!3d43.735004800892554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12b3fe268b01f953%3A0x4078821166ab9b0!2s34380%20Viols-le-Fort!5e0!3m2!1sfr!2sfr!4v1748268041768!5m2!1sfr!2sfr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </footer>
</body>
</html>
