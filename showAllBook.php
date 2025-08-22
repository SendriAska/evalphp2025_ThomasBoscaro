<?php

session_start();

include "./utils/bdd.php";
include "./utils/tool.php";
include "./model/book.php";
include "./model/category.php";

use function model\getAllBooks;
use function model\findBooksByUser;
use function utils\connectBDD;
use function utils\sanitize;

$message = "";

if (!isset($_SESSION["connected"])) {
    header("Location: connexion.php");
    exit;
}

$pdo = connectBDD();

$books = getAllBooks();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/pico.min.css">
    <link rel="stylesheet" href="./public/style.css">
    <title>Liste livres</title>
</head>

<body>
    <header>
        <?php include "components/navbar.php"; ?>
    </header>

    <main>
        <h2>Liste des livres</h2>
        <?php if (empty($books)): ?>
            <p>Vous n'avez ajouté aucun livre.</p>
        <?php else:  ?>

            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Date de publication</th>
                        <th>Auteur</th>
                        <th>Catégorie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= $book["title"] ?></td>
                            <td><?= $book["description"] ?></td>
                            <td><?= $book["publication_date"] ?></td>
                            <td><?= $book["author"] ?></td>
                            <td><?= $book["category_name"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </main>
</body>

</html>