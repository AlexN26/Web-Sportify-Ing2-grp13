<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportify_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des données du formulaire
$user = $_POST['username'];
$pass = $_POST['password'];

// Requête sécurisée
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Comparaison directe des mots de passe (sans hachage)
    if ($pass === $row['password']) {
        $_SESSION['user_type'] = $row['user_type'];
        $_SESSION['username'] = $row['username'];
        
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
        exit();
    }
}

// Si échec de connexion
$_SESSION['login_error'] = "Nom d'utilisateur ou mot de passe incorrect";
header("Location: Votre_compte.html");
exit();

$stmt->close();
$conn->close();
?>