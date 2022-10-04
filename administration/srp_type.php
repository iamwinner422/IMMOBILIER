<?php
	$pdo = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '');
	$leNum =intval($_GET['num_type']);
	$rDelete = $pdo->prepare("DELETE FROM `type_immob` WHERE `num_type` = ?");
	$done = $rDelete->execute(array($leNum));
	if ($done) {
		echo"<script>alert('Type supprimé avec succès!');</script>";
		header("Location: others.php");
	}else{
		echo "<script>alert('Erreur!');</script>";
	}
?>