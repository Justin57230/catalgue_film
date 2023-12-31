<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture du Film</title>
    <link rel="stylesheet" href="./style/film.css">
</head>

<body>
    <?php include("film_header.php"); ?> <!-- Include the film-specific header -->

    <div id="player-container">
        <h1>Lecture du Film</h1>

        <div id="video-player">
            <iframe id="film-player" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="1080"
                height="720" allowfullscreen></iframe>
        </div>

        <br>

        <!-- Ajout du titre du film -->
        <p id="film-title"></p>
    </div>

    <?php
    // Récupère le titre du film à partir du paramètre de requête
    $selectedFilm = isset($_GET['title']) ? $_GET['title'] : '';

    // Charge les informations sur les films à partir du fichier PHP
    include("./film/films.php");

    // Utilise le titre du film pour obtenir les informations correspondantes
    $filmData = isset($films[$selectedFilm]) ? $films[$selectedFilm] : null;

    // Modification pour utiliser la valeur de l'URL directement dans le code JavaScript
    $filmURL = isset($filmData['url']) ? json_encode($filmData['url']) : '';
    ?>

    <script>
        // PHP to JavaScript conversion
        const currentFilmTitle = <?php echo json_encode($selectedFilm); ?>;
        const filmPlayer = document.getElementById("film-player");
        const filmTitle = document.getElementById("film-title");

        function loadFilm() {
            // Utilise directement la chaîne JSON de l'URL du film
            filmPlayer.src = <?php echo $filmURL; ?>;
            // Met à jour le titre du film
            filmTitle.innerText = "Titre du film: " + currentFilmTitle;
        }

        // Chargement initial du film
        loadFilm();
    </script>

</body>

</html>
