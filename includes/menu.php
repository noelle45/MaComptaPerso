<div class="row violet w-100 justify-content-center sticky-top mt-2 mb-0">
<?
    $monyth=date('m');
    $year=date('Y');
    echo '<strong>
    <p class="violet pt-3 pb-3 mt-3">  
        
    <a class="white2" href="http://localhost/MaComptaPerso/view/accueil-mes-comptes.php"> 
    Retour accueil
    </a>
    
    &nbsp; &nbsp; | &nbsp; &nbsp;
    
    <a class="white2" href="http://localhost/MaComptaPerso/view/budget-mensuel.php?month='.$monyth.'&year='.$year.'">
    Mon budget en un clein d\'oeil 
    </a>
    
    &nbsp; &nbsp; | &nbsp; &nbsp;
    
    <a class="white2" href="http://localhost/MaComptaPerso/view/mes-comptes.php"> 
    Mes comptes 
    </a> 
    
    &nbsp; &nbsp; | &nbsp; &nbsp; 
    
    <a class="white2" href="http://localhost/MaComptaPerso/view/saisir-ecriture.php"> 
    Saisie rapide
    </a>
    
    &nbsp; &nbsp; | &nbsp; &nbsp; 
    
    <a class="white2" href="http://localhost/MaComptaPerso/view/mes-echeances.php?action=consultcreance"> 
    Mes échéances
    </a>
    
    &nbsp; &nbsp; | &nbsp; &nbsp; 
    
    <a class="white2" href="http://localhost/MaComptaPerso/view/ma-synthese.php"> 
    Synthése
    </a>
    
    &nbsp; &nbsp; | &nbsp; &nbsp; 
    
    <a class="white2" href="http://localhost/MaComptaPerso/deconnexion.php"> 
    Deconnexion
    </a>
    
    </p></strong>';
?>
</div>
<?