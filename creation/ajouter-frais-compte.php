<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{

$action = isset($_GET['idCompte'])?(int) $_GET['idEcrit']:'';
     
    $queryCharge=$db->prepare('SELECT * FROM charges_fixes 
    WHERE id_charge=:id_charge');
    $queryCharge->bindValue(':id_charge', $_GET['idEcrit'], PDO::PARAM_INT);
    $queryCharge->execute();
    $dataCharge=$queryCharge->fetch();
    
    $categorie = $dataCharge['categorie'];
    $objet = $dataCharge['objet'];
    $montant = $dataCharge['montant'];
    $debit_credit = $dataCharge['debit_credit'];
  	$mode_reglement = $dataCharge['mode_reglement'];
    
    $queryCompte=$db->prepare('SELECT * FROM comptes WHERE id_compte=:id_compte');
    $queryCompte->bindValue(':id_compte', $_GET['idCompte'], PDO::PARAM_INT);
    $queryCompte->execute();
    $dataCompte=$queryCompte->fetch();

    $id_compte = $dataCompte['id_compte'];
    $nom_compte = $dataCompte['nom_compte'];
    $id_banque = $dataCompte['id_banque'];
    $nom_banque = $dataCompte['nom_banque'];
        
    $queryEcriture=$db->prepare('INSERT INTO ecritures (
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
    id_createur,
    mode_reglement)
    
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
    :id_createur,
    :mode_reglement)');
    
    $queryEcriture->bindValue(':date_saisie', date('Y-m-d h:i:s'), PDO::PARAM_STR);
    $queryEcriture->bindValue(':date_ecriture', date('Y-m-d'), PDO::PARAM_STR);
    $queryEcriture->bindValue(':categorie', $categorie, PDO::PARAM_STR);
    $queryEcriture->bindValue(':objet', $objet, PDO::PARAM_STR);
    $queryEcriture->bindValue(':montant', $montant, PDO::PARAM_STR);
    $queryEcriture->bindValue(':debit_credit', $debit_credit, PDO::PARAM_STR);
    $queryEcriture->bindValue(':id_banque', $id_banque, PDO::PARAM_INT);
    $queryEcriture->bindValue(':nom_banque', $nom_banque, PDO::PARAM_STR);
    $queryEcriture->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
    $queryEcriture->bindValue(':nom_compte', $nom_compte, PDO::PARAM_STR);
    $queryEcriture->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
  	$queryEcriture->bindValue(':mode_reglement', $mode_reglement, PDO::PARAM_STR);
    $queryEcriture->execute();
    
echo'<div class="card card5 mt-5">En cours de création...</div>
<meta http-equiv="refresh" content="1;URL=http://myspacefamily.fr/MaComptaPerso/view/voir-compte.php?id='.$id_compte.'">';
   
}
