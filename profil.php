<?php
include("cnx.php");
include("password.php");

// Check if the user is logged in
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve user information from the database (replace with your actual database query)
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle password change if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changePassword'])) {
    $old_password = $_POST['oldPassword'];
    $new_password = $_POST['newPassword'];

    // Vérifier si l'ancien mot de passe correspond à celui dans la base de données
    if (password_verify($old_password, $user['password'])) {
        // Vérifier si le nouveau mot de passe satisfait les critères de sécurité
        if (
            strlen($new_password) >= 10 &&
            preg_match('/[A-Z]/', $new_password) &&
            preg_match('/[a-z]/', $new_password) &&
            preg_match('/[0-9]/', $new_password) &&
            preg_match('/[^a-zA-Z0-9]/', $new_password)
        ) {
            // Hasher le nouveau mot de passe
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe dans la base de données
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$new_password_hashed, $user_id]);

            // Redirection pour éviter le renvoi du formulaire lors du rafraîchissement de la page
            header("Location: profil.php?success=1");
            exit;
        } else {
            // Afficher un message d'erreur si le mot de passe ne satisfait pas les critères
            $password_error = "Le mot de passe doit contenir au moins 10 caractères, dont au moins une majuscule, une minuscule, un chiffre et un caractère spécial.";
        }
    } else {
        // Afficher un message d'erreur si l'ancien mot de passe ne correspond pas
        $password_error = "L'ancien mot de passe est incorrect.";
    }
}

// Handle account deletion if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteAccount'])) {
    // Demander une confirmation avant de supprimer le compte
    echo '<script language="javascript">';
    echo 'if(confirm("Êtes-vous sûr de vouloir supprimer votre compte? Cette action est irréversible.")) {';
    echo 'window.location.href = "delete_account.php";';
    echo '}';
    echo '</script>';
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <!-- Include your stylesheets or styling here -->
</head>

<body>
    <?php include("preset_header.php"); ?>
    <h1>Profil de <?php echo $user['username']; ?></h1>

    <div>
        <p>Nom d'utilisateur: <?php echo $user['username']; ?></p>
        <p>Email: <?php echo $user['email']; ?></p>
        <!-- Add more user information as needed -->
    </div>

    <h2>Changer le Mot de Passe</h2>

    <?php if (isset($successMessage)) : ?>
        <p style="color: green;"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <?php if (isset($password_error)) : ?>
        <p style="color: red;"><?php echo $password_error; ?></p>
    <?php endif; ?>

    <form method="POST" action="profil.php">
        <label for="oldPassword">Ancien Mot de Passe:</label>
        <input type="password" name="oldPassword" required>

        <label for="newPassword">Nouveau Mot de Passe:</label>
        <input type="password" name="newPassword" required>

        <label for="confirmPassword">Confirmer le Nouveau Mot de Passe:</label>
        <input type="password" name="confirmPassword" required>

        <input type="submit" name="changePassword" value="Changer le Mot de Passe">
    </form>

    <h2>Supprimer le Compte</h2>

    <form method="POST" action="profil.php">
        <input type="submit" name="deleteAccount" value="Supprimer le Compte">
    </form>

</body>

</html
