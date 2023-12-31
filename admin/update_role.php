<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Vérifiez si l'utilisateur a le rôle d'administrateur
if ($_SESSION['role'] !== 'admin') {
    header("Location: access_denied.php");
    exit();
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez les données du formulaire
    $userId = $_POST['user_id'];
    $newRole = $_POST['role'];

    // Incluez le fichier de connexion à la base de données
    include("cnx.php");

    // Mettez à jour le rôle de l'utilisateur dans la base de données
    $updateQuery = "UPDATE users SET role = :role WHERE id = :user_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':role', $newRole, PDO::PARAM_STR);
    $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        // Mise à jour réussie, redirigez ou affichez un message de succès
        header("Location: admin/users.php");
        exit();
    } else {
        // Erreur lors de la mise à jour, affichez un message d'erreur
        $errorMessage = "Erreur lors de la mise à jour du rôle.";
    }
}

// Si le formulaire n'a pas été soumis correctement, redirigez ou affichez un message d'erreur
header("Location: admin/users.php");
exit();
