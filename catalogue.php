<?php
session_start();

include("cnx.php");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$stmt = $pdo->query("SELECT * FROM films");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Films</title>
    <link rel="stylesheet" href="./style/catalogue.css">
    <style>
        /* Ajoutez ces styles à votre fichier CSS */

.search-container {
    margin: 20px 0;
    text-align: center;
}

.search-container input[type="text"] {
    padding: 10px;
    font-size: 16px;
}

.search-container input[type="submit"] {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
}

.search-container input[type="submit"]:hover {
    background-color: #555;
}

    </style>
</head>

<body>
    <?php include("preset_header.php"); ?>
    <h1>Liste des Films</h1>

    <!-- Formulaire de recherche -->
    <form method="GET" action="catalogue.php" class="search-container">
        <input type="text" name="search" placeholder="Rechercher un film...">
        <input type="submit" value="Rechercher">
    </form>

    <div class="movies-container">
        <?php
        // Filtrer les films en fonction de la recherche
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filteredMovies = [];

        if (!empty($search)) {
            foreach ($movies as $movie) {
                if (stripos(str_replace(' ', '', strtolower($movie['title'])), str_replace(' ', '', strtolower($search))) !== false) {
                    $filteredMovies[] = $movie;
                }
            }
        } else {
            $filteredMovies = $movies;
        }

        // Afficher les films récupérés de la base de données
        foreach ($filteredMovies as $movie) {
            $title = $movie['title'];
            $posterUrl = $movie['poster_url'];
            $type = $movie['type'];
            $link = ($type === 'film') ? 'film.php?title=' . urlencode($title) : 'serie.php?title=' . urlencode($title);

            echo '<a href="' . $link . '" class="movie">';
            echo '<img src="' . $posterUrl . '" alt="' . $title . '">';
            echo '<div class="movie-title">' . $title . '</div></a>';
        }
        ?>
    </div>
</body>

</html>
