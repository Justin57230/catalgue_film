<!-- serie.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player</title>
    <link rel="stylesheet" href="./style/serie.css">
</head>

<style>
    
</style>

<body>
<?php include("film_header.php"); ?> <!-- Include the film-specific header -->
    <div id="player-container">
        <h1>Sélectionnez une saison et un épisode</h1>
        <div>
            <label for="season-select">Saison:</label>
            <select id="season-select" onchange="loadEpisodes()">
                <!-- Options seront générées dynamiquement en JavaScript -->
            </select>

            <label for="episode-select">Épisode:</label>
            <select id="episode-select" onchange="loadEpisode()">
                <!-- Options seront générées dynamiquement en JavaScript -->
            </select>
        </div>

        <br>

        <div id="video-player">
            <iframe id="episode-player" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="1080"
                height="720" allowfullscreen></iframe>
        </div>

        <br>

        <!-- Ajout du titre du film -->
        <p id="film-title"></p>

        <button onclick="previousEpisode()">Précédent</button>
        <button onclick="nextEpisode()">Suivant</button>

        <br>
    </div>

    <?php
    // Récupère le nom du film à partir du paramètre de requête
    $selectedFilm = isset($_GET['title']) ? $_GET['title'] : '';

    // Utilise le nom du film pour inclure les fichiers correspondants
    $selectedFilmTitlePath = str_replace(" ", "_", $selectedFilm);
    include("titre/{$selectedFilmTitlePath}.php");
    include("serie/{$selectedFilmTitlePath}.php");
    ?>

    <script>
        // PHP to JavaScript conversion
        const episodeTitles = <?php echo json_encode($episodeTitles); ?>;
        const episodeURLs = <?php echo json_encode($episodeURLs); ?>;
        const seasons = <?php echo json_encode(array_keys($episodeTitles)); ?>; // Modification de cette ligne
        let currentSeason = "<?php echo $currentSeason; ?>";
        let currentEpisodeIndex = <?php echo $currentEpisodeIndex; ?>;
        const seasonSelect = document.getElementById("season-select");
        const episodeSelect = document.getElementById("episode-select");
        const filmTitle = document.getElementById("film-title");

        function loadEpisodes() {
            const player = document.getElementById("episode-player");

            // Met à jour la saison courante
            currentSeason = seasonSelect.value;

            // Met à jour la liste déroulante des épisodes
            episodeSelect.innerHTML = "";
            for (let i = 0; i < episodeTitles[currentSeason].length; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.text = "Épisode " + (i + 1);
                episodeSelect.add(option);
            }

            // Met à jour l'épisode en cours
            currentEpisodeIndex = episodeSelect.value;

            player.src = episodeURLs[currentSeason][currentEpisodeIndex];
            player.style.display = "block";
            
            // Met à jour le titre du film
            filmTitle.innerText = "Titre du film: " + episodeTitles[currentSeason][currentEpisodeIndex];
        }

        function loadEpisode() {
            const player = document.getElementById("episode-player");

            currentEpisodeIndex = episodeSelect.value;

            player.src = episodeURLs[currentSeason][currentEpisodeIndex];
            player.style.display = "block";
            // Met à jour le titre du film
            filmTitle.innerText = "Titre du film: " + episodeTitles[currentSeason][currentEpisodeIndex];
        }

        function previousEpisode() {
            if (currentEpisodeIndex > 0) {
                currentEpisodeIndex--;
                episodeSelect.selectedIndex = currentEpisodeIndex;
                loadEpisode();
            }
        }

        function nextEpisode() {
            if (currentEpisodeIndex < episodeTitles[currentSeason].length - 1) {
                currentEpisodeIndex++;
                episodeSelect.selectedIndex = currentEpisodeIndex;
                loadEpisode();
            }
        }

        // Chargement initial des saisons
        seasonSelect.innerHTML = "";
        for (let i = 0; i < seasons.length; i++) {
            const option = document.createElement("option");
            option.value = seasons[i];
            option.text = "Saison " + seasons[i];
            seasonSelect.add(option);
        }

        // Chargement initial des épisodes
        loadEpisodes();
    </script>

</body>

</html>
