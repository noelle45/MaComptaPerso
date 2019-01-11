<?php
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(!isset($_SESSION['id']))
{
    ?><div class="row"> <?
        include('../includes/banniere-connect.php');
        include('../includes/menu.php');
        ?></div>

    <p class="white2 violet center pt-3 pb-3">Créer un compte</p>

    <div class="row w-100 justify-content-center">
        <div class="col">
        <form action="registerok.php" method="post" >
            <table class="bg-white-diffu">
                <tr>
                    <td>
                        Votre nom <br/>
                        <input type="text" name="nom_utilisateur" id="nom_utilisateur" />
                    </td>
                <tr>
                </tr>
                    <td>
                        Votre prénom <br/>
                         <input type="text" name="prenom_utilisateur" id="prenom_utilisateur" />
                    </td>
                <tr>
                </tr>
                    <td>
                        Votre email <br/>
                        <input type="mail" name="mail_utilisateur" id="mail_utilisateur" />
                    </td>
                <tr>
                </tr>
                    <td>
                        Choisissez mot de passe <br/>
                        <input type="password" name="password" id="password" />
                    </td>
                <tr>
                </tr>
                    <td>
                        Confirmez votre mot de passe <br/>
                        <input type="password" name="confirm_password" id="confirm_password" /><br>
                    </td>
                <tr>
                </tr>
                <tr>
                    <td class="text-align-center">
                        <input type="submit" value="Créer mon compte"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    </div>
    <?php
}

 else
{
    include('../includes/banniere-connect.php');
    echo'Vous êtes déjà connecté';
}

include('../includes/footer.php');