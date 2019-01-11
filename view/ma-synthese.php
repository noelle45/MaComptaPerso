<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
    include('../includes/banniere-connect.php');
    include('../includes/menu.php');
    echo'<p>Ma synthèse</p>';
}

else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}



include('../includes/footer.php');
echo'</div>';