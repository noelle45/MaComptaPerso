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
    include('includes/banniere-connect.php');
    include('includes/menu.php');
        ?>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card ombre card50">
                    <a href="http://localhost/MaComptaPerso/view/budget-mensuel.php"><p class="black a-hover-rose">Mon budget mensuel</p></a>
                </div>
            </div>
        </div>
        <br/>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card ombre card50">
                    <a href="http://localhost/MaComptaPerso/view/mes-comptes.php"><p class="black a-hover-rose">Mes comptes</p></a>
                </div>
            </div> 
        </div>
        <br/>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card ombre card50">
                    <a href="http://localhost/MaComptaPerso/view/saisir-ecriture.php"><p class="black a-hover-rose">Saisie rapide d'écriture</p></a>
                </div>
            </div> 
        </div>
        <br/>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card ombre card50">
                    <a href="http://localhost/MaComptaPerso/view/ma-synthese.php"><p class="black a-hover-rose">Ma synthèse</p></a>
                </div>
            </div> 
        </div>

        <?
}
include('includes/footer.php');