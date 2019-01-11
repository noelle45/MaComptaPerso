<?php
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
    ?><div class="row"> <?
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        ?></div><?
    

$id_banque = isset($_GET['id'])?(int) $_GET['id']:'';

$query = $db->prepare('SELECT * FROM banques WHERE id_banque = :id_banque');
$query->bindValue(':id_banque',$id_banque, PDO::PARAM_INT);
$query->execute();
$data=$query->fetch();
$nom_banque = $data['nom_banque']; 
    
    ?>
        <div class="row w-100 justify-content-center">
            <div class="col">
            <form action="crea-compteok.php" method="post" >
                <table class="bg-white-diffu">
                    <?  echo'<p class="black center stardust pt-3 pb-3">'. $nom_banque .'</p>'; ?>
                    <tr>
                        <td class="text-align-center">
                            Nom du compte <br/>
                            <i>Personnalisez-le afin de le retrouver plus facilement</i><br/>
                            <input type="text" name="nom_compte" id="type_compte" /><br/><br/>
                            Type de compte <br/>
                            <select name="type_compte">
                                <option>Compte courant</option>
                                <option>Epargne</option>
                            </select><br/>
                            <? echo'<input type="hidden" name="id_banque" id="id_banque" value="'.$id_banque.'"/>';?>
                            <? echo'<input type="hidden" name="nom_banque" id="nom_banque" value="'.$nom_banque.'"/>';?>
                            <br/><input type="submit" value="Créer!" />
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