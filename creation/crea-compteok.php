<?php
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
    $i = 0;
    $nom_compte = $_POST['nom_compte'];
    $type_compte = $_POST['type_compte'];
    $nom_banque = $_POST['nom_banque'];
    $id_banque = $_POST['id_banque'];
    $id_createur = $_SESSION['id'];
    
    $query=$db->prepare('SELECT COUNT(*) AS nbr FROM comptes 
    WHERE nom_compte =:nom_compte
    AND id_createur =:id_createur');
    $query->bindValue(':nom_compte',$nom_compte, PDO::PARAM_STR);
    $query->bindValue(':id_createur',$id_createur, PDO::PARAM_INT);
    $query->execute();
    $nom_free=($query->fetchColumn()==0)?1:0;
    $query->CloseCursor();
    if(!$nom_free)
    {
        $nom_erreur1 = "<i>Ce nom de compte existe déjà, merci de personnaliser celui-ci afin de le retrouver plus facilement</i>";
        $i++;
    }
    
    
    if ($i==0)
   {
        ?><div class="row"> <?
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        ?></div><?
        
        echo'
        <div class="card">';
        
        echo'
        <h2>Votre nouveau compte '.$nom_compte.' pour la banque '.$nom_banque.' a été crée avec succés !</h2>';
       
        echo'
        </div>';



        $query=$db->prepare('INSERT INTO comptes (id_banque, nom_banque, id_createur, nom_compte, type_compte)
        VALUES (:id_banque, :nom_banque, :id_createur, :nom_compte, :type_compte)');

        $query->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
        $query->bindValue(':id_banque', $id_banque, PDO::PARAM_INT);
        $query->bindValue(':nom_banque', $nom_banque, PDO::PARAM_STR);
        $query->bindValue(':nom_compte', $nom_compte, PDO::PARAM_STR);
        $query->bindValue(':type_compte', $type_compte, PDO::PARAM_STR);
        $query->execute();

        $query = $db->prepare('SELECT * FROM comptes 
        WHERE nom_compte = :nom_compte 
        AND nom_banque = :nom_banque
        AND id_createur = :id_createur');
        $query->bindValue(':nom_compte',$nom_compte, PDO::PARAM_STR);
        $query->bindValue(':nom_banque',$nom_banque, PDO::PARAM_STR);
        $query->bindValue(':id_createur',$id_createur, PDO::PARAM_INT);
        $query->execute();
        $data=$query->fetch();
        $id_compte = $data['id_compte'];

        echo'
        <h2 class="violet pt-5 pb-5 w-100">
            <a class="white2" href="../view/saisir-ecriture.php?id='.$id_compte.'">
            <img src="../creation/img/ecriture-icon.png" alt="icone crea compte" title="Saisir une écriture" width="80px"/>
            Saisir une écriture </a></h2>';
    }
    else
    {
        echo'<h1>Saisie interrompue</h1>';
        echo'<p>Une ou plusieurs erreurs se sont produites pendant la saisie</p>';
        echo'<p>'.$i.' erreur(s)</p>';
        echo'<p>'.$nom_erreur1.'</p>';
        echo'<p><a href="http://localhost/MaComptaPerso/view/mes-comptes.php"> Cliquez ici pour recommencer</a></p>';
    }
}
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');