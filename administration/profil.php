<?php
    session_start();
    $pdo = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    if (empty($_SESSION['num'])) {
        header("Location: index.php");
        exit();
    }else{
        $leNum = intval($_SESSION['num']);
        $requeteAdmin = $pdo->prepare("SELECT * FROM `administration` WHERE num_admin = ?");
        $requeteAdmin->execute(array($leNum));
        $adminInfo = $requeteAdmin->fetch();
        $username =  $adminInfo['admin_name'];
        $adr_mail = $adminInfo['adr_mail'];
        $pass_admin  = $adminInfo['admin_pass'];
    }

    if (isset($_POST['btnSubmit'])) {
        if (!empty($_POST['identification']) AND !empty($_POST['adresse']) AND !empty($_POST['motPasse']) AND !empty($_POST['motPasse2'])) {
            $username = htmlspecialchars($_POST['identification']);
            $adr_mail = htmlspecialchars($_POST['adresse']);
            $pass_admin = htmlspecialchars($_POST['motPasse']);
            $pass_admin2 = htmlspecialchars($_POST['motPasse2']);
            if ($pass_admin == $pass_admin2) {
                $requete = $pdo->prepare("UPDATE `administration` SET `admin_name` = ?, `adr_mail` = ?, admin_pass = ? WHERE `num_admin` = ?");
                $done = $requete->execute(array($username, $adr_mail, $pass_admin, $leNum));
                if ($done) {
                    header("Location: profil.php");
                }else{
                    $erreur = "Erreur!";
                }
            }else{
                $erreur = "Les mots de passe ne correspondent pas!";
            }
        }else{
            $erreur = "Remplissez tous les champs!";        
        }    
    }


?>
<!DOCTYPE html>
<html>
<head>
    <title>Picos Immobilier - Administration</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="../css/admin.css"/>
    <link rel="stylesheet" type="text/css" href="../css/profil.css"/>
</head>
<body>
    <!--INCLUSION-->
    <?php include("header.php");?>
</body>
    <div id="corpsSignUp">
             
            <center>
            <form id="fSignUp" method="post" action="" align="center">
                 <h2>Picos Immobilier</h2>
                 <h4>Administration - Mon Profil</h4>
            
                 <input type="text" required placeholder="Nom d'utilisateur" maxlength="35" name="identification" class="input" value="<?php  if(isset($username)) echo $username ;?>" />
                 <input type="email" required placeholder="Adresse e-mail" maxlength="100" name="adresse" class="input" value="<?php  if(isset($adr_mail)) echo $adr_mail ;?>" />
                 <input type="password" required placeholder="Mot de passe" maxlength="40" name="motPasse" value="<?php  if(isset($pass_admin)) echo $pass_admin ;?>" class="input"/>
                 <input type="password" required placeholder="Confirmer le mot de passe" maxlength="40" name="motPasse2" value="<?php  if(isset($pass_admin)) echo $pass_admin ;?>" class="input"/>
                 <div>

                 </div>
                 <input type="submit" value="Modifier" id="btnSingUp" name="btnSubmit"/>
                 <?php
                    if(isset($erreur)){
                    echo '<p style="color:red;" align="center" id="erreur">'.$erreur.'</p>';
                    }
                ?>
            </form>
            </center>
        </div>
</html>