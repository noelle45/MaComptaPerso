<?php
session_start();
include('includes/connexion-bdd.php');
include('includes/debut.php');

$query = $db->prepare('SELECT * FROM compte_utilisateurs WHERE mail_utilisateur = :email');
$query->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
$query->execute();
$data=$query->fetch();

$message='';
    if (empty($_POST['email']) || empty($_POST['password']) ) //Oublie d'un champ
        {
            $message = '<p class="white2 center violet">Merci de saisir tous les champs</p>
            <p class="white2 center violet"><a class="white" href="index.php">
            Cliquez ici pour revenir à la page précédente</a></p>';
        }

    else // Acces OK !
		{
			$_SESSION['email'] = $data['mail_utilisateur'];
			$_SESSION['prenom'] = $data['prenom_utilisateur'];
      		$_SESSION['nom'] = $data['nom_utilisateur'];
			$_SESSION['id'] = $data['id_utilisateur'];
			$message = ' ';
      		
            
			if ($data['mail_utilisateur'] == $_POST['email'] && $data['password_utilisateur'] == $_POST['password'])
			{
                include("includes/banniere.php");
                include("includes/menu.php");
                echo'<h2 class="violet center pt-3 pb-3">Connection en cours...</h2>';
                ?>
				<meta http-equiv="refresh" content="1 ; url=http://localhost/MaComptaPerso/view/accueil-mes-comptes.php">
				<?php
            } 


			else // Acces pas OK !
			{
                include('includes/banniere.php');
				$message = '<p class="white2 center violet">Une erreur s\'est produite lors de votre identification.<br /> 
                Le mot de passe ou l\'adresse mail saisi n\'est pas correcte.</p>';
                
                ?>
				<meta http-equiv="refresh" content="5 ; url=deconnexion.php">
				<?php
			}
    }
		$query->CloseCursor();
echo $message; 



include('includes/footer.php');