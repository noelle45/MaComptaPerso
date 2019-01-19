<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
?><div class="row"> <?
include('../includes/banniere-connect.php');
include('../includes/menu.php');
?></div><?

    
    $id = $_GET['id'];
        
        	$query=$db->prepare('SELECT * FROM creances WHERE creance_id=:id');
        	$query->bindValue(':id', $id, PDO::PARAM_INT);
        	$query->execute();
        	$data=$query->fetch();

        	?>
			<div class="card card50 ombre">
              <form method="post" action="echeanceok.php" enctype="multipart/form-data">
              <table style="width:100%>">
                <? echo'<input type="hidden" name="id_createur" id="id_createur" value="'. $_SESSION['id'].'"/></td>
                 <input type="hidden" name="id_creance" id="id_creance" value="'. $id .'"/></td>
                 <input type="hidden" name="date_saisie" id="date_saisie" value="'. date('Y-m-d').'"/></td>';?>
                <tr>
                  <td>Date de réglement</td>
                  <td>Montant</td>
                  <td>Mode de paiement</td>
                 </tr>
                   <tr>
                  <td><input type="date" name="date_paiement" id="date_paiement" /></td>
                  <td><input type="number" name="montant" id="montant" step="0.01" required/></td>
                     <td> 
                       <select name="mode_reglement" id="mode_reglement"> 
                          <option value="CB"> Carte bleue </option> 
                          <option value="CHE"> Chéque </option> 
                          <option value="ESP"> Espéces </option>
                          <option value="PRE"> Prélévement </option>
                          <option value="VIR"> Virement </option>
                          <option value="MAND"> Mandat Cash </option>
                          <option value="ANNUL"> Annulation d'écriture </option>
  						</select>
                     </td>
                 </tr>
              </table>
                <br/><input type="submit" value="Enregistrer"/>
              </form>
			</div>
			<?
    
}
include('../includes/footer.php');