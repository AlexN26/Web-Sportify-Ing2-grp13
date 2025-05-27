<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportify_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des données du formulaire
$user = $_POST['username'];
$pass = $_POST['password'];

// Requête préparée pour éviter les injections SQL
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

// Vérifie les informations d'identification
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Comparaison directe des mots de passe (pas de hachage)
    if ($pass === $row['password']) {
        $_SESSION['role'] = $row['user_type'];   // Utilisation de 'role' partout
        $_SESSION['username'] = $row['username'];

        // Redirection selon le rôle
        switch ($_SESSION['role']) {
            case 'client':
                header("Location: client.php");
                break;
            case 'coach':
                header("Location: coach.php");
                break;
            case 'admin':
                header("Location: admin.php");
                break;
            default:
                header("Location: Votre_compte.php");
        }
        exit();
    }
}

// En cas d'échec
$_SESSION['login_error'] = "Nom d'utilisateur ou mot de passe incorrect";
header("Location: Votre_compte.php");
exit();

// Nettoyage
$stmt->close();
$conn->close();
?>
