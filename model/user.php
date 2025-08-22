<?php

namespace model;

use PDO;
use Exception;
use PDOException;

use function utils\connectBDD;

function saveUser(string $firstname, string $lastname, string $email, string $password): bool
{
    try {
        $request = "INSERT INTO users(firstname, lastname, email, password) VALUE (?,?,?,?)";
        $pdo = connectBDD();
        $req = $pdo->prepare($request);
        $req->bindParam(1, $firstname, \PDO::PARAM_STR);
        $req->bindParam(2, $lastname, \PDO::PARAM_STR);
        $req->bindParam(3, $email, \PDO::PARAM_STR);
        $req->bindParam(4, $password, \PDO::PARAM_STR);
        $req->execute();
        return true;
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

function getUserByEmail(string $email): array|false
{
    try {
        $request = "SELECT * FROM users WHERE email = ?";
        $pdo = connectBDD();
        $req = $pdo->prepare($request);
        $req->bindParam(1, $email, \PDO::PARAM_STR);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

function userExists(string $email): bool
{
    try {

        $request = "SELECT u.id_users FROM users AS u WHERE u.email = ?";
        $pdo = connectBDD();
        $req = $pdo->prepare($request);
        $req->bindParam(1, $email, \PDO::PARAM_STR);
        $req->execute();
        $data = $req->fetch(\PDO::FETCH_ASSOC);
        if (empty($data)) {
            return false;
        }
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

function getUserById(int $id): array|false
{
    try {
        $request = "SELECT * FROM users WHERE id = ?";
        $pdo = connectBDD();
        $req = $pdo->prepare($request);
        $req->bindParam(1, $id, \PDO::PARAM_INT);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}