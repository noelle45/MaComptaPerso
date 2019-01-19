<?php
session_start();
echo'<div class="bg-fond">';

include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{

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

    echo'
    <p class="absolute float-left black" style="margin-top:15px;margin-left:100px">
        <a class="black bold" href="http://localhost/MaComptaPerso/creation/crea-ecriture.php?id='.$id_compte.'">
            <img src="../creation/img/ecriture-icon.png" height="100px" alt="ma synthèse" title="Saisir une écriture"/>
        <span class="black bold">Saisir une écriture</span></p></a>';


    ?><div class="row"> <?
    include('../includes/banniere-connect.php');
    include('../includes/menu.php');
    ?></div><?



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
        echo'<div class="col-6">';
            echo'<div class="ml-3 mr-3 card ombre bg-white-diffu mt-3 mb-5">';

                echo'<p class="typo-simple black"> <span class="stardust">'.$nom_banque.'</span><br/><span class="bold">'.$nom_compte.' || '.$type_compte.'</span></p>';

                $solde_actuel = $solde_final - $total_non_pointer;

                echo'<p class="typo-simple black" style="font-size:25px">Solde : <strong> '.number_format($solde_actuel, 2, ',', ' ').' €</strong><span></p>';

                //---------------------------------------------------------------------------------

                $query=$db->prepare('SELECT * FROM ecritures
                ORDER BY date_ecriture DESC LIMIT 0,60');
                $query->execute();
                echo'
                <table style="width:100%">
                <tr>
                <th>Date</th>
                <th>Catégorie</th>
                <th>Objet</th>
                <th class="text-align-center">Crédit</th>
                <th class="text-align-center">Débit</th>
                <th class="text-align-center">Action</th>
                </tr>';        
                while($data = $query->fetch())
                {
                    if($data['id_createur'] == $_SESSION['id'] && $id_compte == $data['id_compte'])
                    {
                        echo'
                        <tr style="border-top:1px solid #aaaaaa">
                        <td>' .$data['date_ecriture']. '</td>
                        <td>' .$data['categorie']. '</td>
                        <td>' .$data['objet']. '</td>
                        <td class="text-right">';
                        if($data['debit_credit'] == "C")
                        {
                            echo $data['montant'].' €';
                        }
                        echo'</td>
                        <td class="text-right">';
                        if($data['debit_credit'] == "D")
                        {
                            echo $data['montant'].' €';
                        }
                        echo'</td>';
                        echo'<td class="text-align-center">';
                        if($data['pointer']==0)
                        {
                            echo'
                            <form method="post" action="http://localhost/MaComptaPerso/view/pointer.php" enctype="multipart/form-data">
                            <input type="hidden" id="id_ecriture" name="id_ecriture" value="'.$data['id_ecriture'].'">
                            <input type="hidden" id="pointer" name="pointer" value="1">
                            <input type="submit" value="Comptabiliser" />
                            </form>';
                            
                            echo'
                            <form method="post" action="http://localhost/MaComptaPerso/creation/delete-ecriture.php" enctype="multipart/form-data">
                            <input type="hidden" id="id_ecriture" name="id_ecriture" value="'.$data['id_ecriture'].'">
                            <input type="hidden" id="id_ecriture" name="id_ecriture" value="'.$data['id_compte'].'">
                            <input type="submit" value="Supprimer" />
                            </form>';
                        }
                        elseif($data['pointer']==1)
                        {
                            echo'<img src="http://www.myspacefamily.fr/sections/budget/img/ok.png" alt="Pointer" title="pointer" height="40px">';
                        }
                        
                        echo'</td>
                        </tr>';
                    }
                }
                echo'</table>
            </div>
        </div>
        
        
<div class="col-4">
<div class="card mt-3 mt-3 ombre bg-white-diffu">';
?>
<div class="accordion" id="accordionExample">
    <div class="card-header bg-green mb-2" id="headingOne">
      
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <p class="black typo-simple typo22">Rappel des Charges Fixes</p>
        </button>
      
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body bg-green-diffu">
        <?
          $req=$db->prepare('SELECT * FROM charges_fixes WHERE id_createur=:id_createur_charges');
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
                        <p class="bg-green border-radius-zig text-align-center p-1 size12" style="border:0.5px solid gray">
                        
                        <a class="white2 a-hover-blanc" href="voir-compte.php?action=ajouterEchCpte&idCompte='.$id_compte.'&idEcrit='.$utilisateur['id_charge'].'">
                        Ajouter l\'échéance <br/>de '.date('M').'
                        </a>
                        </p>
                        </td>
                        <td class="text-left black">' . $utilisateur['objet'] .'</td>
                        <td class="text-right black">- '. $utilisateur['montant'] .'</td>
                        <tr>';
                    }
                    else
                    {
                        echo'<tr>
                        <td>
                        <p class="bg-green border-radius-zig text-align-center p-1 size12" style="border:0.5px solid gray">
                        
                        <a class="white2 a-hover-blanc" href="voir-compte.php?action=ajouterEchCpte&id='.$id_compte.'">
                        Ajouter l\'échéance <br/>de '.date('M').'
                        </a>
                        </p>
                        </td>
                        
                        <td class="text-left black">' . $utilisateur['objet'] .'</td>
                        <td class="text-right black">+ '. $utilisateur['montant'] .'</td>
                        <tr>';
                    }
                }
                echo'
                </table>'
        ?>
      </div>
    </div>


    <div class="card-header bg-green" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <p class="black typo-simple size122">Rappel Autres Charges</p>
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body bg-green-diffu">
          <?
            $req2=$db->prepare('SELECT objet, montant, debit_credit FROM autres_charges WHERE id_createur=:id_createur_charges');
            $req2->bindValue(':id_createur_charges', $_SESSION['id'], PDO::PARAM_INT);
            $req2->execute();
            echo'<table class="w-100">
                ';
                while($utilisateur2=$req2->fetch())
                {
                    
                    if($utilisateur2['debit_credit']=="D")
                    {
                        echo'<tr>
                        <td class="text-left black">' . $utilisateur2['objet'] .'</td>
                        <td class="text-right black">- '. $utilisateur2['montant'] .'</td>
                        <tr>';
                    }
                    else
                    {
                        echo'<tr>
                        <td class="text-left black">' . $utilisateur2['objet'] .'</td>
                        <td class="text-right black">+ '. $utilisateur2['montant'] .'</td>
                        <tr>';
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
        echo '<p class="mt-3 black size22">' .date('d-m-Y', strtotime($data['date_note'])) . ' &nbsp; &nbsp; <span class="note mt-3 size22">' . $data['note_note'] . '</span></p>';
    }
}
echo'</div>';  			
?>
   
<button type="submit" class="btn btn-primary mt-5" onClick="ouvre('<?php 
echo '../creation/popup-notes.php'; ?>');return false">
Trier / supprimer une note
</button>
    
    <p class="class black italic">Après supression d'une note, rafraîchir la page en cliquant sur le bouton ci-dessous pour la prise en compte de cette action</p> 
    
<a href="voir-compte.php">
<img src="http://www.myspacefamily.fr/sections/admin/img/bt-refresh.png" alt="rafraichir" title="rafraîchir la page" height="40px"></a>

</div>
//---------------------------------------------
</div>
 </div>
<?
}

else
{
    header("Location: http://localhost/MaComptaPerso/index.php");
}

include('../includes/footer.php');