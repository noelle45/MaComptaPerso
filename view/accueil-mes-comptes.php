<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');



if(isset($_SESSION['id']))
{
  include('../includes/banniere-connect.php'); 
  include('../includes/menu.php');
    
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
       echo'<meta http-equiv="refresh" content="0.5;URL=crea-banque.php">';
    }
        
        else
        {
        ?>
        <div style="margin-top:100px"></div>
        <div class="row w-100 justify-content-center mt-5 mb-5 pb-5 h-50">
            <div class="col ml-5">
                <div class="card bg-white-diffu ombre">
                  <?    echo'  <a href="http://myspacefamily.fr/MaComptaPerso/view/budget-mensuel.php?month='.date('m').'&year='.date('Y').'">'; ?>
                  <p class="white2 a-hover-rose bg-orange p-1">Mon budget mensuel</p><br/>
                <img style="margin-top:-10px" src="../creation/img/budget-icon.png" height="100px"></a>
                </div>
            </div>
        
        <br/>
        
            <div class="col">
                <div class="card bg-white-diffu ombre">
                    <a href="mes-comptes.php"><p class="white2 a-hover-rose bg-orange p-1">Mes comptes</p><br/>
                    <img style="margin-top:-10px" src="../creation/img/bank-icon.png" height="100px"></a>
                </div>
            </div> 
        
        <br/>
        
            <div class="col">
                <div class="card bg-white-diffu ombre">
                    <a href="saisir-ecriture.php"><p class="white2 a-hover-rose bg-orange p-1">Saisie rapide d'écriture</p><br/>
                    <img style="margin-top:-10px" src="../creation/img/ecriture-icon.png" height="100px"></a>
                </div>
            </div> 
            
            <br/>
        
            <div class="col">
                <div class="card bg-white-diffu ombre">
                    <a href="mes-echeances.php"><p class="white2 a-hover-rose bg-orange p-1">Mes échéances</p><br/>
                    <img style="margin-top:-10px" src="../creation/img/eche-icon.png" height="100px"></a>
                </div>
            </div> 
        
        <br/>
        
            <div class="col mr-5">
                <div class="card bg-white-diffu ombre">
                    <a href="ma-synthese.php"><p class="white2 a-hover-rose bg-orange p-1">Ma synthèse</p><br/>
                    <img style="margin-top:-10px" src="../creation/img/graph.png" height="100px"></a>
                </div>
            </div> 
        </div>

        <?
        }
}

else
{
  	include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');
echo'</div>';