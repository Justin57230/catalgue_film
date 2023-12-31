<?php
include("cnx.php");

// Traitement du formulaire d'ajout de film
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $url = $_POST['url'];

    // Traitement de l'affiche
    $posterFileName = $_FILES['poster']['name'];
    $posterTmpName = $_FILES['poster']['tmp_name'];
    $posterPath = "./affiche/" . $posterFileName;

    // Déplacement de l'affiche vers le dossier ./affiche/
    move_uploaded_file($posterTmpName, $posterPath);

    // Ajout du film à la base de données
    $stmt = $pdo->prepare("INSERT INTO films (title, url, poster_url, type) VALUES (?, ?, ?, 'film')");
    $stmt->execute([$title, $url, $posterPath]);

    // Ajout d'une ligne à ./film/films.php
    $filmsFile = "./film/films.php";
    $newFilmLine = ",\n\"$title\" => [\"url\" => \"$url\", \"type\" => \"film\", \"poster_url\" => \"$posterPath\"],";
    
    // Lit le contenu actuel du fichier
    $filmsContent = file_get_contents($filmsFile);

    // Recherche la dernière occurence de la virgule pour ajouter la nouvelle ligne
    $lastCommaPosition = strrpos($filmsContent, ",");
    $filmsContent = substr_replace($filmsContent, $newFilmLine, $lastCommaPosition, 1);

    // Écrit le nouveau contenu dans le fichier
    file_put_contents($filmsFile, $filmsContent);

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
    <title>Ajouter un Film</title>
    <link rel="stylesheet" href="./style/ajout_film.css">
</head>

<body>
<?php include("preset_header.php") ?>
    <h1>Ajouter un Film</h1>

    <form method="POST" action="ajout_film.php" enctype="multipart/form-data">
        <label for="title">Titre du Film:</label>
        <input type="text" name="title" required>

        <label for="url">URL du Film:</label>
        <input type="text" name="url" required>

        <label for="poster">Affiche du Film:</label>
        <input type="file" name="poster" accept="image/*" required>

        <input type="submit" value="Ajouter">
    </form>

</body>

</html>
