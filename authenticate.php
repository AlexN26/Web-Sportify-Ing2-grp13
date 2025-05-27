<?php
// Connexion à la base de données WAMP
$servername = "localhost";
$username = "root"; // Votre identifiant WAMP
$password = ""; // Votre mot de passe WAMP
$dbname = "sportify_db";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$user = $_POST['username'];
$pass = $_POST['password'];

// Requête SQL sécurisée
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    session_start();
    $_SESSION['user_type'] = $row['user_type'];
    $_SESSION['username'] = $row['username'];
    
    // Redirection en fonction du type d'utilisateur
    switch($row['user_type']) {
        case 'client':
            header("Location: client.php");
            break;
        case 'coach':
            header("Location: coach.php");
            break;
        case 'admin':
            header("Location: admin.php");
            break;
    }
} else {
    echo "Identifiants incorrects";
}

$stmt->close();
$conn->close();
?>