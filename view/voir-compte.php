<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{

$id_compte = isset($_GET['id'])?(int) $_GET['id']:'';
                  
$query=$db->prepare('SELECT * 
FROM comptes 
WHERE id_compte=:id_compte');
$query->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
$query->execute();
$data = $query->fetch();
$nom_compte = $data['nom_compte'];
$type_compte = $data['type_compte'];
$nom_banque = $data['nom_banque'];
    
echo'
<p class="absolute float-left black" style="margin-top:300px;margin-left:250px">
<a href="http://localhost/MaComptaPerso/creation/crea-ecriture.php?id='.$id_compte.'">
<img src="../creation/img/ecriture-icon.png" height="100px" alt="ma synthèse" title="Saisir une écriture"/>
</a>
Saisir une écriture
</p>';

    
?><div class="row"> <?
include('../includes/banniere-connect.php');
include('../includes/menu.php');
?></div><?


 // ---- SOLDE ----------------------------------------------------------------- 

$query=$db->prepare('SELECT SUM(montant) FROM ecritures
WHERE debit_credit="D" AND id_compte=:id_compte');
$query->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
$query->execute();
$data=$query->fetch();
$debit = $data[0];
        
$query=$db->prepare('SELECT SUM(montant) FROM ecritures
WHERE debit_credit="C" AND id_compte=:id_compte');
$query->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
$query->execute();
$data=$query->fetch();
$credit = $data[0];
$solde = ($credit - $debit);
$solde_final = number_format($solde, 2, ',', ' ');

echo'<div class="card ombre bg-white-diffu mt-3 mb-5" style="width:1200px">';
    
echo'<p class="typo-simple black"> Banque : '.$nom_banque.'<br/>Compte : '.$nom_compte.' / '.$type_compte.'</p>';
    
echo'<p class="typo-simple black" style="font-size:25px">Solde : <strong> '. $solde_final .' €</strong><span></p>';

//---------------------------------------------------------------------------------

$query=$db->prepare('SELECT * FROM ecritures
ORDER BY date_ecriture DESC LIMIT 0,60');
$query->execute();
echo'
 <table style="width:100%">
<tr>
<th>Date</th>
<th>Catégorie</th>
<th>Objet</th>
<th class="text-align-center">Crédit</th>
<th class="text-align-center">Débit</th>
<th class="text-align-center">Pointer</th>
</tr>';        
while($data = $query->fetch())
{
if($data['id_createur'] == $_SESSION['id'] && $id_compte == $data['id_compte'])
{
echo'
<tr style="border-top:1px solid #aaaaaa">
<td>' .$data['date_ecriture']. '</td>
<td>' .$data['categorie']. '</td>
<td>' .$data['objet']. '</td>
<td class="text-right">';
if($data['debit_credit'] == "C")
{
echo $data['montant'].' €';
}
echo'</td>
<td class="text-right">';
if($data['debit_credit'] == "D")
{
echo $data['montant'].' €';
}
echo'</td>';
echo'<td class="text-align-center">';
if($data['pointer']==0)
{
echo'
<form method="post" action="http://localhost/MaComptaPerso/view/pointer.php" enctype="multipart/form-data">
<input type="hidden" id="id_ecriture" name="id_ecriture" value="'.$data['id_ecriture'].'">
<input type="checkbox" id="pointe" name="pointe" value="1">
<input type="submit" value="ok" />
</form>';
}
elseif($data['pointe']==1){
echo'<img src="http://www.myspacefamily.fr/sections/budget/img/ok.png" alt="Pointer" title="pointer" height="40px">';
}
echo'</td>
</tr>';
}
}
echo'</table></div></div>';
}