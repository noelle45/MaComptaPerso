<?php
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
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
                        Nom de votre banque <br/>
                        <input type="text" name="nom_banque" id="nom_banque" /><br/><br/>
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