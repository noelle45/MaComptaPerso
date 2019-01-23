<?php
session_start();
session_destroy();
$titre="Déconnexion";
include("includes/debut.php");
include("includes/menu.php");
if ($id==0){echo'<h2 class="violet center white2 pt-3 pb-3">Deconnection en cours...</h2>';}
?>
<meta http-equiv="refresh" content="1 ; url=http://myspacefamily.fr/MaComptaPerso/index.php">
