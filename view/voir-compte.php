<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');
include('../includes/banniere-connect.php');


if(isset($_SESSION['id']))
{
    include('../includes/menu.php');

    $id_compte = isset($_GET['id'])?(int) $_GET['id']:'';

    $query=$db->prepare('SELECT * 
    FROM comptes 
    WHERE id_compte=:id_compte');
    $query->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
    $query->execute();
    $data = $query->fetch();
    $nom_compte = $data['nom_compte'];
    $type_compte = $data['type_compte'];
    $nom_banque = $data['nom_banque'];
    $id_compte = $_GET['id'];

    //---- ECRITURES NON POINTEES ---------------------------
    $queryCNP=$db->prepare('SELECT montant
    FROM ecritures
    WHERE debit_credit="C" 
    AND id_createur=:id
    AND pointer=0
    id_compte=:id_compte');
    $queryCNP->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
    $queryCNP->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
    $queryCNP->execute();

    $queryDNP=$db->prepare('SELECT montant
    FROM ecritures
    WHERE debit_credit="D" 
    AND id_createur=:id
    AND pointer=0
    id_compte=:id_compte');
    $queryDNP->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
    $queryDNP->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
    $queryDNP->execute();

    $DNP = [];
    $CNP = [];

    while($dataCNP=$queryCNP->fetch())
    {$CNP[]=$dataCNP['montant'];}

    while($dataDNP=$queryDNP->fetch())
    {$DNP[]=$dataDNP['montant'];}

    $credits_non_pointer = array_sum($CNP);
    $debits_non_pointer = array_sum($DNP);

    $total_non_pointer = $credits_non_pointer - $debits_non_pointer;

    //---------------------------------------------------------------------------------

    $query=$db->prepare('SELECT SUM(montant) FROM ecritures
    WHERE debit_credit="D" 
    AND id_compte=:id_compte
    AND pointer=1');
    $query->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch();
    $debit = $data[0];

    $query=$db->prepare('SELECT SUM(montant) FROM ecritures
    WHERE debit_credit="C" 
    AND id_compte=:id_compte
    AND pointer=1');
    $query->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch();
    $credit = $data[0];
  
    $solde = ($credit - $debit);
    $solde_final = $solde;

    echo'<div class="row justify-content-center">';
  
  echo'<div class="col-2">';
  
  	$queryLien=$db->prepare('SELECT id_compte, nom_compte, lien FROM comptes
    WHERE id_compte=:id_compte
    AND id_createur=:id_createur');
    $queryLien->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
  	$queryLien->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
    $queryLien->execute();
    $dataLien=$queryLien->fetch();
    $cpte_id = $dataLien['id_compte'];
    $cpte_nom = $dataLien['nom_compte'];
    $cpte_lien = $dataLien['lien'];
  
    if(empty($dataLien['lien']))
       {
        ?>       
            <button type="submit" class="btn btn-primary mt-5" onClick="ouvre('<?php 
            echo '../creation/popup-lien.php?id_compte='.$cpte_id; ?>');return false">
            Ajouter un raccourci vers <br/>
              <?php 
            echo $cpte_nom ; 
            echo'</button>
			<p class="class black italic">Rafraîchir la page</p>
			<a href="http://myspacefamily.fr/MaComptaPerso/view/voir-compte.php?id='.$id_compte.'">
			<img src="http://www.myspacefamily.fr/sections/admin/img/bt-refresh.png" alt="rafraichir" title="rafraîchir la page" height="40px"></a>
            ';
      
        }
        else
        {
           echo'<a class="mb-5" href="' . $cpte_lien . '" target="_blank">';
           echo'<img class="roundedImage mt-5 mr-3 ml-3" src="../creation/img/iconlienb" 
           title="Lien vers votre ' . $cpte_nom . '"><br/>
           <p class="orange bold pt-3" style="background-color:transparent">Lien vers <br/> ' . $cpte_nom . ' </p></a>';
        }
    echo'</div>';
       
        echo'<div class="col-6">';
            echo'<div class="ml-1 mr-1 card ombre bg-white-diffu mt-3 mb-5">';
  
  // icon crea ecriture --------------
	echo'
    <p class="absolute float-left">
        <a href="http://myspacefamily.fr/MaComptaPerso/creation/crea-ecriture.php?nomcpte='.$cpte_nom.'&id='.$id_compte.'">
            <img src="../creation/img/ecriture-icon.png" height="100px" alt="ma synthèse" title="Saisir une écriture"/>
        	<br/><span class="bold" style="color:orange">Saisir une écriture</span></p></a>';
  //-------------------------
  
  
                echo'<p class="typo-simple black">
                <span class="stardust">'.strtolower($nom_banque).'</span><br/>
                <span class="bold">'.strtolower($nom_compte).' '.strtolower($type_compte).'</span></p>';

                $solde_actuel = $solde_final - $total_non_pointer;

                echo'<p class="typo-simple black" style="font-size:25px">
                Solde : 
                <strong> '.number_format($solde_actuel, 2, ',', ' ').' €</strong><br/>
                <i class="italic size12 red bold">Ce solde ne contient que les écritures comptabilisées</i></p>';

                //---------------------------------------------------------------------------------

                $query=$db->prepare('SELECT * FROM ecritures
                ORDER BY date_ecriture DESC LIMIT 0,200');
                $query->execute();
                echo'
                <table style="width:100%">
                <tr>
                <th>Date</th>
                <th>Catégorie</th>
                <th class="text-align-left">Crédit</th>
                <th class="text-align-left">Débit</th>
                <th class="text-align-center">Action</th>
                </tr>';        
                while($data = $query->fetch())
                {
                    if($data['id_createur'] == $_SESSION['id'] && $id_compte == $data['id_compte'])
                    {
                        echo'
                        <tr style="border-top:1px solid #aaaaaa">
                        <td class="size15">' .$data['date_ecriture']. '</td>
                        <td class="size15">' .$data['categorie']. '<br/>
                        ' .$data['objet']. '<br/>
                        ' .$data['mode_reglement']. '
                        </td>
                        <td class="text-left size15">';
                        if($data['debit_credit'] == "C")
                        {
                            echo $data['montant'].' €';
                        }
                        echo'</td>
                        <td class="text-left size15">';
                        if($data['debit_credit'] == "D")
                        {
                            echo $data['montant'].' €';
                        }
                        echo'</td>';
                        echo'<td class="text-align-left">';
                        if($data['pointer']==0)
                        {
                            echo'
                            <form method="post" action="http://myspacefamily.fr/MaComptaPerso/view/pointer.php" enctype="multipart/form-data">
                            <input type="hidden" id="id_ecriture" name="id_ecriture" value="'.$data['id_ecriture'].'">
                            <input type="hidden" id="pointer" name="pointer" value="1">
                            <input type="submit" value="Comptabiliser" />
                            </form>';
                            
                            echo'
                            <form method="post" action="http://myspacefamily.fr/MaComptaPerso/creation/delete-ecriture.php" enctype="multipart/form-data">
                            <input type="hidden" id="id_ecriture" name="id_ecriture" value="'.$data['id_ecriture'].'">
                            <input type="hidden" id="id_ecriture" name="id_compte" value="'.$data['id_compte'].'">
                            <input type="submit" value="Supprimer" />
                            </form>';
                        }
                        elseif($data['pointer']==1)
                        {
                            echo'<p class="text-align-center">
                            <img src="http://www.myspacefamily.fr/sections/budget/img/ok.png" alt="Pointer" title="pointer" height="40px">
                            </p>';
                        }
                        
                        echo'</td>
                        </tr>';
                    }
                }
                echo'</table>
            </div>
        </div>
        
        
<div class="col-4">
<div class="ml-1 mr-1 card ombre bg-white-diffu mt-3 mb-5">';
?>
<div class="accordion" id="accordionExample">
    <div class="card-header bg-green mb-2" id="headingOne">
      
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <p class="white2 typo-simple typo22">Rappel des Charges Fixes</p>
        </button>
      
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body bg-green-diffu">
        <?
  			$query=$db->prepare('SELECT id_createur, COUNT(id_charge)
            AS nbrb
            FROM charges_fixes 
            WHERE id_createur=:id_createur');
            $query->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
            $query->execute();
            $data = $query->fetch();
            $nbrb = $data['nbrb'];
    
            if($data['nbrb']<1)
            {
              echo'<a href="http://myspacefamily.fr/MaComptaPerso/view/budget-mensuel.php?action=creabudget">
              <p class="white2 bold"> Vous n\'avez pas créé de budget... <br/> Créer un budget </p>
              </a>';
            }
  			else
            {
  
                $req=$db->prepare('SELECT * FROM charges_fixes WHERE id_createur=:id_createur_charges AND archive=0');
                $req->bindValue(':id_createur_charges', $_SESSION['id'], PDO::PARAM_INT);
                $req->execute();
                echo'<table class="w-100">
                ';
                while($utilisateur=$req->fetch())
                {
                    
                    if($utilisateur['debit_credit']=="D")
                    {
                        echo'<tr>
                        <td>
                        <a class="white2 a-hover-blanc" href="http://myspacefamily.fr/MaComptaPerso/creation/ajouter-frais-compte.php?action=ajouterEchCpte&idCompte='.$id_compte.'&idEcrit='.$utilisateur['id_charge'].'">
                        <img src="../creation/img/fleche-gauche.png" height="60px" title="Ajouter à vos compte de '.date('M').'">
                        <br/>Ajouter
                        </a>
                        </p>
                        </td>
                        <td class="text-left black size15">' . $utilisateur['objet'] .'</td>
                        <td class="text-right black size15">- '. $utilisateur['montant'] .'</td>
                        <tr>';
                    }
                    else
                    {
                        echo'<tr>
                        <td>
                        <a class="white2 a-hover-blanc" href="http://myspacefamily.fr/MaComptaPerso/creation/ajouter-frais-compte.php?action=ajouterEchCpte&idCompte='.$id_compte.'&idEcrit='.$utilisateur['id_charge'].'">
                        <img src="../creation/img/fleche-gauche.png" height="60px" title="Ajouter à vos compte de '.date('M').'">
                        <br/>Ajouter
                        </a>
                        </p>
                        </td>
                        
                        <td class="text-left black size15">' . $utilisateur['objet'] .'</td>
                        <td class="text-right black size15">+ '. $utilisateur['montant'] .'</td>
                        <tr>';
                    }
                }
            }
                        echo'
                        </table>'
                ?>
              </div>
            </div>
          </div>
        <?
                    echo'</div>';
            
//------------------------------- NOTES

        ?>
        <SCRIPT langage="Javascript">
          function ouvre(fichier) {
          ff=window.open(fichier,"popup",
          "width=600,height=400,left=300,top=350,scrollbars=yes") }
          </SCRIPT>

        <div class="card bg-white-diffu mt-3 ombre">
            <div class="absolute w-100" style="margin-top:-60px;margin-left:20px">
                <div class="relative float-right">
                    <img src="../creation/img/punaiseb.png" alt="mes notes" title="Mes notes" width="140px"/>
                </div>
            </div>
            <p class="stardust text-align-center black">Mes Notes</p>

        <form action="../creation/note_post.php" method="post">
        Saisir une note <br/>
        <input type="note_note" name="note_note" id="note_note" size="30" />
        <input type="submit" value="Envoyer" />
    
        <input type='HIDDEN' name='id_createur' id='id_createur' value=" <?php echo $_SESSION['id']; ?>"/>
        <input type="HIDDEN" name="date_note" id="date_note" value=" <?php echo date('Y-m-d'); ?>" />
        <input type="hidden" name="id_compte" id="id_compte" value=" <?php echo $id_compte; ?> " />
        </form>
        <?php


        $query=$db->prepare('SELECT *
        FROM notes WHERE id_createur=:id ORDER BY id_note DESC');
        $query->bindValue(':id',$_SESSION['id'],PDO::PARAM_INT);
        $query->execute();

        echo'<div class="bg-orange-diffu text-left pl-5 border-radius-zig">';
        while($data = $query->fetch()) 
        {
            if($data['id_createur'] == $_SESSION['id'])
            {
                echo '<p class="mt-3 black size18">' .date('d-m-Y', strtotime($data['date_note'])) . ' 
                &nbsp; &nbsp; <span class="note mt-3 size18">' . $data['note_note'] . '</span></p>';
            }
        }
        echo'</div>';  			
        ?>

        <button type="submit" class="btn btn-primary mt-5" onClick="ouvre('<?php 
        echo '../creation/popup-notes.php'; ?>');return false">
        Trier / supprimer une note
        </button>
         <?   
    		echo'<p class="class black italic">Après supression rafraîchir pour la prise en compte de cette action</p> 
    
        <a href="voir-compte.php?id_compte='.$cpte_id.'"">
        <img src="http://www.myspacefamily.fr/sections/admin/img/bt-refresh.png" alt="rafraichir" title="rafraîchir la page" height="40px"></a>

        </div>
        //---------------------------------------------
        </div>
         </div>';
}

else
{
    echo'
    <meta http-equiv="refresh" content="1;URL=http://myspacefamily.fr/MaComptaPerso/index.phpS">';
}

include('../includes/footer.php');