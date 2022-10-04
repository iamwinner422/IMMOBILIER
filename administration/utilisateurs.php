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
    $rUser = $pdo->prepare("SELECT * FROM `utilisateurs`");
    $rUser->execute();
    $nbUser = $rUser->rowCount();
    /*LISTE USER*/
    $listeUser = $rUser->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Picos Immobilier - Administration</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>
	<!--INCLUSION-->
    <?php include("header.php");?>
    <div id ="infos">
        <div class="box-info">
            <p class="entetes">Nombre total d'inscrits</p>
            <p class="chiffres"><?php echo $nbUser;?></p>
        </div>
        <div id="search">
        	<form id="fSearch" method="post" action="">
        		<input type="text" name="boxSearch" title="Recherche" placeholder="Recherche" id="box-search" value="<?php if (isset($recherche)) echo $recherche;?>"/>
        		<input type="submit" name="btnSearch" id="btnSearch" value="" />
        	</form>
        	<?php
        		if (isset($_POST['btnSearch'])) {
        			if (!empty($_POST['boxSearch'])) {
        				$recherche = htmlspecialchars($_POST['boxSearch']);
        				$rUser = $pdo->prepare("SELECT * FROM `utilisateurs` WHERE `nom_user` = :recherche OR `prenoms_user` = :recherche OR `num_tel` = :recherche OR `adr_mail` = :recherche");
        				$rUser->bindValue(':recherche', $recherche, PDO::PARAM_STR);
    					$rUser->execute();
    					$listeUser = $rUser->fetchAll();

        			}
        		}
        	?>
        </div>
    </div>
    <center>
    <div id="corps">
    	<p class="title">Liste des utilisateurs </p>
            <table class="tble" cellpadding="0" cellspacing="0" border="0" id="t4">
                <tr class="entete">
                    <td align="center">Numéro</td>
                    <td>Nom & Prénoms</td>
                    <td align="center">Téléphone</td>
                	<td>Adresse E-mail</td>
                	<td align="center">Opération</td>
                </tr>
                <?php
                    $i = 1;
                    foreach ($listeUser as $user) {
                        echo "
                            <tr class='infos'>
                                <td align='center'>".$i."</td>
                                <td>".$user['nom_user']." ".$user['prenoms_user']."</td>
                                <td align='center'>".$user['num_tel']."</td>
                                <td>".$user['adr_mail']."</td>
                                <td align='center'><a href='srp_usr.php?num=".$user['num_user']."' id='supprimer'>Supprimer</a></td>
                            </tr>";
                        $i++;
                    }   
                ?>
            </table>
    </div>
    </center>
</body>
</html>