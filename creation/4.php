<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');


$id_createur = $_SESSION['id'];
$creance_id = $_POST['creance_id'];
$date_saisie = $_POST['date_saisie'];
$date_ecriture = $_POST['date_ecriture'];
$montant = $_POST['montant'];
$mode_reglement = $_POST['mode_reglement'];
$date_saisie = $_POST['date_saisie'];
$debit_credit = $_POST['debit_credit'];
$objet = $_POST['objet'];
$id_banque = $_POST['id_banque'];
$nom_banque = $_POST['nom_banque']; 
$nom_compte = $_POST['nom_compte']; 
$id_compte = $_POST['id_compte'];

$echeances=$db->prepare('INSERT INTO echeances
(id_createur, id_creance, date_saisie, date_paiement, montant, mode_reglement)
VALUES (:id_createur, :creance_id, :date_saisie, :date_ecriture, :montant, :mode_reglement)
');
$echeances->execute();

$montant= str_replace(',','.',$montant);

$echeances->bindValue(':id_createur',$_SESSION['id'], PDO::PARAM_INT);
$echeances->bindValue(':creance_id',$creance_id, PDO::PARAM_INT);
$echeances->bindValue(':date_saisie',$date_saisie, PDO::PARAM_STR);
$echeances->bindValue(':date_ecriture',date('d-m-y'), PDO::PARAM_STR);
$echeances->bindValue(':montant',$montant, PDO::PARAM_STR);
$echeances->bindValue(':mode_reglement',$mode_reglement, PDO::PARAM_STR);
$echeances->execute();

echo'<meta http-equiv="refresh" content="0;URL=http://myspacefamily.fr/MaComptaPerso/view/voir-compte.php?id='.$id_compte.'">';


include('../includes/footer.php');