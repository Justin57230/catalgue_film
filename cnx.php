<?php
$host = "localhost";
$db = "catalogue_films";
$user = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>