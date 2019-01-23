<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
    
$id_creance = $_POST['id_creance'];
$date_paiement = $_POST['date_paiement'];
$date_saisie = $_POST['date_saisie'];
$montant = $_POST['montant'];
$mode_reglement = $_POST['mode_reglement'];

$echeances=$db->prepare('INSERT INTO echeances
(id_createur, id_creance, date_saisie, date_paiement, montant, mode_reglement)
VALUES (:id_createur, :id_creance, :date_saisie, :date_paiement, :montant, :mode_reglement)
');
$echeances->execute();

$montant= str_replace(',','.',$montant);

$echeances->bindValue(':id_createur',$_SESSION['id'], PDO::PARAM_INT);
$echeances->bindValue(':id_creance',$id_creance, PDO::PARAM_INT);
$echeances->bindValue(':date_saisie',$date_saisie, PDO::PARAM_STR);
$echeances->bindValue(':date_paiement',$date_paiement, PDO::PARAM_STR);
$echeances->bindValue(':montant',$montant, PDO::PARAM_STR);
$echeances->bindValue(':mode_reglement',$mode_reglement, PDO::PARAM_STR);
$echeances->execute();

echo'En cours de création...
<meta http-equiv="refresh" content="1;URL=http://myspacefamily.fr/MaComptaPerso/view/mes-echeances.php">';

}
include('../includes/footer.php');