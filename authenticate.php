<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportify_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_POST['username'];
$pass = $_POST['password'];


$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($pass === $row['password']) {
        $_SESSION['role'] = $row['user_type'];
        $_SESSION['username'] = $row['username'];

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

$_SESSION['login_error'] = "Nom d'utilisateur ou mot de passe incorrect";
echo '<p style="color:red;">mot de passe ou nom d utilisateur incorrect </p>';

header("Location: Votre_compte.php");
exit();

$stmt->close();
$conn->close();
?>
