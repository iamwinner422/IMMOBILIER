<?php
	$pdo = new PDO('mysql:host=localhost; dbname=immobilier', 'root', '');
	$leNum =intval($_GET['num']);
	$rDelete = $pdo->prepare("DELETE FROM `messsages` WHERE `num_msg` = ?");
	$done = $rDelete->execute(array($leNum));
	if ($done) {
		echo"<script>alert('Message supprimé avec succès!');</script>";
		header("Location: messages.php");
		exit();
	}else{
		echo "<script>alert('Erreur!');</script>";
	}
?>