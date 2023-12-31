<?php
session_start();
include("cnx.php");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Récupérer la liste des films et séries depuis la base de données
$stmt = $pdo->query("SELECT * FROM films");
$films = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Films et Séries</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        form {
            display: inline-block;
        }

        input[type="submit"] {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include("preset_header.php"); ?>
    <h1>Gestion des Films et Séries</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Titre</th>
            <th>Gérer</th>
        </tr>

        <?php foreach ($films as $film) : ?>
            <tr>
                <td><?= $film['id'] ?></td>
                <td><?= $film['type'] ?></td>
                <td><?= $film['title'] ?></td>
                <td>
                    <form method="POST" action="suppression_serie.php">
                        <input type="hidden" name="delete_id" value="<?= $film['id'] ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
    // Traitement de la suppression
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        $deleteId = $_POST['delete_id'];

        // Supprimer le film de la base de données
        $stmt = $pdo->prepare("DELETE FROM films WHERE id = ?");
        $stmt->execute([$deleteId]);

        echo "Le film ou la série a été supprimé(e) avec succès.";
    }
    ?>

</body>

</html>
