<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');
include('../includes/banniere-connect.php');


if(isset($_SESSION['id']))
{
    include('../includes/menu.php');
$query=$db->prepare('SELECT id_createur, COUNT(id_banque)
AS nbrb
FROM banques 
WHERE id_createur=:id_createur');
$query->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$query->execute();
$data = $query->fetch();
$nbrb = $data['nbrb'];

if($data['nbrb']<1)
{

echo'<div class="row mx-auto h-50">';
echo'<div class="card ombre card50 p-5">';
echo'<p class="mb-5">Commençons par créer une banque</p><br/>
<a class="white2" href="../creation/crea-banque.php">
<img class="mt-3" src="../creation/img/bank-icon.png" alt="icone crea banque" title="Nouvelle banque" width="150px"/>
</a>';
echo'</div>';
echo'</div>';

}

else
{
//----------------- CONSULTER --------------------------------------------------

$action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'consultcreance';

switch($action)
{ 
 case "consultcreance":
        
echo'<div style="fixed:top;margin-top:-50px">
<p class="black bold mt-5 p-3 bg-green-diffu">
<a class="black" href="http://myspacefamily.fr/MaComptaPerso/view/mes-echeances.php?action=ajoutercreance"> 
Créer un nouvel échéancier</p>
</a>
</div>';
        
$query=$db->prepare('SELECT * FROM creances ');
//$query->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$query->execute();

$headind = 0;
$collapse = 0;
        
echo'<div class="row justify-content-center h-100">';
    while($creance=$query->fetch())
    {
        if($creance['id_createur']==$_SESSION['id'])
        {
            $headind ++;
            $collapse ++;
            $creance_id = $creance['creance_id'];
            $creance_nom = $creance['creance_nom'];
            $montant_depart = $creance['montant_depart'];
            $nom_creancier = $creance['nom_creancier'];
            $creance_nom = $creance['creance_nom'];


            echo'<div clas="col-4">';
                 echo'<div class="accordion" id="accordionExample">';
                    echo'<div class="card-header mt-5 mr-3 bg-white-diffu ombre" style="border: 1px dashed orange; width:200px" id="heading'.$headind.'">';

                        echo'<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse'.$collapse.'" aria-expanded="true" aria-controls="collapse'.$collapse.'">';

                            echo'<p class="black bold">'.$creance_nom.'<br/>'.$nom_creancier.'</p>';

                        echo'</button>';
                    echo'</div>';
                echo'</div>';

        echo'<div id="collapse'.$collapse.'" class="collapse" aria-labelledby="heading'.$headind.'" data-parent="#accordionExample">';

            echo'<div class="card-body bg-orange-diffu">';

    //-----------------------------------------------------------------------
                $query2=$db->prepare('SELECT * FROM echeances WHERE id_creance=:creance_id ORDER BY date_paiement DESC');
                $query2->bindValue(':creance_id', $creance_id, PDO::PARAM_INT);
                $query2->execute();

                echo'
                    <table class="w-100">
                      <tr>
                        <th>
                          Nom du créantier
                        </th>
                        <th>
                          Nom de la créance
                        </th>
                        <th>
                          Montant de départ
                        </th>
                      </tr>
                      <tr class="bold">
                      <tr>
                      <td colspan="3"></td>
                      </tr>
                      <tr class="bold size18">
                        <td>'.$nom_creancier.'</td>
                          <td>'.$creance_nom.'</td>
                          <td class="text-right">'.number_format($montant_depart, 2, ',', ' ').' €</td>
                      </tr>
                        <tr>
                          <td class="bg-green-diffu bold white2">Mes échéances</td>
                          <td class="bg-green-diffu white2 text-align-center"></td>
                          <td class="bg-green-diffu white2 text-right"><strong>Solde restant dû</strong></td>
                        </tr>
                    </table>

                      <table class="w-100">
                        <tr>
                          <th>
                            date de saisie
                          </th>
                          <th>
                            date de paiement
                          </th>
                          <th>
                            Montant
                          </th>
                          <th>
                            Mode de réglement
                          </th>
                          <th>

                          </th>
                        </tr>';

                while($echeance=$query2->fetch())
                {
                    echo'
                        <tr>
                          <td>'.$echeance['date_saisie'].'</td>
                          <td>'.$echeance['date_paiement'].'</td>
                          <td>'.number_format($echeance['montant'], 2, ',', ' ').' €</td>
                          <td>'.$echeance['mode_reglement'].'</td>
                          <td></td>
                        </tr>';
                }
                        echo'<tr>
                            <td class="bg-green-diffu bold white2">SOLDE RESTANT DÛ</td>
                            <td class="bg-green-diffu"></td>
                            <td class="bg-green-diffu"></td>
                            <td class="bg-green-diffu"></td>';

                          $query3=$db->prepare('SELECT SUM(montant) FROM echeances WHERE id_creance=:id_creance');
                          $query3->bindValue(':id_creance', $creance_id, PDO::PARAM_INT);
                          $query3->execute();
                          $data3=$query3->fetch();
                          $somme = $data3[0];
                          $solde = ($montant_depart - $somme);
                          $solde_final = number_format($solde, 2, ',', ' ');

                          echo'<td class="text-align-center bg-green-diffu bold size18 white2"><strong> '. $solde_final .' €</strong></td>
                        </tr>
                      </table>';
                        
                    echo'<p class="bg-blue white2 p-2 bold mt-5"><a class="white2 a-hover-blanc" href="../creation/crea-echeance.php?id='.$creance_id.'">Saisir une échéance qui ne soit pas comptabilisée en banque</a></p>';

    //------------------------------------------------------------------------
            echo'</div>'; 
        echo'</div>';
    echo'</div>';
    }
    }
echo'</div>';

break;

 //---------------------------------- AJOUTER -------------------------------------------------

$action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'ajoutercreance';

case "ajoutercreance":
?>
    <div class="row justify-content-center">
        <div class="card ombre">
        <form method="post" action="http://localhost/MaComptaPerso/view/mes-echeances.php?action=creacreance" enctype="multipart/form-data">
            
        <table style="width:100%">
        <? echo'
         <input type="hidden" name="date_creation" id="date_creation" value="'. date('Y-m-d h:i:s').'"/>';?>
            <tr>
                <th>Nom de la créance</th>
                <td><input type="text" name="creance_nom" id="creance_nom" required /></td>
                <th>Nom du Créancier</th>
                <td><input type="text" name="nom_creancier" id="nom_creancier" required /></td>
                <th>Montant de départ</th>
                <td><input type="number" name="montant_depart" id="montant_depart" step="0.01" required /></td>
            </tr>
            
            <tr>
                <th>Montant de l'échéance</th>
                <td><input type="number" name="montant_echeance" id="montant_echeance" step="0.01" required /></td>
                <th>Jour de paiement (jj)</th>
                <td><input type="text" name="date_reglement" id="date_reglement" size="2" required /></td>
                <th>Mode de réglement</th>
                <td>
                    <select id="mode_reglement" name="mode_reglement" >
                        <option value="VIR"> Virement </option>
                        <option value="PRE"> Prélément </option>
                        <option value="CHE"> Chéque </option>
                        <option value="CB"> Carte Bleue </option>
                        <option value="ESP"> Espèces </option>
                        <option value="MAN"> Mandat </option>
                        <option value="Autre"> Autre </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    A partir de :
                    <select id="mois_prem_prel" name="mois_prem_prel" >
                        <option value="01"> Janvier </option>
                        <option value="02"> Février </option>
                        <option value="03"> Mars </option>
                        <option value="04"> Avril </option>
                        <option value="05"> Mai </option>
                        <option value="06"> Juin </option>
                        <option value="07"> Juillet </option>
                        <option value="08"> Août </option>
                        <option value="09"> Septembre </option>
                        <option value="10"> Octobre </option>
                        <option value="11"> Novembre </option>
                        <option value="12"> Décembre </option>
                    </select> 2019
                </td>
            </tr>
        </table>
        <br/><input type="submit" value="Enregistrer"/>
        </form>
         <br/> <i> Note : Si vous avez plusieurs créances chez un même créancier 
        <br> Donnez-lui un nom différent de celui du créancier afin de la retrouver plus facilement</i>
        </div>
    </div>
        <?

 break;
//-------------------------------------------------------------------------------
$action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'creacreance';

case "creacreance":

    $id_createur = (int) $_SESSION['id'];
    $date_creation = $_POST['date_creation'];
    $creance_nom = $_POST['creance_nom'];
    $nom_creancier = $_POST['nom_creancier'];
    $montant_depart = (float) $_POST['montant_depart'];
    $montant_echeance = (float) $_POST['montant_echeance'];
    $date_reglement = $_POST['date_reglement'];
    $mode_reglement = $_POST['mode_reglement'];
    $mois_prem_prel = $_POST['mois_prem_prel'];

    $montant_depart= str_replace(',','.',$montant_depart);
    $montant_echeance = str_replace(',','.',$montant_echeance);

    $query=$db->prepare('INSERT INTO `creances`
    (`date_creation`,`id_createur`, `creance_nom`, `nom_creancier`, `montant_depart`, `montant_echeance`, `date_reglement`, `mode_reglement`, `mois_prem_prel`)
    VALUES (:date_creation, :id_createur, :creance_nom, :nom_creancier, :montant_depart, :montant_echeance, :date_reglement, :mode_reglement, :mois_prem_prel)');
    $query->bindValue(':date_creation', $date_creation, PDO::PARAM_STR);
    $query->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
    $query->bindValue(':creance_nom', $creance_nom, PDO::PARAM_STR);
    $query->bindValue(':nom_creancier', $nom_creancier, PDO::PARAM_STR);
    $query->bindValue(':montant_depart', $montant_depart, PDO::PARAM_STR);
    $query->bindValue(':montant_echeance', $montant_echeance, PDO::PARAM_STR);
    $query->bindValue(':date_reglement', $date_reglement, PDO::PARAM_INT);
    $query->bindValue(':mode_reglement', $mode_reglement, PDO::PARAM_STR);
    $query->bindValue(':mois_prem_prel', $mois_prem_prel, PDO::PARAM_STR);
    $query->execute();

    $nbr_echeances = $montant_depart / $montant_echeance;

    echo '<div class="card pt-5 bg-white-diffu"> <p class="black size18">Votre nouvelle créance '.$creance_nom.' pour le créancier '.$nom_creancier.' a bien été enregistrée<br/>
    Montant total de '. number_format($montant_depart, 2, ',', ' ') .' €<br/>
    Des échéances de '. number_format($montant_echeance, 2, ',', ' ') .' €<br/>
    Réglement prévu le '. $date_reglement .' du mois.<br/>
    <br/>
    Soit : ' . number_format($nbr_echeances, 2, ',', ' ') . ' écheances.
    <br><br>
    <a class="black size18" href="http://localhost/MaComptaPerso/view/mes-echeances.php?action=consultcreance"> Retour aux créances </a></p></div>';

    break;

 //------------------------------------- voir ---------------------------------------------------
 $action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'voircreance';

case "voircreance":
$id = isset($_GET['id'])?(int) $_GET['id']:'';

$query=$db->prepare('SELECT * FROM creances WHERE creance_id=:id ');
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();
$data = $query->fetch();

$query=$db->prepare('SELECT * FROM creances WHERE creance_id=:id ');
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();

 

 while($data = $query->fetch())
{
$id_creance = $data['creance_id'];
$montant_depart = number_format($data['montant_depart'], 2, ',', ' ');
$montant_dep = $data['montant_depart'];
 
if($data['id_createur'] == $_SESSION['id'])
{
 ?>

<div class="card card50 ombre mt-5">
 <table class="tableau" style="width:100%">
<tr>
<th>
Nom du créantier
</th>
<th>
Nom de la créance
</th>
<th>
Montant de départ
</th>
</tr>
<tr>
<td><? echo $data['nom_creancier']; ?></td>
<td><? echo $data['creance_nom']; ?></td>
<td class="text-right"><? echo $montant_depart; ?> €</td>
</tr>
<tr>
<td class="bg-danger white2"></td>
<td class="bg-danger white2 text-align-center">Mes échéances</td>
<td class="bg-danger white2 text-right"><strong>Solde restant dû</strong></td>
</tr>
</table>

<table style="width:100%">
<tr>
<th>
date de saisie
</th>
 <th>
date de paiement
</th>
<th>
 Montant
</th>
 <th>
Mode de réglement
</th>
<th>
 
</th>
</tr> <?
$query=$db->prepare('SELECT * FROM echeances WHERE id_creance=:id ORDER BY date_paiement ASC');
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();

 while($data = $query->fetch())
{
 $montant = number_format($data['montant'], 2, ',', ' ');
?>
<tr>
<? echo'<td>'.$data['date_saisie'].'</td>
<td>'.$data['date_paiement'].'</td>
<td>'.$montant.' €</td>
 <td>'.$data['mode_reglement'].'</td>
<td></td>'; ?>
</tr><?
}?>
<tr>
<td class="bg-danger"></td>
<td class="bg-danger"></td>
<td class="bg-danger"></td>
<td class="bg-danger"></td><?

$query=$db->prepare('SELECT SUM(montant) FROM echeances WHERE id_creance=:id_creance');
$query->bindValue(':id_creance', $id_creance, PDO::PARAM_INT);
$query->execute();
$data=$query->fetch();
$somme = $data[0];
$solde = ($montant_dep - $somme);
$solde_final = number_format($solde, 2, ',', ' ');

echo'<td class="text-align-center bg-danger white2"><strong> '. $solde_final .' €</strong></td>'; ?>
</tr>
</table>
</div>
<div style="margin-top:50px"></div><?
}
 
 } // while voir creance

 break; 
    

} // switch action
//--------------------------------------------------------------------------------

} // else pas de banque
} // if isset session

else
{
include('../includes/banniere.php');
echo'Vous n\'êtes pas connecté';
}

echo'</div>';
include('../includes/footer.php');
