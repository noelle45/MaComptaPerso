<?php
session_start();


echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');


 echo'<p class="text-align-center stardust ombre bg-green-diffu white2">Graphique de mes dépenses réelles</p>';
         echo'<div class="card ombre bg-white">';
            include('../creation/graph-perso2.php');
         echo'</div>';

include('../includes/footer.php');