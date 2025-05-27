<?php
session_start();
session_destroy();
header("Location: Votre-compte.html");
exit();
?>