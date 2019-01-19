<?php
session_start();
echo'<div class="bg-fond">';

include('../includes/connexion-bdd.php');
include('../includes/debut.php');

$note = (int) $_GET['id'];
        
        $query = $db->prepare('DELETE FROM notes WHERE id_note=:id');
        $query->bindValue(':id',$note,PDO::PARAM_INT);
        $query->execute();
        $query->closeCursor();

          echo '<p style="text-align:center;margin-top:50px">Note supprimée! :D <br />
        Redirection automatique';

header('Location: popup-notes.php/');
exit;

include('../includes/footer.php');