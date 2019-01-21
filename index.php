<?php
session_start();
include('includes/connexion-bdd.php');
include('includes/debut.php');



if(!isset($_SESSION['id']))
    {
        ?>

<? include('includes/banniere.php'); ?>

        <div class="row w-100 justify-content-center">
            <div class="col">
                <form action="connexion.php" method="post" >
                    <table class="bg-white-diffu">
                        <h2 class="pt-5 black">Bonjour et bienvenue !</h2>
                            <p class="texte-center black"> Pour accéder à cette section <br> vous devez vous identifier</p>
                                        <br/>
                                    <input name="email" type="mail" id="email" placeholder="Email" /><br /><br/>
                                    <input type="password" name="password" id="password" placeholder="Mot de passe" /><br/><br/>

                                    <input type="submit" value="Connexion" />
                        
                                <a href="creation/register.php"><p class="black">Pas encore de compte ?<br/>
                                Inscription gratuite ici</p></a>
                    </table>
                </form>
            </div>
        </div>

        <?php
    }
else
{
    header('Location: view/accueil-mes-comptes.php');
exit;
}
include('includes/footer.php');