<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');
?>

<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <p class="black stardust">Rappel des Charges Fixes</p>
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <?
          $req=$db->prepare('SELECT objet, montant, debit_credit FROM charges_fixes WHERE id_createur=:id_createur_charges');
          $req->bindValue(':id_createur_charges', $_SESSION['id'], PDO::PARAM_INT);
          $req->execute();
                echo'<table class="w-100">
                ';
                while($utilisateur=$req->fetch())
                {
                    
                    if($utilisateur['debit_credit']=="D")
                    {
                        echo'<tr>
                        <td class="text-left black">' . $utilisateur['objet'] .'</td>
                        <td class="text-right black">- '. $utilisateur['montant'] .'</td>
                        <tr>';
                    }
                    else
                    {
                        echo'<tr>
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
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <p class="black stardust">Rappel Autres Charges</p>
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
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
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>


<? include('../includes/footer.php');