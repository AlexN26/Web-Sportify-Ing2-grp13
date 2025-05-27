<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "sportify_db";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);
if ($conn->connect_error) {
    header("Location: inscription.html?error=db_error");
    exit();
}

// Récupération des données du formulaire
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$user_type = $_POST['role'] ?? ''; // champ <select name="role">

if (empty($username) || empty($password) || empty($user_type)) {
    header("Location: inscription.html?error=empty_fields");
    exit();
}

if (strlen($username) < 3 || strlen($password) < 6) {
    header("Location: inscription.html?error=invalid_input");
    exit();
}

// Vérifier si le nom d'utilisateur existe déjà
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    $conn->close();
    header("Location: inscription.html?error=already_exists");
    exit();
}
$stmt->close();

// Insertion en clair du mot de passe
$stmt = $conn->prepare("INSERT INTO users (username, password, user_type, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $username, $password, $user_type);

if ($stmt->execute()) {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $user_type;
    header("Location: Votre_compte.php?success=registered");
} else {
    header("Location: inscription.html?error=db_insert_fail");
}

$stmt->close();
$conn->close();
exit();
?>