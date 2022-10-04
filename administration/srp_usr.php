<?php
	$pdo = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '');
	$leNum =intval($_GET['num']);
	$rDelete = $pdo->prepare("DELETE FROM `utilisateurs` WHERE `num_user` = ?");
	$done = $rDelete->execute(array($leNum));
	if ($done) {
		echo"<script>alert('Utilisateur supprimé avec succès!');</script>";
		header("Location: utilisateurs.php");
	}else{
		echo "<script>alert('Erreur!');</script>";
	}
?>