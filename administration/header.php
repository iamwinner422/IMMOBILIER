<div id="banniere">
    <nav id="menu">    
        <ul>
            <li id="titre">Administration - Picos Immobilier</li>
            <?php
				if (isset($_SESSION['num']) AND $adminInfo['num_admin'] == $_SESSION['num']){
			?>
            <li id="deconnexion"><a href="deconnexion.php">Deconnexion</a></li>
            <li id="username"><a href="profil.php" title="Mon profil"><?php echo $username;?></a></li>
            <?php
				}
			?>
        </ul>
    </nav>
</div>
<div id="ban-2">
	<nav id="menu-2">
		<ul>
			<li><a href="administration.php">Accueil</a></li>
			<li><a href="utilisateurs.php">Utilisateurs</a></li>
			<li><a href="annonces.php">Annonces</a></li>
			<li><a href="messages.php">Messages</a></li>
			<li><a href="others.php">Autres</a></li>
		</ul>
	</nav>
</div>
