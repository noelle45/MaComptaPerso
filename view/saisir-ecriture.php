<?php
session_start();
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{

        $query=$db->prepare('SELECT id_createur, COUNT(id_banque)
        AS nbrb
        FROM banques 
        WHERE id_createur=:id_createur');
        $query->bindValue(':id_createur', $_SESSION['id'], PDO::PARAM_INT);
        $query->execute();
        $data = $query->fetch();
        $nbrb = $data['nbrb'];
    
        if($data['nbrb']<1)
        {
            ?><div class="row"> <?
            include('../includes/banniere-connect.php');
            include('../includes/menu.php');
            ?></div><?
            
            echo'<div class="row mx-auto h-50">';
                echo'<div class="card ombre card50 p-5">';
                    echo'<p class="mb-5">Commençons par créer une banque</p><br/>
                    <a class="white2" href="../creation/crea-banque.php">
                    <img class="mt-3" src="../creation/img/bank-icon.png" alt="icone crea banque" title="Nouvelle banque" width="150px"/>
                    </a>';
                echo'</div>';
            echo'</div>';
            
        }
        
        else
        {
            ?><div class="row"> <?
            include('../includes/banniere-connect.php');
            include('../includes/menu.php');
            ?></div>

            <div class="row w-100 justify-content-center">
                <div class="col">
            <form action="../creation/crea-ecritureok.php" method="post" >
                <div class=" card card50 p-2 ombre bg-white-diffu">
                    <p class="stardust">Saisie rapide</p>
            <table style="margin-top:-20px">
                <tr>
                    <td>
                        date de débit <br/>
                        <input type="date" name="date_ecriture" id="date_ecriture" />
                </tr>
                <tr>
                    <td>
                        Catégorie <br/>
                        <select id="categorie" name="categorie" >
                          			<option value="Logement">Logement </option> 
                                    <option value="Sante"> Sante </option> 
                                    <option value="Transport"> Transport </option>
                                    <option value="Impots"> Impôts </option>
                                    <option value="Epargne"> Epargne </option>
                                    <option value="Loisir"> Loisir </option>
                                    <option value="Alimentation"> Alimentation </option>
                                    <option value="Animaux"> Animaux </option>
                                    <option value="Scolaire"> Scolaire </option>
                                    <option value="Vie quotidienne autre achat"> Vie quotidienne autre achat </option>
                                    <option value="Vêtements"> Vêtements </option>
                                    <option value="Frais fixe"> Frais fixe </option>
                                  	<option value="Frais banquaire"> Frais banquaire </option>
                                    <option value="Frais professionnels"> Frais professionnels </option>
                                    <option value="Ressources"> Ressources </option>
                                  	<option value="Cadeaux"> Cadeaux </option>
                                  	<option value="Autre"> Autre </option>
                                </select>
                    </td>
                    <td>
                        Objet <br/>
                        <input type="text" name="objet" id="objet" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Montant <br/>
                        <input type="number" name="montant" id="montant" step="0.01" required/>
                    </td>
                    <td>Type d'opération<br/>
                        <select id="debit_credit" name="debit_credit" >
                            <option value="D">Débit </option>
                            <option value="C">Crédit </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-align-center">
                        <?
 
                        $query=$db->prepare('SELECT * FROM comptes');
                        $query->execute();
                        echo'<fieldset><legend>Sur le compte</legend>';
                        
                        while($data = $query->fetch())
                        { 
                            if($data['id_createur']==$_SESSION['id'])
                            {
                                echo'<input type="radio" name="id_compte" value="'.$data['id_compte'].'">';
                                echo $data['nom_compte'];
                                echo'<br/>';
                            }
                        }
                        echo'</fieldset>';
                        
                        echo'
                        <input type="hidden" name="date_saisie" id="date_saisie" value="'.date("Y-m-d H:i:s").'"/>
                        '; ?>
                    </td>
                    <tr>
                        <td colspan="2" class="text-align-center">
                            <input type="submit" value="Créer!"/>
                        </td>
                    </tr>
            </table>
                    </div>
        </form>
    </div>
    </div>
    <?php 
    }
}
else
{
    include('../includes/banniere.php');
    include('../includes/menu.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');