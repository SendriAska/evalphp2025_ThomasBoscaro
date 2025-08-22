<?php

namespace model;

use function utils\connectBDD;
use PDO;
use Exception;
use PDOException;


function addBook(string $title, string $description, string $publicationDate, string $author, int $categoryId): bool {
    try {
        $request = "INSERT INTO book(title, description, publication_date, author, id_category) VALUE (?,?,?,?)";
        $pdo = connectBDD();
        $req = $pdo->prepare($request);
        $req->bindParam(1, $title, \PDO::PARAM_STR);
        $req->bindParam(2, $description, \PDO::PARAM_STR);
        $req->bindParam(3, $publicationDate, \PDO::PARAM_STR);
        $req->bindParam(4, $author, \PDO::PARAM_STR);
        $req->bindParam(5, $categoryId, \PDO::PARAM_INT);
        $req->execute();
        return true;
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

function getAllBooks(): array {
    try {
        $request = "SELECT b.id_book, b.title, b.description, b.publication_date, c.name AS name, u.firstname AS firstname, u.lastname AS lastname 
                    FROM book AS b 
                    JOIN category AS c ON b.id_category = c.id_category 
                    JOIN users AS u ON b.id_users = u.id_users";
        $pdo = connectBDD();
        $req = $pdo->prepare($request);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}
