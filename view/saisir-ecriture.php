<?php
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
?>
<div class="row">
<? include('../includes/banniere-connect.php');
include('../includes/menu.php'); ?>
</div>



    <div class="row w-100 justify-content-center">
        <div class="col">
        <form action="../creation/crea-ecritureok.php" method="post" >
            <table class="bg-white-diffu">
                <tr>
                    <td class="">
                        date de débit <br/>
                        <input type="date" name="date_ecriture" id="date_ecriture" />
                </tr>
                <tr>
                    <td>
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
                                </select>
                    </td>
                    <td>
                        Objet <br/>
                        <input type="text" name="objet_ecriture" id="objet_ecriture" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-align-center">
                        <input type="checkbox" name="debit" value="1" checked/>Débit 
                        <input type="checkbox" name="credit" value="1" />Crédit
                    </td>
                </tr>
                <tr>
                    <td>
                        <?
 
                        $query1=$db->prepare('SELECT * FROM comptes');
                        //$query1->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
                        $query1->execute();
                        //$data1 = $query1->fetch();
                        
                        echo'Compte
                        <br/>
                        <select name="nom_compte">';
                        while($data1 = $query1->fetch())
                        { 
                            if($data1['id_createur']==$_SESSION['id'])
                            {
                                echo'<option>'; 
                                echo $data1['nom_compte'];
                                echo'</option>';
                            }
                        }
                        echo'</select>';
                        
                        echo'
                        <input type="hidden" name="date_saisie" id="date_saisie" value="'.date('Y-m-d').'"/>
                        '; ?>
                    </td>
                    <tr>
                        <td colspan="2" class="text-align-center">
                            <input type="submit" value="Créer!"/>
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
    include('../includes/menu.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');