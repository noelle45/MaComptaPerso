<?php
session_start();
include('includes/connexion-bdd.php');
include('includes/debut.php');



if(!isset($_SESSION['id']))
    {
		include('includes/banniere.php');
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
                        
                                <a href="creation/register.php">
                                  <p class="white2 bg-green-diffu bold border-radius-zig p-3 mt-3 mb-3">Pas encore de compte ?<br/>
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
              Votre adresse mail vous est demandée lors de votre inscription
              afin que vous puissiez vous identifier lors de votre prochaine 
              connexion à votre espace personnel.<br/>
          </div>  
       </div>
          
	</div> <!-- row
        <?php
    }
else
{
  include('includes/banniere-connecte.php');
  include('includes/menu.php');
  echo'Vous êtes déjà connecté(e)"';
}

include('includes/footer.php');