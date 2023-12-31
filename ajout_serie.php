<?php
include("cnx.php");

// Traitement du formulaire d'ajout de série
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $numSeasons = $_POST['num_seasons'];

    // Traitement de l'affiche
    $posterFileName = $_FILES['poster']['name'];
    $posterTmpName = $_FILES['poster']['tmp_name'];
    $posterPath = "./affiche/" . $posterFileName;

    // Déplacement de l'affiche vers le dossier ./affiche/
    move_uploaded_file($posterTmpName, $posterPath);

    // Ajout de la série à la base de données
    $stmt = $pdo->prepare("INSERT INTO films (title, poster_url, season, type) VALUES (?, ?, 'S1', 'serie')");
    $stmt->execute([$title, $posterPath]);

    // Création du document dans ./titre/
    $episodeTitles = [];
    for ($i = 1; $i <= $numSeasons; $i++) {
        $titlesInput = $_POST["season_${i}_titles"];
        $titlesArray = explode(';', $titlesInput);

        // Remove any leading or trailing whitespaces in each title
        $titlesArray = array_map('trim', $titlesArray);

        $seasonKey = "S{$i}";
        $episodeTitles[$seasonKey] = $titlesArray;
    }

    $documentContentTitles = '<?php $episodeTitles = ' . var_export($episodeTitles, true) . ';' . "\n" . '?>';
    file_put_contents("./titre/" . str_replace(' ', '_', $title) . ".php", $documentContentTitles);

    // ...

    // Process and store episode URLs
    $episodeURLs = [];
    for ($i = 1; $i <= $numSeasons; $i++) {
        $urlsInput = $_POST["season_${i}_urls"];
        $urlsArray = explode(';', $urlsInput);

        // Remove any leading or trailing whitespaces in each URL
        $urlsArray = array_map('trim', $urlsArray);

        $seasonKey = "S{$i}";
        $episodeURLs[$seasonKey] = $urlsArray;
    }

    $documentContentURLs = '<?php $episodeURLs = ' . var_export($episodeURLs, true) . ';' . "\n" . '$currentSeason = "S1"; $currentEpisodeIndex = 1; ?>';
    file_put_contents("./serie/" . str_replace(' ', '_', $title) . ".php", $documentContentURLs);

    // ...

    // Redirection vers la page principale après l'ajout
    header("Location: catalogue.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Série</title>
    <link rel="stylesheet" href="./style/ajout_serie.css">

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("serieForm");
            const seasonsContainer = document.getElementById("seasonsContainer");

            document.getElementById("numSeasons").addEventListener("input", function () {
                const numSeasons = this.value;
                renderSeasonFields(numSeasons);
            });

            function renderSeasonFields(numSeasons) {
                seasonsContainer.innerHTML = ""; // Réinitialiser le contenu

                for (let i = 1; i <= numSeasons; i++) {
                    const seasonDiv = document.createElement("div");
                    seasonDiv.innerHTML = `
                        <h2>Saison ${i}</h2>
                        <label for="season_${i}_titles">Titres des épisodes (séparés par des points-virgules):</label>
                        <textarea name="season_${i}_titles" rows="4" cols="50" required></textarea>

                        <label for="season_${i}_urls">URLs des épisodes (séparés par des points-virgules):</label>
                        <textarea name="season_${i}_urls" rows="4" cols="50" required></textarea>

                        <div id="episodesContainer_${i}"></div>
                    `;

                    seasonsContainer.appendChild(seasonDiv);

                    // Générer les champs pour chaque épisode
                    document.querySelector(`[name="season_${i}_titles"]`).addEventListener("input", function () {
                        const titles = this.value.replace(/\n/g, '').split(';');
                        const urls = document.querySelector(`[name="season_${i}_urls"]`).value.replace(/\n/g, '').split(';');

                        renderEpisodeFields(i, titles, urls);
                    });
                }
            }

            function renderEpisodeFields(seasonNumber, titles, urls) {
                const episodesContainer = document.getElementById(`episodesContainer_${seasonNumber}`);
                episodesContainer.innerHTML = ""; // Réinitialiser le contenu

                for (let j = 1; j <= titles.length; j++) {
                    const episodeDiv = document.createElement("div");
                    episodeDiv.innerHTML = `
                        <h3>Épisode ${j}</h3>
                        <label for="season_${seasonNumber}_episode_${j}_title">Nom de l'épisode:</label>
                        <input type="text" name="season_${seasonNumber}_episode_${j}_title" value="${titles[j-1]}" required>

                        <label for="season_${seasonNumber}_episode_${j}_url">URL de l'épisode:</label>
                        <input type="url" name="season_${seasonNumber}_episode_${j}_url" value="${urls[j-1]}" required>
                    `;

                    episodesContainer.appendChild(episodeDiv);
                }
            }
        });
    </script>
</head>

<body>
    <?php include("preset_header.php"); ?>
    <h1>Ajouter une Série</h1>

    <form method="POST" action="ajout_serie.php" enctype="multipart/form-data" id="serieForm">
        <label for="title">Nom de la Série:</label>
        <input type="text" name="title" required>

        <label for="numSeasons">Nombre de Saisons:</label>
        <input type="number" name="num_seasons" id="numSeasons" min="1" required>

        <label for="poster">Affiche de la Série:</label>
        <input type="file" name="poster" accept="image/*" required>

        <div id="seasonsContainer"></div>

        <input type="submit" value="Ajouter">
    </form>

</body>

</html>
