<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password if applicable
$database = "alimentation_db"; // Your database name
$port = 3306; // MySQL connection port, default is 3306

try {
    $db = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}

try {
    $updateQuery = $db->prepare("UPDATE identifiant_achat SET connecte = 0");
    $updateQuery->execute();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the entered username and password
    $enteredUsername = $_POST["pseudo"];
    $enteredPassword = $_POST["password"];

    try {
        // Prepare and execute the query to check the username and password against identifiant_achat table
        $query = $db->prepare("SELECT * FROM identifiant_achat WHERE nom = :username AND motdepasse = :password");
        $query->bindParam(":username", $enteredUsername);
        $query->bindParam(":password", $enteredPassword);
        $query->execute();

        // Fetch the first row from the result
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && $user["id"] == 1) {
            // If the user is found and has id=1, update the 'connecte' column to 1
            $updateQuery = $db->prepare("UPDATE identifiant_achat SET connecte = 1 WHERE id = :user_id");
            $updateQuery->execute(array(":user_id" => $user["id"]));

            // Set session variables and redirect to magasin.php

            $_SESSION["user_id"] = $user["id"];
            header("location: magasin.php");
            exit();
        } else {
            // If the user is not found or credentials are incorrect, redirect back to the login page
            header("location: listearticle.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        die();
    }
}
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #228B22;
        }

        .center-wrapper {
            text-align: center;
            margin-top: 20px;
        }

        .login-form {
            width: 30%;
            margin: 0 auto;
            border: 1px solid #228B22;
            padding: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #228B22;
        }

        .textinput {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #228B22;
            color: #fff;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2E8B57;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }
    </style>
</head>

<body>
    <h1>Connexion</h1>
    <div class="center-wrapper">
        <form name="form" method="post" class="login-form">
            <label for="pseudo">Nom d'utilisateur du cuisinier/ère</label>
            <input id="pseudo" name="pseudo" placeholder="Nom d'utilisateur" required type="text" class="textinput">

            <label for="password">Mot de passe</label>
            <input id="password" name="password" placeholder="Mot de passe" required type="password" class="textinput">

            <br>
            <input type="submit" name="valider" value="Se connecter">
        </form>
    </div>
</body>

</html>