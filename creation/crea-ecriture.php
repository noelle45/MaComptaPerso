<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
    $id_compte = isset($_GET['nomcpte'])?(int) $_GET['id']:'';

    //--- Requete dans comptes pour recup avec id_banque
    $query=$db->prepare('SELECT nom_banque, id_compte, nom_compte, id_createur, id_banque
    FROM comptes
    WHERE id_compte=:id_compte AND id_createur=:id_createur');
  	$query->bindValue(':id_createur',$_SESSION['id'], PDO::PARAM_INT);
    $query->bindValue(':id_compte',$_GET['id'], PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch();
    $nom_compte = $_GET['nomcpte'];
    $id_banque = $data['id_banque'];
    $nom_banque = $data['nom_banque'];
    $id_createur = $data['id_createur'];

        include('../includes/banniere-connect.php');
        include('../includes/menu.php');

      echo'
      <div class="row w-100 justify-content-center">
          <div class="col">
            <div class="card card50 ombre mt-5 p-5">
            <p class="stardust text-align-center gray mt-3"> '. $nom_banque .'  '. $nom_compte .'</p>
            <form action="crea-saisieok.php" method="post" >
                <table class="bg-white-diffu">
                  	<p class="orange size22 bold mb-2">Etape 3 : Saisissez un montant</p>
                    </td>
                </tr>

                <tr>
                    <td class="text-left p-5">
                        date de débit <br/>
                        <input type="date" name="date_ecriture" id="date_ecriture" required/><br/><br/>
                        Catégorie <br/>
                        <select id="categorie" name="categorie" >
                            <option value="Echeance">Echéance créance en cours</option>
                            <option value="Logement">Logement </option> 
                            <option value="Sante"> Sante </option> 
                            <option value="Transport"> Transport </option>
                            <option value="Impots"> Impôts </option>
                            <option value="Epargne"> Epargne </option>
                            <option value="Loisir"> Loisir </option>
                            <option value="Alimentation"> Alimentation </option>
                            <option value="Retrait"> Retrait espèces </option>
                            <option value="Telephone_mobile"> Téléphone/Mobile/Fixe </option>
                            <option value="ADSL_cable"> ADSL/Câble/Fibre </option>
                            <option value="Animaux"> Animaux </option>
                            <option value="Scolaire"> Scolaire </option>
                            <option value="Vie_quotidienne_autre_achat"> Vie quotidienne autre achat </option>
                            <option value="Vetements"> Vêtements </option>
                            <option value="Frais_fixe"> Frais fixe </option>
                            <option value="Frais_banquaire"> Frais banquaire </option>
                            <option value="Frais_professionnels"> Frais professionnels </option>
                            <option value="Ressources"> Ressources </option>
                            <option value="Cadeaux"> Cadeaux </option>
                            <option value="Autre"> Autre </option>
                        </select><br/><br/>
                        Objet <br/>
                        <input type="text" name="objet" id="objet" required/><br/><br/>
                        Montant <br/>
                        <input type="number" name="montant" id="montant" step="0.01" required/><br/><br/>
                        Type d\'opération<br/>
                        <select id="debit_credit" name="debit_credit" >
                            <option value="D">Débit </option>
                            <option value="C">Crédit </option>
                        </select>
                        <br/><br/>
                        Mode de réglement <br/>
                        <select id="mode_reglement" name="mode_reglement" >
                            <option value="CB">Carte bleue</option>
                            <option value="CHQ">Chéque </option> 
                            <option value="ESP"> Espéce </option>
                            <option value="PRE"> Prélevement </option>
                            <option value="VIR"> Virement </option>
                            <option value="MAND"> Mandat </option>
                            <option value="AUT"> Autre </option>
                        </select>

                        <input type="hidden" name="id_banque" id="id_banque" value="'.$id_banque.'"/>
                        <input type="hidden" name="nom_banque" id="nom_banque" value="'.$nom_banque.'"/>
                        <input type="hidden" name="id_compte" id="id_compte" value="'.$id_compte.'"/>
                        <input type="hidden" name="nom_compte" id="nom_compte" value="'.$nom_compte.'"/>
                        <input type="hidden" name="id_createur" id="id_createur" value="'.$id_createur.'"/>
                        <input type="hidden" name="date_saisie" id="date_saisie" value="'.date("Y-m-d H:i:s").'"/>
                        <br/><br/>
                        <input type="submit" value="Créer!" />
                    </td>
                </tr>
             </table>
          </form>
       </div>
   </div>
   </div>';
    
}
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');
echo'</div>';