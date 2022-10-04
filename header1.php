<header id="entete">         
     <nav class="menu">       
         <ul>
            <li><a href="index.php">Accueil</a></li>
            <li class="dropdown">
                 <a href="account/dashboard.php" class="dropbtn"><?php echo $prenoms." ".$nom ?></a>
                <?php
                    if (isset($_COOKIE['__lingoser']) AND $userInfo['num_user'] == $_COOKIE['__lingoser']){
                ?>
                 <div class="elementListe">
                     <a href="account/profil.php">Mon profil</a>
                     <a href="account/deconnexion.php">Deconnexion</a>
                 </div>
                 <?php
                    }
                ?>
            </li>
            <li id="nAnnonce"><a href="nouvelle_annonce.php">Nouvelle annonce</a></li>
         </ul>
    </nav>
</header>