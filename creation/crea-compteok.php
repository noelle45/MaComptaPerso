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
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        
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

        echo'<meta http-equiv="refresh" content="0.5;URL=crea-ecriture.php?nomcpte='.$nom_compte.'&id='.$id_compte.'">';
    }
    else
    {
      	include('../includes/banniere-connect.php');
   		include('../includes/menu.php');
    
        echo'
        <div class="row">
        	<div class="col">
        		<div class="card card50 mt-5 ombre">
      				<h1>Saisie interrompue</h1>
                      <p>Une ou plusieurs erreurs se sont produites pendant la saisie</p>
                      <p>'.$i.' erreur(s)</p>
                      <p>'.$nom_erreur1.'</p>
                      <p><a href="http://myspacefamily.fr/MaComptaPerso/view/mes-comptes.php"> Cliquez ici pour recommencer</a></p>
                </div>
             </div>
          </div>';
    }
}
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');