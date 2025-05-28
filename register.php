<?php
// Connexion à la BDD
$conn = new mysqli("localhost", "root", "", "sportify_db");

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupération des données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Vérification si le nom d'utilisateur existe déjà
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Username déjà pris
    header("Location: inscription.php?error=username");
    exit();
}

// Hachage du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insertion du nouvel utilisateur
$insertSql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param("sss", $username, $hashedPassword, $role);
$insertStmt->execute();

$conn->close();

// Redirection après succès
header("Location: Votre_compte.php");
exit();
?>
