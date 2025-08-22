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

    <main class="container-fluid">
        <h1>Liste des livres</h1>
        <section>
            <?php
            include "./utils/bdd.php";
            include "./model/book.php";

            use function model\getAllBooks;

            try {
                $books = getAllBooks();
                if (count($books) > 0) {
                    foreach ($books as $book) {
                        echo "<article>";
                        echo "<h2>" . htmlspecialchars($book['title']) . "</h2>";
                        echo "<p><strong>Auteur:</strong> " . htmlspecialchars($book['user_firstname']) . " " . htmlspecialchars($book['user_lastname']) . "</p>";
                        echo "<p><strong>Date de publication:</strong> " . htmlspecialchars($book['publication_date']) . "</p>";
                        echo "<p><strong>Catégorie:</strong> " . htmlspecialchars($book['category_name']) . "</p>";
                        echo "<p>" . nl2br(htmlspecialchars($book['description'])) . "</p>";
                        echo "</article><hr>";
                    }
                } else {
                    echo "<p>Aucun livre disponible.</p>";
                }
            } catch (Exception $e) {
                echo "<p>Erreur lors de la récupération des livres : " . $e->getMessage() . "</p>";
            }
            ?>
        </section>
</body>
</html>