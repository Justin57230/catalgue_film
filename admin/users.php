<?php
include("../cnx.php");

// Vérifiez si l'utilisateur est connecté et a le rôle d'administrateur
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Traitement du formulaire pour définir/unset l'utilisateur en tant qu'administrateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['set_admin'])) {
        $user_id = $_POST['user_id'];

        // Mettez en œuvre la logique pour définir l'utilisateur en tant qu'administrateur dans votre base de données
        $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
        $stmt->execute([$user_id]);

        echo "L'utilisateur a été défini en tant qu'administrateur.";
    } elseif (isset($_POST['unset_admin'])) {
        $user_id = $_POST['user_id'];

        // Mettez en œuvre la logique pour retirer le rôle d'administrateur de l'utilisateur dans votre base de données
        $stmt = $pdo->prepare("UPDATE users SET role = 'user' WHERE id = ?");
        $stmt->execute([$user_id]);

        echo "Le rôle d'administrateur a été retiré de l'utilisateur.";
    } elseif (isset($_POST['delete_user'])) {
        $user_id = $_POST['user_id'];

        // Mettez en œuvre la logique pour supprimer l'utilisateur de votre base de données
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);

        echo "L'utilisateur a été supprimé.";
    }
}

// Récupérez la liste des utilisateurs depuis la base de données
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="../style/user_admin.css">
</head>

<body>
    <?php include("preset_header.php"); ?>
    <h1>Gestion des Utilisateurs</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role'] ?></td>
                <td>
                    <?php if ($user['role'] !== 'admin') : ?>
                        <form method="post" action="users.php" onsubmit="return confirm('Êtes-vous sûr de vouloir définir cet utilisateur en tant qu\'admin ?');">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <input type="submit" name="set_admin" value="Définir en tant qu'admin">
                        </form>
                    <?php else : ?>
                        <form method="post" action="users.php" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer le rôle d\'admin à cet utilisateur ?');">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <input type="submit" name="unset_admin" value="Retirer le rôle d'admin">
                        </form>
                    <?php endif; ?>

                    <form method="post" action="users.php" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <input type="submit" name="delete_user" value="Supprimer">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>
