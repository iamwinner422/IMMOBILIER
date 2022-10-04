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
        header("Location: ../connexion.php");
        exit();
    }
    #ANNONCES PAR LE USER
    $reqAnn = $pdo->prepare("SELECT * FROM `annonces` WHERE `num_user` = ? ORDER BY `num_ann` DESC");
    $reqAnn->execute(array($num_user));
    $nbAnn = $reqAnn->rowCount();//nbre annonces
    $listeAnn = $reqAnn->fetchAll();
    
    #DETAILS DES ANNONCES PAR NUM_DET
    if (isset($_GET['num_det']) AND is_numeric($_GET['num_det'])) {
        $leNum = intval($_GET['num_det']);
        $rAnn = $pdo->prepare("SELECT * FROM `annonces` WHERE `num_ann` = :num");
        $rAnn->bindValue(':num', $leNum, PDO::PARAM_INT);
        $rAnn->execute();
        $resultat = $rAnn->fetch();
        $description = $resultat['desc_ann'];
        $num_ville = $resultat['num_ville'];
        $num_type = $resultat['num_type'];
        $number = $resultat['num_ann'];
        //NOM DE LA VILLE
        $reqVille = $pdo->prepare("SELECT `nom_ville` FROM `villes` WHERE `num_ville` = ?");
        $reqVille->execute(array($num_ville));
        $reqVil = $reqVille->fetch();
        #nom de la ville
        $ville = $reqVil['nom_ville'];
        //NOM DU TYPE
        $reqType = $pdo->prepare("SELECT `libelle_type` FROM `type_immob` WHERE `num_type` = ?");
        $reqType->execute(array($num_type));
        $reqTpe = $reqType->fetch();
        #nom du type
        $type = $reqTpe['libelle_type'];  
    }else{
        
        /*$description = "Selectionnez une annonce";
        $ville = "Selectionnez une annonce";
        $type = "Selectionnez une annonce";*/
    }   

?>

<!DOCTYPE html>
<html>
<head>
	<title>Picos Immobilier - Dashboard</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/accueil.css"/>
	<link rel="stylesheet" type="text/css" href="../css/account.css">
</head>
<body>
	<!-- I N C L U S I O N -->
    <?php
        include("header.php");
    ?>
    <div id ="infos">
        <div class="box-info">
            <p class="entetes">Nombre d'annonces par moi</p>
            <p class="chiffres"><?php echo $nbAnn;?></p>
        </div>
    </div>
    <center>
    <div id="corps" class="js-page">
        <div id="liste">
            <p class="title">Mes dernières annonces</p>
            <table class="tble" cellpadding="0" cellspacing="0" border="0" id="t1">
                <tr class="entete">
                    <td align="center">Numéro</td>
                    <td>Titre</td>
                    <td>Prix</td>
                    <td>Lieu</td>
                    <td>Date</td>
                    <td align="center" colspan="3">Opérations</td>
                </tr>
                <?php
                    $i = 1;
                    foreach ($listeAnn as $ann) {
                        echo "
                            <tr class='infos'>
                                <td align='center'>".$i."</td>
                                <td>".$ann['titre_ann']."</td>
                                <td>".$ann['prix_ann']."</td>
                                <td>".$ann['lieu_ann']."</td>
                                <td>".$ann['date_ann']."</td>
                                <td align='center'><a href='dashboard.php?num_det=".$ann['num_ann']."' id='details'>Détails</a></td>
                                <td align='center'><a href='../modifier.php?num=".$ann['num_ann']."&numser=".$_COOKIE['__lingoser']."' id='modifier'>Modifier</a></td>
                                <td align='center'><a href='srp_ann.php?num=".$ann['num_ann']."' id='supprimer'>Supprimer</a></td>
                            </tr>";
                            $i++;
                        }

                   
                    ?>
            </table>
            <div id="corps-details">
                <p class="tt">Description</p>
                <p class="ss"><?php if (isset($description)){echo $description;}?></p>
                <p class="tt">Ville</p>
                <p class="ss"><?php if (isset($ville)){echo $ville;}?></p>
                <p class="tt">Type de bien immobilier</p>
                <p class="ss"><?php if (isset($type)){echo $type;}?></p>
                <p class="tt">Photos</p>
                <?php if(isset($number)){echo"<p><a href='../photos.php?num_ann=".$number."&num_user=".$num_user."'id='photos'>Voir les photos</a></p>";}?>
            </div>
        </div>
    </div>
    </center>
    <?php
        include("footer.php");
    ?>
</body>
</html>
