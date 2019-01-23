<?
session_start();
echo'<div class="bg-fond">';
include('../includes/connexion-bdd.php');
include('../includes/debut.php');



            $id_ecriture = $_POST['id_ecriture'];
            $pointer = $_POST['pointer'];                     
        
         	$query=$db->prepare('UPDATE `ecritures` SET `pointer`=:pointer WHERE id_ecriture=:id_ecriture');

                    $query->bindValue(':id_ecriture', $id_ecriture, PDO::PARAM_INT);
                    $query->bindValue(':pointer', $pointer, PDO::PARAM_INT);
                    $query->execute();
                    $query->CloseCursor();
        
        $query=$db->prepare('select id_compte from ecritures WHERE id_ecriture=:id_ecriture');
        $query->bindValue(':id_ecriture', $id_ecriture, PDO::PARAM_INT);
        $query->execute();
        $data=$query->fetch();
        $id_compte = $data['id_compte'];
        
       echo'<meta http-equiv="refresh" content="0.5 ; url=http://myspacefamily.fr/MaComptaPerso/view/voir-compte.php?id='.$id_compte.'">';