<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Modifier un article</title>
    <style>
        /* Mettez ici les styles nécessaires pour la page de modification */
    </style>
</head>

<body>
    <?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = ""; // Remplacez par votre mot de passe si nécessaire
    $database = "alimentation_db"; // Votre nom de base de données
    $port = 3306; // Port de connexion MySQL, par défaut 3306

    try {
        $db = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        die();
    }



    // Vérifier si l'ID de l'article est présent dans l'URL
    if (isset($_GET['id'])) {
        $idArticle = $_GET['id'];

        // Récupérer les informations de l'article à partir de la base de données en fonction de son ID
        $queryArticle = $db->prepare("SELECT * FROM articles_achat WHERE id = :id");
        $queryArticle->bindParam(':id', $idArticle);
        $queryArticle->execute();
        $article = $queryArticle->fetch(PDO::FETCH_ASSOC);

        if (!$article) {
            // Rediriger si l'article n'existe pas
            header('Location: magasin.php');
            exit();
        }
    } else {
        // Rediriger si l'ID de l'article n'est pas présent dans l'URL
        header('Location: magasin.php');
        exit();
    }

    // Traitement du formulaire de modification
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Récupérer les nouvelles valeurs du formulaire
        $nom = $_POST["nom"];
        $description = $_POST["description"];
        $prix = $_POST["prix"];

        // Gérer la mise à jour de l'image s'il y a lieu
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $image_temp = $_FILES["image"]["tmp_name"];
            $image = "images/" . $_FILES["image"]["name"];

            if (!is_dir("images")) {
                mkdir("images");
            }

            move_uploaded_file($image_temp, $image);
        } else {
            // Conserver l'ancienne image si aucune nouvelle image n'est chargée
            $image = $article['image_path'];
        }

        // Mettre à jour les informations de l'article dans la base de données
        $queryUpdate = $db->prepare("UPDATE articles_achat SET nom_article = :nom, description = :description, prix = :prix, image_path = :image WHERE id = :id");
        $queryUpdate->bindParam(":nom", $nom);
        $queryUpdate->bindParam(":description", $description);
        $queryUpdate->bindParam(":prix", $prix);
        $queryUpdate->bindParam(":image", $image);
        $queryUpdate->bindParam(":id", $idArticle);
        $queryUpdate->execute();

        // Rediriger vers la page d'affichage des articles après la mise à jour
        header('Location: magasin.php');
        exit();
    }
    ?>

    <h1>Modifier l'article</h1>

    <div class="center-wrapper">
        <form action="" method="POST" class="ajoutarticle" enctype="multipart/form-data">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo $article['nom_article']; ?>" class="textinput" required><br>

            <label for="image">Image :</label>
            <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/jpg"><br>

            <label for="description" class="space">Description :</label>
            <textarea id="description" name="description" rows="3" style="width: 100%;" wrap="soft" required><?php echo $article['description']; ?></textarea><br>

            <label for="prix" class="space">Prix :</label>
            <input type="number" id="prix" name="prix" min="0" step="0.01" value="<?php echo $article['prix']; ?>" class="textinput" required><br>

            <input type="submit" value="Enregistrer les modifications">
        </form>
    </div>

</body>

</html>