 
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
    #TOUTES LES VILLES
    $requete = $pdo->prepare("SELECT * FROM `villes`");
    $requete->execute();
    $listeVille = $requete->fetchAll();
    #TOUTES LES TYPES
    $requete1 = $pdo->prepare("SELECT * FROM `type_immob`");
    $requete1->execute();
    $listeType = $requete1->fetchAll();

    #TRAITEMENT DU FORMULAIRE
    if(isset($_POST['btnAjouter'])){
        //VERIFICATION DES CHAMPS
        if(!empty($_POST['titre']) AND !empty($_POST['prix']) AND !empty($_POST['description']) AND !empty($_POST['lieu'])){
            //VERIFIVATION DU Prix
            if(is_numeric($_POST['prix'])){
            //VERIFCATIONS DES IMAGES CHARGEES
            #TABLEAU DES EXTENSIONS
            $extensions_autorisees = array('jpg', 'jpeg', 'png', 'gif', 'PNG', 'JPG', 'JPEG', 'GIF');
            if (empty($_FILES['image1']) AND empty($_FILES['image2']) AND empty($_FILES['image3']) AND empty($_FILES['image4']) AND empty($_FILES['image5'])) {
                $erreur = "Veuillez choisir au moins une image.";
            }else{
                //IMAGE 1
                if (isset($_FILES['image1']) AND $_FILES['image1']['error'] == 0) {
                    $infoImage1 = pathinfo($_FILES['image1']['name']);
                    $extensionImage1 = $infoImage1['extension'];
                    if (in_array($extensionImage1, $extensions_autorisees)){
                        //RECUPERATION DES CHEMINS
                        $pathDestination1 = 'uploads/'.$_FILES['image1']['name'];
                        $pathTmp1 = $_FILES['image1']['tmp_name'];
                        if(move_uploaded_file($pathTmp1, $pathDestination1)){
                            //INSERTION DANS LA BASE
                            $erreur =  $pathDestination1;
                        }else{
                            $erreur = "Erreur lors de l'envoi.";
                        }
                    }else{
                        $erreur = "Certains fichiers ne sont pas des images...";
                    }
                }
                if(isset($_FILES['image2']) AND $_FILES['image2']['error'] == 0){
                    $infoImage2 = pathinfo($_FILES['image2']['name']);
                    $extensionImage2 = $infoImage2['extension'];
                    if (in_array($extensionImage2, $extensions_autorisees)){
                        //RECUPERATION DES CHEMINS
                        $pathDestination2 = 'uploads/'.$_FILES['image2']['name'];
                        $pathTmp2 = $_FILES['image2']['tmp_name'];
                        if(move_uploaded_file($pathTmp2, $pathDestination2)){
                            //INSERTION DANS LA BASE
                            $erreur =  $pathDestination2;
                        }else{
                            $erreur = "Erreur lors de l'envoi.";
                        }
                    }else{
                        $erreur = "Certains fichiers ne sont pas des images...";
                    }
                }
                if (isset($_FILES['image3']) AND $_FILES['image3']['error'] == 0) {
                    $infoImage3 = pathinfo($_FILES['image3']['name']);
                    $extensionImage3 = $infoImage3['extension'];
                    if (in_array($extensionImage3, $extensions_autorisees)){
                        //RECUPERATION DES CHEMINS
                        $pathDestination3 = 'uploads/'.$_FILES['image3']['name'];
                        $pathTmp3 = $_FILES['image3']['tmp_name'];
                        if(move_uploaded_file($pathTmp3, $pathDestination3)){
                        //INSERTION DANS LA BASE
                            $erreur =  $pathDestination3;
                        }else{
                            $erreur = "Erreur lors de l'envoi.";
                        }
                    }else{
                        $erreur = "Certains fichiers ne sont pas des images...";
                    }
                }
                if (isset($_FILES['image4']) AND $_FILES['image4']['error'] == 0) {
                    $infoImage4 = pathinfo($_FILES['image4']['name']);
                    $extensionImage4 = $infoImage4['extension'];
                    if (in_array($extensionImage4, $extensions_autorisees)){
                       //RECUPERATION DES CHEMINS
                        $pathDestination4 = 'uploads/'.$_FILES['image4']['name'];
                        $pathTmp4 = $_FILES['image4']['tmp_name'];
                        if(move_uploaded_file($pathTmp4, $pathDestination4)){
                            //INSERTION DANS LA BASE
                            $erreur =  $pathDestination4;
                        }else{
                                $erreur = "Erreur lors de l'envoi.";
                        }
                    }else{
                        $erreur = "Certains fichiers ne sont pas des images...";
                    }
                }
                if (isset($_FILES['image5']) AND $_FILES['image5']['error'] == 0) {
                    $infoImage5 = pathinfo($_FILES['image5']['name']);
                    $extensionImage5 = $infoImage5['extension'];
                    if (in_array($extensionImage5, $extensions_autorisees)){
                        //RECUPERATION DES CHEMINS
                        $pathDestination5 = 'uploads/'.$_FILES['image5']['name'];
                        $pathTmp5 = $_FILES['image5']['tmp_name'];
                        if(move_uploaded_file($pathTmp5, $pathDestination5)){
                            //INSERTION DANS LA BASE
                            $erreur = $pathDestination5;
                        }else{
                            $erreur = "Erreur lors de l'envoi.";
                        }
                    }else{
                        $erreur = "Certains fichiers ne sont pas des images...";
                    }
                }else{
                    $erreur = "Veuillez choisir au moins une image.";
                }

            }
                //AFFECTATION DES CHAMPS DANS LES VARIABLES
                $title = htmlspecialchars($_POST['titre']);
                $price = htmlspecialchars($_POST['prix']);
                $desc = htmlspecialchars($_POST['description']);
                $place = htmlspecialchars($_POST['lieu']);
                //SELECTION DES NUMEROS CORRESPONDANT AUX SELECTs
                $nomVlle = $_POST['lstVille'];
                $nomType = $_POST['lstType'];
                $reqNumVille = $pdo->prepare("SELECT `num_ville` FROM `villes` WHERE `nom_ville` = ?");
                $reqNumVille->execute(array($nomVlle));
                $reslt1 = $reqNumVille->fetch();
                $numVille = $reslt1['num_ville'];//resultat
                $reqNumType = $pdo->prepare("SELECT `num_type` FROM `type_immob` WHERE `libelle_type` = ?");
                $reqNumType->execute(array($nomType));
                $reslt2 = $reqNumType->fetch();
                $numType = $reslt2['num_type'];//resultat
                    ///INSERTION DES ELEMENTS DANS LA BASE...
                    $ladate = date('d/m/Y');
                    $reqAjout = $pdo->prepare("INSERT INTO `annonces` VALUES(null, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $done = $reqAjout->execute(array($title, $desc, $price, $place, $ladate, $numVille, $leNum, $numType));
                    if ($done) {
                    //SELECTION DU DERNIER NUMERO D'ANNONCE POUR INSERTION DES IMAGES
                    $reqNumAnn = $pdo->prepare("SELECT MAX(num_ann) AS `dernier_num` FROM `annonces`");
                    $reqNumAnn->execute();
                    $reponse = $reqNumAnn->fetch();
                    $dernier_num = $reponse['dernier_num'];
                        //INSERTION
                        if (isset($pathDestination1)) {
                            $reqIns1 = $pdo->prepare("INSERT INTO `images` VALUES(null, ?, ?)");
                            $reqIns1->execute(array($pathDestination1, $dernier_num));
                        }
                        if (isset($pathDestination2)) {
                            $reqIns2 = $pdo->prepare("INSERT INTO `images` VALUES(null, ?, ?)");
                            $reqIns2->execute(array($pathDestination2, $dernier_num));
                        }
                        if (isset($pathDestination3)) {
                            $reqIns3 = $pdo->prepare("INSERT INTO `images` VALUES(null, ?, ?)");
                            $reqIns3->execute(array($pathDestination3, $dernier_num));
                        }
                        if (isset($pathDestination4)) {
                            $reqIns4 = $pdo->prepare("INSERT INTO `images` VALUES(null, ?, ?)");
                            $reqIns4->execute(array($pathDestination4, $dernier_num));
                        }
                        if (isset($pathDestination5)) {
                            $reqIns5 = $pdo->prepare("INSERT INTO `images` VALUES(null, ?, ?)");
                            $reqIns5->execute(array($pathDestination5, $dernier_num));
                        }
                        //REDIRECTION
                        header("Location: account/dashboard.php");
                        exit();
                    }else{
                        $erreur = "Erreur";
                    }
                }else{
                    $erreur = "Erreur!Le prix n'est pas numérique.";
                }
            }else{
                $erreur = "Veuillez remplir tous les champs!";
            }
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Picos Immobilier - Nouvelle Annonce</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/nAnnonce.css"/>
    <link rel="stylesheet" href="css/accueil.css"/>
</head>
<body>
    <?php
        include ("header1.php");
    ?>
    <div id="conseils">
        <h3>4 Règles pour publier votre annonce</h3>
        <ul>
            <li>N'écrivez pas le prix dans le titre</li>
            <li>N'indiquez pas vos coordonée(téléphone, adresse...) dans la description</li>
            <li>Ne publiez pas la même annonce plusieurs fois</li>
            <li>Ne publiez pas des annonces sur des biens litigieux</li>
        </ul>
    </div>
    <div id="corps">
        <form id="formAjout" method="POST" action="" enctype="multipart/form-data">
            <h3>Ajout d'une annonce</h3>
            <div>
                <input type="text" name="titre" class="input" placeholder="Titre de l'annonce" value="<?php if(isset($title)) echo $title ?>" required/>
                <input type="text" name="prix" class="input" placeholder="Prix du bien" required value="<?php if(isset($price)) echo $price ?>"/>
            </div>
            <div>
                <input type="text" name="description" class="input" placeholder="Description de l'annonce" id="description"
                value="<?php if(isset($desc)) echo $desc?>" required/>
            </div>
            <div id="select">
                <div class="lst-contenaire">
                <?php
                    echo '<select name="lstVille" class="lst">',"n";
                    echo '<optgroup label="Villes">';
                    foreach($listeVille as $ville){
                    // Affichage de la ligne
                    echo "\t",'<option value="', $ville['nom_ville'] ,'"','>', $ville['nom_ville'] ,'</option>',"\n";
                    }
                    echo '</optgroup>';
                    echo '</select>',"\n";
                ?>
                </div>
                <div class="lst-contenaire">
                <?php
                    echo '<select name="lstType" class="lst">',"n";
                    echo '<optgroup label="Type de biens">';
                    foreach($listeType as $type){
                    // Affichage de la ligne
                    echo "\t",'<option value="', $type['libelle_type'] ,'"','>', $type['libelle_type'] ,'</option>',"\n";
                    }
                    echo '</<optgroup>';
                    echo '</select>',"\n";
                ?>
                </div>
            </div>
            <div>
                <input type="text" name="lieu" class="input" placeholder="Situation du bien" id="lieu" required value="<?php if(isset($place)) echo $place ?>"/>
            </div>
            <div id="blckImage">
                <input type="file" name="image1" class="fImage"/><br/>
                <span id="leschamps_2"><a href="javascript:create_champ(2)" class="ajout">Ajouter une image</a></span>
            </div>
            <div>
                <input type="reset" name="reset" id="reset" value="Effacer"/>
                <input type="submit" name="btnAjouter" id="btnAjouter" value="Ajouter"/>
            </div>
            <?php
                if(isset($erreur)){
                    echo '<p id="erreur">'.$erreur.'</p>';
                }
            ?>
        </form>
        <script type="text/javascript">
            //AJOUT DES CHAMPS
            function create_champ(i) {
            var i2 = i + 1;
            document.getElementById('leschamps_'+i).innerHTML = '<input type="file" class="fImage" name="image'+i+'"></span>';
            /* on limite ici le nombre de champs à un maximum de 5 */
            document.getElementById('leschamps_'+i).innerHTML += (i <= 4) ? '<br/><span id="leschamps_'+i2+'"><a href="javascript:create_champ('+i2+')" class="ajout">Ajouter une image</a></span>' : '';
        }
        </script>
    </div>
</body>
</html>
