<?php

require('classUser.php');

require('bdclass.php');

session_start();

$bdd=Dbconnect::connection();

$User= new User();


if(isset($_POST['inscription'])){
     $reponse= $User->validation($_POST);
     echo "Votre inscription est réussie !";
}

if(isset($_POST['connexion'])){
    $result = $User->connectUser($_POST);
}
  
if ( isset($_POST['editName']) ) {
    $isUser=true;
    $isMail=false;
    $change= $User->editUser($bdd,$isMail,$isUser,$_SESSION['userId']);
}

if ( isset($_POST['editMail']) ) {
    $isUser=false;
    $isMail=true;
    $change= $User->editUser($bdd,$isMail,$isUser,$_SESSION['userId']);
}

if ( isset($_POST['deleteUser'])){

    $delete = $User->deleteUser($bdd,$_SESSION['userId']);    
    if($delete){ echo"Utilisateur supprimé";}  
}

if ( isset($_POST['disconect']) ){
    $disco= $User->deconectUser($bdd,$_SESSION['userId']);    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poo training</title>
</head>
<body>

<div id="ModifMail">
    <form action='' method='post'>
        <label>Votre nouveau email</label>
        <input type='text' name='newMail'>
        <input type='submit' name='editMail'>
    </form>

</div>

<div id="ModifName">
    <form action='' method='post'>
        <label>Votre nouveau Nom</label>
        <input type='text' name='newName'>
        <input type='submit' name='editName'>
    </form>

</div>


<div class='choix'>
    <form action='' method='post'>
        <input type='submit' name='deleteUser' value='Suprimer user'>
        <input type='submit' name='disconect' value='deconnecter user'>
        <input type='submit' name='changeName' value="modifier nom d'utilisateur" id="btnName">
        <input type='submit' name='changeMail' value='modifier email' id="btnMail">
    </form>
</div>



<div class="login">
        <form action="" method="post">
            <p>connexion</p>
            <label for="username">Entrez votre nom d'utilisateur</label>
            <input type="text" name="userconnex">

            <label for="password">Entrez votre mot de passe</label>
            <input type="text" name="passconnex">

            <input type="submit" name="connexion" value="Connexion">
        </form>
</div>

 <hr>

 <div class="register">
        <form action="" method="post">
                <p>inscription</p>
            <label for="email">Entrez votre adresse e-mail</label>
            <input type="text" name="email" id="">

            <label for="username">Entrez votre nom d'utilisateur</label>
            <input type="text" name="username" id="">

            <label for="password">Entrez votre mot de passe</label>
            <input type="text" name="password" > <br>

            <input type="submit" name="inscription" value="register">
        </form>
        
    </div>

</body>
</html>
