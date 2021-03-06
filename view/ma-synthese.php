<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
    $query=$db->prepare('SELECT id_createur, COUNT(id_banque)
        AS nbrb
        FROM banques 
        WHERE id_createur=:id_createur');
        $query->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
        $query->execute();
        $data = $query->fetch();
        $nbrb = $data['nbrb'];
    
        if($data['nbrb']<1)
        {
            ?><div class="row"> <?
            include('../includes/banniere-connect.php');
            include('../includes/menu.php');
            ?></div><?
            
            echo'<div class="row mx-auto h-50">';
                echo'<div class="card ombre card50 p-5">';
                    echo'<p class="mb-5">Commençons par créer une banque</p><br/>
                    <a class="white2" href="../creation/crea-banque.php">
                    <img class="mt-3" src="../creation/img/bank-icon.png" alt="icone crea banque" title="Nouvelle banque" width="150px"/>
                    </a>';
                echo'</div>';
            echo'</div>';
            
        }
        
        else
        {   
            echo'<div class="row">';
                include('../includes/banniere-connect.php');
                include('../includes/menu.php');
            echo'</div>';
//------------------------------------------------------------------
            echo'<div class="row w-100 h-100 p-5 mt-5">';

                 echo'<div class="col-6">';
                    echo'
                    <p class="text-align-center stardust ombre bg-green-diffu white2">Graphique de mon prévisionnel</p>';
                    echo'<div class="card ombre bg-white">';
                        include('../creation/graph-budget.php');
                    echo'</div>'; // card
                 echo'</div>'; // col

                 echo'<div class="col-6">';
                    echo'
                    <p class="text-align-center stardust ombre bg-green-diffu white2">Graphique de mes dépenses réelles</p>';
                    echo'<div class="card ombre bg-white">';
                        include('../creation/graph-perso2.php');
                    echo'</div>'; // card
                echo'</div>'; // col

            echo'</div>'; // row
        }
}

else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}


include('../includes/footer.php');
