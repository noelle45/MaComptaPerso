<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
    $date_saisie = $_POST['date_saisie'];
    $date_ecriture = $_POST['date_ecriture'];
    $categorie = $_POST['categorie'];
    $objet = $_POST['objet'];
    $montant = $_POST['montant'];
    $debit_credit = $_POST['debit_credit'];
    $id_banque = $_POST['id_banque'];
    $nom_banque = $_POST['nom_banque'];
    $id_compte = $_POST['id_compte'];
    $nom_compte = $_POST['nom_compte'];
    $id_createur = $_SESSION['id'];
    
        ?><div class="row"> <?
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        ?></div><?

        $query=$db->prepare('INSERT INTO ecritures (
        date_saisie, 
        date_ecriture, 
        categorie,
        objet, 
        montant, 
        debit_credit, 
        id_banque, 
        nom_banque, 
        id_compte, 
        nom_compte, 
        id_createur)
        
        VALUES (
        :date_saisie, 
        :date_ecriture, 
        :categorie, 
        :objet, 
        :montant, 
        :debit_credit, 
        :id_banque, 
        :nom_banque, 
        :id_compte, 
        :nom_compte, 
        :id_createur)');
    
        $montant= str_replace(',','.',$montant);

        $query->bindValue(':date_saisie', $date_saisie, PDO::PARAM_STR);
        $query->bindValue(':date_ecriture', $date_ecriture, PDO::PARAM_STR);
        $query->bindValue(':categorie', $categorie, PDO::PARAM_STR);
        $query->bindValue(':objet', $objet, PDO::PARAM_STR);
        $query->bindValue(':montant', $montant, PDO::PARAM_STR);
        $query->bindValue(':debit_credit', $debit_credit, PDO::PARAM_STR);
        $query->bindValue(':id_banque', $id_banque, PDO::PARAM_INT);
        $query->bindValue(':nom_banque', $nom_banque, PDO::PARAM_STR);
        $query->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
        $query->bindValue(':nom_compte', $nom_compte, PDO::PARAM_STR);
        $query->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
        $query->execute();
    
     echo'
        <div class="card">';
    
        echo'
        <h2>'.$objet.' <br/>pour un montant de :<br/> '.$montant.' € <br/>enregistré pour le compte ;<br/>'.$nom_compte.' <br/> Banque : '.$nom_banque.' !</h2>
        <p><a style="color:blue" href="../view/voir-compte.php?id='.$id_compte.'">Retour</a>';
        echo'
        </div>';

}
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');
echo'</div>';