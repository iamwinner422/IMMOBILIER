<?php
    session_start();
    $pdo = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    if (isset($_COOKIE['__lingoser'])) {
        $leNum = intval($_COOKIE['__lingoser']);
        $requeteUser = $pdo->prepare("SELECT * FROM `utilisateurs` WHERE num_user = ?");
        $requeteUser->execute(array($leNum));
        $userInfo = $requeteUser->fetch();
        $num_user= $userInfo['num_user'];
        $nom =  $userInfo['nom_user'];
        $prenoms = $userInfo['prenoms_user'];
        $numero = $userInfo['num_tel'];
        $adresse = $userInfo['adr_mail'];
    }else{
        header("Location: connexion.php");
        exit();
    }
    #VERIFCATION DU NUMERO D'ANNONCE
    if (isset($_GET['num_ann']) AND is_numeric($_GET['num_ann']) AND isset($_GET['num_user']) AND is_numeric($_GET['num_user']) AND  intval($_GET['num_user']) == $num_user){
        $reqNumAnn = $pdo->prepare("SELECT * FROM `annonces` WHERE `num_ann` = ?");
        $reqNumAnn->execute(array($_GET['num_ann']));
        $existe = $reqNumAnn->rowCount();
        if ($existe != 0) {
            $num_ann = intval($_GET['num_ann']);
        }else{
           header("Location: dashboard.php");
            exit(); 
        }
    }
    else{
        header("Location: dashboard.php");
        exit();
    }
    #SELECTION DES IMAGES
    $reqImg = $pdo->prepare("SELECT `source` FROM `images` WHERE `num_ann` = ?");
    $reqImg->execute(array($num_ann));
    $nbImage = $reqImg->rowCount();
    $listeImg = $reqImg->fetchAll();
    if ($nbImage == 0) {
        $erreur = "Aucune image disponible pour l'annonce.";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Picos Immobilier - Photos</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/photos.css"/>
    <link rel="stylesheet" type="text/css" href="css/accueil.css"/>
</head>
<body>
    <?php
        include ("header1.php"); 
    ?>
    
    <h1>Photos de l'annonce</h1>

    <?php
        if (isset($erreur)) {
            echo "<p id='erreur'>".$erreur."</p>";
        }else{
            echo '
        <div id="corps">
        <div id="slider">';
         
            echo '
                <img src="" alt="Cliquez sur les flêches pour défiler" id="slide">
                <div id="precedent" onclick="ChangeSlide(-1)"><</div>
                <div id="suivant" onclick="ChangeSlide(1)">></div>
            ';
            
            echo '
                <script type="text/javascript">
                    var slide = [];
            ';
                    //AJOUT DES IMAGES AU TABLEAU SLIDE
                        foreach ($listeImg as $img) {
                            echo "
                                slide.push('".$img['source']."');
                            ";
                        }
                    echo'
                    var numero = 0;

                    function ChangeSlide(sens) {
                        numero = numero + sens;
                        if (numero < 0)
                            numero = slide.length - 1;
                        if (numero > slide.length - 1)
                            numero = 0;
                            document.getElementById("slide").src = slide[numero];
                        }
                </script>
                ';
        echo "
        </div>
        </div>";
        }
    ?>
</body>
</html>