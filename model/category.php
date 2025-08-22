<?php

namespace model;

use PDO;
use Exception;
use PDOException;

use function utils\connectBDD;

function findAllCategory(): array
    {
        try {
            $request = "SELECT c.id_category AS idCategory , c.name FROM category AS c";
            $pdo = connectBDD();
            $req = $pdo->prepare($request);
            $req->execute();
            return $req->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

function getCategoryById(int $id): array|false
{
    try {
        $request = "SELECT * FROM category WHERE id_category = ?";
        $pdo = connectBDD();
        $req = $pdo->prepare($request);
        $req->bindParam(1, $id, \PDO::PARAM_INT);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}