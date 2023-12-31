<?php
session_start();
include("preset_header.php");

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix d'ajout</title>
    <link rel="stylesheet" href="./style/ajt.css">
</head>

<body>

<section class="content-section">
    <p>Choisissez le type d'ajout :</p>

    <?php if ($_SESSION['role'] === 'admin') : ?>
        <label class="radio-label">
            <input type="radio" name="type_ajout" value="film" id="filmRadio"> Ajouter un film
        </label>

        <label class="radio-label">
            <input type="radio" name="type_ajout" value="serie" id="serieRadio"> Ajouter une série
        </label>

        <button onclick="redirect()">OK</button>

        <br><br>

        <div id="contentContainer"></div>

    <?php else : ?>
        <p>Vous n'avez pas les autorisations nécessaires pour effectuer cette action.</p>
    <?php endif; ?>

    <script>
        function redirect() {
            // Récupérer la valeur du bouton radio sélectionné
            var selectedType = document.querySelector('input[name="type_ajout"]:checked');

            if (selectedType) {
                // Construire le chemin de redirection en fonction du type sélectionné
                var page = (selectedType.value === "film") ? "ajout_film.php" : "ajout_serie.php";

                // Rediriger vers la page appropriée
                window.location.href = page;
            } else {
                alert("Veuillez sélectionner un type d'ajout.");
            }
        }
    </script>

</section>

</body>
</html>
