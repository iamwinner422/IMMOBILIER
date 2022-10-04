<?php
    session_start();
    $pdo = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    if (isset($_COOKIE['__lingomin'])) {
        $leNum = intval($_COOKIE['__lingomin']);
        $requeteAdmin = $pdo->prepare("SELECT * FROM `administration` WHERE num_admin = ?");
        $requeteAdmin->execute(array($leNum));
        $adminInfo = $requeteAdmin->fetch();
        $username =  $adminInfo['admin_name'];
        $adr_mail = $adminInfo['adr_mail'];
    }else{
        header("Location: index.php");
        exit();
    }
    #REQUÊTE DU NB USER
    $rUser = $pdo->prepare("SELECT * FROM `utilisateurs` order by `num_user` DESC");
    $rUser->execute();
    $nbUser = $rUser->rowCount();
    #REQUÊTE DU NB ANNONCE
    $rAnnonce = $pdo->prepare("SELECT * FROM `annonces` order by `num_ann` DESC");
    $rAnnonce->execute();
    $nbAnnonce = $rAnnonce->rowCount();
    #REQUÊTE DU NB MESSAGE
    $rMsg = $pdo->prepare("SELECT * FROM `messages` order by `num_msg` DESC");
    $rMsg->execute();
    $NbMsg = $rMsg->rowCount();
    /*LISTE USER*/
    $listeUser = $rUser->fetchAll();
    /*LISTE ANNONCE*/
    $listeAnnonce = $rAnnonce->fetchAll();
    /*LISTE MSG*/
    $listeMsg = $rMsg->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Picos Immobilier - Administration</title>
	<meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="../css/admin.css"/>
</head>
<body>
	<!--INCLUSION-->
    <?php include("header.php");?>
    <div id ="infos">
        <div class="box-info">
            <p class="entetes">Nombre total d'inscrits</p>
            <p class="chiffres"><?php echo $nbUser;?></p>
        </div>
        <div class="box-info">
            <p class="entetes">Nombre d'annonces publiées</p>
            <p class="chiffres"><?php echo $nbAnnonce;?></p>
        </div>
        <div class="box-info">
            <p class="entetes">Nombre de messages reçus</p>
            <p class="chiffres"><?php echo $NbMsg;?></p>
        </div>
    </div>
    <div id="boxes">
        <div id="utilisateurs" class="display">
            <p class="title">Liste des 5 derniers utilisateurs inscrits</p>
            <table class="tble" cellpadding="0" cellspacing="0" border="0" id="t1">
                <tr class="entete">
                    <td align="center">Numéro</td>
                    <td>Adresse E-mail</td>
                    <td align="center">Téléphone</td>
                </tr>
                <?php
                    $i = 1;
                    foreach ($listeUser as $user) {
                        echo "
                            <tr class='infos'>
                                <td align='center'>".$i."</td>
                                <td>".$user['adr_mail']."</td>
                                <td align='center'>".$user['num_tel']."</td>
                            </tr>";
                        $i++;
                        if ($i > 5) {
                            break;
                        } 
                    }   
                ?>
            </table>
        </div>
        
        <div id="messages" class="display">
            <p class="title">Listes des 5 derniers messages reçues</p>
            <table class="tble" cellpadding="0" cellspacing="0" border="0" id="t3">
                <tr class="entete">
                    <td align="center">Numéro</td>
                    <td>Objet</td>
                    <td>Nom & Prénoms</td>
                    <td>E-mail</td>
                </tr>
                <?php
                    $i = 1;
                    foreach ($listeMsg as $msg) {
                        echo "
                            <tr class='infos'>
                                <td align='center'>".$i."</td>
                                <td>".$msg['objet']."</td>
                                <td>".$msg['nom_evy']." ".$msg['prenoms_evy']."</td>
                                <td>".$msg['adr_mail']."</td>
                            </tr>";
                        $i++;
                        if ($i > 5) {
                            break;
                        } 
                    }   
                ?>
            </table>
        </div>

        <div id="annonces" class="display">
            <p class="title">Liste des 5 dernières annonces publiées</p>
            <table class="tble" cellpadding="0" cellspacing="0" border="0" id="t2">
                <tr class="entete">
                    <td align="center">Numéro</td>
                    <td>Titre</td>
                    <td>Téléphone annonceur</td>
                    <td>E-mail annonceur</td>
                </tr>
                <?php
                    $i = 1;
                    foreach ($listeAnnonce as $annonce) {
                        $num_user = $annonce['num_user'];
                        #REQUETE DES INFOS DES ANNONCEURS
                        $rInfos = $pdo->prepare("SELECT `num_tel`, `adr_mail` FROM `utilisateurs` WHERE `num_user` = ?");
                        $rInfos->execute(array($num_user));
                        $infos = $rInfos->fetch();
                        $numero = $infos['num_tel'];
                        $adresse = $infos['adr_mail'];
                        echo "
                            <tr class='infos'>
                                <td align='center'>".$i."</td>
                                <td>".$annonce['titre_ann']."</td>
                                <td>".$numero."</td>
                                <td>".$adresse."</td>
                            </tr>";
                        $i++;
                        if ($i > 5) {
                            break;
                        } 
                    }   
                ?>
            </table>
        </div>
    </div>
    <?php
        include 'footer.php';
    ?>
</body>
</html>
