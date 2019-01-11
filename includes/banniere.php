<p class="white2 violet center titre-script pt-5 pb-5">Ma Compta Perso</p>
    
    <?php
    if(isset($_SESSION['id']))
    {
        $query=$db->prepare('SELECT id_utilisateur, membre_utilisateur FROM compte_utilisateurs WHERE id_utilisateur=:id');
        $query->bindValue(':id',$_SESSION['id'],PDO::PARAM_INT);
        $query->execute();
        $data=$query->fetch();
        $utilisateur = $data['prenom_utilisateur'];
        
        echo '<h2> Bienvenue '.$utilisateur.'</h2>';
    }
    else
    {
        echo '
        <p class="violet pt-3 pb-3"> 
        <a class="white2" href="http://localhost/MaComptaPerso/index.php"> 
        Connexion 
        </a> 
        
        &nbsp; &nbsp; | &nbsp; &nbsp; 
        
        <a class="white2" href="http://localhost/MaComptaPerso/creation/register.php"> 
        Créer un compte 
        </a> 
        </p>';
    }
?>    
