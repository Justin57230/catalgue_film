<?php
session_start();

// Détruit toutes les données de session
session_destroy();

// Redirige l'utilisateur vers la page d'accueil ou une autre page après la déconnexion
header("Location: index.php");
exit;
?>
