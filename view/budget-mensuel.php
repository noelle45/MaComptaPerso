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
    WHERE id_createur=:id_createur
    ');
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
        echo'<div class="card ombre card50 p-2">';
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
        ?></div><?

        $table = ['01'=>'Janvier','02'=>'Février', '03'=>'Mars', '04'=>'Avril', '05'=>'Mai', '06'=>'Juin', '07'=>'Juillet', '08'=>'Août', '09'=>'Septembre', '10'=>'Octobre', '11'=>'Novembre', '12'=>'Décembre'];

        $action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'view';
        $month = (isset($_GET['month']))?htmlspecialchars($_GET['month']):'';
        $year = (isset($_GET['year']))?htmlspecialchars($_GET['year']):'';

        switch($action)
        {
            case "view":
            ?>
            <div class="card bg-white-diffu center">
            <form action="budget-mensuel.php?action=view&month=month&year=year">
            <table style="margin-top:-20px">
            <tr>
            <td>
            <select id="month" name="month" >
            <option value="00">Mois </option>
            <option value="01">Janvier </option> 
            <option value="02"> Février </option> 
            <option value="03"> Mars </option>
            <option value="04"> Avril </option>
            <option value="05"> Mai </option>
            <option value="06"> Juin </option>
            <option value="07"> Juillet </option>
            <option value="08"> Août </option>
            <option value="09"> Septembre </option>
            <option value="10"> Octobre </option>
            <option value="11"> Novembre </option>
            <option value="12"> Décembre </option>
            </select>
            </td>
            <td>
            <select id="year" name="year" >
            <option value="01">Année </option>
            <option value="2019">2019 </option> 
            </select>
            </td>
            <td>
            <input type="submit" value="ok" />
            </td>
            </tr>
            </table>
            </form>
            <?

            if(!empty($_GET['month']))
            {
                echo'<p class="typo-simple black size18 mb-3">'.$table[$month].' '.$year.'</p>';

                //--- AFFICHAGE DES CPTES ECRITURES DE MES COMPTES --------------------
                
                $query=$db->prepare('SELECT * FROM ecritures
                WHERE id_createur=:id_createur
                ORDER BY date_ecriture ASC
                ');
                $query->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
                $query->execute();

echo'<div class="row justify-content-center ml-1 mr-1" style="">';
    echo'<div class="col-4">';
            echo'<div class="card ombre bg-orange-diffu">';
                    echo'<h2 class="bg-orange p-3 white2 stardust">Mes Dépenses Réelles</h2>';
                
                        echo'<div class="mt-3 pt-3 bg-orange">';
                        echo'<a class="white2 a-hover-blanc" href="mes-comptes.php><p class="white2 a-hover-blue">
                        Voir mes comptes</p></a>
                        </div>';
                
                        echo'<table class="w-100">
                            <tr style="border-top:1px solid gray">
                                <th class="size15">
                                    Objet
                                </th>
                                <th class="size15">
                                    Débit
                                </th>
                                <th class="size15">
                                    Crédit
                                </th>
                            </tr>';
                
                            $tCredit = [];
                            $tDebit = [];
                
                            while($data=$query->fetch())
                            {
                                $date = $data['date_ecriture'];
                                $date_replace = str_replace('-', ' ',$date);
                                $date_explode = explode(" ",$date_replace);
                                $month_date = $date_explode[1];
                                $year_date = $date_explode[0];

                                if($year_date == $_GET['year'] && $month_date == $_GET['month'])
                                {
                                    echo'
                                    <tr style="border-top:1px solid gray">
                                        <td class="size15">'
                                            .$data['categorie'].'<br/>'.$data['objet'].'<br/>'.$data['nom_banque'].'<br/>
                                        </td>
                                        <td class="size15">';
                                            if($data['debit_credit']=="D")
                                            {
                                                $dataJolieDebit = number_format($data['montant'], 2, ',', ' ');
                                                echo $dataJolieDebit.' €';
                                                $tDebit[] = $data['montant'];
                                            }
                                        echo'</td>
                                        <td class="size15">';
                                            if($data['debit_credit']=="C")
                                            {
                                                $dataJolieCredit = number_format($data['montant'], 2, ',', ' ');
                                                echo $dataJolieCredit.' €';
                                                $tCredit[] = $data['montant'];
                                            }
                                        echo'</td>
                                    </tr>';                
                                        }
                                    }
                                    $totalCredit = array_sum($tCredit);
                                    $totalDebit = array_sum($tDebit);
                                    $res = ($totalCredit-$totalDebit);
                                    $res = number_format($res, 2, ',', ' ');

                                    echo'
                                    <tr style="border-top:1px solid gray">
                                        <td class="violet white2 size18"><strong>
                                            Total</strong>
                                        </td>
                                        <td class="violet white2 size18">
                                            <strong>'.number_format($totalDebit, 2, ',', ' ').' € </strong>
                                        </td>
                                        <td class="violet white2 size18">
                                            <strong>'.number_format($totalCredit, 2, ',', ' ').' €</strong>
                                        </td>
                                    </tr>';
                            echo'</table>';
                
                            if($res >= 0)
                            {
                                echo'<div class="mt-3 border-radius-zig pt-3 bg-orange">';
                                echo'<a class="white2 a-hover-blanc" href="" style="font-size:25px"><p class="white2 a-hover-blue">SOLDE au '. date('d-m-Y').'<br/><strong>'.$res.' € </p></strong></a>
                                </div>';
                            }
                            else
                            {
                                echo'<div class="mt-3 border-radius-zig pt-3 bg-red">';
                                echo'<a class="white2 a-hover-blanc" href="" style="font-size:25px"><p class="white2 a-hover-blue">SOLDE au '. date('d-m-Y').'<br/><strong>'.$res.' € </p></strong></a>
                                </div>'; 
                            }
                        echo'</div>';   
                    echo'</div>';
                
//-------------- PREVISIONNEL ---------------------------------------------------------------------  
                            
                    //requette budgets
                    $query_budgets=$db->prepare('SELECT *
                    FROM budgets 
                    WHERE id_createur=:id');
                    $query_budgets->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                    $query_budgets->execute();
                            
                    echo'<div class="col-4">
                        <div class="accordion" id="accordion">';

                            $headind = 0;
                            $collapse = 0;
                
                            while($data_budgets=$query_budgets->fetch())
                            {
                                $headind ++;
                                $collapse ++;

                            echo'
                            <div class="card-header bg-green-diffu" id="heading'.$headind.'">
                            <h2 class="mb-0 bg-green">

                            <button class="btn btn-link bg-green" type="button" data-toggle="collapse" data-target="#collapse'.$collapse.'" aria-expanded="true" aria-controls="collapse'.$collapse.'">'; 

                            $nom_budget=$data_budgets['nom_budget'];
                            $id_budget=$data_budgets['id_budget'];
                            $id_createur=$data_budgets['id_createur'];
                            echo'<h2 class="p-3 bg-green white2 stardust">
                            Mon Prévisionnel '. $nom_budget .'<h2>
                            </button>
                            </h2>
                            </div>
                                          
                            <div id="collapse'.$collapse.'" class="collapse" aria-labelledby="heading'.$headind.'" data-parent="#accordion">
                                <div class="card-body bg-green-diffu">';

                                //requete voir charges fixes
                                $query_charges = $db ->prepare('SELECT * 
                                FROM charges_fixes 
                                WHERE id_createur=:id_createur
                                AND archive=0
                                ORDER BY date_saisie ASC');
                                $query_charges->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
                                $query_charges->execute();

                                echo'<table class="w-100">';
                                    echo'<tr>';
                                        echo'<th colspan="5">';
                                            echo'<p  class="black size15">Charges fixes</p>';
                                        echo'</th>';
                                    echo'</tr>';

                                    echo'<tr>';
                                        echo'<th class="black size15">';
                                            echo'Catégorie';
                                        echo'</th>';

                                        echo'<th class="black size15">';
                                            echo'Objet';
                                        echo'</th class="black size15">';

                                        echo'<th class="black size15">';
                                            echo'Débit';
                                        echo'</th>';

                                        echo'<th class="black size15">';
                                            echo'Crédit';
                                        echo'</th>';
                                    echo'</tr>';

                                    while($data_charges=$query_charges->fetch())
                                    {
                                        if($data_charges['id_budget']==$id_budget)
                                        {
                                            echo'<tr>';
                                                echo'<td>';
                                                    echo'<p class="black size15">' . $data_charges['categorie'] . '</p>';
                                                echo'</td>';

                                                echo'<td>';
                                                    echo'<p class="black size15">' . $data_charges['objet'] . '</p>';
                                                echo'</td>';

                                                echo'<td>';
                                                    if($data_charges['debit_credit']=="D")
                                                    {
                                                        echo'<p class="black size15">' . $data_charges['montant'] . '</p>';
                                                    }
                                                echo'</td>';

                                                echo'<td>';
                                                    if($data_charges['debit_credit']=="C")
                                                    {
                                                        echo'<p class="black size15">' . $data_charges['montant'] . '</p>';
                                                    }
                                                echo'</td>';

                                            echo'</tr>';
                                        }
                                    }
                                echo'</table>';

                                echo'<div class="mt-3 p-3 bg-green">';
                                echo'<a class="white2 a-hover-blanc" href="budget-mensuel.php?action=creaprev&budget='.$id_budget.'">
                                <p class="white2 a-hover-blue">Ajouter une charge ou une ressource</p></a>
                                </div>
                                </div>
                                </div>';
                        
}
echo'</div>
</div>';
//echo'</div>';
                
                
                
 /*                          echo'<div class="col-4">';
                             echo'<div class="card ombre bg-green-diffu">';
                                
                              $nom_budget=$data_budgets['nom_budget'];
                                $id_budget=$data_budgets['id_budget'];
                                $id_createur=$data_budgets['id_createur'];
                                
                                echo'<h2 class="bg-green p-3 white2 stardust">Mon Prévisionnel '. $nom_budget .'<h2>';
                                
                                //requete voir charges fixes
                                $query_charges = $db ->prepare('SELECT * 
                                FROM charges_fixes 
                                WHERE id_createur=:id_createur
                                AND archive=0
                                ORDER BY date_saisie ASC');
                                $query_charges->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
                                $query_charges->execute();
                                
                                        echo'<table class="w-100">';
                                            echo'<tr>';
                                                echo'<th colspan="5">';
                                                    echo'<p  class="black size15">Charges fixes</p>';
                                                echo'</th>';
                                            echo'</tr>';
                                        
                                            echo'<tr>';
                                                echo'<th class="black size15">';
                                                    echo'Catégorie';
                                                echo'</th>';
                                        
                                                echo'<th class="black size15">';
                                                    echo'Objet';
                                                echo'</th class="black size15">';
                                        
                                                echo'<th class="black size15">';
                                                    echo'Débit';
                                                echo'</th>';
                                        
                                                echo'<th class="black size15">';
                                                    echo'Crédit';
                                                echo'</th>';
                                            echo'</tr>';
                            
                                while($data_charges=$query_charges->fetch())
                                {
                                    if($data_charges['id_budget']==$id_budget)
                                    {
                                            echo'<tr>';
                                                echo'<td>';
                                                        echo'<p class="black size15">' . $data_charges['categorie'] . '</p>';
                                                    echo'</td>';

                                                    echo'<td>';
                                                        echo'<p class="black size15">' . $data_charges['objet'] . '</p>';
                                                    echo'</td>';
                                                    echo'<td>';
                                                if($data_charges['debit_credit']=="D")
                                                {
                                                        echo'<p class="black size15">' . $data_charges['montant'] . '</p>';
                                                }
                                                    echo'</td>';
                                                    echo'<td>';
                                                if($data_charges['debit_credit']=="C")
                                                {
                                                        echo'<p class="black size15">' . $data_charges['montant'] . '</p>';
                                                }
                                                    echo'</td>';
                                            echo'</tr>';
                                    }
                                }
                                 echo'</table>';
                                
                                echo'<div class="mt-3 p-3 bg-green">';
                                echo'<a class="white2 a-hover-blanc" href="budget-mensuel.php?action=creaprev&budget='.$id_budget.'">
                                <p class="white2 a-hover-blue">Ajouter une charge ou une ressource</p></a>
                                </div>';
                                
                                echo'</div>';
                                echo'</div>';
                            }
                                
                            
                            
/*                          

                                                        <tr style="border-top:1px solid gray">
                                                        <th colspan="4" class="size15 bg-green text-align-center">
                                                        Charges fixes et/ou Ressources fixes
                                                        </th>
                                                        </tr>
                                                        <tr style="border-top:1px solid gray">
                                                        <th class="size15">Objet</th>
                                                        <th class="size15">Débit</th>
                                                        <th class="size15">Crédit</th>
                                                        <th></th>
                                                        </tr>
                                                        ';
                
                                                            echo'
                                                            <tr style="border-top:1px solid gray">
                                                            <td class="size15">' . $data_charges['categorie'] .'<br/>'. $data_charges['objet'] . '</td>
                                                            <td class="size15">';
                                                            if($data_charges['debit_credit']=="D")
                                                            {
                                                                echo number_format($data_charges['montant'], 2, ',', ' ') . ' €';
                                                                $tDebit1[] = $data_charges['montant'];
                                                            }
                                                            echo'</td>
                                                                <td class="size15">';
                                                            if($data_charges['debit_credit']=="C")
                                                            {
                                                                echo number_format($data_charges['montant'], 2, ',', ' ') . ' €';
                                                                $tCredit1[] = $data_charges['montant'];
                                                            }
                                                            echo'</td>
                                                            <td><p class="bg-green border-radius-zig text-align-center p-1 size12" style="border:0.5px solid gray"><a class="white2 a-hover-blanc" href="budget-mensuel.php?action=archiverCF&id='.$data_charges['id_charge'].'">Archiver</a></p></td>
                                                            </tr>';
                                                        }
                                                }
                                                        $totalCredit1 = array_sum($tCredit1);
                                                        $totalDebit1 = array_sum($tDebit1);
                                                        $res1 = ($totalCredit1-$totalDebit1);
                                                        $res1 = number_format($res1, 2, ',', ' ');

                                                        echo'</tr>
                                                        <tr style="border-top:1px solid gray">
                                                        <th class="size15 bg-green"><strong>
                                                        Total</strong>
                                                        </th>
                                                        <td class="size15 bg-green"><strong>
                                                        ' .number_format($totalDebit1, 2, ',', ' ').' €</strong>
                                                        </td>
                                                        <td class="size15 bg-green"><strong>
                                                        '.number_format($totalCredit1, 2, ',', ' ').' €</strong>
                                                        </td>
                                                        <td class="size15 bg-green text-align-center">
                                                        Solde <br/><span class="size15"><strong>'.$res1.' €</strong></span>
                                                        </td>
                                                        </tr>
                                                        </table>';
                                    
                                    
                                    //requete voir autres charges
                                    $query_autres_charges = $db ->prepare('SELECT * 
                                    FROM autres_charges 
                                    WHERE id_createur=:id_createur
                                    AND archive=0
                                    ORDER BY date_saisie ASC');
                                    $query_autres_charges->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
                                    //$query_autres_charges->bindValue(':id_budget', $id_budget, PDO::PARAM_INT);
                                    $query_autres_charges->execute();
    
                                    $tCredit2 = [];
                                    $tDebit2 = [];
                
                                    while($data_autres_charges=$query_autres_charges->fetch())
                                    {
                                        if($id_budget == $data_autres_charges['id_budget']) 
                                        {
                                        echo'<table class="w-100">
                                        <tr style="border-top:1px solid gray">
                                        <th colspan="4" class="size15 bg-green text-align-center">
                                        Autres charges et/ou ressources
                                        </th>
                                        </tr>
                                        <tr style="border-top:1px solid gray">
                                        <th class="size15">Objet</th>
                                        <th class="size15">Débit</th>
                                        <th class="size15">Crédit</th>
                                        <th></th>
                                        </tr>
                                        ';

                                            echo'
                                            <tr style="border-top:1px solid gray">
                                            <td class="size15">' . $data_autres_charges['categorie'] .'<br/>'. $data_autres_charges['objet'] . '</td>
                                            <td class="size15">';
                                            if($data_autres_charges['debit_credit']=="D")
                                            {
                                                echo number_format($data_autres_charges['montant'], 2, ',', ' ') . ' €';
                                                $tDebit2[] = $data_autres_charges['montant'];
                                            }
                                            echo'</td>
                                            <td class="size15">';
                                            if($data_autres_charges['debit_credit']=="C")
                                            {
                                                echo number_format($data_autres_charges['montant'], 2, ',', ' ') . ' €';
                                                $tCredit2[] = $data_autres_charges['montant'];
                                            }
                                            echo'</td>
                                            <td><p class="bg-green border-radius-zig text-align-center p-1 size12"><a class="white2 a-hover-blanc" href="budget-mensuel.php?action=archiverAC&id='.$data_autres_charges['id_charge'].'">Archiver</a></p></td>
                                            </tr>';
                                        }

                                        $totalCredit2 = array_sum($tCredit2);
                                        $totalDebit2 = array_sum($tDebit2);
                                        $res2 = ($totalCredit2-$totalDebit2);
                                        $res2 = number_format($res2, 2, ',', ' ');

                                        echo'</tr>
                                        <tr style="border-top:1px solid gray">
                                        <th class="size15 bg-green"><strong>
                                        Total</strong>
                                        </th>
                                        <td class="size15 bg-green"><strong>
                                        ' .number_format($totalDebit2, 2, ',', ' ').' €</strong>
                                        </td>
                                        <td class="size15 bg-green"><strong>
                                        '.number_format($totalCredit2, 2, ',', ' ').' €</strong>
                                        </td>
                                        <td class="size15 bg-green text-align-center">
                                        Solde <br/><span class="size15"><strong>'.$res2.' €</strong></span>
                                        </td>
                                        </tr>
                                        </table>';

                                        $td = ($totalDebit1 + $totalDebit2);
                                        $tc = ($totalCredit1 + $totalCredit2);
                                        $tt = ($tc - $td);
                
                                    
                                        if($tt >= 0){
                                            echo'<div class="mt-3 border-radius-zig pt-3 bg-green">';
                                            echo'<a class="white2 a-hover-blanc" href="" style="font-size:25px"><p class="white2 a-hover-blue">Il me reste<br/><strong> '.number_format($tt, 2, ',', ' ').' €</p></strong></a>
                                            </div>';
                                        }
                                        else
                                        {
                                            echo'<div class="mt-3 border-radius-zig pt-3 bg-red">';
                                            echo'<a class="white2 a-hover-blanc" href="" style="font-size:25px"><p class="white2 a-hover-blue">Il me reste<br/><strong> '.number_format($tt, 2, ',', ' ').' €</p></strong></a>
                                            </div>';
                                        }
                                    }

            
                            echo'<div class="mt-3 pt-3 bg-green">';
                            echo'<a class="white2 a-hover-blanc" href="budget-mensuel.php?action=creaprev"><p class="white2 a-hover-blue">Ajouter une charge ou une ressource</p></a>
                            </div>';
                            
 */      
//-------------- SYNTHESE BUDGET --------------------------------------------------------------

                echo'<div class="col-4">';
                    echo'<div class="card ombre bg-blue-diffu">';
                        echo'<h2 class="bg-blue p-3 white2 stardust"> Ma Synthèse Budget </h2>';
//----CHARGES FIXES DEBIT -------------------------------------------------------------------------------

                        $query=$db->prepare('SELECT * FROM charges_fixes
                        WHERE id_createur=:id'); 
                        $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                        $query->execute();

                        $query=$db->prepare('SELECT sum(`montant`) FROM charges_fixes 
                        WHERE debit_credit="D" 
                        AND id_createur=:id
                        AND archive=0
                        ');
                        $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                        $query->execute();
                        $resultDCF=$query->fetch();
                        echo'
                        <table class=w-100">
                            <tr>
                                <td class="text-left"><strong>
                                    <p class="black">Mes Charges Fixes : 
                                </td>
                                
                                <td class="text-right">
                                    <strong>'.number_format($resultDCF[0], 2, ',', ' ') .'</p>
                                </td>
                            </tr>';
                
 //---- AUTRES CHARGES DEBIT ---------------------------------------               
                        $query=$db->prepare('SELECT sum(`montant`) FROM autres_charges 
                        WHERE debit_credit="D" 
                        AND id_createur=:id
                        AND archive=0
                        ');
                        $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                        $query->execute();
                        $resultDAC=$query->fetch();
                        echo'
                            <tr class="text-left">
                                <td><strong>
                                    <p class="black">Mes Autres Charges : 
                                </td>
                                
                            <td class="text-right">
                                <strong>'.number_format($resultDAC[0], 2, ',', ' ') .'</p>
                            </td>
                        </tr>';
                
//---- CHARGES FIXES CREDIT -------------------------------------------
                        $query=$db->prepare('SELECT sum(`montant`) FROM charges_fixes
                        WHERE debit_credit="C" 
                        AND id_createur=:id
                        AND archive=0
                        ');
                        $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                        $query->execute();
                        $resultCCF=$query->fetch();
                
//---- AUTRS CHARGES CREDIT -------------------------------------------
                        $query=$db->prepare('SELECT sum(`montant`) FROM autres_charges
                        WHERE debit_credit="C" 
                        AND id_createur=:id
                        AND archive=0
                        ');
                        $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                        $query->execute();
                        $resultCAC=$query->fetch();
                
//---- SOLDES CREDITS -------------------------------------------               
                        $creditTC = $resultCCF[0] + $resultCAC[0];
                        echo'
                        <tr class="text-left">
                            <td><strong>
                                <p class="black">Mes Revenus Budgetés : 
                            </td>
                            
                            <td class="text-right">
                                <strong>'.number_format($creditTC, 2, ',', ' ') .'</p>
                            </td>
                        </tr>';

                        $soldeB = ($creditTC - $resultDAC[0] - $resultDCF[0]);
                        echo'
                        <tr class="text-left">
                            <td><strong>
                                <p class=" black">Mon Solde Prévu Budgeté : 
                            </td>
                            
                            <td class="text-right">
                                <strong>'.number_format($soldeB, 2, ',', ' ') .'</p></strong>
                            </td>
                        </tr>
                    </table>';
                
 //-------------- SYNTHESE CPTEES SAISIES REELS --------------------------------------------------------------

                        echo'<h2 class="bg-blue p-3 white2 stardust"> Ma Synthèse sur le Réel </h2>';

                        $query=$db->prepare('SELECT date_ecriture, montant
                        FROM ecritures 
                        WHERE debit_credit="D" 
                        AND id_createur=:id
                        ');
                        $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                        $query->execute();
                
        
                        while($debit=$query->fetch())
                        {
                            $month = (isset($_GET['month']))?htmlspecialchars($_GET['month']):'';
                            $year = (isset($_GET['year']))?htmlspecialchars($_GET['year']):'';
                            $debitE = $debit['date_ecriture'];
                            $debit_replace = str_replace('-', ' ',$debitE);
                            $debit_explode = explode(" ",$date_replace);
                            $month_date = $date_explode[1];
                            $year_date = $date_explode[0];
            
            
                            $query=$db->prepare('SELECT montant
                            FROM ecritures 
                            WHERE debit_credit="D" 
                            AND id_createur=:id
                            ');
                            $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                            $query->execute();
                
                            while($DD=$query->fetch())
                            {
                                if($month_date == $_GET['month'] && $year_date == $_GET['year'])
                                {
                                    echo'je ne sais pas pourquoi c\'est vide';
                                }
                            }
                        }     
                            echo'</div>';
                        echo'</div>';
                    echo'</div>';
                echo'</div>';
                echo'</div>';
 
             
            }
            else
            {
                echo'Choisissez une date';
            }

        break;
//-------------------------------------- END VIEW ------------------------------
                
                
//--------------- CREATE PREVISIONNEL -----------------------------------------

                $action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'creaprev';

                case "creaprev":
                ?>
                <div class="card bg-white-diffu center">
                <form action="budget-mensuel.php?action=creaprevok" method="post">
                <table style="margin-top:-20px">
                <tr>
                <td>
                <br/>
                <h2 class="orange">Charges fixes</h2>
                </td>
                <td>
                <? echo'<input type="hidden" name="date_saisie" id="date_saisie" value="'.date("Y-m-d H:i:s").'"/>'; ?>
                </td>
                <td>
                Catégorie <br/>
                <select id="categorie" name="categorie" >
                <option value="Logement">Logement </option> 
                <option value="Sante"> Sante </option> 
                <option value="Transport"> Transport </option>
                <option value="Impots"> Impôts </option>
                <option value="Epargne"> Epargne </option>
                <option value="Loisir"> Loisir </option>
                <option value="Alimentation"> Alimentation </option>
                <option value="Telephone mobile"> Téléphone/Mobile/Fixe </option>
                <option value="Animaux"> Animaux </option>
                <option value="Scolaire"> Scolaire </option>
                <option value="Vie quotidienne autre achat"> Vie quotidienne autre achat </option>
                <option value="Vêtements"> Vêtements </option>
                <option value="Frais fixe"> Frais fixe </option>
                <option value="Frais banquaire"> Frais banquaire </option>
                <option value="Frais professionnels"> Frais professionnels </option>
                <option value="Ressources"> Ressources </option>
                <option value="Cadeaux"> Cadeaux </option>
                <option value="Autre"> Autre </option>
                </select>
                </td>
                <td>
                Objet <br/>
                <input type="text" name="objet" id="objet" />
                </td>
                <td>
                Montant <br/>
                <input type="number" name="montant" id="montant" step="0.01" required/>
                </td>
                <td>Type d'opération <br/>
                <select id="debit_credit" name="debit_credit" >
                <option value="D">Débit </option>
                <option value="C">Crédit </option>
                </select>
                </td>
                <td>
                <br/>
                <input type="submit" value="Ajouter!"/>
                </td>
                </tr>
                </table>
                </form>
                </div>

<!--------------------------- AUTRES CHARGES ------------------------------------------------->
                
                <div class="card bg-white-diffu center">
                <form action="budget-mensuel.php?action=creapreautrevok" method="post">
                <table style="margin-top:-20px">
                <tr>
                <td>
                <br/>
                <h2 class="orange">Autres charges</h2>
                </td>
                <td>
                <? echo'<input type="hidden" name="date_saisie" id="date_saisie" value="'.date("Y-m-d H:i:s").'"/>'; ?>
                </td>
                <td>
                Catégorie <br/>
                <select id="categorie" name="categorie" >
                <option value="Logement">Logement </option> 
                <option value="Sante"> Sante </option> 
                <option value="Transport"> Transport </option>
                <option value="Impots"> Impôts </option>
                <option value="Epargne"> Epargne </option>
                <option value="Loisir"> Loisir </option>
                <option value="Alimentation"> Alimentation </option>
                <option value="Telephone mobile"> Téléphone/Mobile/Fixe </option>
                <option value="Animaux"> Animaux </option>
                <option value="Scolaire"> Scolaire </option>
                <option value="Vie quotidienne autre achat"> Vie quotidienne autre achat </option>
                <option value="Vêtements"> Vêtements </option>
                <option value="Frais fixe"> Frais fixe </option>
                <option value="Frais banquaire"> Frais banquaire </option>
                <option value="Frais professionnels"> Frais professionnels </option>
                <option value="Ressources"> Ressources </option>
                <option value="Cadeaux"> Cadeaux </option>
                <option value="Autre"> Autre </option>
                </select>
                </td>
                <td>
                Objet <br/>
                <input type="text" name="objet" id="objet" />
                </td>
                <td>
                Montant <br/>
                <input type="number" name="montant" id="montant" step="0.01" required/>
                </td>
                <td>Type d'opération <br/>
                <select id="debit_credit" name="debit_credit" >
                <option value="D">Débit </option>
                <option value="C">Crédit </option>
                </select>
                </td>
                <td>
                <br/>
                <input type="submit" value="Ajouter!"/>
                </td>
                </tr>
                </table>
                </form>
                </div>
                <?
                
            $monyth=date('m');
            $year=date('Y');
            echo'                
            <a class="white2" href="http://localhost/MaComptaPerso/view/budget-mensuel.php?month='.$monyth.'&year='.$year.'">
            <p class="white2 bg-green-diffu p-3 size18"><strong>Retour vers mon budget</strong></p>
            </a>';

            break;  
//---------------------------- CREATE PREVISIONNEL OK ---------------------------------------

            $action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'creapreautrevok';
            case "creapreautrevok":

            $id_createur = $_SESSION['id'];
            $date_saisie = $_POST['date_saisie'];
            $categorie = $_POST['categorie'];
            $objet = $_POST['objet'];
            $montant = $_POST['montant'];
            $debit_credit = $_POST['debit_credit'];

            $query=$db->prepare('INSERT INTO `autres_charges`(`id_createur`, `date_saisie`, `categorie`, `objet`, `montant`, `debit_credit`)
            VALUES (:id_createur, :date_saisie, :categorie, :objet, :montant, :debit_credit)');

            $montant= str_replace(',','.',$montant);

            $query->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
            $query->bindValue(':date_saisie', $date_saisie, PDO::PARAM_STR);
            $query->bindValue(':categorie', $categorie, PDO::PARAM_STR);
            $query->bindValue(':objet', $objet, PDO::PARAM_STR);
            $query->bindValue(':montant', $montant, PDO::PARAM_STR);
            $query->bindValue(':debit_credit', $debit_credit, PDO::PARAM_STR);
            $query->execute();

            echo'<a class="gray a-hover-rose" href="budget-mensuel.php?action=creaprev"><p>Saisir une autre charges</p></a>';
            echo'<a class="gray a-hover-rose" href="budget-mensuel.php?action=view"><p>Retour à votre budget</p></a>';
            
            $monyth=date('m');
            $year=date('Y');
            
            header('Location: http://localhost/MaComptaPerso/view/budget-mensuel.php?action=creaprev');

            break;       
//---------------------------------- AUTRE CHARGES OK-------------------------------------------

            $action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'creaprevok';
            case "creaprevok":

            $id_createur = $_SESSION['id'];
            $date_saisie = $_POST['date_saisie'];
            $categorie = $_POST['categorie'];
            $objet = $_POST['objet'];
            $montant = $_POST['montant'];
            $debit_credit = $_POST['debit_credit'];

            $query=$db->prepare('INSERT INTO `charges_fixes`(`id_createur`, `date_saisie`, `categorie`, `objet`, `montant`, `debit_credit`)
            VALUES (:id_createur, :date_saisie, :categorie, :objet, :montant, :debit_credit)');

            $montant= str_replace(',','.',$montant);

            $query->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
            $query->bindValue(':date_saisie', $date_saisie, PDO::PARAM_STR);
            $query->bindValue(':categorie', $categorie, PDO::PARAM_STR);
            $query->bindValue(':objet', $objet, PDO::PARAM_STR);
            $query->bindValue(':montant', $montant, PDO::PARAM_STR);
            $query->bindValue(':debit_credit', $debit_credit, PDO::PARAM_STR);
            $query->execute();

            echo'<a class="gray a-hover-rose" href="budget-mensuel.php?action=creaprev"><p>Saisir une autre charges</p></a>';
            echo'<a class="gray a-hover-rose" href="budget-mensuel.php?action=view"><p>Retour à votre budget</p></a>';
                
                $monyth=date('m');
                $year=date('Y');
            
            header('Location: http://localhost/MaComptaPerso/view/budget-mensuel.php?action=creaprev');

            break;  
//----------------------------------------------- ARCHIVER ------------------------------------------------------
            $action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'archiverCF';
            case "archiverCF":
                $id_charge = (isset($_GET['id']))?htmlspecialchars($_GET['id']):'';
                
                $query=$db->prepare('UPDATE charges_fixes SET archive = 1
                WHERE id_charge = :id_charge');
                $query->bindValue(':id_charge',$id_charge,PDO::PARAM_INT);
                $query->execute();
                $query->CloseCursor();
            break;
            
                
            $action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'archiverAC';
            case "archiverAC":
                $id_autre_charge = (isset($_GET['id']))?htmlspecialchars($_GET['id']):'';
                
                $query=$db->prepare('UPDATE autres_charges SET archive = 1
                WHERE id_charge = :id_autre_charge');
                $query->bindValue(':id_autre_charge',$id_autre_charge,PDO::PARAM_INT);
                $query->execute();
                $query->CloseCursor();
                
                $monyth=date('m');
                $year=date('Y');
                
            header('Location: http://localhost/MaComptaPerso/view/budget-mensuel.php?month='.$monyth.'&year='.$year.'');

                
            break;
//---------------------------------------------------------------------------------------------

               /*  <!--

                    menu :
                    créer un prévisionnel
                    impoorter le prévionnel du mois dernier

                    Charges fixes
                    <form action crea-previsionnelok.php>
                    ajouter champs "mois" "année" "jour de paiement" "Montant" "Objet" "categorie (choix)" "Objet" bt:OK

                    Autres charges
                    <form action crea-previsionnelok.php>
                    ajouter champs "mois" "année" "jour de paiement" "Montant" "Objet" "categorie (choix)" "Objet" bt:OK

                    colone
                    Affichage

                    Prévisionnel :
                    tableau
                    Mois
                    données renvoyées par crea-previsionnelok.php
                    "jour de paiement" "Montant" "Objet" "categorie" "Objet" bt:modifier / bt:supprimer

                        détail + total du mois/année choisis
                    ----------------------------------------------------------------------------------------

                    colone
                    Affichage
                    Dépenses réélles :
                    Tableau des saisies effectuées dans tous les comptes durant le mois

                        détail + total 


                    colone
                    Affichage différence :
                    total prévionnel - total réél

                    Résultat :
                    Vous avez économisé xxx euros
                    Oups, vous avez dépassé de xxx euros

                 -->   */

                echo'</div>';
            }
        }
    }
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}



include('../includes/footer.php');
echo'</div>';
