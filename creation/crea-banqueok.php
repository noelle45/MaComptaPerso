<?php
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
    ucwords($nom)=$_POST['nom_banque'];
    $id = $_SESSION['id'];
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
                    
    echo'
    </div>';
     
    $query=$db->prepare('INSERT INTO banques (id_createur, nom_banque)
    VALUES (:id, :nom_banque)');

    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->bindValue(':nom_banque', $nom, PDO::PARAM_STR);
    $query->execute();

  	echo'<meta http-equiv="refresh" content="0.5;URL=crea-compte.php?id='.$nom.'">';
}
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');