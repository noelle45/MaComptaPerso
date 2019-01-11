<html lang="fr">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name=”robots” content=”index,follow” />
<meta name="author" content=”noelle-monge.fr“/>
<meta name=”twitter:creator” content=”@MongeNoelle” />
<meta property="og:title" content="MaComptaPerso">
<meta property="og:type" content="Comptabilité personnelle">
<meta property="og:description" content="Tenir ses comptes personnels avec un outil simple et intuitif et 100% gratuit!">
<meta property="og:image" content="">
    
<meta property="og:image:alt" content="Logo MySpaceFamily">
<meta name="twitter:title" content="MaComptaPerso">
<meta name="twitter:url" content="">
<meta name="twitter:description" content="Ma Compta Perso est un outil simple de budget personnel 100% gratuit, facile d'accés et intuitif. Tenir ses comptes ne sera jamais plus une corvée">
    
<meta name="twitter:image" content="">
    
<meta http-equiv="x-ua-compatible" content="ie=edge">
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">
<link href="css/business-casual.min.css" rel="stylesheet">

<link rel="stylesheet" media="screen" type="text/css" title="Design" href="http://myspacefamily.com/css/constant.css" />
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="http://localhost/MaComptaPerso/creation/style.css" />

<?php
//Attribution des variables de session
$id=(isset($_SESSION['id_utilisateur']))?(int) $_SESSION['id']:0;
$prenom=(isset($_SESSION['prenom_utilisateur']))?$_SESSION['prenom']:'';
$nom=(isset($_SESSION['nom_utilisateur']))?$_SESSION['nom']:'';
$mail=(isset($_SESSION['mail_utilisateur']))?$_SESSION['mail']:'';
//On inclue les 2 pages restantes


    echo '<title> MaComptaPerso </title>';

?>
    </head>
<body>
