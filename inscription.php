<?php
try {
	$pdo = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	if (isset($_POST['btnSubmit'])) {
		/*AFFECTATION DANS LES VARIABLES*/
		$prenoms = htmlspecialchars($_POST['prenoms']);
		$nom = htmlspecialchars($_POST['nom']);
		$num_tel = htmlspecialchars($_POST['num_tel']);
		$adr_mail = htmlspecialchars($_POST['adr_mail']);
		$password = sha1($_POST['pass']);
		$password2 = sha1($_POST['pass2']);
		if (!empty($_POST['prenoms']) AND !empty($_POST['nom']) AND !empty($_POST['num_tel']) AND !empty($_POST['adr_mail']) AND !empty($_POST['pass']) AND !empty($_POST['pass2'])) {
			if( filter_var($adr_mail, FILTER_VALIDATE_EMAIL)){
				if(is_numeric($num_tel)){
					if (strlen($num_tel) == 8){
						/*VERIFICATION DE L'EXISTANCE DU NUMERO DE TELEPHONE -- DEBUT*/
						$requeteNum = $pdo->prepare("SELECT * FROM utilisateurs WHERE num_tel = ?");
						$requeteNum->execute(array($num_tel));
						$numExiste = $requeteNum->rowCount();/*FIN*/
						if ($numExiste == 0) {
							/*VERIFICATION DE L'EXISTANCE DE L'ADRESSE E-MAIL */
							$requeteMail = $pdo->prepare("SELECT * FROM utilisateurs WHERE adr_mail = ?");
							$requeteMail->execute(array($adr_mail));
							$mailExiste = $requeteMail->rowCount();
							if ($mailExiste == 0) {
								/*COMPARAISON DES MOTS DE PASSES*/
								if ($password == $password2){
									$rInsert = $pdo->prepare("INSERT INTO `utilisateurs` VALUES (null, ?, ?, ?, ?, ?)");
									$done = $rInsert->execute(array($prenoms, $nom, $num_tel, $adr_mail, $password));
									if ($done) {
										$msg = "Votre compte a été bien crée!";
										header("Location: connexion.php");
										exit();
									}else{
										$erreur = "Erreur lors de la création du compte!";
									}   
									
								}else{
									$erreur = "Les mots de passes ne corrrespondent pas!";
								}
							}else{
								$erreur = "L'adresse e-mail est déjà utilisée!";
							}
						}else{
							$erreur = "Le numéro de téléphone est déjà utilisé!";
						}
					}else{
						$erreur = "Le numéro de téléphone n'est pas valide!";
					}
				}
			}else{
				$erreur= "Votre adresse e-mail n'est pas valide!";
			}
		}else{
			$erreur = "Veuillez remplir tous les champs!";
		}

	}
} catch (Exception $e) {
	echo $e;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Picos Immobilier - Insciption</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="css/log.css"/>
</head>
<body>
	<!-- I N C L U S I O N -->
	<?php
	include("header.php");
	?>
	<div id="corpsSignIn">
		<h2>Picos Immobilier</h2>
		<h4>Créér votre compte Picos Immobilier</h4>
		<form id="fSignIn" action="" method="post" align="center">
			<div>
				<input type="text" required placeholder="Prénoms" maxlength="50" name="prenoms" class="input" value="<?php if(isset($prenoms)) echo $prenoms ?>" title="Prénoms"/>
				<input type="text" required placeholder="Nom" maxlength="35" name="nom" class="input" value="<?php if(isset($nom)) echo $nom ?>" title="Nom"/>
			</div>
			<input type="text" required placeholder="Numéro de téléphone(TOGO (+228))" maxlength="8" name="num_tel" class="input" id="numTel" title="Numéro de téléphone(TOGO (+228))"/>
			<div><input type="email" required placeholder="Adresse e-mail" maxlength="35" name="adr_mail" class="input" id="adrMail" title="Adresse e-mail"/></div>
			<div>
				<input type="password" required placeholder="Mot de passe" maxlength="20" name="pass" class="input" title="Mot de passe"/>
				<input type="password" required placeholder="Confirmer le mot de passe" maxlength="20" name="pass2" class="input" title="Confirmer le mot de passe"/>
			</div>
			<div class="blockEnLigne">
				<input type="submit" value="S'inscrire" id="btnSingIn" name="btnSubmit"/>
				<input type="reset" value="Annuler" id="btnCancel"/>
			</div>
		</form>
		<?php
		if(isset($erreur)){
			echo '<p style="color:red;" align="center" >'.$erreur.'</p>';
		}
		if(isset($msg)){
			echo '<p style="color:green;" align="center" >'.$msg.'</p>';
		}
		?>
		<p><a href="connexion.php">Se connecter à un compte existant</a></p>
		<p id="infos">NB: Votre E-mail et numéro téléphone seront utilisés dans la publication des annonces</p>
		<style type="text/css">
			#infos{
				font-family: Segoe UI;
				color:;
			}
		</style>
	</div> 
	<!-- I N C L U S I O N -->
	<?php
	include("footer.php");
	?>
</div>
</body>
</html>
