<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Accueil</title>
    <style>
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            background-color: #006A4E;
            /* Utilisez le rouge du drapeau du Bangladesh */
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #E62020;
            text-align: center;
            margin: 20px 0;
        }

        .center-wrapper {
            text-align: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Styles pour le carousel */
        .carousel {
            width: 100%;
            overflow: hidden;
            background-color: #fff;
            border: 1px solid #ccc;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        /* ... */

        /* Style pour le conteneur du carrousel */
        /* ... */

        /* Style pour le conteneur du carrousel */
        .carousel-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            /* Pour centrer les éléments verticalement */
            max-width: 600px;
            height: 400px;
            margin: 0 auto;
            overflow: hidden;
            position: relative;
            /* Ajout pour positionner le bouton "Voir plus" */
            background-color: rgba(255, 255, 255, 0.7);
            /* Remplacer le fond blanc par un fond transparent avec une opacité */
        }

        /* ... */


        /* Style pour les éléments du carrousel */
        .carousel-item {
            flex: 1;
            /* Pour que les éléments prennent une part égale de l'espace disponible */
            display: none;
            margin-right: 10px;
            vertical-align: top;
        }

        /* Classe pour les images du carrousel */
        .carousel-img {
            max-width: 100%;
            height: 200px;
            /* Set a fixed height for the images */
            object-fit: contain;
            border-bottom: 1px solid #ccc;
            margin: 0 auto;
        }


        /* Style pour le div qui contient le texte de l'article et le prix */
        .carousel-caption {

            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
        }


        /* Style pour le bouton "Voir plus" */
        .voir-plus-btn {
            flex: 1;
            /* Pour que le lien prenne le reste de la place disponible */
            display: flex;
            align-items: center;
            /* Pour centrer verticalement le contenu */
            justify-content: center;
            /* Pour centrer horizontalement le contenu */
            margin-top: 20px;
            background-color: #006A4E;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            position: absolute;
            /* Ajout pour le positionnement absolu */
            bottom: 10px;
            /* Ajout pour définir la distance depuis le bas */
            left: 50%;
            /* Ajout pour centrer horizontalement le bouton */
            transform: translateX(-50%);
            /* Ajout pour affiner le centrage horizontal */
        }

        .voir-plus-btn:hover {
            background-color: #2E8B57;
        }

        /* Classe pour l'effet de transition */
        .fade-in-out {
            animation: fadeInOut 1s ease-in-out;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }



        /* Styles pour la section "A propos de nous" */
        .about {
            flex: 1;
            /* Take up all available width on its row */
            margin-top: 30px;
            text-align: left;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
        }

        .about h2,
        .about p strong {
            color: #E62020;
        }

        .about p {
            margin: 10px 0;
        }

        .banner {
            background-color: #E62020;
            /* Rouge avec transparence */
            color: #fff;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            position: absolute;
            /* Position absolue pour la superposer */
            top: 0;
            /* Alignement en haut */
            left: 0;
            /* Alignement à gauche */
            width: 100%;
            /* Prend toute la largeur */
        }

        .logo-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: -100px;
            position: absolute;
            /* Position absolue pour déplacer la section */
            top: 50%;
            /* Centrer la section verticalement */
            left: 300px;
            /* Distance du côté gauche */
            transform: translateY(-50%);
            /* Ajuster la position verticale */
        }


        /* Style pour les images de logos */
        .logo,
        .logo2 {
            max-width: 100px;
            height: auto;
            margin-bottom: 10px;
            /* Espacement entre les images de logo */
        }

        /* Style pour la section des logos */
        .logo-section,
        .logo2-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: -100px;
            position: absolute;
            /* Position absolue pour déplacer la section */
            top: 50%;
            /* Centrer la section verticalement */
            transform: translateY(-50%);
            /* Ajuster la position verticale */
        }

        /* Positionnement pour la section des logos 1 */
        .logo-section {
            left: 300px;
            /* Distance du côté gauche */
        }

        /* Positionnement pour la section des logos 2 */
        .logo2-section {
            right: 300px;
            /* Distance du côté droit */
        }

        /* Style pour la section des images coulissantes */
        /* Style pour la section des images coulissantes */
        .sliding-images {
            position: fixed;
            top: 0;
            left: 90px;
            width: 60px;
            /* Ajuster la largeur selon vos besoins */
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Aligner verticalement les images */
            align-items: center;
            /* Centrer horizontalement les images */
            pointer-events: none;
            /* Pour éviter que les images coulissantes captent les événements de la souris */

            /* Définir les images coulissantes à gauche très proche de la limite d'écran */
            transform: translateX(-10px);
        }

        /* Style pour la section des images coulissantes à droite */
        .sliding-images-right {
            position: fixed;
            top: 0;
            right: 90px;
            width: 60px;
            /* Ajuster la largeur selon vos besoins */
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Aligner verticalement les images */
            align-items: center;
            /* Centrer horizontalement les images */
            pointer-events: none;
            /* Pour éviter que les images coulissantes captent les événements de la souris */
            /* Définir les images coulissantes à droite très proche de la limite d'écran */
            transform: translateX(10px);
        }




        /* Style pour les images coulissantes */
        .sliding-image {
            width: 200px;
            height: 200px;
            margin: 10px;
        }
    </style>



</head>

<body>
    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = ""; // Remplacez par votre mot de passe si nécessaire
    $database = "alimentation_db"; // Votre nom de base de données
    $port = 3306; // Port de connexion MySQL, par défaut 3306

    try {
        $db = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exceptions
    } catch (PDOException $e) {
        // Handle connection error
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
        die();
    }

    // Requête pour récupérer les articles pour le carousel
    $queryCarousel = $db->query('SELECT * FROM articles_achat ORDER BY date_achat DESC LIMIT 5');
    $articlesCarousel = $queryCarousel->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <h1>Clichy Supermarket</h1>

    <div class="center-wrapper">

        <div class="center-wrapper">
            <!-- Carousel -->
            <div class="carousel carousel-container" id="carousel">
                <div class="banner">Dernières nouveautés</div>
                <?php foreach ($articlesCarousel as $index => $article) : ?>
                    <div class="carousel-item" style="<?php echo $index === 0 ? 'display: block;' : ''; ?>">
                        <img class="carousel-img fade-in-out" src="<?php echo $article['image_path']; ?>" alt="<?php echo $article['nom_article']; ?>">
                        <!-- Nom de l'article et Prix (en dehors du carrousel) -->
                        <div class="carousel-caption">
                            <h3><?php echo $article['nom_article']; ?></h3>
                            <p><?php echo $article['prix']; ?> €</p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <a href="listearticle.php" class="voir-plus-btn">Voir plus</a>
            </div>
            <div class="logo-section">
                <img class="logo" src="pran.png" alt="Logo 1">
                <img class="logo" src="rfl.png" alt="Logo 2">
                <img class="logo" src="trs.png" alt="Logo 3">
                <img class="logo" src="national.png" alt="Logo 4">
            </div>

            <div class="logo2-section">
                <img class="logo2" src="shama.png" alt="Logo 1">
                <img class="logo2" src="Nestlee.png" alt="Logo 2">
                <img class="logo2" src="Yum.jpg" alt="Logo 3">
                <img class="logo2" src="parachute.png" alt="Logo 4">
                <!-- Ajoutez plus d'images de logos ici si nécessaire -->
            </div>

        </div>
        <div class="sliding-images">
            <img class="sliding-image" src="fushka.jpeg" alt="Sliding Image 1">
            <img class="sliding-image" src="margouze.jpg" alt="Sliding Image 2">
            <img class="sliding-image" src="flour.jpg" alt="Sliding Image 2">

            <!-- Ajoutez plus d'images coulissantes ici si nécessaire -->
        </div>

        <div class="sliding-images-right">
            <img class="sliding-image" src="fushka.jpeg" alt="Sliding Image 1">
            <img class="sliding-image" src="margouze.jpg" alt="Sliding Image 2">
            <img class="sliding-image" src="flour.jpg" alt="Sliding Image 2">
        </div>



        <!-- JavaScript pour le carrousel en boucle -->
        <!-- ... -->
        <script>
            const carouselInner = document.getElementById('carousel');
            const carouselItems = carouselInner.getElementsByClassName('carousel-item');
            let currentIndex = 0;

            function scrollCarousel() {
                // Cacher l'article actuel
                carouselItems[currentIndex].style.display = 'none';

                // Passer à l'article suivant
                currentIndex = (currentIndex + 1) % carouselItems.length;

                // Afficher l'article suivant
                carouselItems[currentIndex].style.display = 'block';
                carouselItems[currentIndex].classList.add('fade-in-out'); // Ajout de la classe pour l'effet de fondu
            }

            // Appeler scrollCarousel() toutes les 5 secondes (5000 ms)
            setInterval(scrollCarousel, 4000);
        </script>
        <!-- ... -->

        <!-- Section "A propos de nous" -->
        <div class="center-wrapper about">
            <h2>Coordonnées du Supermarché</h2>
            <p><strong>Nom du Supermarché :</strong> Groupe supermarket</p>
            <p><strong>Adresse :</strong> 12 rue des Bois, 92070 Clichy</p>

            <h2>A propos de nous</h2>
            <p>Clichy Supermarket est un supermarché de référence dans la région de Clichy depuis 2010. Fondé par M. Abdul Aziz, nous avons débuté comme une petite épicerie de quartier et avons évolué pour proposer aujourd'hui une large gamme de produits alimentaires et non alimentaires.
                Nous mettons un point d'honneur à fournir des produits de qualité issue des quatre coins du monde.</p>
            <p>Nous nous engageons à continuer d'être un partenaire fiable et de confiance pour vous.</p>
        </div>
</body>

</html>