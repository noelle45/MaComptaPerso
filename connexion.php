<?php
session_start();
include('includes/connexion-bdd.php');
include('includes/debut.php');

$query = $db->prepare('SELECT * FROM compte_utilisateurs WHERE mail_utilisateur = :email');
$query->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
$query->execute();
$data=$query->fetch();

    if (empty($_POST['email']) || empty($_POST['password']) ) //Oublie d'un champ
        {
            echo'<p class="white2 bold center p-5 violet">
            <img src="creation/img/oups.png" height="140px"> Merci de saisir tous les champs</p>';
            ?>
            <div class="row justify-content-center">
          
            <div class="col-6">
              <div class="card ml-5 ombre bg-white-diffu">
                
                <form action="connexion.php" method="post" >
                    
                  <table class="bg-white-diffu">
                        <h2 class="pt-5 black">Bonjour et bienvenue !</h2>
                            <p class="texte-center black"> Pour accéder à cette section <br> vous devez vous identifier</p>
                                        <br/>
                                    <input name="email" type="mail" id="email" placeholder="Email" /><br /><br/>
                                    <input type="password" name="password" id="password" placeholder="Mot de passe" /><br/><br/>

                                    <input type="submit" value="Connexion" />
                        
                                <a href="creation/register.php"><p class="white2 bg-green-diffu bold border-radius-zig p-3 mt-3 mb-3">Pas encore de compte ?<br/>
                                Inscription gratuite ici</p></a>
                    </table>
                  
                </form>
                
            </div> <!-- car -->
            </div> <!-- col-6 -->

              <div class="col-6">
                <div class="card card50 red bg-white-diffu text-left mt-5"> <span class="bold">JAMAIS </span><br/>
                  MaComptaPerso.fr ne vous demandera <br/>
                  les coordonnées de votre établissement bancaire
                  ainsi que vos :<br/>
                  - N° de compte bancaire<br/>
                  - N° de carte Bleue / de paiement ou autre<br/>
                  - Votre RIB / RICE<br/>
                  Votre adresse mail vous est demandée lors de votre inscription afin de vous identifier par la suite.<br/>
                </div>  
             </div>

          </div> <!-- row -->
              <?php

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
                echo'<p class="white2 bold p-5 center violet">Connection en cours...</p>';
                echo'<meta http-equiv="refresh" content="1 ; url=http://myspacefamily.fr/MaComptaPerso/view/accueil-mes-comptes.php">';
				
            } 


			else // Acces pas OK !
			{
				echo'
                
                <div class="row white2 p-5 bold center violet">
                
      			<div class="col-6 text-right">
                <img src="creation/img/oups.png" height="140px">
                </div>
                
                <div class="col-6 text-left pt-5">
                Une erreur s\'est produite lors de votre identification.<br />
                Le mot de passe ou l\'adresse mail saisi n\'est pas correcte.
                </div>
                
                </div>';
                
              ?>

			<div class="row justify-content-center">
          
            <div class="col-6">
              <div class="card ml-5 ombre bg-white-diffu">
                
                <form action="connexion.php" method="post" >
                    
                  <table class="bg-white-diffu">
                        <h2 class="pt-5 black">Bonjour et bienvenue !</h2>
                            <p class="texte-center black"> Pour accéder à cette section <br> vous devez vous identifier</p>
                                        <br/>
                                    <input name="email" type="mail" id="email" placeholder="Email" /><br /><br/>
                                    <input type="password" name="password" id="password" placeholder="Mot de passe" /><br/><br/>

                                    <input type="submit" value="Connexion" />
                        
                               <a href="creation/register.php"><p class="white2 bold bg-green-diffu border-radius-zig p-3 mt-3 mb-3">Pas encore de compte ?<br/>
                                Inscription gratuite ici</p></a>
                    </table>
                  
                </form>

                </div> <!-- car -->
            </div> <!-- col-6 -->

              <div class="col-6">
                <div class="card card50 red bg-white-diffu text-left mt-5"> <span class="bold">JAMAIS </span><br/>
                    MaComptaPerso.fr ne vous demandera <br/>
                    les coordonnées de votre établissement bancaire
                    ainsi que vos :<br/>
                    - N° de compte bancaire<br/>
                    - N° de carte Bleue / de paiement ou autre<br/>
                    - Votre RIB / RICE<br/>
                    Votre adresse mail vous est demandée lors de votre inscription afin de vous identifier par la suite.<br/>


                </div>  
             </div>

              </div> <!-- row -->
       			 <?php
            }
    }
$query->CloseCursor();

include('includes/footer.php');