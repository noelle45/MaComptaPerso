<?php


//include('../includes/connexion-bdd.php');

// variables
$queryLogement=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Logement"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryLogement->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryLogement->execute();
$dataLogement = $queryLogement->fetch();
$resultLogement = $dataLogement[0];
    
$queryViequotidienneautreachat=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Vie_quotidienne_autre_achat"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryViequotidienneautreachat->bindValue(':id_createurid', $_SESSION['id'], PDO::PARAM_INT);
$queryViequotidienneautreachat->execute();
$dataVie_quotidienne_autre_achat = $queryViequotidienneautreachat->fetch();
$resultVie_quotidienne_autre_achat = $dataVie_quotidienne_autre_achat[0];

$queryADSL_cable=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="ADSL_cable"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryADSL_cable->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryADSL_cable->execute();
$dataADSL_cable = $queryADSL_cable->fetch();
$resultADSL_cable = $dataADSL_cable[0];
    
$queryTelephone_mobile=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Telephone_mobile"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryTelephone_mobile->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryTelephone_mobile->execute();
$dataTelephone_mobile = $queryTelephone_mobile->fetch();
$resultTelephone_mobile = $dataTelephone_mobile[0];
    
    $logement = $resultTelephone_mobile+$resultVie_quotidienne_autre_achat+$resultLogement+$resultADSL_cable;
    

$querySante=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Sante"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$querySante->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$querySante->execute();
$dataSante = $querySante->fetch();
            
$queryTransport=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Transport"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryTransport->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryTransport->execute();
$dataTransport = $queryTransport->fetch();
            
$queryLoisir=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Loisir"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryLoisir->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryLoisir->execute();
$dataLoisir = $queryLoisir->fetch();
            
$queryImpots=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Impots"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryImpots->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryImpots->execute();
$dataImpots = $queryImpots->fetch();
            
$queryEpargne=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Epargne"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryEpargne->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryEpargne->execute();
$dataEpargne = $queryEpargne->fetch();
            
$queryAlimentation=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Alimentation"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryAlimentation->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryAlimentation->execute();
$dataAlimentation = $queryAlimentation->fetch();

            
$queryAnimaux=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Animaux"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryAnimaux->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryAnimaux->execute();
$dataAnimaux = $queryAnimaux->fetch();
            
$queryScolaire=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Scolaire"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryScolaire->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryScolaire->execute();
$dataScolaire = $queryScolaire->fetch();
            
$queryVetements=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Vetements"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryVetements->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryVetements->execute();
$dataVetements = $queryVetements->fetch();
            
$queryFraisbancaire=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Frais_banquaire"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryFraisbancaire->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryFraisbancaire->execute();
$dataFraisbancaire = $queryFraisbancaire->fetch();
            
$queryFraisprofessionnels=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Frais_professionnels"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryFraisprofessionnels->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryFraisprofessionnels->execute();
$dataFraisprofessionnels = $queryFraisprofessionnels->fetch();
            
$queryCadeaux=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Cadeaux"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryCadeaux->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryCadeaux->execute();
$dataCadeaux = $queryCadeaux->fetch();
            
$queryAutre=$db->prepare('SELECT sum(montant) FROM charges_fixes WHERE categorie="Autre"
AND archive=0
AND debit_credit="D"
AND id_createur=:id_createur
');
$queryAutre->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
$queryAutre->execute();
$dataAutre = $queryAutre->fetch();


if(empty($logement)){$logement = 0;}
else{$Logement = $logement;}

if(empty($dataTransport[0])){$dataTransport[0] = 0;}
else{$Transport = $dataTransport[0];}

if(empty($dataSante[0])){$dataSante[0] = 0;}
else{$Sante = $dataTransport[0];}

if(empty($dataLoisir[0])){$dataLoisir[0] = 0;}
else{$Loisir = $dataLoisir[0];}

if(empty($dataImpots[0])){$dataImpots[0] = 0;}
else{$Impots = $dataImpots[0];}

if(empty($dataEpargne[0])){$dataEpargne[0] = 0;}
else{$Epargne = $dataEpargne[0];}

if(empty($dataAlimentation[0])){$dataAlimentation[0] = 0;}
else{$Alimentation = $dataAlimentation[0];}

if(empty($dataAnimaux[0])){$dataAnimaux[0] = 0;}
else{$Animaux = $dataAnimaux[0];}

if(empty($dataScolaire[0])){$dataScolaire[0] = 0;}
else{$Scolaire = $dataScolaire[0];}

if(empty($dataVetements[0])){$dataVetements[0] = 0;}
else{$Vetements = $dataVetements[0];}

if(empty($dataFraisbancaire[0])){$dataFraisbancaire[0] = 0;}
else{$Frais_bancaire = $dataFraisbancaire[0];}

if(empty($dataFraisprofessionnels[0])){$dataFraisprofessionnels[0] = 0;}
else{$Frais_professionnels = $dataFraisprofessionnels[0];}

if(empty($Cadeaux[0])){$Cadeaux[0] = 0;}
else{$Cadeaux = $Cadeaux[0];}

if(empty($Autre[0])){$Autre[0] = 0;}
else{$Autre = $Autre[0];}


            $Logement = $logement;
			$Transport = $dataTransport[0];
			$Sante = $dataSante[0];
            $Loisir = $dataLoisir[0];
            $Impots = $dataImpots[0];
            $Epargne = $dataEpargne[0];
            $Alimentation = $dataAlimentation[0];
            $Animaux = $dataAnimaux[0];
            $Scolaire = $dataScolaire[0];
            $Vetements = $dataVetements[0];
            $Frais_bancaire = $dataFraisbancaire[0];
            $Frais_professionnels = $dataFraisprofessionnels[0];
            $Cadeaux = $dataCadeaux[0];
            $Autre = $dataAutre[0];















