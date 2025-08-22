<?php
session_start();

include "./utils/bdd.php";
include "./utils/tool.php";
include "./model/book.php";
include "./model/category.php";

use function model\addBook;
use function utils\sanitize;
use function model\findAllCategory;
use function model\getCategoryById;

$message = "";

if (!isset($_SESSION["connected"])) {
    header("Location: connexion.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = sanitize($_POST["title"]);
    $description = sanitize($_POST["description"]);
    $publicationDate = sanitize($_POST["publication_date"]);
    $author = sanitize($_POST["author"]);
    $categoryId = (int) $_POST["id_category"];
    $userId = $_SESSION["connected"];

    if (empty($title) || empty($description) || empty($publicationDate) || empty($categoryId) || empty($author)) {
        $message = "Tous les champs sont obligatoires.";
    } else {
        try {
            if (addBook($title, $description, $publicationDate, $author, $categoryId, $userId)) {
                $message = "Livre ajouté avec succès !";
            } else {
                $message = "Erreur lors de l'ajout du livre.";
            }
        } catch (Exception $e) {
            $message = "Erreur lors de l'ajout du livre : " . $e->getMessage();
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/pico.min.css">
    <link rel="stylesheet" href="./public/style.css">
    <title>Ajouter livre</title>
</head>

<body>
    <header>
        <?php include "components/navbar.php"; ?>
    </header>

    <main class="container-fluid">
        <form action="addBook.php" method="post">
            <label>Titre :</label>
            <input type="text" name="title" required><br>

            <label>Description :</label>
            <textarea name="description" required></textarea><br>

            <label>Date de publication :</label>
            <input type="date" name="publication_date" required><br>

            <label>Auteur :</label>
            <input type="text" name="author" required><br>

            <label>Catégorie (ID) :</label>
            <input type="number" name="id_category" required><br>

            <button type="submit">Ajouter le livre</button>
        </form>
        <p><?= $message ?? "" ?></p>
    </main>
</body>

</html>