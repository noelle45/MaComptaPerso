<?php
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');

$nom_banque = isset($_GET['id'])?(int) $_GET['id']:'';

$query = $db->prepare('SELECT * FROM banques WHERE nom_banque = :nom_banque AND id_createur=:id_createur');
$query->bindValue(':nom_banque',$_GET['id'], PDO::PARAM_STR);
$query->bindValue(':id_createur',$_SESSION['id'], PDO::PARAM_STR);
$query->execute();
$data=$query->fetch();
$id_banque=$data['id_banque'];
    ?>
        <div class="row w-100 justify-content-center">
            <div class="col">
            <form action="crea-compteok.php" method="post" >
                <table class="w-100">
                    
                    <tr>
                        <td class="text-align-center">
                        <div class="row w-100 justify-content-center">
                            <div class="col">
                              <div class="card card50 ombre mt-5 p-5">
                              <form action="crea-compteok.php" method="post" >
                                  <table class="bg-white-diffu">
                                  <p class="orange size22 bold mb-2">Etape 2 : Associez un compte à </p>
                                          <?  echo'<p class="black center stardust pt-3 pb-3">'. $_GET['id'] .'</p>'; ?>
                                    <i style="font-size:12px">Personnalisez son nom afin de le retrouver plus facilement</i>
                    	<tr>
                        <td class="text-align-center">
                            Nom du compte <br/>
                            <input type="text" name="nom_compte" id="type_compte" /><br/><br/>
                            Type de compte <br/>
                            <select name="type_compte">
                                <option>Compte courant</option>
                                <option>Epargne</option>
                            </select><br/>
                            <? echo'<input type="hidden" name="id_banque" id="id_banque" value="'.$id_banque.'"/>';?>
                            <? echo'<input type="hidden" name="nom_banque" id="nom_banque" value="'.$_GET['id'].'"/>';?>
                            <br/><input type="submit" value="Créer!" />
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