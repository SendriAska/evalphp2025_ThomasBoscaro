<?php

namespace model;

use function utils\connectBDD;
use PDO;
use Exception;
use PDOException;


function addBook(string $title, string $description, string $publicationDate, string $author, int $categoryId, int $usersId): bool {
    try {
        $request = "INSERT INTO book(title, description, publication_date, author, category_id, users_id) VALUE (?,?,?,?,?)";
        $pdo = connectBDD();
        $req = $pdo->prepare($request);
        $req->bindParam(1, $title, \PDO::PARAM_STR);
        $req->bindParam(2, $description, \PDO::PARAM_STR);
        $req->bindParam(3, $publicationDate, \PDO::PARAM_STR);
        $req->bindParam(4, $author, \PDO::PARAM_STR);
        $req->bindParam(5, $categoryId, \PDO::PARAM_INT);
        $req->bindParam(6, $usersId, \PDO::PARAM_INT);
        $req->execute();
        return true;
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

function getAllBooks(): array {
    try {
        $request = "SELECT b.id, b.title, b.description, b.publication_date, c.name AS category_name, u.firstname AS user_firstname, u.lastname AS user_lastname 
                    FROM book AS b 
                    JOIN category AS c ON b.category_id = c.id 
                    JOIN users AS u ON b.users_id = u.id";
        $pdo = connectBDD();
        $req = $pdo->prepare($request);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}