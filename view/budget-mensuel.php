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
        
        $table2 = ['01'=>'1','02'=>'2', '03'=>'3', '04'=>'4', '05'=>'5', '06'=>'6', '07'=>'7', '08'=>'8', '09'=>'9', '10'=>'10', '11'=>'11', '12'=>'12'];

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

echo'<div class="row justify-content-center">';
                
echo'<div class="col-4">';
                //--debut bouton accordion
echo'<div class="card ombre">

<p class="black"> <a class="black a-hover-blue" href="mes-comptes.php">
<strong><p class="white2 size22">
Voir mes comptes</p></strong></a>

<div class="accordion" id="accordion">

                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0 bg-orange">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> 
                
                    <h2 class="bg-orange p-3 white2 stardust">Mes Dépenses Réelles
                    <br/><span class="typo-simple size15">Tous comptes confondus</span></h2>
                    <img src="../creation/img/fleche_bas.png" title="+ de détails" alt="+ de détail"/>
                    </button>
                    </h2>
                   
                </div>
                
<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
<div class="card-body bg-orange-diffu">';
                //--fin bouton accordion                   
                
                
                echo'<div class="mt-3 pt-3 bg-orange">
                        <a class="white2 a-hover-blue" href="mes-comptes.php">
                        <strong><p class="white2 size22">
                        Voir mes comptes</p></strong></a>
                </div>

                
                        <table class="w-100">
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
                                
                                
                                    if($year_date == $_GET['year'] && $month_date == $_GET['month'] && $data['pointer']==1
                                      || $year_date != $_GET['year'] && $month_date != $_GET['month'] && $data['pointer']!=1)
                                    {
                                        echo'
                                        <tr style="border-top:1px solid gray">
                                            <td class="size15">'
                                                .$data['categorie'].'<br/>'.$data['objet'].'<br/>'.$data['nom_banque'].'<br/>';
                                                if($data['pointer']==0)
                                                {
                                                    echo'<p class="red bold size15"> Non pointée<br/>
                                                    du '.$data['date_ecriture'].'</p>';
                                                    $plus_debit_non_pointer = $data['montant'];
                                                }
                                            echo'</td>
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
                                        elseif($data['pointer']==0 && $_GET['month'] > $month_date)
                                        {
                                            echo'
                                        <tr style="border-top:1px solid gray">
                                            <td class="size15">'
                                                .$data['categorie'].'<br/>'.$data['objet'].'<br/>'.$data['nom_banque'].'<br/>';
                                                if($data['pointer']==0)
                                                {
                                                    echo'<p class="red bold size15"> Non pointée<br/> 
                                                    du '.$data['date_ecriture'].'</p>';
                                                }
                                            echo'</td>
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
                                        <td></td>
                                    </tr>';
                            echo'</table>';
echo'</div>';
echo'</div>';
echo'</div>';
                //-fin accordion
                           if($_GET['year']==date('Y') && $_GET['month']==date('m')) 
                           {
                                if($res >= 0)
                                {
                                    echo'<div class="mt-3 border-radius-zig pt-3 bg-orange">';
                                    echo'
                                    <p class="white2 size22">SOLDE au '. date('d-m-Y').'<br/><strong>'.$res.' € 
                                    </strong>
                                    </p>
                                    </div>';
                                }
                                else
                                {
                                    echo'<div class="mt-3 border-radius-zig pt-3 bg-red">';
                                    echo'
                                    <p class="white2">SOLDE au '. date('d-m-Y').'<br/>
                                    <strong>'.$res.' € </strong>
                                    </p>
                                    </div>'; 
                                }
                            }
                            else
                            {
                                if($res >= 0)
                                {
                                    
                                    echo'<div class="mt-3 border-radius-zig pt-3 bg-orange">';
                                    echo'
                                    <p class="white2 size22">SOLDE prévu pour '. $table[$month] .'<br/><strong>'.$res.' € 
                                    </strong>
                                    </p>
                                    </div>';
                                }
                                else
                                {
                                    echo'<div class="mt-3 border-radius-zig pt-3 bg-red">';
                                    echo'
                                    <p class="white2">SOLDE prévu pour '.$table[$month].'<br/>
                                    <strong>'.$res.' € </strong>
                                    </p>
                                    </div>'; 
                                }
                            }
                
echo'</div>';               
echo'</div>';
//echo'</div>';
               
//-------------- PREVISIONNEL ---------------------------------------------------------------------  
                    
                    //requette budgets
                    $query_budgets=$db->prepare('SELECT *
                    FROM budgets 
                    WHERE id_createur=:id');
                    $query_budgets->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                    $query_budgets->execute();
                            
                    echo'<div class="col-4">
                    <div class="card bg-white-diffu ombre">
                    
                    <p class="black"> <a class="black a-hover-blue" href="http://localhost/MaComptaPerso/view/budget-mensuel.php?action=creabudget">
                    <strong><p class="white2 size22">
                    Créer un nouveau Budget</p></strong></a>
                    
                        <div class="accordion bg-white-diffu" id="accordion">
                        <h2 class="stardust p-3 white2 bg-green mb-0"> Mes prévisions </h2>';
                            $headind = 0;
                            $collapse = 0;
                
                            while($data_budgets=$query_budgets->fetch())
                            {
                                $headind ++;
                                $collapse ++;

                            echo'
                            <div class="card-header bg-white-diffu" id="heading'.$headind.'">
                            
                            <h2 class="mb-0 bg-green-diffu">

                            <button class="btn btn-link " type="button" data-toggle="collapse" data-target="#collapse'.$collapse.'" aria-expanded="true" aria-controls="collapse'.$collapse.'">'; 

                            $nom_budget=$data_budgets['nom_budget'];
                            $id_budget=$data_budgets['id_budget'];
                            $id_createur=$data_budgets['id_createur'];
                            echo'<h2 class="pt-3 pl-3 pr-3 white2 stardust">
                            '. $nom_budget .'<h2>
                            <img src="../creation/img/fleche_bas.png" title="+ de détails" alt="+ de détail"/>
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

                                        //echo'<th class="black size15">';
                                        //    echo'Objet';
                                        //echo'</th class="black size15">';

                                        echo'<th class="black size15">';
                                            echo'Débit';
                                        echo'</th>';

                                        echo'<th class="black size15">';
                                            echo'Crédit';
                                        echo'</th>';
                                        echo'<th></th>';
                                    echo'</tr>';
                                
                                    $dcf = [];
                                    $ccf = [];

                                    while($data_charges=$query_charges->fetch())
                                    {
                                        if($data_charges['id_budget']==$id_budget)
                                        {
                                            echo'<tr>';
                                                echo'<td>';
                                                    echo'<p class="black size15">' . $data_charges['categorie'] . '<br/>
                                                    '. $data_charges['objet']. '</p>';
                                                echo'</p></td>';

                                                //echo'<td>';
                                                //    echo'<p class="black size15">' . $data_charges['objet'] . '</p>';
                                               // echo'</td>';

                                                echo'<td>';
                                                    if($data_charges['debit_credit']=="D")
                                                    {
                                                        echo'<p class="black size15">' . $data_charges['montant'] . '</p>';
                                                        $dcf[]=$data_charges['montant'];
                                                    }
                                                echo'</td>';

                                                echo'<td>';
                                                    if($data_charges['debit_credit']=="C")
                                                    {
                                                        echo'<p class="black size15">' . $data_charges['montant'] . '</p>';
                                                        $ccf[]=$data_charges['montant'];
                                                    }
                                                echo'</td>
                                                <td><p class="bg-green border-radius-zig text-align-center p-1 size12" style="border:0.5px solid gray"><a class="white2 a-hover-blanc" href="budget-mensuel.php?action=archiverCF&id='.$data_charges['id_charge'].'">Archiver</a></p></td>
                                            </tr>';
                                        }
                                    }
                                                    $totalCredit = array_sum($ccf);
                                                    $totalDebit = array_sum($dcf);
                                                    $resCF = ($totalCredit-$totalDebit);
                                                    $resCF2 = number_format($resCF, 2, ',', ' ');
                                
                                            echo'<tr>
                                            
                                                <td>total</td>
                                               
                                                <td>
                                                    ' . number_format($totalDebit, 2, ',', ' ') .
                                               '</td>
                                               <td>
                                                    ' . number_format($totalCredit, 2, ',', ' ') .
                                               '</td>
                                            </tr>
                                            <tr class="bg-green ombre">
                                                <td colspan="3" class="text-left">
                                                    SOLDE CHARGES FIXES
                                                </td>
                                                
                                               <td colspan="2" class="text-align-center size18"><strong>
                                                   ' . $resCF2 .
                                               '</strong></td>
                                            </tr>';
                                echo'</table>';

                                echo'<div class="mt-3 p-3 bg-green">';
                                echo'<a class="white2 a-hover-blanc" href="budget-mensuel.php?action=creaprev&budget='.$id_budget.'">
                                <p class="white2 a-hover-blue">Ajouter une charge ou une ressource</p></a>
                                </div>';
                                
                                //requete voir autres charges fixes
                                $query_autres_charges = $db ->prepare('SELECT * 
                                FROM autres_charges 
                                WHERE id_createur=:id_createur
                                AND archive=0
                                ORDER BY date_saisie ASC');
                                $query_autres_charges->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
                                $query_autres_charges->execute();
                                
                                echo'<table class="w-100">';
                                    echo'<tr>';
                                        echo'<th colspan="5">';
                                            echo'<p  class="black size15">Autres charges</p>';
                                        echo'</th>';
                                    echo'</tr>';

                                    echo'<tr>';
                                        echo'<th class="black size15">';
                                            echo'Catégorie';
                                        echo'</th>';

                                        //echo'<th class="black size15">';
                                        //    echo'Objet';
                                        //echo'</th class="black size15">';

                                        echo'<th class="black size15">';
                                            echo'Débit';
                                        echo'</th>';

                                        echo'<th class="black size15">';
                                            echo'Crédit';
                                        echo'</th>';
                                        echo'<th></th>';
                                    echo'</tr>';
                                
                                    $dcfAC = [];
                                    $ccfAC = [];
                                    
                                    while($data_autres_charges=$query_autres_charges->fetch())
                                    {
                                        if($data_autres_charges['id_budget']==$id_budget)
                                        {
                                            echo'<tr>';
                                                echo'<td>';
                                                    echo'<p class="black size15">' . $data_autres_charges['categorie'] . '</br>'
                                                    . $data_autres_charges['objet'] . '</p>';
                                                echo'</p></td>';

                                                //echo'<td>';
                                                //    echo'<p class="black size15">' . $data_autres_charges['objet'] . '</p>';
                                               // echo'</td>';

                                                echo'<td>';
                                                    if($data_autres_charges['debit_credit']=="D")
                                                    {
                                                        echo'<p class="black size15">' . $data_autres_charges['montant'] . '</p>';
                                                        $dcfAC[]=$data_autres_charges['montant'];
                                                    }
                                                echo'</td>';

                                                echo'<td>';
                                                    if($data_autres_charges['debit_credit']=="C")
                                                    {
                                                        echo'<p class="black size15">' . $data_autres_charges['montant'] . '</p>';
                                                        $ccfAC[]=$data_autres_charges['montant'];
                                                    }
                                                echo'</td>
                                                <td><p class="bg-green border-radius-zig text-align-center p-1 size12" style="border:0.5px solid gray"><a class="white2 a-hover-blanc" href="budget-mensuel.php?action=archiverCF&id='.$data_autres_charges['id_charge'].'">Archiver</a></p></td>
                                            </tr>';
                                        }
                                    }
                                                    $totalCreditAC = array_sum($ccfAC);
                                                    $totalDebitAC = array_sum($dcfAC);
                                                    $resCFAC = ($totalCreditAC-$totalDebitAC);
                                                    $resCFAC2 = number_format($resCFAC, 2, ',', ' ');
                                
                                            echo'<tr>
                                            
                                                <td>total</td>
                                                
                                                <td>
                                                    ' . number_format($totalDebitAC, 2, ',', ' ') .
                                               '</td>
                                               <td>
                                                    ' . number_format($totalCreditAC, 2, ',', ' ') .
                                               '</td>
                                            </tr>
                                            <tr class="bg-green ombre">
                                                <td colspan="3" class="text-left">
                                                    SOLDE AUTRES CHARGES
                                                </td>
                                                
                                               <td colspan="2" class="text-align-center size18"><strong>
                                                   ' . $resCFAC2 .
                                               '</strong></td>
                                            </tr>';
                                echo'</table>';
                                
                                $soldeFinalBudget = ($resCF + $resCFAC);
                                $soldeFinalBudget2 = number_format($soldeFinalBudget, 2, ',', ' ');
                                
                                
                                echo'<div class="pt-5">';
                                if($soldeFinalBudget2 >= 0)
                                {
                                echo'<div class="card ombre size18 pt-5">';
                                echo'<h2 class="stardust"> Solde final pour le budget '. $nom_budget .'</h2><br/>';
                                echo '<p class="typo-simple green size28"><strong>'. $soldeFinalBudget2.'</strong></p>';
                                echo'</div>';
                                }
                                else
                                {
                                echo'<div class="card ombre size18 pt-5">';
                                echo'<h2 class="stardust"> Solde final pour le budget '. $nom_budget .'</h2><br/>';
                                echo '<p class="typo-simple red size28"><strong>'. $soldeFinalBudget2.'</strong></p>';
                                echo'</div>';
                                }
                                echo'</div>
                                </div>
                                </div>';
                        
}
echo'</div>
</div>
</div>';

//-------------- SYNTHESE BUDGET --------------------------------------------------------------

                echo'<div class="col-4">';
                    echo'<div class="card ombre bg-blue-diffu">';
                        echo'<h2 class="bg-blue p-3 white2 stardust"> Synthèse de mes Prévisions </h2>';
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
                        <table class="w-100 mb-5">
                            <tr>
                                <td class="text-left">
                                    <p class="black">Mes Charges Fixes : 
                                </td>
                                
                                <td class="text-right">
                                    '.number_format($resultDCF[0], 2, ',', ' ') .' €</p>
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
                                <td>
                                    <p class="black">Mes Autres Charges : 
                                </td>
                                
                            <td class="text-right">
                                '.number_format($resultDAC[0], 2, ',', ' ') .' €</p>
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
                            <td>
                                <p class="black">Mes Revenus : 
                            </td>
                            
                            <td class="text-right">
                                '.number_format($creditTC, 2, ',', ' ') .' €</p>
                            </td>
                        </tr>';

                        $soldeB = ($creditTC - $resultDAC[0] - $resultDCF[0]);
                        echo'
                        
                        <tr class="text-left bg-blue bold" style="border:1px solid white">
                                <td colspan="2" class="text-align-center">
                                    <p class="black p-3">Solde  &nbsp; &nbsp; '. number_format($soldeB, 2, ',', ' ') .' €</p>
                                </td>
                            </tr>
                    </table>';
                
 //-------------- SYNTHESE CPT SAISIES REELS --------------------------------------------------------------
    $year = (isset($_GET['year']))?htmlspecialchars($_GET['year']):'';
    $month = (isset($_GET['month']))?htmlspecialchars($_GET['month']):'';
                
    echo'<h2 class="bg-blue p-3 white2 stardust"> Synthèse sur le Réel '.$_SESSION['prenom'].'
    <br/> <span class="typo-simple size28"> '.$_GET['month'].'/'.$_GET['year'].'</span></h2>';
                
    
                        
 echo'<div class="text-left">';
                    
//---- ECRITURES NON POINTEES ---------------------------
                        
                            $queryCNP=$db->prepare('SELECT montant, date_ecriture, pointer
                            FROM ecritures
                            WHERE debit_credit="C" 
                            AND id_createur=:id
                            AND pointer=0');
                            $queryCNP->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                            $queryCNP->execute();

                            $queryDNP=$db->prepare('SELECT montant, date_ecriture, pointer
                            FROM ecritures
                            WHERE debit_credit="D" 
                            AND id_createur=:id
                            AND pointer=0');
                            $queryDNP->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
                            $queryDNP->execute();
                    
                            $DNP = [];
                            $CNP = [];

                            while($dataCNP=$queryCNP->fetch())
                            {
                                $dateCNP = $dataCNP['date_ecriture'];
                                $date_replaceCNP = str_replace('-', ' ',$dateCNP);
                                $date_explodeCNP = explode(" ",$date_replaceCNP);
                                $month_dateCNP = $date_explodeCNP[1];
                                $year_dateCNP = $date_explodeCNP[0];
                                
                                if($_GET['month'] == $month_dateCNP && $_GET['year'] == $year_dateCNP
                                  || $_GET['month'] > $month_dateCNP && $_GET['year'] > $year_dateCNP && $dataCNP['pointer']==0)
                                {
                                    $CNP[]=$dataCNP['montant'];
                                }
                            }
                            $credits_non_pointer = array_sum($CNP);
                
                            while($dataDNP=$queryDNP->fetch())
                            {
                                $dateDNP = $dataDNP['date_ecriture'];
                                $date_replaceDNP = str_replace('-', ' ',$dateDNP);
                                $date_explodeDNP = explode(" ",$date_replaceDNP);
                                $month_dateDNP = $date_explodeDNP[1];
                                $year_dateDNP = $date_explodeDNP[0];
                                
                                if($_GET['month'] == $month_dateDNP && $_GET['year'] == $year_dateDNP
                                  || $_GET['month'] > $month_dateDNP && $_GET['year'] > $year_dateDNP && $dataDNP['pointer']==0)
                                {
                                    $DNP[]=$dataDNP['montant'];
                                }
                            }
                            $debits_non_pointer = array_sum($DNP);

//---- DEBITS --------------------------------------- 
                $table2 = ['01'=>'1','02'=>'2', '03'=>'3', '04'=>'4', '05'=>'5', '06'=>'6', '07'=>'7', '08'=>'8', '09'=>'9', '10'=>'10', '11'=>'11', '12'=>'12'];
                $mois_en_cours = $table2[$_GET['month']];
                    
                        $query=$db->prepare('SELECT sum(`montant`), date_ecriture
                        FROM ecritures 
                        WHERE debit_credit="D"
                        AND YEAR(date_ecriture)=:anne_en_cours
                        AND MONTH(date_ecriture)=:mois_en_cours
                        AND pointer=1');
                        $query->bindValue(':anne_en_cours', $_GET['year'], PDO::PARAM_STR);
                        $query->bindValue(':mois_en_cours',$mois_en_cours, PDO::PARAM_STR);
                        $query->execute();
                        $debit = $query->fetch();
                        
//---- CREDITS -------------------------------------------
                        //AND MONTH(date_ecriture)=:0mois_en_cours
                        $mois_en_cours = $table2[$_GET['month']]; // 1
        
                
                        $query=$db->prepare('SELECT sum(`montant`), date_ecriture
                        FROM ecritures
                        WHERE debit_credit="C" 
                        AND YEAR(date_ecriture)=:anne_en_cours
                        AND MONTH(date_ecriture)=:mois_en_cours
                        AND pointer=1');
                        $query->bindValue(':anne_en_cours', $_GET['year'], PDO::PARAM_STR);
                        $query->bindValue(':mois_en_cours',$mois_en_cours, PDO::PARAM_STR);
                        $query->execute();
                        $credit = $query->fetch();
                   
//---- RESULTAT ------------------------------------------                        
                        $solde_precedent = [];
                
                        $debitD = $debit[0];
                        $creditC = $credit[0];
                    
                        $credit_actuel = $creditC + $credits_non_pointer;
                        $debit_actuel = $debitD + $debits_non_pointer;
                        $solde_actuel = $credit_actuel - $debit_actuel;
                
                        $query=$db->prepare('SELECT montant, date_ecriture
                        FROM ecritures
                        WHERE debit_credit="C" 
                        AND pointer =0');
                        $query->execute();
                
                        $cumul_credit_non_pointer=[];
                
                        while($cumul_credit_non_pointer1=$query->fetch())
                        {
                                $dateCNP = $cumul_credit_non_pointer1['date_ecriture'];
                                $date_replaceCNP = str_replace('-', ' ',$dateCNP);
                                $date_explodeCNP = explode(" ",$date_replaceCNP);
                                $month_dateCNP = $date_explodeCNP[1];
                                $year_dateCNP = $date_explodeCNP[0];
                            
                            if($month_dateCNP < $_GET['month'] && $year_dateCNP < $_GET['month'])
                            {
                                $cumul_credit_non_pointer[]=$cumul_credit_non_pointer1['montant'];
                                
                            }
                        }
                        $total_cumul_credit_non_pointer = array_sum($cumul_credit_non_pointer);
                
                        $query=$db->prepare('SELECT montant, date_ecriture
                        FROM ecritures
                        WHERE debit_credit="D" 
                        AND pointer =0');
                        $query->execute();
                
                        $cumul_debit_non_pointer=[];
                
                        while($cumul_debit_non_pointer1=$query->fetch())
                        {
                            $dateDNP = $cumul_debit_non_pointer1['date_ecriture'];
                            $date_replaceDNP = str_replace('-', ' ',$dateDNP);
                            $date_explodeDNP = explode(" ",$date_replaceDNP);
                            $month_dateDNP = $date_explodeDNP[1];
                            $year_dateDNP = $date_explodeDNP[0];
                            
                            if($month_dateDNP < $_GET['month'] && $year_dateDNP < $_GET['month'])
                            {
                                $cumul_debit_non_pointer[]=$cumul_debit_non_pointer1['montant'];
                            }
                        }
                        $total_cumul_debit_non_pointer = array_sum($cumul_debit_non_pointer);               
                
                        $debits_non_pointer2 = $debits_non_pointer + $total_cumul_debit_non_pointer;
                        $credits_non_pointer2 = $credits_non_pointer + $total_cumul_credit_non_pointer;
                
                        echo'<p class="red bold">Debits non pointés ce mois-ci : '.number_format($debits_non_pointer2, 2, ',', ' ').' €<br/>';
                        echo'Crédits non pointés ce mois-ci : '.number_format($credits_non_pointer2, 2, ',', ' ').' €</p><br/><br/>';
                        echo'<a href="http://localhost/MaComptaPerso/view/mes-comptes.php"><p class="bold white2 bg-green p-2 text-align-center">Voir le détail de mes comptes</p></a>';
                        echo'
                            <table class="w-100">
                            <tr class="text-left">
                                <td>
                                    <p class="black">Mes Ressources
                                </td>
                                <td class="text-right">
                                
                                    '. number_format($credit_actuel, 2, ',', ' ') .' €</p>
                                </td>
                            </tr>';
                    
                        echo'
                            <tr class="text-left">
                                <td>
                                    <p class="black">Mes dépenses
                                </td>
                                <td class="text-right">
                                   '. number_format($debit_actuel, 2, ',', ' ') .' €</p>
                                </td>
                        </tr>';
                
                    $solde = $credit[0] - (int) $debit[0];
//---- SOLDES -------------------------------------------
                        echo'
                            <tr class="text-left bg-blue bold" style="border:1px solid white">
                                <td colspan="2" class="text-align-center">
                                    <p class="black p-3">Mon solde actuel &nbsp; &nbsp; '.number_format($solde, 2, ',', ' ').' €</p>
                                </td>
                            </tr>';
                
                        echo'
                        <tr class="text-left">
                            <td>
                                <p class="black">Mon solde réel
                            </td>
                            <td class="text-right">
                                '.number_format($solde_actuel, 2, ',', ' ') .' €</p>
                            </td>
                        </tr>
                        </table>';
                    }
echo'</div>';
//---------------------------------------------------------
                
                
                
                            echo'</div>';
                        echo'</div>';
                    echo'</div>';
                echo'</div>';
                echo'</div>';
         
        break;
//-------------------------------------- END VIEW ------------------------------
            $action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'creabudget';    
            case "creabudget":
                
                echo'
                <div style="margin-top:100px">
                <form action="http://localhost/MaComptaPerso/view/budget-mensuel.php?action=creabudgetok" method="post">
                <table style="margin-top:-20px">
                    <tr>
                        <td>Nom de votre nouveau budget
                            <input type="text" name="nom_budget" />
                            Partager ce budget
                            <input type="checkbox" name="partage" value="1"/>
                            <input type="submit" value="Créer!"/>
                        </td>
                    </tr>
                </table>
                </form>
                </div>';
                    
                break;
                
            $action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'creabudgetok';    
            case "creabudgetok":
                
                $id_createur = $_SESSION['id'];
                $nom_budget = $_POST['nom_budget'];
                $partage = $_POST['partage'];

                $query=$db->prepare('INSERT INTO `budgets`(`id_createur`, `nom_budget`, `partage`)
                VALUES (:id_createur, :nom_budget, :partage)');

                $query->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
                $query->bindValue(':nom_budget', $nom_budget, PDO::PARAM_STR);
                $query->bindValue(':partage', $partage, PDO::PARAM_INT);
                $query->execute();
            
                header('Location: http://localhost/MaComptaPerso/view/budget-mensuel.php?month='.$monyth.'&year='.$year.'');
                    
                break;

                
//--------------- CREATE PREVISIONNEL -----------------------------------------

                $action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'creaprev';
                

                case "creaprev":
                $id_budget = (isset($_GET['budget']))?htmlspecialchars($_GET['budget']):'';
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
                    <? echo'<input type="hidden" name="id_budget" value="'.$id_budget.'"'; ?>
                </td>
                <td>
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
                    <? echo'<input type="hidden" name="id_budget" value="'.$id_budget.'"'; ?>
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
            $id_budget = $_POST['id_budget'];

            $query=$db->prepare('INSERT INTO `autres_charges`(`id_createur`, `id_budget`, `date_saisie`, `categorie`, `objet`, `montant`, `debit_credit`)
            VALUES (:id_createur, :id_budget, :date_saisie, :categorie, :objet, :montant, :debit_credit)');

            $montant= str_replace(',','.',$montant);

            $query->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
            $query->bindValue(':id_budget', $id_budget, PDO::PARAM_INT);
            $query->bindValue(':date_saisie', $date_saisie, PDO::PARAM_STR);
            $query->bindValue(':categorie', $categorie, PDO::PARAM_STR);
            $query->bindValue(':objet', $objet, PDO::PARAM_STR);
            $query->bindValue(':montant', $montant, PDO::PARAM_STR);
            $query->bindValue(':debit_credit', $debit_credit, PDO::PARAM_STR);
            $query->execute();

            echo'<a class="gray a-hover-rose" href="budget-mensuel.php?action=creaprev&budget='.$id_budget.'"><p>Saisir une autre charges</p></a>';
            echo'<a class="gray a-hover-rose" href="budget-mensuel.php?action=view"><p>Retour à votre budget</p></a>';
            
            $monyth=date('m');
            $year=date('Y');
            
            header('Location: http://localhost/MaComptaPerso/view/budget-mensuel.php?action=creaprev&budget='.$id_budget.'');

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
            $id_budget = $_POST['id_budget'];

            $query=$db->prepare('INSERT INTO `charges_fixes`(`id_createur`, `id_budget`, `date_saisie`, `categorie`, `objet`, `montant`, `debit_credit`)
            VALUES (:id_createur, :id_budget, :date_saisie, :categorie, :objet, :montant, :debit_credit)');

            $montant= str_replace(',','.',$montant);

            $query->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
            $query->bindValue(':date_saisie', $date_saisie, PDO::PARAM_STR);
            $query->bindValue(':id_budget', $id_budget, PDO::PARAM_INT);
            $query->bindValue(':categorie', $categorie, PDO::PARAM_STR);
            $query->bindValue(':objet', $objet, PDO::PARAM_STR);
            $query->bindValue(':montant', $montant, PDO::PARAM_STR);
            $query->bindValue(':debit_credit', $debit_credit, PDO::PARAM_STR);
            $query->execute();

            echo'<a class="gray a-hover-rose" href="budget-mensuel.php?action=creaprev&budget='.$id_budget.'"><p>Saisir une autre charges</p></a>';
            echo'<a class="gray a-hover-rose" href="budget-mensuel.php?action=view"><p>Retour à votre budget</p></a>';
                
                $monyth=date('m');
                $year=date('Y');
            
            header('Location: http://localhost/MaComptaPerso/view/budget-mensuel.php?action=creaprev&budget='.$id_budget.'');

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

                echo'</div>';
        }}}
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}



include('../includes/footer.php');
echo'</div>';
