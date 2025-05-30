<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "sportify_db";
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['error' => 'ID de coach invalide']);
    exit;
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM coachs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Coach non trouvé']);
    exit;
}

$coach = $result->fetch_assoc();
echo json_encode($coach);
?>