<header class="entete">         
     <nav class="menu">       
         <ul>
             <li><a href="index.php">Accueil</a></li>
             <li class="dropdown">
                 <a href="annonces.php" class="dropbtn">Annonces</a>
                 <div class="elementListe">
                     <a href="annonces.php?type=Maisons">Maisons</a>
                     <a href="annonces.php?type=Terrains">Terrains</a>
                     <a href="annonces.php?type=Boutiques">Boutiques</a>
                     <a href="annonces.php?type=Autres">Autres</a>
                 </div>
             </li>
             <li class="dropdown" id="noconnect">
                 <a href="#" class="dropbtn">Compte</a>
                 <div class="elementListe">
                     <a href="connexion.php">Connexion</a>
                     <a href="inscription.php">Inscription</a>
                 </div>
             </li>
             <li class="dropdown" id="user">
                 <a href="account/dashboard.php" class="dropbtn"><?php if(isset($prenoms)){
                  echo $prenoms;}else{ echo "<style type='text/css'>
                    #user{
                        display: none;
                        opacity: 0;
                        visibility: hidden;
                     }
                 </style>";}?></a>
                 <div class="elementListe">
                 <?php if (isset($_COOKIE['__lingoser']) AND $userInfo['num_user'] == $_COOKIE['__lingoser']){?>
                    <a href="account/profil.php">Profil</a>
                    <a href="account/deconnexion.php">Deconnexion</a>
                <?php } ?>    
                </div>
             </li>
             <li><a href="about.php">A propos</a></li>
             <li id="nAnnonce"><a href="nouvelle_annonce.php">Ajouter une annonce</a></li>
         </ul>
    </nav>
</header>