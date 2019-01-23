<div class="violet">
<p class="white2 violet center titre-script pt-3">Ma Compta Perso</p>
</div>

    <?php
    if(isset($_SESSION['id']))
    {
        echo'<div class="violet mb-3" style="margin-top:-20px">
        <h2 class="violet pb-3 center gray"><strong> Bienvenue '.$_SESSION['prenom'].'</strong></h2>
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
        <a class="white2" href="http://myspacefamily.fr/MaComptaPerso/index.php"> Connexion </a> 
        &nbsp; &nbsp; | &nbsp; &nbsp; 
        <a class="white2" href="http://myspacefamily.fr/MaComptaPerso/creation/register.php"> Créer un compte </a> </p>';
    }
?>    
