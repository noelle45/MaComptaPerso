<?php
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
    $nom=$_POST['nom_banque'];
    $id = $_SESSION['id'];
    
    ?><div class="row"> <?
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        ?></div><?
                    
    echo'
    <div class="card">';
                    
    echo'
    <h2>Votre nouvelle banque '.$nom.' a été crée avec succés !</h2>';
    echo'
    <h2 class="violet pt-5 pb-5 w-100">
        <a class="white2" href="../creation/crea-compte.php?id='.$_SESSION['id'].'">
        <img src="../creation/img/compt-icon.png" alt="icone crea compte" title="Ajouter un compte" width="80px"/>
        Associer un compte </a></h2>';

    echo'
    </div>';
     
    $query=$db->prepare('INSERT INTO banques (id_createur, nom_banque)
    VALUES (:id, :nom_banque)');

    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->bindValue(':nom_banque', $nom, PDO::PARAM_STR);
    $query->execute();
}
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');