<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Ajouter un article</title>
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

        .ajoutarticle {
            width: 50%;
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

        .space {
            margin-top: 10px;
        }

        textarea {
            resize: vertical;
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

        h2 {
            color: #228B22;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #228B22;
            color: #fff;
        }

        img {
            max-width: 100px;
            max-height: 100px;
        }

        .search-form {
            margin-top: 20px;
        }

        .search-form input[type="text"] {
            width: 50%;
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
        }

        .search-form input[type="submit"] {
            background-color: #228B22;
            color: #fff;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
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

    // Check if the user is already logged in
    if (isset($_SESSION["connecte"])) {
        if ($_SESSION["user_id"] == "1") {
            // Redirect the administrator to the administration page
            header("location: magasin.php");
            exit();
        } else {
            // Redirect the user to the user page
            header("location: login.php");
            exit();
        }
    }


    // Handle form submission
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nom = $_POST["nom"];
        $quantite = $_POST["quantite"];
        $unite = $_POST["unite"];
        $prix = $_POST["prix"];
        $mot_cle = $_POST["mot_cle"]; // Get the selected keyword from the form
        $description = $quantite . " " . $unite;

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $image_temp = $_FILES["image"]["tmp_name"];
            $image = "images/" . $_FILES["image"]["name"];

            if (!is_dir("images")) {
                mkdir("images");
            }

            move_uploaded_file($image_temp, $image);
        } else {
            $image = "";
        }

        // Insert the article details into the "articles_achat" table
        $query = $db->prepare("INSERT INTO articles_achat (nom_article, description, prix, date_achat, image_path) VALUES (:nom, :description, :prix, NOW(), :image)");
        $query->bindParam(":nom", $nom);
        $query->bindParam(":description", $description);
        $query->bindParam(":prix", $prix);
        $query->bindParam(":image", $image);
        $query->execute();

        // Get the ID of the last inserted article
        $lastInsertId = $db->lastInsertId();

        // Insert the keyword and the associated article ID into the "mot" table
        $queryMot = $db->prepare("INSERT INTO mot (article_id, mot_cle) VALUES (:article_id, :mot_cle)");
        $queryMot->bindParam(":article_id", $lastInsertId);
        $queryMot->bindParam(":mot_cle", $mot_cle);
        $queryMot->execute();

        // Show success message
        echo '<p class="success-message">Article ajouté avec succès!</p>';
    }



    // Handle article deletion
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $idToDelete = $_GET['id'];
        $queryDelete = $db->prepare('DELETE FROM articles_achat WHERE id = :id');
        $queryDelete->bindParam(':id', $idToDelete);
        $queryDelete->execute();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle article search
    if (isset($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $querySearch = $db->prepare("SELECT * FROM articles_achat WHERE nom_article LIKE :search");
        $querySearch->bindValue(':search', '%' . $searchTerm . '%');
        $querySearch->execute();
        $donnees = $querySearch->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Retrieve all articles from the database
        $query = $db->query('SELECT articles_achat.*, mot.mot_cle AS categorie 
                    FROM articles_achat 
                    LEFT JOIN mot ON articles_achat.id = mot.article_id');
        $donnees = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Handle logout
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        // Update the 'connecte' column in the database to mark the logout
        $updateQuery = $db->prepare("UPDATE identifiant_achat SET connecte = false");
        $updateQuery->execute();

        session_destroy();
        header('Location: login.php');
        exit();
    }

    ?>

    <h1 id="titre">Ajouter un article</h1>

    <div class="center-wrapper">
        <form action="" method="POST" class="ajoutarticle" enctype="multipart/form-data">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" placeholder="Nom" class="textinput" required><br>

            <label for="image">Image :</label>
            <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/jpg"><br>

            <label for="quantite" class="space">Quantité :</label>
            <input type="number" id="quantite" name="quantite" min="0" step="0.01" placeholder="Quantité" class="textinput" required>

            <label for="unite" class="space">Unité :</label>
            <select id="unite" name="unite">
                <option value="g">g</option>
                <option value="kg">kg</option>
                <option value="pièce">pièce</option>
            </select><br>

            <label for="prix" class="space">Prix :</label>
            <input type="number" id="prix" name="prix" min="0" step="0.01" placeholder="Prix" class="textinput" required><br>

            <label for="mot_cle" class="space">Mot clé :</label>
            <select id="mot_cle" name="mot_cle">
                <option value="fruit">Fruit</option>
                <option value="legume">Légume</option>
                <option value="boisson">Boisson</option>
                <option value="hygiene">Hygiène et Beauté</option>
                <option value="viande_poisson">Viande et Poisson</option>
                <option value="epicerie_sucre">Épicerie sucrée</option>
                <option value="epicerie_sale">Épicerie salée</option>
                <option value="entretien">Entretien</option>
                <option value="surgele">Surgelé</option>
                <option value="glace">Glace</option>
                <option value="autre">Autre</option>
            </select><br>

            <input type="submit" value="Ajouter">
        </form>
    </div>

    <!-- Ajout du bouton de déconnexion -->
    <div class="logout-link">
        <a href="?action=logout">Déconnexion</a>
    </div>


    <div class="search-form">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Rechercher par nom">
            <input type="submit" value="Rechercher">
        </form>
    </div>

    <!-- ... (code précédent) ... -->

    <h2>Articles ajoutés:</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom de l'article</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Catégorie</th>
            <th>Date d'ajout</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php foreach ($donnees as $row) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nom_article']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['prix']; ?></td>
                <td><?php echo $row['categorie']; ?></td> <!-- Display the category value -->
                <td><?php echo $row['date_achat']; ?></td>
                <td>
                    <?php if ($row['image_path']) : ?>
                        <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['nom_article']; ?>">
                    <?php else : ?>
                        Image non disponible
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')">Supprimer</a>
                    <a href="modifier_article.php?id=<?php echo $row['id']; ?>">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>





</body>

</html>