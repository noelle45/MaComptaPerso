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
        $query->closeCursor();

          echo '<p style="text-align:center;margin-top:50px">écriture supprimée! :D <br />
        Redirection automatique';

header('Location: http://localhost/MaComptaPerso/view/voir-compte.php?id='.$id_compte.'/');
exit;

include('../includes/footer.php');