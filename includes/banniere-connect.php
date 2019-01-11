<div class="row w-100 violet">
<p class="white2 violet center titre-script pt-3">Ma Compta Perso</p>
</div>

    <?php
    if(isset($_SESSION['id']))
    {
        echo'<div class="row w-100 violet mb-3" style="margin-top:-20px">
        <h2 class="violet center"> Bienvenue '.$_SESSION['prenom'].'</h2>
        </div>';
        
        
        $id=$_SESSION['id'];
        $query=$db->prepare('SELECT id_utilisateur, membre_utilisateur FROM compte_utilisateurs WHERE id_utilisateur=:id');
        $query->bindValue(':id',$id,PDO::PARAM_INT);
        $query->execute();
        $data=$query->fetch();
        $utilisateur = $_SESSION['prenom'];
        
        
    }
    else
    {
        
        echo '
        <p class="violet pt-3 pb-3"> 
        <a class="white2" href="http://localhost/MaComptaPerso/index.php.php"> Connexion </a> 
        &nbsp; &nbsp; | &nbsp; &nbsp; 
        <a class="white2" href="http://localhost/MaComptaPerso/creation/register.php"> Créer un compte </a> </p>';
    }
?>    
