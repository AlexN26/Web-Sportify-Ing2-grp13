<?php
// Connexion à la BDD
$conn = new mysqli("localhost", "root", "", "sportify_db");

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// On vérifie que les données existent bien dans $_POST
if (!isset($_POST['username'], $_POST['password'], $_POST['user_type'])) {
    // Redirection ou message d'erreur si au moins une donnée manque
    header("Location: inscription.php?error=missing_data");
    exit();
}

$username = trim($_POST['username']);
$password = $_POST['password'];
$role = trim($_POST['user_type']);

// Vérifie que les champs ne sont pas vides
if ($username === '' || $password === '' || $role === '') {
    header("Location: inscription.php?error=empty_fields");
    exit();
}

// Vérification si le nom d'utilisateur existe déjà
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Username déjà pris
    header("Location: inscription.php?error=username_taken");
    exit();
}

// Hachage du mot de passe pour ne pas le voir dans la base de donne
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// === IMPORTANT ===
// Vérifie que ta table users a bien une colonne "role"
// Sinon il faut enlever la colonne role ou la créer dans ta BDD

// Si ta table n'a pas de colonne role, remplace la requête par :
// $insertSql = "INSERT INTO users (username, password) VALUES (?, ?)";
// $insertStmt = $conn->prepare($insertSql);
// $insertStmt->bind_param("ss", $username, $hashedPassword);

// Sinon si elle a la colonne role, fais ça :
$insertSql = "INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param("sss", $username, $password, $role);

$insertStmt->execute();

$conn->close();

// Redirection après succès
header("Location: Votre_compte.php");
exit();
?>
