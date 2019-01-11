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
        
        $query2=$db->prepare('SELECT id_createur, COUNT(id_compte)
        AS nbrc
        FROM comptes 
        WHERE id_createur=:id_createur');
        $query2->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
        $query2->execute();
        $data2 = $query2->fetch();
        $nbrb2 = $data2['nbrc'];
    
        $query3=$db->prepare('SELECT banques.nom_banque AS bank, banques.id_banque AS idbank FROM banques
        LEFT JOIN comptes ON banques.nom_banque = comptes.nom_banque
        WHERE comptes.nom_banque IS NULL');
        $query3->execute();
        
        $query4=$db->prepare('SELECT banques.nom_banque AS bank, banques.id_banque AS idbank FROM banques
        LEFT JOIN comptes ON banques.nom_banque = comptes.nom_banque
        WHERE comptes.nom_banque IS NULL');
        $query4->execute();
        $data4=$query4->fetch();
        if(empty($data4))
        {
          echo'';
        }
                
       else
        {
           if($data2['id_createur']==$_SESSION['id']){
            echo'<div class="row w-100">';
                echo'<div class="col-3 offset-10">';
                    echo'<div class="absolute mt-3 pt-2">';
                        echo'<p class="blink white2 text-right"> Votre banque<br/>';
                            while($data3 = $query3->fetch())
                            {
                                echo' <a class="blink white2" href="http://localhost/MaComptaPerso/creation/crea-compte.php?id='.$data3['idbank'].'">'. $data3['bank'].
                                '</a><br/>';
                            }
                            echo'n\'a pas de compte associé';
                        echo'</p>';
                    echo'</div>';
                echo'</div>';
            echo'</div>';
           }
        }
    //card
    echo'<div class=" absolute mt-3 pt-2 ml-5 w-20">';
    echo'<p class="white2">Créer une nouvelle banque</p>
    <a class="white2" href="../creation/crea-banque.php">
    <img style="margin-top:-10px" src="../creation/img/bank-icon.png" alt="icone crea banque" title="Nouvelle banque" width="80px"/>
    </a>';
    //--/card
    echo'</div>';

        ?><div class="row"> <?
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        ?></div><?

            $query=$db->prepare('SELECT * FROM comptes
            NATURAL JOIN banques
            ');
            $query->execute();
        
            echo'<div class="row ml-3 mr-3">';
         		while($data = $query->fetch())
                {
                  if($data['id_createur'] == $_SESSION['id'])
            		{
                    echo'
                    <div class="col-3">
                        <div class="card bg-white-diffu ombre mt-3 mb-3">
                  			<p class="stardust black">'.$data['nom_banque'].'</p>';
                    
                    		$id_banque=$data['id_banque'];
                  
                    		$query2=$db->prepare('SELECT * FROM comptes WHERE id_banque=:id_banque');
                            $query2->bindValue(':id_banque', $id_banque, PDO::PARAM_INT);
                            $query2->execute();
                    		$data2=$query2->fetch();
                    		$id_compte = $data2['id_compte'];
                    
                    		$query3=$db->prepare('SELECT SUM(montant) FROM ecritures
                            WHERE debit=1 AND id_compte=:id_compte');
                            $query3->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
                            $query3->execute();
                            $data3=$query3->fetch();
                            $debit = $data3[0];

                            $query4=$db->prepare('SELECT SUM(montant) FROM ecritures
                            WHERE debit=0 AND id_compte=:id_compte');
                            $query4->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
                            $query4->execute();
                            $data4=$query4->fetch();
                            $credit = $data4[0];
                  
                            $solde = ($credit - $debit);
                            $solde_final = number_format($solde, 2, ',', ' ');

                  
                            echo'<div class="violet">';
                  			echo'<p class="titre-script"> <strong> '. $solde_final .' €</strong></p>';
                    		
                    		$id_banque=$data['id_banque'];
                    		$query5=$db->prepare('SELECT COUNT(`pointe`),`id_ecriture`,`id_banque` 
                            FROM `ecritures` 
                            WHERE `id_banque`=:id_banque AND `pointe`=0');
                            $query5->bindValue(':id_banque', $id_banque, PDO::PARAM_INT);
                            $query5->execute();
                    		$data5=$query5->fetch();
                    		
                      echo'<p>Vous avez actuellement '.$data5[0].' écriture(s) non pointée(s)</p>';
                      echo'</div>';
                      
                      echo'<a href="http://localhost/MaComptaPerso/creation/crea-compte.php?id='.$data['id_banque'].'">
                      <br/><i class="mt-3">Créer un nouveau compte pour '. $data['nom_banque'] .'</i>
                      </a><br/>';
//================================================================================================================
                        $query25=$db->prepare('SELECT * 
                        FROM comptes  WHERE id_banque=:id_banque');
                    	$query25->bindValue(':id_banque', $id_banque, PDO::PARAM_INT);
                        $query25->execute();
                        while($data25 = $query25->fetch())
                        {
                            echo'
                            <br/>
                            <div class="mt-3"></div>
                            <a href="http://www.myspacefamily.fr/sections/budget/mensuel.php?action=voirecritures&id='.$data25['id_compte'].'">
                            <p style="color:#900C3F">
                            <img src="http://www.myspacefamily.fr/sections/evenements/img/go.png" alt="go" title="go!" height="20px" >  
                            <strong>'.$data25['nom_compte'].' '.$data25['type_compte'].'</strong>
                            </p>
                            </a>
                            <br/>';
                         }
                          //  }
//================================================================================================================
                    echo'</div>';
                    echo'</div>';
                    
                  }
                }
        echo' </div>';
    }
    include('../includes/footer.php');
echo'</div>';