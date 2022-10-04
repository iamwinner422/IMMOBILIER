<?php
    session_start();
    $pdo = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    if (isset($_COOKIE['__lingoser'])) {
        echo "
            <style type='text/css'>
                #noconnect{
                    display: none;
                    opacity: 0;
                    visibility: hidden;
                 }
                #user{
                    display: inline-block;
                    opacity: 1;
                    visibility: visible;
                 }
            </style>
        ";
        $leNum = intval($_COOKIE['__lingoser']);
        $requeteUser = $pdo->prepare("SELECT * FROM `utilisateurs` WHERE num_user = ?");
        $requeteUser->execute(array($leNum));
        $userInfo = $requeteUser->fetch();
        $numero= $userInfo['num_user'];
        $nom =  $userInfo['nom_user'];
        $prenoms = $userInfo['prenoms_user'];
        $numero = $userInfo['num_tel'];
        $adresse = $userInfo['adr_mail'];

    }else{
        echo "
            <style type='text/css'>
                #user{
                    display: none;
                    opacity: 0;
                    visibility: hidden;
                 }
            </style>
        ";
    }
        
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Picos Immobilier - Accueil</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/accueil.css"/>
    </head>
    <body>
        <!-- I N C L U S I O N -->
        <?php
            include("header.php");
        ?>
        <div id="presentation">
            <div id="banniere">
                <h1>PICOS IMMOBILIER</h1>
                <h3>Trouver la maison parfaite pour vous et votre famille.</h3>
                <button id="trouver"><a href="annonces.php?type=Maisons">Trouver une maison</a></button>
            </div>
        </div>
        <div id="images">
        <div class="slider">
            <div class="slides">
                <img src="img/27.jpg" alt="Maison" class="slide"/>
                <img src="img/29.jpg" alt="Appartement" class="slide"/>
                <img src="img/30.jpg" alt="Immeuble" class="slide"/>
            </div>
        </div>
        </div>
        <!--<div id="lestarifs">
            <h1>Passer votre annonce sur Picos Immobillier à des tarifs  défiant toute concurrence.</h1>
            <h2>Nos tarifs</h2>
            <div class="tarifs">
                <h2> Simple</h2>
                <h3>6000 FCFA/Mois</h3>
                    <ul>
                        <li>4 Photos</li>
                        <li>700 Caractères de description</li>
                        <li>4 Modifications possibles</li>
                    </ul>
                <a href="nouvelle_annonce.php#2" class="ajtAnnonce">Ajouter l'annonce</a>
            </div>
            <div class="tarifs">
                <h2>Professionel</h2>
                <h3>15000 FCFA/Mois</h3>
                    <ul>
                        <li>8 Photos</li>
                        <li>1500 Caractères de description</li>
                        <li>10 Modifications possibles</li>
                    </ul>
                <a href="nouvelle_annonce.php#2" class="ajtAnnonce">Ajouter l'annonce</a>
            </div>
            <div class="tarifs">
                <h2>Entreprise</h2>
                <h3>30000 FCFA/Mois</h3>
                    <ul>
                        <li>16 Photos</li>
                        <li>3000 Caractères de description</li>
                        <li>Modifications illimités</li>
                    </ul>
                <a href="nouvelle_annonce.php#2" class="ajtAnnonce">Ajouter l'annonce</a>
            </div>
        </div>-->
        <div id="start">
            <p><a href="annonces.php" id="get-started">Commençons</a></p>
        </div>
         <!-- I N C L U S I O N -->
        <?php
            include("footer.php");
        ?>
    </body>
</html>