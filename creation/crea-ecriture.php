<?php
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['mail']))
{

?><div class="row"> <?
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        ?></div><? ?>

    <div class="row w-100 justify-content-center">
        <div class="col">
        <form action="crea-banqueok.php" method="post" >
            <table class="bg-white-diffu">
                <tr>
                    <td class="text-align-center">
                        date de débit <br/>
                        <input type="date" name="date_ecriture" id="date_ecriture" /><br/><br/>
                        Catégorie <br/>
                        <input type="text" name="categorie_ecriture" id="categorie_ecriture" /><br/><br/>
                        Objet <br/>
                        <input type="text" name="objet_ecriture" id="objet_ecriture" /><br/><br/>
                        <input type="checkbox" name="debit" value="1" />Débit
                        
                        <? echo'
                        <input type="hidden" name="id_banque" id="id_banque" value="'.$id_banque.'"/>
                        <input type="hidden" name="nom_banque" id="nom_banque" value="'.$nom_banque.'"/>
                        <input type="hidden" name="id_compte" id="id_compte" value="'.$id_compte.'"/>
                        <input type="hidden" name="nom_compte" id="nom_compte" value="'.$nom_compte.'"/>
                        <input type="hidden" name="id_createur" id="id_createur" value="'.$id_createur.'"/>
                        <input type="hidden" name="date_saisie" id="date_saisie" value="'.date('d-m-Y').'"/>'; ?>
                        
                        <br/><br/>
                        <input type="submit" value="Créer!" />
                    </td>
                <tr>
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