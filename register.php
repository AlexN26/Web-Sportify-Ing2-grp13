<?php
// Connexion à la BDD
$conn = new mysqli("localhost", "root", "", "sportify_db");

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifie que les données existent
if (!isset($_POST['username'], $_POST['password'], $_POST['user_type'], $_POST['email'])) {
    header("Location: inscription.php?error=missing_data");
    exit();
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];  // On garde le mot de passe en clair ici
$role = trim($_POST['user_type']);

// Vérifie que les champs ne sont pas vides
if ($username === '' || $email === '' || $password === '' || $role === '') {
    header("Location: inscription.php?error=empty_fields");
    exit();
}

// Vérifie si le nom d'utilisateur est déjà pris
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: inscription.php?error=username_taken");
    exit();
}

// Insertion du mot de passe en clair (comme demandé, mais pas recommandé)
$insertSql = "INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param("ssss", $username, $email, $password, $role);

$insertStmt->execute();
$insertStmt->close();
$conn->close();

// Redirection après succès
header("Location: Votre_compte.php");
exit();
?>
