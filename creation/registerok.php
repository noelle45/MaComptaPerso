<?php   
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

    $mdp_erreur = NULL;
    $mail_erreur1 = NULL;
    $mail_erreur2 = NULL;
    
    $i = 0;

    $nom = $_POST['nom_utilisateur'];
    $prenom = $_POST['prenom_utilisateur'];
    $mail = $_POST['mail_utilisateur'];
    $password = ($_POST['password']);
    $confirm = ($_POST['confirm_password']);

    //Vérification du mdp

    if ($password != $confirm || empty($confirm) || empty($password))

    {
        $mdp_erreur = "Votre mot de passe et votre confirmation diffèrent, ou sont vides";
        $i++;
    }
    
    //Il faut que l'adresse email n'ait jamais été utilisée

    $query=$db->prepare('SELECT COUNT(*) AS nbr FROM compte_utilisateurs WHERE mail_utilisateur =:mail');
    $query->bindValue(':mail',$mail, PDO::PARAM_STR);
    $query->execute();
    $mail_free=($query->fetchColumn()==0)?1:0;
    $query->CloseCursor();

    if(!$mail_free)
    {
        $mail_erreur1 = "Votre adresse email est déjà utilisée pour un compte";
        $i++;
    }

    //On vérifie la forme

    if (!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $mail) || empty($mail))
    {
        $mail_erreur2 = "Votre adresse E-Mail n'a pas un format valide";
        $i++;
    }

    if ($i==0)
   {
    ?><div class="row"> <?
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        ?></div><?
    echo'<div class="card">';
    echo'<h1>Inscription terminée</h1>';
    echo'<p class="black">Bienvenue '.stripslashes(htmlspecialchars($_POST['prenom_utilisateur'])).' votre compte est créé</p>
    <p class="black a-hover-rose"><a href="crea-banque.php">Cliquez ici pour revenir à la page d\'accueil</a></p>';
    echo'</div>';
        
    $query=$db->prepare('INSERT INTO compte_utilisateurs (nom_utilisateur, prenom_utilisateur, mail_utilisateur,
    password_utilisateur)
    VALUES (:nom, :prenom, :mail, :password)');

    $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $query->bindValue(':nom', $nom, PDO::PARAM_STR);
    $query->bindValue(':mail', $mail, PDO::PARAM_STR);
    $query->bindValue(':password', $password, PDO::PARAM_STR);
    $query->execute();
    //Et on définit les variables de sessions

        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['mail'] = $mail;
        $_SESSION['id'] = $db->lastInsertId(); ;
        $query->CloseCursor();

    }

    else

    {
        ?><div class="row"> <?
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        ?></div><?
        
        echo'<div class="card">';
        echo'<h1>Inscription interrompue</h1>';
        echo'<p class="black">Une ou plusieurs erreurs se sont produites pendant l\'incription</p>';
        echo'<p class="black">'.$i.' erreur(s)</p>';

        echo'<p class="black">'.$mdp_erreur.'</p>';
        echo'<p class="black">'.$mail_erreur1.'</p>';
        echo'<p class="black">'.$mail_erreur2.'</p>';

        echo'<p class="black a-hover-rose"><a href="register.php">Cliquez ici pour recommencer </a></p>';
        echo'</div>';
    }