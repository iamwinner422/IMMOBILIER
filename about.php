<?php
    /*TRAITEMENT DU FORMULAIRE*/
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
    
    if (isset($_POST['envoyer'])) {
    /*CHAMPS VIDES*/
        if (empty($_POST['prenoms']) AND empty($_POST['nom']) AND empty($_POST['objet']) and empty($_POST['numero']) AND empty($_POST['adr_mail']) AND empty($_POST['message'])) {
            $erreur = "Veuillez remplir tous les champs!";
                        
        }else{
            $nom = htmlspecialchars($_POST['nom']);
            $prenoms = htmlspecialchars($_POST['prenoms']);
            $objet = htmlspecialchars($_POST['objet']);
            $numero = htmlspecialchars($_POST['numero']);
            $adrMail = htmlspecialchars($_POST['adr_mail']);
            $message = htmlspecialchars($_POST['message']);

            if (filter_var($adrMail, FILTER_VALIDATE_EMAIL)) {
                if (is_numeric($numero)) {
                    if (strlen($numero) == 8) {
                        /*requette*/
                        $laRequete = $pdo->prepare("INSERT INTO `messages` VALUES(null,?,?,?,?,?,?)");
                        $done = $laRequete->execute(array($nom, $prenoms, $objet, $numero, $adrMail, $message));
                        if ($done) {
                            echo"<script>alert('Votre méssage a été bien envoyé. Nous vous répondrons dans les plus brefs délais.');</script>";
                             /*affectation des valeurs nulles*/
                            $nom = " ";
                            $prenoms = " ";
                            $objet = " ";
                            $numero = " ";
                            $message = " ";
                            $adrMail = " ";
                        }else{
                            echo"<script>alert('Erreur lors de l'envoi du méssage!');</script";
                        }

                    }else{
                        echo"<script>alert('Le numéro de téléphone saisi n\'est pas valide!');</script";
                    }
                }else{
                        echo"<script>alert('Le numéro de téléphone saisi n\'est pas valide!');</script";
                    }
            }else{
                    echo"<script>alert('L\'adresse e-mail saisie n\'est pas valide!');</script";
                }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Picos Immobilier - Accueil</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/about.css"/>
        <link rel="stylesheet" type="text/css" href="css/accueil.css">
    </head>
    <body>
        <!-- I N C L U S I O N -->
        <?php
            include("header.php");
        ?>
        <h1 id="titre">Picos Immobilier - A propos</h1>
        <div id="nous">
            <h1>NOUS</h1>
            <p>Picos Immobilier est une plate-forme internet qui sert de vitrine aux particuliers et aussi aux entreprises de faire passer leurs annonces sur internet à des prix défiants toute concurrence.</p>
            <p>Vous pouvez y passer les annonces de vos biens immeubles telques Terrains, Maisons, Boutiques...En vue de la vente ou de la location.</p>
        </div>
        <div id="team">
            <h1>Notre équipe</h1>
            <p>Picos Immobilier est formé d'une jeune équipe très dynamique</p>
            <div id="block">
            <div class="cote">
                <img src="img/user_male_100px.png" alt="Mr X" title="Mr X" class="imgEquipe"/>
                <h3>Mr XXXXXX<br/>(The Brain)</h3>
                <h4>Responsable administratif</h4>
                <a href="tel://0022800000000" class="contact">Contacter</a>
            </div>
            <div id="centre">
                <img src="img/user_100px.png" alt="iamwinner" title="iamwinner" class="imgEquipe"/>
                <h3>iamwinner<br/>(The Geek)</h3>
                <h4>Responsable technique</h4>
                <a href="tel://0022800000000" class="contact">Contacter</a>
            </div>
            <div class="cote">
                <img src="img/user_female_100px.png" alt="Mlle Y" title="Mlle Y" class="imgEquipe"/>
                <h3>Mlle YYYYYY<br/>(The Anti-paparazi)</h3>
                <h4>Responsable de la communication</h4>
                <a href="tel://0022800000000" class="contact">Contacter</a>
            </div>
            </div>
            <p>The future is now!!</p>
        </div>
        <div id="contact">
            <h1>Nous Contacter</h1>
            <h3>Ecrivez nous sur notre E-mail</h3>
            <form method="post" id="formContact" action="">
                <div>
                    <input type="text" placeholder="Prénoms" maxlength="50" required name="prenoms" class="input"/>
                    <input type="text" placeholder="Nom" maxlength="35" required name="nom" class="input"/>
                </div>
                <div>
                    <input type="text" placeholder="Objet" maxlength="100" required name="objet" class="input"/>
                    <input type="text" placeholder="Adresse" maxlength="100" required name="adresse" class="input"/>
                </div>
                <div>
                    <input type="tel" placeholder="Numéro de téléphone" maxlength="8" required name="numero" class="input"/>
                    <input type="email" placeholder="Adresse E-mail" maxlength="50" required name="adr_mail" class="input"/>
                </div>
                <textarea class="input" placeholder="Message" name="message">
                </textarea>
                <br/>
                <input type="submit" name="envoyer" value="Envoyer" id="btnEnvoyer">
            </form>
            <h3>OU</h3>
            <br/>
            <h3>Contactez nous directement</h3>
            <a href="tel://0022898023036">98023036</a>
            <h3>Picos Immobilier, 11 Rue Avenue Akei 152 Lomé - TOGO</h3>
        </div>
        <?php
            include("footer.php");
        ?>
    </body>
</html>