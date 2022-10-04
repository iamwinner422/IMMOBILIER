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
    $rMsg = $pdo->prepare("SELECT * FROM `messages`");
    $rMsg->execute();
    $nbMsg = $rMsg->rowCount();
    /*LISTE USER*/
    $listeMsg = $rMsg->fetchAll();

    #VERIFICATION DU NUMERO DU MESSAGE RECU DEPUIS LA BARRE D_ADRESSE
    if (isset($_GET['num']) AND is_numeric($_GET['num']) AND intval($_GET['num']) <= $nbMsg) {
        $leNum = intval($_GET['num']);
        $rMsg = $pdo->prepare("SELECT `message` FROM `messages` WHERE `num_msg` = :num");
        $rMsg->bindValue(':num', $leNum, PDO::PARAM_INT);
        $rMsg->execute();
        $corpsMsg = $rMsg->fetch();
        $leMsg = $corpsMsg['message'];
        		
    }elseif (empty($_GET['num'])) {
        $leMsg = "Sélectionner un message";
    }
    else{
        $erreur = "Erreur de message!";
    }	
    	
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
            <p class="entetes">Nombre de messages reçues</p>
            <p class="chiffres"><?php echo $nbMsg;?></p>
        </div>
    </div>
    <center>
    <div id="corps1">
    	<p class="title">Liste des messages </p>
        <table class="tble" cellpadding="0" cellspacing="0" border="0" id="t5">
            <tr class="entete">
                <td align="center">Numéro</td>
                <td>Objet</td>
                <td>Nom & Prénoms</td>
                <td align="center">Téléphone</td>
            	<td>Adresse E-mail</td>
            	<td align="center" colspan="2">Opérations</td>
            </tr>
            <?php
                $i = 1;
                foreach ($listeMsg as $msg) {
                    echo "
            	        <tr class='infos'>
                        	<td align='center'>".$i."</td>
                        	<td>".$msg['objet']."</td>
                        	<td>".$msg['prenoms_evy']." ".$msg['nom_evy']."</td>
                	    	<td align='center'>".$msg['num_tel_evy']."</td>
                       		<td>".$msg['adr_mail']."</td>
                        	<td align='center'><a href='messages.php?num=".$msg['num_msg']."' id='details'>Détails</a></td>
                        	<td align='center'><a href='srp_msg.php?num=".$msg['num_msg']."' id='supprimer'>Supprimer</a></td>
                        </tr>";
                        $i++;
                    }

               
                ?>
        </table>
        <div id="corps-msg">
        	<!--<textarea id="box-msg">-->
        		<p>
                    <?php
                        if (isset($leMsg)) {
                            echo $leMsg;
                        }
                        if (isset($erreur)) {
                            echo $erreur;
                        }
                    ?>
                    
                </p>
        	<!--</textarea>-->
        </div>
    </div>
    </center>
</body>
</html>