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
        header("Location: /connexion.php");
        exit();
    }

    if (isset($_GET['num']) AND is_numeric($_GET['num']) AND isset($_GET['numser']) AND is_numeric($_GET['numser']) AND  intval($_GET['numser']) == $num_user ) {
        $num_ann = intval($_GET['num']);
        $requeteAnn = $pdo->prepare("SELECT * FROM `annonces` WHERE num_ann = ?");
        $requeteAnn->execute(array($num_ann));
        $annInfo = $requeteAnn->fetch();
        $num_user = $annInfo['num_user'];
        if($annInfo['num_user'] == $_GET['numser']){
            $titre_ann = $annInfo['titre_ann'];
            $description = $annInfo['desc_ann'];
            $prix_ann = $annInfo['prix_ann'];
            $lieu_ann = $annInfo['lieu_ann'];
            $date_ann = $annInfo['titre_ann'];
            $num_ville = $annInfo['num_ville'];
            $num_type = $annInfo['num_type'];
        }else{
            header("Location: account/dashboard.php");
            exit();
        }
        
    }else{
        header("Location: account/dashboard.php");
        exit();
    }
        #SELECTION DE LA VILLE
    $reqVille = $pdo->prepare("SELECT `nom_ville` FROM `villes` WHERE `num_ville` = ?");
    $reqVille->execute(array($num_ville));
    $result = $reqVille->fetch();
    $nom_ville = $result['nom_ville'];
        #SELECTION DU TYPE
    $reqType = $pdo->prepare("SELECT `libelle_type` FROM `type_immob` WHERE `num_type` = ?");
    $reqType->execute(array($num_type));
    $result1 = $reqType->fetch();
    $libelle = $result1['libelle_type'];
        #TOUTES LES VILLES
    $requete = $pdo->prepare("SELECT * FROM `villes`");
    $requete->execute();
    $listeVille = $requete->fetchAll();
        #TOUTES LES TYPES
    $requete1 = $pdo->prepare("SELECT * FROM `type_immob`");
    $requete1->execute();
    $listeType = $requete1->fetchAll();
        #SUPPRESSION DES IMAGES DANS LA BASE
    $reqSup = $pdo->prepare("DELETE FROM `images` WHERE `num_ann` = ?");
    $reqSup->execute(array($num_ann));
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Picos Immobilier - Modification</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/accueil.css"/>
        <link rel="stylesheet" type="text/css" href="css/account.css">
    </head>
    <body>
        <?php
        include ("header1.php"); 
        ?>
        <center>
            <div id="corps1">
                <?php
            #TRAITEMENT DU FORMULAIRE DE MODIFICATION
                if(isset($_POST['btnModifier'])){
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
                                //$erreur =  $pathDestination1;
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
                                //$erreur =  $pathDestination2;
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
                                //$erreur =  $pathDestination3;
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
                                //$erreur =  $pathDestination4;
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
                                //$erreur = $pathDestination5;
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
                        ///MIS A JOUR DES ELEMENTS DANS LA BASE...
                        $reqUpdate = $pdo->prepare("UPDATE `annonces` SET `titre_ann` = ?, `desc_ann` = ?, `prix_ann` = ?, `lieu_ann` = ?, `num_ville` = ?, `num_type` = ? WHERE `num_ann` = ? AND `num_user` = ?");
                        $done = $reqUpdate->execute(array($title, $desc, $price, $place, $numVille, $numType, $num_ann, $leNum));
                        if ($done) {
                                 //INSERTION
                            if (isset($pathDestination1)) {
                                $reqIns1 = $pdo->prepare("INSERT INTO `images` VALUES(null, ?, ?)");
                                $reqIns1->execute(array($pathDestination1, $num_ann));
                            }
                            if (isset($pathDestination2)) {
                                $reqIns2 = $pdo->prepare("INSERT INTO `images` VALUES(null, ?, ?)");
                                $reqIns2->execute(array($pathDestination2, $num_ann));
                            }
                            if (isset($pathDestination3)) {
                                $reqIns3 = $pdo->prepare("INSERT INTO `images` VALUES(null, ?, ?)");
                                $reqIns3->execute(array($pathDestination3, $num_ann));
                            }
                            if (isset($pathDestination4)) {
                                $reqIns4 = $pdo->prepare("INSERT INTO `images` VALUES(null, ?, ?)");
                                $reqIns4->execute(array($pathDestination4, $num_ann));
                            }
                            if (isset($pathDestination5)) {
                                $reqIns5 = $pdo->prepare("INSERT INTO `images` VALUES(null, ?, ?)");
                                $reqIns5->execute(array($pathDestination5, $num_ann));
                            }

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
            <form id="formUp" method="POST" action="" enctype="multipart/form-data">
                <h3>Modification</h3>
                <div>
                    <input type="text" name="titre" class="input" placeholder="Titre de l'annonce" value="<?php if(isset($titre_ann)) echo $titre_ann ?>" required/>
                    <input type="text" name="prix" class="input" placeholder="Prix du bien" value="<?php if(isset($prix_ann)) echo $prix_ann ?>" required/>
                </div>
                <div>
                    <input type="text" name="description" class="input" placeholder="Description de l'annonce" id="description" value="<?php if(isset($description)) echo $description ?>" required/>
                </div>
                <div id="select">
                    <div class="lst-contenaire">
                        <?php
                        $selected = '';
                        // Parcours du tableau
                        echo '<select name="lstVille" class="lst">',"n";
                        echo '<optgroup label="Villes">';
                        foreach($listeVille as $ville){
                        // Test de la valeur
                            if($nom_ville == $ville['nom_ville']){
                                $selected = 'selected="selected"';
                            }
                        // Affichage de la ligne
                            echo "\t",'<option value="', $ville['nom_ville'] ,'"', $selected ,'>', $ville['nom_ville'] ,'</option>',"\n";
                        // Remise à zéro de $selected
                            $selected='';
                        }
                        echo '</optgroup>';
                        echo '</select>',"\n";
                        ?>
                    </div>
                    <div class="lst-contenaire">
                        <?php
                        $selected = '';
                        // Parcours du tableau
                        echo '<select name="lstType" class="lst">',"n";
                        echo '<optgroup label="Type de biens">';
                        foreach($listeType as $type){
                        // Test de la valeur
                            if($libelle == $type['libelle_type']){
                                $selected = 'selected="selected"';
                            }
                        // Affichage de la ligne
                            echo "\t",'<option value="', $type['libelle_type'] ,'"', $selected ,'>', $type['libelle_type'] ,'</option>',"\n";
                        // Remise à zéro de $selected
                            $selected='';
                        }
                        echo '</<optgroup>';
                        echo '</select>',"\n";
                        ?>    
                    </div>
                </div>
                <div>
                    <input type="text" name="lieu" class="input" placeholder="Situation du bien" id="lieu" value="<?php if(isset($lieu_ann)) echo $lieu_ann ?>" required/>
                </div>
                <div id="blckImage">
                    <input type="file" name="image1" class="fImage"/><br/>
                    <span id="leschamps_2"><a href="javascript:create_champ(2)" class="ajout">Ajouter une image</a></span>
                </div>
                <div>
                    <input type="reset" name="reset" id="reset" value="Effacer"/>
                    <input type="submit" name="btnModifier" id="btnModifier" value="Modifier"/>
                </div>
                <?php
                if(isset($erreur)){
                    echo '<p id="erreur">'.$erreur.'</p>';
                }
                ?>
            </form>
        </div>
    </center>
    <script type="text/javascript">
            //AJOUT DES CHAMPS
            function create_champ(i) {
                var i2 = i + 1;
                document.getElementById('leschamps_'+i).innerHTML = '<input type="file" class="fImage" name="image'+i+'"></span>';
                /* on limite ici le nombre de champs à un maximum de 5 */
                document.getElementById('leschamps_'+i).innerHTML += (i <= 4) ? '<br/><span id="leschamps_'+i2+'"><a href="javascript:create_champ('+i2+')" class="ajout">Ajouter une image</a></span>' : '';
            }
        </script>
        <?php
        include("footer.php");
        ?>
    </body>
    </html>