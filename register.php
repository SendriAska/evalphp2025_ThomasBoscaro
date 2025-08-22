<?php

$message = "";
if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

include "./utils/bdd.php";
include "./utils/tool.php";
include "./model/user.php";



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $firstname = utils\sanitize($_POST['firstname']);
    $lastname = utils\sanitize($_POST['lastname']);
    $email = utils\sanitize($_POST['email']);
    $password = utils\sanitize($_POST['password']);

    if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
        $message = "Tous les champs sont obligatoires.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Adresse e-mail invalide.";
    } else {
        try {
            if (model\userExists($email)) {
                $message = "Un compte avec cet e-mail existe déjà.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                model\saveUser($firstname, $lastname, $email, $hashedPassword);
                header("Location: connexion.php");
                exit;
            }
        } catch (Exception $e) {
            $message = "Erreur lors de l'inscription : " . $e->getMessage();
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
    <title>Inscription</title>
</head>
<body>
    <header>
        <?php include "components/navbar.php"; ?>
    </header>

    <main class="container-fluid">

        <form action="" method="post" enctype="multipart/form-data">
            <h2>S'inscrire</h2>
            <p class="error"><?= $message ?></p>
            <input type="text" name="firstname" placeholder="saisir le prénom">
            <input type="text" name="lastname" placeholder="saisir le nom">
            <input type="email" name="email" placeholder="saisir le mail">
            <input type="password" name="password" placeholder="saisir le password">
            <input type="submit" value="inscription" name="submit">
        </form>

    </main>
</body>
</html>

<?php
session_start();
