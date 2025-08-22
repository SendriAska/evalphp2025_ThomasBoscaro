<?php 
session_start();
$message = "";

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

include "./utils/bdd.php";
include "./utils/tool.php";
include "./model/user.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = utils\sanitize($_POST['email']);
    $password = utils\sanitize($_POST['password']);

    if (empty($email) || empty($password)) {
        $message = "Tous les champs sont obligatoires.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Adresse e-mail invalide.";
    } else {
        try {
            $user = model\getUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                // Connexion réussie
                $_SESSION["user_id"] = $user['id'];
                $_SESSION["connected"] = true;
                header("Location: index.php");
                exit;
            } else {
                $message = "Email ou mot de passe incorrect.";
            }
        } catch (Exception $e) {
            $message = "Erreur lors de la connexion : " . $e->getMessage();
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
    <title>Connexion</title>
</head>

<body>

    <header>
        <?php include "components/navbar.php"; ?>
    </header>

    <main class="container-fluid">

        <form action="" method="post">
            <h2>Se connecter</h2>
            <input type="email" name="email" placeholder="saisir le mail">
            <input type="password" name="password" placeholder="saisir le mot de passe">
            <input type="submit" value="connexion" name="submit">
            <p class="error"><?= $message ?></p>
        </form>

    </main>
</body>

</html>