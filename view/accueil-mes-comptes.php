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
        ?><div class="row"> <?
            include('../includes/banniere-connect.php');
            include('../includes/menu.php');
            ?></div>
        
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