<?php
// register.php

include("cnx.php");
require("password.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Vérifier si le mot de passe et la confirmation sont identiques
    if ($password !== $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }

    // Hacher le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Ajouter l'utilisateur à la base de données
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword]);

    // Redirection vers la page de connexion après l'inscription
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="./style/login.css">
    <link rel="stylesheet" href="./style/register.css">
</head>

<body>
    <?php include("preset_header.php"); ?>
    <h1>Inscription</h1>

    <form method="POST" action="register.php">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" name="username" required>

        <label for="email">Adresse e-mail:</label>
        <input type="email" name="email" required>

        <label for="password">Mot de passe:</label>
        <input type="password" name="password" required>

        <label for="confirm_password">Confirmer le mot de passe:</label>
        <input type="password" name="confirm_password" required>

        <input type="submit" value="S'inscrire">
    </form>

    <div id="error-container"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');

            form.addEventListener('submit', function (event) {
                const username = form.querySelector('[name="username"]').value;
                const email = form.querySelector('[name="email"]').value;
                const password = form.querySelector('[name="password"]').value;
                const confirmPassword = form.querySelector('[name="confirm_password"]').value;

                const errorMessages = [];

                if (!username) {
                    errorMessages.push('<span class="error-icon">&#x274C;</span>Veuillez saisir un nom d\'utilisateur.');
                }

                if (!email) {
                    errorMessages.push('<span class="error-icon">&#x274C;</span>Veuillez saisir une adresse e-mail.');
                }

                if (!password) {
                    errorMessages.push('<span class="error-icon">&#x274C;</span>Veuillez saisir un mot de passe.');
                } else if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/)) {
                    errorMessages.push('<span class="error-icon">&#x274C;</span>Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre, 1 symbole et être long d\'au moins 10 caractères.');
                }

                if (password !== confirmPassword) {
                    errorMessages.push('<span class="error-icon">&#x274C;</span>Les mots de passe ne correspondent pas.');
                }

                const errorContainer = document.getElementById('error-container');

                if (errorMessages.length > 0) {
                    event.preventDefault(); // Empêcher l'envoi du formulaire
                    errorContainer.innerHTML = '<p>' + errorMessages.join('</p><p>') + '</p>';
                    errorContainer.style.display = 'block'; // Afficher le conteneur d'erreur
                } else {
                    errorContainer.style.display = 'none'; // Cacher le conteneur d'erreur
                }
            });
        });
    </script>

</body>

</html>
