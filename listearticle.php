<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des articles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #006A4E;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #E62020;
            text-align: center;
            margin-top: 20px;
        }

        .center-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .article {
            flex: 0 0 20%;
            margin: 10px;
            padding: 10px;
            border: 1px solid #228B22;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .article img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .article p {
            color: #228B22;
            font-size: 16px;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a,
        .pagination .current {
            display: inline-block;
            padding: 5px 10px;
            background-color: #228B22;
            color: #fff;
            text-decoration: none;
            margin: 5px;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #2E8B57;
        }


        .filter-form input[type="submit"] {
            display: inline-block;
            padding: 10px 20px;
            background-color: #228B22;
            color: #fff;
            text-decoration: none;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .filter-form input[type="submit"]:hover {
            background-color: #2E8B57;
        }

        .filter-form input[type="submit"][name="categorie"] {
            width: auto;
        }
    </style>
</head>

<body>

    <a href="index.php" style="text-decoration: none; color: #E62020;">
        <h1>Clichy Supermarket</h1>
    </a>


    <div class="center-wrapper">
        <form action="" method="GET" class="filter-form">
            <input type="hidden" name="page" value="1">
            <input type="submit" name="categorie" value="Tous les articles">
            <input type="submit" name="categorie" value="Fruit">
            <input type="submit" name="categorie" value="Légume">
            <input type="submit" name="categorie" value="Boisson">
            <input type="submit" name="categorie" value="Hygiène et Beauté">
            <input type="submit" name="categorie" value="Viande et Poisson">
            <input type="submit" name="categorie" value="Épicerie sucrée">
            <input type="submit" name="categorie" value="Épicerie salée">
            <input type="submit" name="categorie" value="Entretien">
            <input type="submit" name="categorie" value="Surgelé">
            <input type="submit" name="categorie" value="Glace">
            <input type="submit" name="categorie" value="Autre">
        </form>
    </div>

    <div class="center-wrapper">
        <?php
        // Informations de connexion à la base de données depuis MySQL Workbench
        $servername = "localhost";
        $username = "root";
        $password = ""; // Remplacez par votre mot de passe de la base de données, s'il y en a un
        $database = "alimentation_db"; // Nom de votre base de données
        $port = 3306; // Port de connexion MySQL, par défaut 3306

        try {
            // Connexion à la base de données avec PDO en spécifiant le port
            $db = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Filtrer par catégorie si une catégorie est sélectionnée
            $whereClause = '';
            if (isset($_GET['categorie'])) {
                $categorie = strtolower($_GET['categorie']); // Convertir en minuscules
                if ($categorie !== 'tous les articles') {
                    $whereClause = "WHERE LOWER(mot_cle) = '$categorie'";
                }
            }

            // Pagination
            $articlesParPage = 10; // Nombre d'articles par page
            $pageCourante = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $depart = ($pageCourante - 1) * $articlesParPage;

            // Requête pour récupérer les données depuis la base de données (résultats paginés)
            $query = $db->query("SELECT DISTINCT a.* FROM articles_achat a 
                                 INNER JOIN mot m ON a.id = m.article_id 
                                 $whereClause LIMIT $depart, $articlesParPage");
            $donnees = $query->fetchAll(PDO::FETCH_ASSOC);

            // Compter le nombre total d'articles pour la pagination
            $queryCount = $db->query("SELECT COUNT(DISTINCT article_id) AS total FROM mot $whereClause");
            $resultCount = $queryCount->fetch(PDO::FETCH_ASSOC);
            $nombreArticles = $resultCount['total'];

            // Calculer le nombre total de pages
            $nombrePages = ceil($nombreArticles / $articlesParPage);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            die();
        }

        // Afficher les données récupérées
        foreach ($donnees as $row) {
            echo '<div class="article">';
            // Afficher l'image de l'article
            if (isset($row['image_path'])) {
                echo '<img src="' . $row['image_path'] . '" alt="' . (isset($row['nom_article']) ? $row['nom_article'] : '') . '">';
            }

            // Afficher le nom de l'article
            if (isset($row['nom_article'])) {
                echo '<p>Nom : ' . $row['nom_article'] . '</p>';
            }

            // Afficher le prix de l'article
            if (isset($row['prix'])) {
                echo '<p>Prix : ' . $row['prix'] . ' €</p>';
            }

            // Afficher la quantité de l'article (description)
            if (isset($row['description'])) {
                echo '<p>Quantité : ' . $row['description'] . '</p>';
            } else {
                echo '<p>Quantité : Non spécifiée</p>';
            }

            echo '</div>';
        }
        ?>
    </div>



    <div class="pagination">
        <?php
        // Afficher les liens vers les pages précédentes et suivantes
        if ($pageCourante > 1) {
            echo '<a href="?page=' . ($pageCourante - 1);
            if (isset($_GET['categorie'])) {
                echo '&categorie=' . $_GET['categorie'];
            }
            echo '">Précédent</a>';
        }

        for ($i = 1; $i <= $nombrePages; $i++) {
            if ($i === $pageCourante) {
                echo '<span class="current">' . $i . '</span>';
            } else {
                echo '<a href="?page=' . $i;
                if (isset($_GET['categorie'])) {
                    echo '&categorie=' . $_GET['categorie'];
                }
                echo '">' . $i . '</a>';
            }
        }

        if ($pageCourante < $nombrePages) {
            echo '<a href="?page=' . ($pageCourante + 1);
            if (isset($_GET['categorie'])) {
                echo '&categorie=' . $_GET['categorie'];
            }
            echo '">Suivant</a>';
        }
        ?>
    </div>

</body>

</html>