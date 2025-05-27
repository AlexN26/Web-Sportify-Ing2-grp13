<?php
session_start();
session_destroy();
header("Location: Votre_compte.php");
exit();
?>