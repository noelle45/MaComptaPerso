<?php
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');

if(isset($_SESSION['id']))
{
            include('../includes/banniere-connect.php');
            include('../includes/menu.php');
    
        $date_ecriture = $_POST['date_ecriture']; // pour le
        $categorie = $_POST['categorie'];
        $objet = $_POST['objet'];
        $montant = $_POST['montant']; // montant saisi
        $debit_credit = $_POST['debit_credit'];
        $id_createur = $_SESSION['id'];
        $id_compte = $_POST['id_compte'];
        $date_saisie = $_POST['date_saisie']; // date saisie
  		$mode_reglement = $_POST['mode_reglement'];
        
        //$id_banque = $_POST['id_banque'];
    
    if($_POST['categorie'] == "Echeance")
    {
        $query=$db->prepare('INSERT INTO ecritures (date_saisie, date_ecriture, categorie, objet, montant, debit_credit, id_compte, id_createur, mode_reglement)
            VALUES (:date_saisie, :date_ecriture, :categorie, :objet, :montant, :debit_credit, :id_compte, :id_createur, :mode_reglement)');

            $montant= str_replace(',','.',$montant);

            $query->bindValue(':date_saisie', $date_saisie, PDO::PARAM_STR);
            $query->bindValue(':date_ecriture', $date_ecriture, PDO::PARAM_STR);
            $query->bindValue(':categorie', $categorie, PDO::PARAM_STR);
            $query->bindValue(':objet', $objet, PDO::PARAM_STR);
            $query->bindValue(':debit_credit', $debit_credit, PDO::PARAM_STR);
            $query->bindValue(':montant', $montant, PDO::PARAM_STR);
            $query->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
            $query->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
      		$query->bindValue(':mode_reglement', $mode_reglement, PDO::PARAM_STR);
            $query->execute();

            $query2=$db->prepare('SELECT id_banque, nom_compte, id_compte, nom_banque
            FROM comptes
            WHERE id_compte =:id_compte');
            $query2->bindValue(':id_compte',$_POST['id_compte'], PDO::PARAM_INT);
            $query2->execute();
            $data2=$query2->fetch();
            $id_banque2 = $data2['id_banque'];
            $nom_compte2 = $data2['nom_compte'];
            $id_compte2 = $data2['id_compte'];
            $nom_banque2 = $data2['nom_banque'];
      		

            $query3=$db->prepare('UPDATE ecritures
            SET id_banque=:id_banque , nom_compte=:nom_compte , nom_banque=:nom_banque, id_compte=:id_compte
            WHERE id_createur=:id_createur
            AND objet=:objet
            AND date_saisie=:date_saisie
            AND montant=:montant');

            $query3->bindValue(':id_createur',$_SESSION['id'], PDO::PARAM_INT);
            $query3->bindValue(':objet',$_POST['objet'], PDO::PARAM_STR);
            $query3->bindValue(':date_saisie',$_POST['date_saisie'], PDO::PARAM_STR);
            $query3->bindValue(':montant',$_POST['montant'], PDO::PARAM_STR);
            $query3->bindValue(':id_banque',$id_banque2, PDO::PARAM_INT);
            $query3->bindValue(':nom_compte',$nom_compte2, PDO::PARAM_STR);
            $query3->bindValue(':nom_banque',$nom_banque2, PDO::PARAM_STR);
            $query3->bindValue(':id_compte',$id_compte2, PDO::PARAM_INT);
            $query3->execute();
    
        
        echo'
            <div class="card pt-5">';
            echo'Nom de la créance à imputer';
            $query4=$db->prepare('SELECT * FROM creances WHERE id_createur=:id_createur');
            $query4->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
            $query4->execute();
            
                echo'
                <form action="3.php" method="post">
                <select id="creance_id" name="creance_id" >';
                while($data4=$query4->fetch())
                {
                    echo'<option value="'.$data4['creance_id'].'">'.$data4['creance_nom'].'</option>';
                }
                echo'</select>
                    <input type="hidden" name="montant" value="'.$montant.'"/>
                    <input type="hidden" name="date_ecriture" value="'.$date_ecriture.'"/>
                    <input type="hidden" name="id_compte" value="'.$id_compte.'"/>
                    <input type="hidden" name="date_saisie" value="'.$date_saisie.'"/>
                    <input type="hidden" name="objet" value="'.$objet.'"/>
                    <input type="hidden" name="nom_banque" value="'.data2['nom_banque'].'"/>
                    <input type="hidden" name="id_banque" value="'.$id_banque2.'"/>
                    <input type="hidden" name="debit_credit" value="'.$debit_credit.'"/>
                    <input type="hidden" name="nom_compte" value="'.$nom_compte2.'"/>
                    <input type="hidden" name="montant_echeance" value="'.$data4['montant_echeance'].'"/>
                    <input type="hidden" name="date_paiement" value="'.$data4['date_paiement'].'"/>
                    <input type="submit" value="Valider" />
                </form>';
                echo'</div>';
        
        }
    
        else
        {
            ?><div class="row"> <?
            include('../includes/banniere-connect.php');
            include('../includes/menu.php');
            ?></div><?

            $query=$db->prepare('INSERT INTO ecritures (date_saisie, date_ecriture, categorie, objet, montant, debit_credit, id_compte, id_createur, mode_reglement)
            VALUES (:date_saisie, :date_ecriture, :categorie, :objet, :montant, :debit_credit, :id_compte, :id_createur, :mode_reglement)');

            $montant= str_replace(',','.',$montant);

            $query->bindValue(':date_saisie', $date_saisie, PDO::PARAM_STR);
            $query->bindValue(':date_ecriture', $date_ecriture, PDO::PARAM_STR);
            $query->bindValue(':categorie', $categorie, PDO::PARAM_STR);
            $query->bindValue(':objet', $objet, PDO::PARAM_STR);
            $query->bindValue(':debit_credit', $debit_credit, PDO::PARAM_STR);
            $query->bindValue(':montant', $montant, PDO::PARAM_STR);
            $query->bindValue(':id_compte', $id_compte, PDO::PARAM_INT);
            $query->bindValue(':id_createur', $id_createur, PDO::PARAM_INT);
          	$query->bindValue(':mode_reglement', $mode_reglement, PDO::PARAM_STR);
            $query->execute();

            $query2=$db->prepare('SELECT id_banque, nom_compte, id_compte, nom_banque
            FROM comptes
            WHERE id_compte =:id_compte');
            $query2->bindValue(':id_compte',$_POST['id_compte'], PDO::PARAM_INT);
            $query2->execute();
            $data2=$query2->fetch();
            $id_banque2 = $data2['id_banque'];
            $nom_compte2 = $data2['nom_compte'];
            $id_compte2 = $data2['id_compte'];
            $nom_banque2 = $data2['nom_banque'];

            $query3=$db->prepare('UPDATE ecritures
            SET id_banque=:id_banque , nom_compte=:nom_compte , nom_banque=:nom_banque, id_compte=:id_compte
            WHERE id_createur=:id_createur
            AND objet=:objet
            AND date_saisie=:date_saisie
            AND montant=:montant');

            $query3->bindValue(':id_createur',$_SESSION['id'], PDO::PARAM_INT);
            $query3->bindValue(':objet',$_POST['objet'], PDO::PARAM_STR);
            $query3->bindValue(':date_saisie',$_POST['date_saisie'], PDO::PARAM_STR);
            $query3->bindValue(':montant',$_POST['montant'], PDO::PARAM_STR);
            $query3->bindValue(':id_banque',$id_banque2, PDO::PARAM_INT);
            $query3->bindValue(':nom_compte',$nom_compte2, PDO::PARAM_STR);
            $query3->bindValue(':nom_banque',$nom_banque2, PDO::PARAM_STR);
            $query3->bindValue(':id_compte',$id_compte2, PDO::PARAM_INT);
            $query3->execute();




            echo'
            <div class="card">';

            echo'
            <h2>'.$montant.' € enregistré pour le compte '.$nom_compte2.' <br/> Banque : '.$nom_banque2.' !</h2>
            <p><a style="color:blue" href="../view/voir-compte.php?id='.$id_compte.'">Retour</a>';
            echo'</div>';
        }
    

}
else
{
    include('../includes/banniere.php');
    echo'Vous n\'êtes pas connecté';
}

include('../includes/footer.php');
echo'</div>';