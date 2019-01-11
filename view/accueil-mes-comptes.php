<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{

    ?><div class="row"> <?
    
    ?></div><?

/*
    $query = $db->prepare('SELECT * FROM banques WHERE id_createur = :id');
    $query->bindValue(':id',$_SESSION['id'], PDO::PARAM_STR);
    $query->execute();
    $data=$query->fetch();

    if($data['id_createur'] == $_SESSION['id'])
    { */
        include('../includes/banniere-connect.php');
        ?>
        <div style="margin-top:100px"></div>
        <div class="row w-100 justify-content-center mt-5 mb-5 pb-5 h-50">
            <div class="col ml-5">
                <div class="card ombre">
                    <a href="budget-mensuel.php"><p class="black a-hover-rose">Mon budget mensuel</p>
                    <img style="margin-top:-10px" src="../creation/img/budget-icon.png" height="100px"></a>
                </div>
            </div>
        
        <br/>
        
            <div class="col">
                <div class="card ombre">
                    <a href="mes-comptes.php"><p class="black a-hover-rose">Mes comptes</p>
                    <img style="margin-top:-10px" src="../creation/img/bank-icon.png" height="100px"></a>
                </div>
            </div> 
        
        <br/>
        
            <div class="col">
                <div class="card ombre">
                    <a href="saisir-ecriture.php"><p class="black a-hover-rose">Saisie rapide d'écriture</p>
                    <img style="margin-top:-10px" src="../creation/img/ecriture-icon.png" height="100px"></a>
                </div>
            </div> 
            
            <br/>
        
            <div class="col">
                <div class="card ombre">
                    <a href="ma-synthese.php"><p class="black a-hover-rose">Mes échéances</p>
                    <img style="margin-top:-10px" src="../creation/img/eche-icon.png" height="100px"></a>
                </div>
            </div> 
        
        <br/>
        
            <div class="col mr-5">
                <div class="card ombre">
                    <a href="ma-synthese.php"><p class="black a-hover-rose">Ma synthèse</p>
                    <img style="margin-top:-10px" src="../creation/img/graph.png" height="100px"></a>
                </div>
            </div> 
        </div>

        <?
   }
 /*  else
    {
        echo'<h2 class="violet pt-5 pb-5">
        <a class="white2" href="http://localhost/MaComptaPerso/creation/crea-banque.php">
        <img src="../creation/img/bank-icon.png" alt="icone crea banque" title="Créer une banque" width="80px"/>
        Commençon par créer une banque </a></h2>';
    } 
} */
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');
echo'</div>';