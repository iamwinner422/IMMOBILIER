<?php
    session_start();
    $laBase = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

    if (isset($_POST['btnSubmit'])) {
        $identification = htmlspecialchars($_POST['identification']);//VARIABLE UNIQUE D'IDENTIFICATION(E-MAIL ET NUMERO)
        $password = $_POST['motPasse'];
        if (!empty($identification) AND !empty($password)) {
            $requeteUser = $laBase->prepare("SELECT * FROM `administration` WHERE admin_name = ? AND admin_pass = ?");/*RECHERCHE DANS LA BASE*/
            $requeteUser->execute(array($identification, $password));
            $userExiste = $requeteUser->rowCount();
            if ($userExiste == 1) {
                $adminInfo = $requeteUser->fetch();
                $_SESSION['num'] = $adminInfo['num_admin'];
                #NOM DU COOKIE __LINGOMIN = LOGIN + ADMIN
                setcookie('__lingomin', $adminInfo['num_admin'], time() + 360*24*3600, null, null, false, true);
                echo '<script>document.location.replace("administration.php");</script>';
            }
            else{
                $erreur = "Le nom d'utilisateur ou le mot de passe est incorrect";
            }
        }else{
            $erreur = "Veuillez remplir tous les champs!";
        }
    }   
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Picos Immobilier - Administration</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="../css/new.css"/>
    </head>
    <body>
         <div id="corpsSignUp">
             
            <center>
            <form id="fSignUp" method="post" action="" align="center">
                 <h2>Picos Immobilier</h2>
                 <h4>Administration</h4>
            
                 <input type="text" required placeholder="Nom d'utilisateur" maxlength="35" name="identification" class="input" value="<?php  if(isset($identification)) echo $identification ;?>" />
                 <input type="password" required placeholder="Mot de passe" maxlength="20" name="motPasse" class="input"/>
                 <div>

                 </div>
                 <input type="submit" value="Se connecter" id="btnSingUp" name="btnSubmit"/>
                 <?php
                    if(isset($erreur)){
                    echo '<p style="color:red;" align="center" id="erreur">'.$erreur.'</p>';
                    }
                ?>
             </form>
             </center>
             
            <!--<div id="otherConnect">
                 <h2>Se connecter avec </h2>
                 <img src="img/google_logo_100px.png" title="Se connecter avec Google"  alt="Google" class="connectImg"/>
                 <img src="img/facebook_circled_100px.png" title="Se connecter avec Facebook"  alt="Facebook" class="connectImg"/>
                 <img src="img/twitter_100px.png" title="Se connecter avec Twitter"  alt="Twitter" class="connectImg"/>
             </div>-->
        </div>
    </body>
</html>
