<?
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');
?>
<script langage="javascript">
    function isDOMRequired() 
    {
    // Return false, indicating that this object is available in code view.
    return false;
    }

    function objectTag() 
    {
    return document.body.innerHTML;
    }
</script>
<?
 $id_compte = isset($_GET['id_compte'])?(int) $_GET['id_compte']:'';

$id_compte = $_GET['id_compte'];
$lien = $_POST['lien'];

$query=$db->prepare('UPDATE `comptes` SET `lien`=:lien WHERE id_compte=:id_compte');
$query->bindValue(':id_compte', $_GET['id_compte'], PDO::PARAM_INT);
$query->bindValue(':lien', $_POST['lien'], PDO::PARAM_STR);
$query->execute();
$query->CloseCursor();

$query2=$db->prepare('SELECT `nom_compte` WHERE `id_compte`=:lien WHERE id_compte=:id_compte');
$query2->bindValue(':id_compte', $_GET['id_compte'], PDO::PARAM_INT);
$query2->execute();
$data2=$query2->fetch();


echo'<p class="black">Le lien '.$data2['nom_compte'].' a bien été ajouté</p>'
?>
<input type="submit" name="Submit" value="Fermer la fen&ecirc;tre" onClick="window.close()">
<?
        
       