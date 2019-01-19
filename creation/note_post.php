<?php
session_start();
echo'<div class="bg-fond">';

include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{

$id_compte = $_POST['id_compte'];

$req = $db->prepare('INSERT INTO notes (id_createur, date_note, note_note) VALUES(?, ?, ?)');
$req->execute(array($_POST['id_createur'], $_POST['date_note'], $_POST['note_note']));


header('Location: http://localhost/MaComptaPerso/view/voir-compte.php?id='.$id_compte.'');
exit;
}

include('../includes/footer.php');