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
            
         //--------------------------------------------------------------------------------       
            echo'<div class="absolute mt-3 pt-2 ml-5 w-20">';
                echo'
                <p class="white2">Créer une nouvelle banque
                </p>
                <a class="white2" href="../creation/crea-banque.php">
                <img style="margin-top:-10px" src="../creation/img/bank-icon.png" alt="icone crea banque" title="Nouvelle banque" width="80px"/>
                </a>';
            echo'</div>';
           
            ?><div class="row"> <?
                include('../includes/banniere-connect.php');
                include('../includes/menu.php');
            ?></div><?
          //-------------------------------------------------------------------------------
            // BODY 
            
            $queryU=$db->prepare('SELECT id_utilisateur FROM compte_utilisateurs WHERE id_utilisateur=:id_createur');
            $queryU->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
            $queryU->execute();
            $dataU = $queryU->fetch();
            $id_utilisateur = $dataU['id_utilisateur'];
            
            
            $queryB=$db->prepare('SELECT nom_banque, id_banque FROM banques WHERE id_createur =:id_createur');
            $queryB->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
            $queryB->execute();
            
            if($id_utilisateur == $_SESSION['id'])
            {
                echo'<div class="row w-100 justify-content-center">';
                    while($bank = $queryB->fetch())
                    {
                        $id_banque= $bank['id_banque'];
                        $nom_banque = $bank['nom_banque'];
                        
                        echo'<div clas="col-3">';
                            echo'<div class="card ombre ml-3 mr-3 p-3">';
                        
                                echo'<p class="stardust">'. $bank['nom_banque'].'</p>';
                                echo'<br/>';

                                $queryC=$db->prepare('SELECT nom_compte, id_compte, id_banque FROM comptes WHERE id_banque =:id_banque');
                                $queryC->bindValue('id_banque', $id_banque, PDO::PARAM_INT);
                                $queryC->execute();

                                while($cpt = $queryC->fetch())
                                {
                                    $id_cpt = $cpt['id_compte'];
                                    if($id_utilisateur == $_SESSION['id'] && $id_banque == $cpt['id_banque'])
                                    {
                                        echo $cpt['nom_compte'];
                                        echo'<br/>';
                                    }
                                }
                        echo'
                        <a href="http://localhost/MaComptaPerso/creation/crea-compte.php?id='.$id_banque.'">
                        <p class="mt-3">Créer un nouveau compte pour <br/>'.$nom_banque.'
                        </p>
                        </a>';
                        
                            echo'</div>';
                        echo'</div>';
                    }
                echo'</div>';
                
                $queryBSN=$db->prepare('SELECT banques.nom_banque AS bank, banques.id_banque AS idbank FROM banques
                LEFT JOIN comptes ON banques.nom_banque = comptes.nom_banque
                WHERE comptes.nom_banque IS NULL');
                $queryBSN->execute();
                
                echo'<div class=row">';
                    echo'<p class="blink">';
                
                while($banque_sans_cpte = $queryBSN->fetch())
                {
                    echo'Votre bank '. $banque_sans_cpte['bank'] .' n\'a pas encore de compte associé';
                }
                echo'</p></div>';
            
         //--------------------------------------------------------------------------------   
          
        }
    }
}
    include('../includes/footer.php');
echo'</div>';