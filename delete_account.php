<?php
include("cnx.php");

// Vérifie si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupère l'identifiant de l'utilisateur actuel
$user_id = $_SESSION['user_id'];

// Supprime l'utilisateur de la base de données
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);

// Déconnecte l'utilisateur après la suppression du compte
session_destroy();

// Redirige vers la page d'accueil ou une page appropriée après la suppression
header("Location: index.php");
exit();
?>
