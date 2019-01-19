<?php
session_start();
echo'<div class="bg-fond">';
    include('../includes/connexion-bdd.php');
    include('../includes/debut.php');

    if(isset($_SESSION['id']))
    {
//---------- FIRST CONNEXION CREATE BANK ------------------------------------------
        
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
            
            //------- ICON CREATE BANK --------------
            
            echo'<div class="row mx-auto h-50">';
                echo'<div class="card ombre card50 p-5 bg-white-diffu">';
                    echo'<p class="mb-5">Commençons par créer une banque</p><br/>
                    <a class="white2" href="../creation/crea-banque.php">
                    <img class="mt-3" src="../creation/img/bank-icon.png" alt="icone crea banque" title="Nouvelle banque" width="150px"/>
                    </a>';
                echo'</div>';
            echo'</div>';
            
        }
//--------------------------------------------------------------------------------      
        else
        {
            
//---------------------------- ICON CREATE NEW BANK ------------------------------     
            
            echo'<div class="absolute mt-3 pt-2 ml-5 w-20">';
                echo'
                <p class="white2">Créer une nouvelle banque
                </p>
                <a class="white2" href="../creation/crea-banque.php">
                <img style="margin-top:-10px" src="../creation/img/bank-icon.png" alt="icone crea banque" title="Nouvelle banque" width="80px"/>
                </a>';
            echo'</div>';
            
 //-------------------------- HEADER ----------------------------------------     
            
            ?><div class="row"> <?
                include('../includes/banniere-connect.php');
                include('../includes/menu.php');
            ?></div><?
//--------------------------- BODY --------------------------------------------
            
            $queryU=$db->prepare('SELECT id_utilisateur FROM compte_utilisateurs WHERE id_utilisateur=:id_createur');
            $queryU->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
            $queryU->execute();
            $dataU = $queryU->fetch();
            $id_utilisateur = $dataU['id_utilisateur'];
            
            $queryB=$db->prepare('SELECT nom_banque, id_banque 
            FROM banques WHERE id_createur =:id_createur');
            $queryB->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
            $queryB->execute();
            
            if($id_utilisateur == $_SESSION['id'])
            {
                
//------- IF BANK WITHOUT COMPT ------------------------------------------------
                
                $queryBSN=$db->prepare('SELECT banques.nom_banque AS bank, banques.id_banque AS idbank 
                FROM banques
                LEFT JOIN comptes ON banques.nom_banque = comptes.nom_banque
                WHERE comptes.nom_banque IS NULL');
                $queryBSN->execute();
                $test = $queryBSN ->fetch();
                if(!empty($test))
                {
                    $queryBSN->execute();
                    echo'<p class="blink bg-white-diffu p-3 mt-0">
                    Votre banque';
                    while($banque_sans_cpte = $queryBSN->fetch())
                    {
                        echo'<br/><a href="http://localhost/MaComptaPerso/creation/crea-compte.php?id='.$banque_sans_cpte['idbank'].'"><strong>'. $banque_sans_cpte['bank'] .'</strong></a>, ';
                    }
                    echo'<br/>n\'a pas encore de compte associé';
                }
                
 //--------- VIEW ALL BANKS -----------------------------------------------------------  
                
                echo'<div class="row w-100 justify-content-center mt-5">';
                    while($bank = $queryB->fetch())
                    {
                        $id_banque= $bank['id_banque'];
                        $nom_banque = $bank['nom_banque'];
                        
                        echo'<div clas="col-3">';
                            echo'<div class="card ombre ml-3 mr-3 p-3 bg-white-diffu">';
                        
                                echo'<p class="stardust">'. $bank['nom_banque'].'</p>';
                                echo'<br/>';
                        
                       
                        $query5=$db->prepare('SELECT COUNT(`pointer`),`id_ecriture`,`id_banque` 
                        FROM `ecritures` 
                        WHERE `id_banque`=:id_banque AND `pointer`=0');
                        $query5->bindValue(':id_banque', $id_banque, PDO::PARAM_INT);
                        $query5->execute();
                        $data5=$query5->fetch();
                    		
                        echo'<p class="black">Vous avez actuellement '.$data5[0].' écriture(s) non pointée(s)';
                        
                    
 // ---- TOTAL BALANCE BANK ----------------------------------------------------------------- 
                        
            $queryC1=$db->prepare('SELECT nom_compte, id_compte, id_banque 
            FROM comptes WHERE id_banque =:id_banque');
            $queryC1->bindValue('id_banque', $id_banque, PDO::PARAM_INT);
            $queryC1->execute();
            $dataC1 = $queryC1->fetch();
            $id_compte = $dataC1['id_compte'];
                        
            $queryDE=$db->prepare('SELECT SUM(montant) FROM ecritures
            WHERE debit_credit="D" 
            AND id_banque=:id_banque
            AND pointer=1');
            $queryDE->bindValue(':id_banque', $id_banque, PDO::PARAM_INT);
            $queryDE->execute();
            $dataDE=$queryDE->fetch();
            $debit = $dataDE[0];

            $queryCR=$db->prepare('SELECT SUM(montant) FROM ecritures
            WHERE debit_credit="C" 
            AND id_banque=:id_banque
            AND pointer=1');
            $queryCR->bindValue(':id_banque', $id_banque, PDO::PARAM_INT);
            $queryCR->execute();
            $dataCR=$queryCR->fetch();
            $credit = $dataCR[0];
                        
            $solde = ($credit - $debit);
            $solde_final = number_format($solde, 2, ',', ' ');
            
             echo'<p class="typo-simple black" style="font-size:25px">Solde au '.date('d-m-y').' <br/> <strong> '. $solde_final .' €</strong><span></p>
             <p class="black">Sur la totalité de vos comptes '.$nom_banque;
                        
// -------- TOTAL BALANCE CPTE ----------------------------------------------------------------------            
                        
            $queryC=$db->prepare('SELECT nom_compte, id_compte, id_banque 
            FROM comptes WHERE id_banque =:id_banque');
            $queryC->bindValue('id_banque', $id_banque, PDO::PARAM_INT);
            $queryC->execute();

            while($cpt = $queryC->fetch())
            {
                $id_cpt = $cpt['id_compte'];
                
                $queryDE2=$db->prepare('SELECT SUM(montant) FROM ecritures
                WHERE debit_credit="D" AND id_compte=:id_compte');
                $queryDE2->bindValue(':id_compte', $id_cpt, PDO::PARAM_INT);
                $queryDE2->execute();
                $dataDE2=$queryDE2->fetch();
                $debit2 = $dataDE2['SUM(montant)'];

                $queryCR2=$db->prepare('SELECT SUM(montant) FROM ecritures
                WHERE debit_credit="C" AND id_compte=:id_compte');
                $queryCR2->bindValue(':id_compte', $id_cpt, PDO::PARAM_INT);
                $queryCR2->execute();
                $dataCR2=$queryCR2->fetch();
                $credit2 = $dataCR2['SUM(montant)'];
                
                $solde2 = ($credit2 - $debit2);
                $solde_final2 = number_format($solde2, 2, ',', ' ');
                                    
               
                
//--------------- VIEW CPT PER BANK -------------------------------------------------------------------
                        
                        echo'<p class="violet mb-3">
                        <a class="white2 bold size22" href="voir-compte.php?id='.$cpt['id_compte'].'">';
                        echo $cpt['nom_compte'];
                        echo'</a></p>';
                        
                        if($solde_final2<0)
                        {
                            echo'<p class="red bold size18">' .$solde_final2. ' €</p>';
                        }
                        else
                        {
                            echo'<p class="blue bold size18">' .$solde_final2. ' €</p>';
                        }
                        echo'<br/>';
                        
            }
//--------------------------- LINK CREATE NEW COMPT ----------------------------------------------------
            echo'
            <a href="http://localhost/MaComptaPerso/creation/crea-compte.php?id='.$id_banque.'">
            <p class="mt-3 black bg-green-diffu border-radius-zig p-3">
            Créer un nouveau compte <br/> pour votre banque <br/><span class="bold">'.$nom_banque.'</span>
            </p>
            </a>';
                        
            echo'</div>';
        echo'</div>';
    }

echo'</div>';

 //----------- END BODY --------------------------------------------------------------------   
          
        }
    }
}
else
{
    header("Location: http://localhost/MaComptaPerso/index.php");
}
    include('../includes/footer.php');
echo'</div>';