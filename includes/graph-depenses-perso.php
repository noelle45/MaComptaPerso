<?php
//include('../includes/connexion-bdd.php');

// variables
$queryLogement_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Logement"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryLogement_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryLogement_perso->execute();
$dataLogement_perso = $queryLogement_perso->fetch();
$resultLogement_perso = $dataLogement_perso[0];
    
$queryViequotidienneautreachat_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Vie_quotidienne_autre_achat"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryViequotidienneautreachat_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryViequotidienneautreachat_perso->execute();
$dataVie_quotidienne_autre_achat_perso = $queryViequotidienneautreachat_perso->fetch();
$resultVie_quotidienne_autre_achat_perso = $dataVie_quotidienne_autre_achat_perso[0];

$queryADSL_cable_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="ADSL_cable"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryADSL_cable_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryADSL_cable_perso->execute();
$dataADSL_cable_perso = $queryADSL_cable_perso->fetch();
$resultADSL_cable_perso = $dataADSL_cable_perso[0];
    
$queryTelephone_mobile_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Telephone_mobile"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryTelephone_mobile_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryTelephone_mobile_perso->execute();
$dataTelephone_mobile_perso = $queryTelephone_mobile_perso->fetch();
$resultTelephone_mobile_perso = $dataTelephone_mobile_perso[0];
    
    $logement_perso = $resultTelephone_mobile_perso + $resultVie_quotidienne_autre_achat_perso+$resultLogement_perso + $resultADSL_cable_perso;
    

$querySante_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Sante"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$querySante_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$querySante_perso->execute();
$dataSante_perso = $querySante_perso->fetch();
            
$queryTransport_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Transport"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryTransport_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryTransport_perso->execute();
$dataTransport_perso = $queryTransport_perso->fetch();
            
$queryLoisir_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Loisir"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryLoisir_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryLoisir_perso->execute();
$dataLoisir_perso = $queryLoisir_perso->fetch();
            
$queryImpots_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Impots"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryImpots_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryImpots_perso->execute();
$dataImpots_perso = $queryImpots_perso->fetch();
            
$queryEpargne_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Epargne"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryEpargne_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryEpargne_perso->execute();
$dataEpargne_perso = $queryEpargne_perso->fetch();
            
$queryAlimentation_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Alimentation"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryAlimentation_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryAlimentation_perso->execute();
$dataAlimentation_perso = $queryAlimentation_perso->fetch();

            
$queryAnimaux_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Animaux"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryAnimaux_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryAnimaux_perso->execute();
$dataAnimaux_perso = $queryAnimaux_perso->fetch();
            
$queryScolaire_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Scolaire"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryScolaire_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryScolaire_perso->execute();
$dataScolaire_perso = $queryScolaire_perso->fetch();
            
$queryVetements_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Vetements"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryVetements_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryVetements_perso->execute();
$dataVetements_perso = $queryVetements_perso->fetch();
            
$queryFraisbancaire_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Frais_banquaire"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryFraisbancaire_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryFraisbancaire_perso->execute();
$dataFraisbancaire_perso = $queryFraisbancaire_perso->fetch();
            
$queryFraisprofessionnels_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Frais_professionnels"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryFraisprofessionnels_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryFraisprofessionnels_perso->execute();
$dataFraisprofessionnels_perso = $queryFraisprofessionnels_perso->fetch();
            
$queryCadeaux_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Cadeaux"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryCadeaux_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryCadeaux_perso->execute();
$dataCadeaux_perso = $queryCadeaux_perso->fetch();
            
$queryAutre_perso=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Autre"
AND pointer=1
AND debit_credit="D"
AND id_createur=:id
');
$queryAutre_perso->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$queryAutre_perso->execute();
$dataAutre_perso = $queryAutre_perso->fetch();


if(empty($logement_perso)){$logement_perso = 0;}
else{$Logement_perso = $logement_perso;}

if(empty($dataTransport_perso[0])){$dataTransport_perso[0] = 0;}
else{$Transport_perso = $dataTransport_perso[0];}

if(empty($dataSante_perso[0])){$dataSante_perso[0] = 0;}
else{$Sante_perso = $dataTransport_perso[0];}

if(empty($dataLoisir_perso[0])){$dataLoisir_perso[0] = 0;}
else{$Loisir_perso = $dataLoisir_perso[0];}

if(empty($dataImpots_perso[0])){$dataImpots_perso[0] = 0;}
else{$Impots_perso = $dataImpots_perso[0];}

if(empty($dataEpargne_perso[0])){$dataEpargne_perso[0] = 0;}
else{$Epargne_perso = $dataEpargne_perso[0];}

if(empty($dataAlimentation_perso[0])){$dataAlimentatio_perso[0] = 0;}
else{$Alimentation_perso = $dataAlimentation_perso[0];}

if(empty($dataAnimaux_perso[0])){$dataAnimaux_perso[0] = 0;}
else{$Animaux_perso = $dataAnimaux_perso[0];}

if(empty($dataScolaire_perso[0])){$dataScolaire_perso[0] = 0;}
else{$Scolaire_perso = $dataScolaire_perso[0];}

if(empty($dataVetements_perso[0])){$dataVetements_perso[0] = 0;}
else{$Vetements_perso = $dataVetements_perso[0];}

if(empty($dataFraisbancaire_perso[0])){$dataFraisbancaire_perso[0] = 0;}
else{$Frais_bancaire_perso = $dataFraisbancaire_perso[0];}

if(empty($dataFraisprofessionnels_perso[0])){$dataFraisprofessionnels_perso[0] = 0;}
else{$Frais_professionnels_perso = $dataFraisprofessionnels_perso[0];}

if(empty($Cadeaux_perso[0])){$Cadeaux_perso[0] = 0;}
else{$Cadeaux_perso = $Cadeaux_perso[0];}

if(empty($Autre_perso[0])){$Autre_perso[0] = 0;}
else{$Autre_perso = $Autre_perso[0];}


            $Logement_perso = $logement_perso;
			$Transport_perso = $dataTransport_perso[0];
			$Sante_perso = $dataSante_perso[0];
            $Loisir_perso = $dataLoisir_perso[0];
            $Impots_perso = $dataImpots_perso[0];
            $Epargne_perso = $dataEpargne_perso[0];
            $Alimentation_perso = $dataAlimentation_perso[0];
            $Animaux_perso = $dataAnimaux_perso[0];
            $Scolaire_perso = $dataScolaire_perso[0];
            $Vetements_perso = $dataVetements_perso[0];
            $Frais_bancaire_perso = $dataFraisbancaire_perso[0];
            $Frais_professionnels_perso = $dataFraisprofessionnels_perso[0];
            $Cadeaux_perso = $dataCadeaux_perso[0];
            $Autre_perso = $dataAutre_perso[0];















