<?php
function utilisateur()
{
    $id=$_SESSION['utilisateur_id'];
    $db = dbConnect();
    $query = $db->query('SELECT * FROM utilisateurs WHERE utilisateur_id=id');
    $query->execute();
    $utilisateur = $query->fetch();
    return $utilisateur;
}

function ulisateurParMail()
{
    $mail=$_SESSION['mail_utilisateur'];
    $query = $db->prepare('SELECT * FROM utilisateurs WHERE mail_utilisateur = :email');
    $query->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $utilisateur_connect=$query->fetch();
    return $utilisateur_connect;
}


function dbConnect()
    {
        try
        {
            $db = new PDO('mysql:host=localhost', 'root', '');
        }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
    
}