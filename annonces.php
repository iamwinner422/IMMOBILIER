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

    #REQUETES DES ANNONCES
    $requeteAnnonce = $pdo->prepare("SELECT * FROM `annonces` ORDER BY `num_ann` DESC");
    $requeteAnnonce->execute();
    $listeAnnonce = $requeteAnnonce->fetchAll();
    
    //ANNONCE EN FONCTION DU TYPE
    if (isset($_GET['type'])) {
        if ($_GET['type'] == "Maisons") {
            $libelle = htmlspecialchars($_GET['type']);
            #SELECTION DU NUMERO POUR LE LIBELLE MAISON
            $reqType = $pdo->prepare("SELECT `num_type` FROM `type_immob` WHERE `libelle_type` = ? ");
            $reqType->execute(array($libelle));
            $result = $reqType->fetch();
            $num_type = $result['num_type'];//NUMERO

            $requeteAnnonce = $pdo->prepare("SELECT * FROM `annonces` WHERE `num_type` = ? ORDER BY `num_ann` DESC");
            $requeteAnnonce->execute(array($num_type));
            $listeAnnonce = $requeteAnnonce->fetchAll();
        }elseif ($_GET['type'] == "Terrains") {
            $libelle = htmlspecialchars($_GET['type']);
            #SELECTION DU NUMERO POUR LE LIBELLE MAISON
            $reqType = $pdo->prepare("SELECT `num_type` FROM `type_immob` WHERE `libelle_type` = ? ");
            $reqType->execute(array($libelle));
            $result = $reqType->fetch();
            $num_type = $result['num_type'];//NUMERO
            
            $requeteAnnonce = $pdo->prepare("SELECT * FROM `annonces` WHERE `num_type` = ? ORDER BY `num_ann` DESC");
            $requeteAnnonce->execute(array($num_type));
            $listeAnnonce = $requeteAnnonce->fetchAll();
        }elseif ($_GET['type'] == "Boutiques") {
           $libelle = htmlspecialchars($_GET['type']);
            #SELECTION DU NUMERO POUR LE LIBELLE MAISON
            $reqType = $pdo->prepare("SELECT `num_type` FROM `type_immob` WHERE `libelle_type` = ? ");
            $reqType->execute(array($libelle));
            $result = $reqType->fetch();
            $num_type = $result['num_type'];//NUMERO
            
            $requeteAnnonce = $pdo->prepare("SELECT * FROM `annonces` WHERE `num_type` = ? ORDER BY `num_ann` DESC");
            $requeteAnnonce->execute(array($num_type));
            $listeAnnonce = $requeteAnnonce->fetchAll();
        }elseif ($_GET['type'] == "Autres") {
            #SELECTION DU NUMERO POUR LE LIBELLE AUTRES
            $reqType = $pdo->prepare("SELECT `num_type` FROM `type_immob` WHERE `libelle_type` <> ? AND `libelle_type` <> ? AND `libelle_type` <> ? ");
            $reqType->execute(array("Maisons", "Terrains", "Boutiques"));
            $result = $reqType->fetchAll();
            $tabListe = [];//tableau qui va contenir les $listeAnnonces
            foreach ($result as $num) {
                $requeteAnnonce = $pdo->prepare("SELECT * FROM `annonces` WHERE `num_type` = ? ORDER BY `num_ann` DESC");
                $requeteAnnonce->execute(array($num['num_type']));
                $listeAnnonce = $requeteAnnonce->fetchAll();
                array_push($tabListe, $listeAnnonce);  //ajout de $listeAnnonce à la fin             
            }
        
        }else{
            header("Location: annonces.php");
        }
    }
        
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Picos Immobilier - Annonces</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/accueil.css"/>
        <link rel="stylesheet" type="text/css" href="css/annonces.css"/>
    </head>
    <body>
        <!-- I N C L U S I O N -->
        <?php
            include("header.php");
        ?>
        <div id="corps">
            <div id="liste">
            <p class="title">Dernières annonces</p>
            <table class="tble" cellpadding="0" cellspacing="0" border="0" id="t1">
                <tr class="entet">
                    <td align="center">Numéro</td>
                    <td align="center">Date pub.</td>
                    <td>Type</td>
                    <td>Adresse ou Lieu</td>
                    <td>Ville</td>
                    <td>Titre</td>
                    <td>Description</td>
                    <td>Prix</td>
                    <td align="center">Images</td>
                    <td align="center">Contact</td>
                    <td>Adresse E-mail</td>
                </tr>
                <?php
                //SI LE TYPE EST AUTRE
                  if (isset($_GET['type']) AND $_GET['type'] == "Autres") {
                        //$annonce fait partir de $listeAnnonce et $listeAnnonce fait partir de $tabListe
                        $i = 1;
                        foreach ($tabListe as $listeAnnonce) {  
                            foreach ($listeAnnonce as $annonce) {
                                #RECUPERATION DES CLES ETRANGERES DE UTILISATEUR VILLE ET TYPE
                                $num_user = $annonce['num_user'];
                                $num_type = $annonce['num_type'];
                                $num_ville = $annonce['num_ville'];
                                #REQUETE DES INFOS DES ANNONCEURS
                                $rInfos = $pdo->prepare("SELECT `num_tel`, `adr_mail` FROM `utilisateurs` WHERE `num_user` = ?");
                                $rInfos->execute(array($num_user));
                                $infos = $rInfos->fetch();
                                $numero = $infos['num_tel'];
                                $adresse = $infos['adr_mail'];

                                #REQUETE DU TYPE IMMOBILIER
                                $rType = $pdo->prepare("SELECT `libelle_type` FROM `type_immob` WHERE `num_type` = ?");
                                $rType->execute(array($num_type));
                                $type = $rType->fetch();
                                $libelle_type = $type['libelle_type'];

                                #REQUETE DE LA VILLE
                                $rVille = $pdo->prepare("SELECT `nom_ville` FROM `villes` WHERE `num_ville` = ?");
                                $rVille->execute(array($num_ville));
                                $ville = $rVille->fetch();
                                $nom_ville = $ville['nom_ville'];

                                echo "
                                    <tr class='infos'>
                                        <td align='center'>".$i."</td>
                                        <td align='center'>".$annonce['date_ann']."</td>
                                        <td>".$libelle_type."</td>
                                        <td>".$annonce['lieu_ann']."</td>
                                        <td>".$nom_ville."</td>
                                        <td>".$annonce['titre_ann']."</td>
                                        <td>".$annonce['desc_ann']."</td>
                                        <td>".$annonce['prix_ann']."</td>
                                        <td align='center'><a href='images.php?num_ann=".$annonce['num_ann']."'><img src='img/picture_30px.png' alt='image' id='img'/><a></td>
                                        <td align='center'>".$numero."</a></td>
                                        <td>".$adresse."</td>
                                    </tr>";
                                
                            }
                            $i++;
                        }
                    }else{
                          $i = 1;
                        foreach ($listeAnnonce as $annonce) {
                            #RECUPERATION DES CLES ETRANGERES DE UTILISATEUR VILLE ET TYPE
                            $num_user = $annonce['num_user'];
                            $num_type = $annonce['num_type'];
                            $num_ville = $annonce['num_ville'];
                            #REQUETE DES INFOS DES ANNONCEURS
                            $rInfos = $pdo->prepare("SELECT `num_tel`, `adr_mail` FROM `utilisateurs` WHERE `num_user` = ?");
                            $rInfos->execute(array($num_user));
                            $infos = $rInfos->fetch();
                            $numero = $infos['num_tel'];
                            $adresse = $infos['adr_mail'];

                            #REQUETE DU TYPE IMMOBILIER
                            $rType = $pdo->prepare("SELECT `libelle_type` FROM `type_immob` WHERE `num_type` = ?");
                            $rType->execute(array($num_type));
                            $type = $rType->fetch();
                            $libelle_type = $type['libelle_type'];

                            #REQUETE DE LA VILLE
                            $rVille = $pdo->prepare("SELECT `nom_ville` FROM `villes` WHERE `num_ville` = ?");
                            $rVille->execute(array($num_ville));
                            $ville = $rVille->fetch();
                            $nom_ville = $ville['nom_ville'];

                            echo "
                                <tr class='infos'>
                                    <td align='center'>".$i."</td>
                                    <td align='center'>".$annonce['date_ann']."</td>
                                    <td>".$libelle_type."</td>
                                    <td>".$annonce['lieu_ann']."</td>
                                    <td>".$nom_ville."</td>
                                    <td>".$annonce['titre_ann']."</td>
                                    <td>".$annonce['desc_ann']."</td>
                                    <td>".$annonce['prix_ann']."</td>
                                    <td align='center'><a href='images.php?num_ann=".$annonce['num_ann']."'><img src='img/picture_30px.png' alt='image' id='img'/><a></td>
                                    <td align='center'>+228 ".$numero."</td>
                                    <td>".$adresse."</td>
                                </tr>";
                            $i++;
                        }
                    }   
                ?>
            </table>
            </div>
        </div>
        <?php
            /*include ('footer.php');*/
        ?>
    </body>
</html>
