<?php
session_start();
echo'<div class="bg-fond">';

include('../includes/connexion-bdd.php');
include('../includes/debut.php');

 $id_compte = isset($_GET['id_compte'])?(int) $_GET['id_compte']:'';
//-------------------------------------------------------------------
$id=$_SESSION['id'];
$query=$db->prepare('SELECT *
FROM comptes WHERE id_createur=:id AND id_compte=:id_compte');
$query->bindValue(':id',$id,PDO::PARAM_INT);
$query->bindValue(':id_compte',$_GET['id_compte'],PDO::PARAM_INT);
$query->execute();
$data=$query->fetch();

$id_compte = $data['id_compte'];
$nom_compte = $data['nom_compte'];

echo'
<div class="card bg-white-diffu">
<p class="black">Ajouter un lien vers '.$nom_compte.'
<form action="crea-lien.php?id_compte='.$_GET['id_compte'].'" method="post" >
Lien de votre banque<br/>
http://<input type="text" name="lien" />
<input type="submit" name="Submit" value="Envoyer">
</form>
</div>
';
//--------------------------------------------------------------------------------
