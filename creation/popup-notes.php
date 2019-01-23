<?php
session_start();
echo'<div class="bg-fond">';

include('../includes/connexion-bdd.php');
include('../includes/debut.php');
?>
<script langage="javascript">
    function isDOMRequired() 
    {
    // Return false, indicating that this object is available in code view.
    return false;
    }

    function objectTag() 
    {
    return document.body.innerHTML;
    }
</script>
<?php
//-------------------------------------------------------------------
$id=$_SESSION['id'];
            $query=$db->prepare('SELECT *
            FROM notes WHERE id_createur=:id ORDER BY id_note ASC');
  			$query->bindValue(':id',$id,PDO::PARAM_INT);
            $query->execute();
?>
<div class="card bg-white-diffu">
<table>

    
    <table class="w-100">
        <tr>
            <th>Date de saisie</th>
            <th>Objet</th>
            <th class="text-align-center">Action</th>
            </tr>
    <?php
    while($data = $query->fetch()) 
    {
        if($data['id_createur'] == $_SESSION['id'])
        {
            echo'
            <tr>
                <td>
                    <p class="text-left note siez22">' . date('d-m-Y', strtotime($data['date_note'])) . '</p>
                </td>
                <td>
                    <p class="text-left note siez22">' . $data['note_note'] . '</p>
                </td>
                <td>
                    <p class="text-align-center bg-green-diffu border-radius-zig p-2">
                    <a class="white2" href="delete-notes.php?id='.$data['id_note'].'">Supprimer</a></p>
                </td>
            </tr>';
        }
    }
?>
  </table>
<input type="submit" name="Submit" value="Fermer la fen&ecirc;tre" onClick="window.close()">
</div>
<?php


//--------------------------------------------------------------------------------
