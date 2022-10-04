<?php
	$pdo = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '');
	$leNum =intval($_GET['num_ville']);
	$rDelete = $pdo->prepare("DELETE FROM `villes` WHERE `num_ville` = ?");
	$done = $rDelete->execute(array($leNum));
	if ($done) {
		echo"<script>alert('Ville supprimée avec succès!');</script>";
		header("Location: others.php");
	}else{
		echo "<script>alert('Erreur!');</script>";
	}
?>