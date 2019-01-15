<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
    $id_compte = isset($_GET['id'])?(int) $_GET['id']:'';

    //--- Requete dans comptes pour recup avec id_banque
    $query=$db->prepare('SELECT nom_banque, id_compte, nom_compte, id_createur, id_banque
    FROM comptes
    WHERE id_compte=:id_compte');
    $query->bindValue(':id_compte',$id_compte, PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch();
    $nom_compte = $data['nom_compte'];
    $id_banque = $data['id_banque'];
    $nom_banque = $data['nom_banque'];
    $id_createur = $data['id_createur'];

?><div class="row"> <?
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        ?></div><? ?>
    <div class="row w-100 justify-content-center">
        <div class="col">
        <form action="crea-saisieok.php" method="post" >
            <table class="bg-white-diffu ombre" style="width:600px">
                <tr>
                    <td>
                        <? echo'<p class="stardust text-align-center black mt-3"> '. $nom_banque .'  '. $nom_compte .'</p>' ?>
                    </td>
                </tr>

                <tr>
                    <td class="text-left p-5">
                        date de débit <br/>
                        <input type="date" name="date_ecriture" id="date_ecriture" required/><br/><br/>
                        Catégorie <br/>
                        <select id="categorie" name="categorie" >
                            <option value="Logement">Logement </option> 
                            <option value="Sante"> Sante </option> 
                            <option value="Transport"> Transport </option>
                            <option value="Impots"> Impôts </option>
                            <option value="Epargne"> Epargne </option>
                            <option value="Loisir"> Loisir </option>
                            <option value="Alimentation"> Alimentation </option>
                            <option value="Animaux"> Animaux </option>
                            <option value="Scolaire"> Scolaire </option>
                            <option value="Vie quotidienne autre achat"> Vie quotidienne autre achat </option>
                            <option value="Vêtements"> Vêtements </option>
                            <option value="Frais fixe"> Frais fixe </option>
                            <option value="Frais banquaire"> Frais banquaire </option>
                            <option value="Frais professionnels"> Frais professionnels </option>
                            <option value="Ressources"> Ressources </option>
                            <option value="Cadeaux"> Cadeaux </option>
                            <option value="Autre"> Autre </option>
                        </select><br/><br/>
                        Objet <br/>
                        <input type="text" name="objet" id="objet" required/><br/><br/>
                        Montant <br/>
                        <input type="number" name="montant" id="montant" step="0.01" required/><br/><br/>
                        Type d'opération<br/>
                        <select id="debit_credit" name="debit_credit" >
                            <option value="D">Débit </option>
                            <option value="C">Crédit </option>
                        </select>
                        <? 
    
                        echo'
                        <input type="hidden" name="id_banque" id="id_banque" value="'.$id_banque.'"/>
                        <input type="hidden" name="nom_banque" id="nom_banque" value="'.$nom_banque.'"/>
                        <input type="hidden" name="id_compte" id="id_compte" value="'.$id_compte.'"/>
                        <input type="hidden" name="nom_compte" id="nom_compte" value="'.$nom_compte.'"/>
                        <input type="hidden" name="id_createur" id="id_createur" value="'.$id_createur.'"/>
                        <input type="hidden" name="date_saisie" id="date_saisie" value="'.date("Y-m-d H:i:s").'"/>'; ?>
                        
                        <br/><br/>
                        <input type="submit" value="Créer!" />
                    </td>
                </tr>
                </table>
            </form>
            </div>
    </div>
    <?php       
}
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');
echo'</div>';