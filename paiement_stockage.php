<?php

$conn = new mysqli("localhost", "root", "", "sportify_db");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}


$client_username = trim($_POST['client_username']);
$nom_complet = trim($_POST['nom_complet']);
$adresse1 = trim($_POST['adresse1']);
$adresse2 = isset($_POST['adresse2']) ? trim($_POST['adresse2']) : null;
$ville = trim($_POST['ville']);
$code_postal = trim($_POST['code_postal']);
$pays = trim($_POST['pays']);
$telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : null;
$carte_etudiant = isset($_POST['carte_etudiant']) ? trim($_POST['carte_etudiant']) : null;
$type_carte = trim($_POST['type_carte']);
$numero_carte = trim($_POST['numero_carte']);
$nom_carte = trim($_POST['nom_carte']);
$date_expiration = trim($_POST['date_expiration']);
$code_securite = trim($_POST['code_securite']);


$sql = "INSERT INTO paiement (
    client_username, nom_complet, adresse1, adresse2, ville, 
    code_postal, pays, telephone, carte_etudiant, type_carte, 
    numero_carte, nom_carte, date_expiration, code_securite
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";



$stmt = $conn->prepare($sql);


$stmt->bind_param(
    "ssssssssssssss",
    $client_username, $nom_complet, $adresse1, $adresse2, $ville,
    $code_postal, $pays, $telephone, $carte_etudiant, $type_carte,
    $numero_carte, $nom_carte, $date_expiration, $code_securite
);



if ($stmt->execute()) {
  
    header("Location: rendez-vous.php");
} else {
  
   echo '<p style="color:red;">l operation n a pas pu etre effectuee</p>';
}
$stmt->close();
$conn->close();
exit();
?>