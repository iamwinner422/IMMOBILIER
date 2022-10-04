<?php
	$pdo = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '');
	$leNum =intval($_GET['num']);
	$rDelete = $pdo->prepare("DELETE FROM `annonces` WHERE `num_ann` = ?");
	$done = $rDelete->execute(array($leNum));
	if ($done) {
		echo"<script>alert('Annonce supprimé avec succès!');</script>";
		header("Location: annonces.php");
		exit();
	}else{
		echo "<script>alert('Erreur!');</script>";
	}
?>