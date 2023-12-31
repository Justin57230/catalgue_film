<?php
// login.php

include("cnx.php");
require 'password.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Recherche de l'utilisateur dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Connexion réussie
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Assurez-vous que le champ role existe dans votre base de données
        header("Location: catalogue.php"); // Rediriger vers la page du catalogue
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="./style/login.css">
</head>

<body>
    <?php include("preset_header.php"); ?>
    <h1>Connexion</h1>

    <form method="POST" action="login.php">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" name="username" required>

        <label for="password">Mot de passe:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Se connecter">
    </form>

</body>

</html>
