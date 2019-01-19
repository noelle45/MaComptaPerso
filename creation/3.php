<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

?><div class="row"> <?
include('../includes/banniere-connect.php');
include('../includes/menu.php');
?></div><?

$creance_id = $_POST['creance_id'];
$montant = $_POST['montant'];
$date_saisie = $_POST['date_saisie'];
$id_compte = $_POST['id_compte'];
$objet = $_POST['objet'];
$debit_credit  = $_POST['debit_credit'];
$nom_banque = $_POST['nom_banque'];
$nom_compte = $_POST['nom_compte'];
$date_ecriture = $_POST['date_ecriture'];

$query=$db->prepare('SELECT * FROM creances WHERE creance_id=:creance_id');
$query->bindValue(':creance_id', $creance_id, PDO::PARAM_INT);
$query->execute();
$data=$query->fetch();

$creance_nom = $data['creance_nom'];
$nom_creancier = $data['nom_creancier'];
$montant_echeance = $data['montant_echeance'];
$date_reglement = $data['date_reglement'];
$mode_reglement = $data['mode_reglement'];
$creance_id = $data['creance_id'];    


$cpte=$db->prepare('SELECT * FROM comptes WHERE id_compte=:id_compte');
$cpte->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
$cpte->execute();
$compte=$cpte->fetch();
$nom_compte = $compte['nom_compte'];
$nom_banque = $compte['nom_banque'];
$id_banque = $compte['id_banque'];
    
    

echo'
<div class="row justify-content-center">
<div class="card card50 ml-5 mr-5 mt-5 ombre">
    <p class="typo-simple black size22 text-align-center">
    Echéance à valider
    </p>

    <table class="w-100">
    <tr>
    <th> Créancier </th><td>'.$nom_creancier.'</td>
    </tr>
    <tr>
    <th> Créance </th><td>'.$creance_nom.'</td>
    </tr>
    <tr>
    <th> Date de saisie </th><td>'.$date_saisie.'</td>
    </tr>
    <tr>
    <th> Les échéances prévues sont de </th><td>'.$montant_echeance.' €</td>
    </tr>
    <tr>
    <th> Vous avez saisi une échéance de </th><td>'.number_format($montant, 2, ',', ' ').' €</td>
    </tr>
    <tr>
    <th> Mode réglement </th><td>'.$mode_reglement.'</td>
    </tr>
    <tr>
    <th> Sur votre compte </th><td>'.$nom_compte.' '.$nom_banque.'<br/> ainsi que dans votre tableau d\'amortissement</td>
    </tr>
    </table>

    <p class="typo-simple black">
    Souhaitez-vous valider cette échéance ?
    </p>

';

echo'
 <form action="4.php" method="post" >
<input type="hidden" name="creance_nom" value="'.$creance_nom.'"/>
<input type="hidden" name="nom_creancier" value="'.$nom_creancier.'"/>
<input type="hidden" name="montant_echeance" value="'.$montant_echeance.'"/>
<input type="hidden" name="date_reglement" value="'.$date_reglement.'"/>
<input type="hidden" name="mode_reglement" value="'.$mode_reglement.'"/>
<input type="hidden" name="debit_credit" value="'.$debit_credit.'"/>
<input type="hidden" name="objet" value="'.$objet.'"/>
<input type="hidden" name="creance_id" value="'.$creance_id.'"/>
<input type="hidden" name="montant" value="'.$montant.'"/>
<input type="hidden" name="date_saisie" value="'.$date_saisie.'"/>
<input type="hidden" name="date_ecriture" value="'.$date_ecriture.'"/>
<input type="hidden" name="id_compte" value="'.$id_compte.'"/>
<input type="hidden" name="nom_banque" value="'.$nom_banque.'"/>
<input type="hidden" name="id_banque" value="'.$id_banque.'"/>
<input type="hidden" name="nom_banque" value="'.$nom_compte.'"/>
<input type="hidden" name="creance_id" value="'.$creance_id.'"/>

<input type="submit" value="Créer!" />

     <a href="http://localhost/MaComptaPerso/view/saisir-ecriture.php"> <p class="black bold"> Non </p></a>
</form>
</div>
</div>';

include('../includes/footer.php');
