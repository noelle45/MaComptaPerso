<?php
session_start();
echo'<div class="bg-fond">';

include('../includes/connexion-bdd.php');
include('../includes/debut.php');

$id = $_POST['id_ecriture'];
$id_compte = $_POST['id_compte'];
        
        $query = $db->prepare('DELETE FROM ecritures WHERE id_ecriture=:id');
        $query->bindValue(':id',$id,PDO::PARAM_INT);
        $query->execute();



echo '<div class="card card5 mt-5"><p style="text-align:center;margin-top:50px">écriture supprimée! :D <br />
Redirection automatique</p></div>
<meta http-equiv="refresh" content="1;URL=http://myspacefamily.fr/MaComptaPerso/view/voir-compte.php?id='.$id_compte.'">';

include('../includes/footer.php');