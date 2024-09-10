<?php
    require_once '../../Php/Classes/Utente.php';
    require_once '../../Php/Classes/Debugger.php';

    $email = trim($_POST['email']);
    $password = trim($_POST['psw']);
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $via = trim($_POST['via']);
    $civico = trim($_POST['civico']);
    $citta = trim($_POST['citta']);
    $CAP = trim($_POST['CAP']);

    $user = Utente::signup($nome, $cognome, $email, $password, $via, $citta, $civico, $CAP);

    if(gettype($user) == "object") {
        session_start();
        $_SESSION["logged"] = true;
        $_SESSION["id"] = $user->id;
        $_SESSION["nome"] = $user->nome;
        $_SESSION["cognome"] = $user->cognome;
        $_SESSION["email"] = $user->email;
        $_SESSION["ruolo"] = $user->ruolo;

        if($user->ruolo == 3)
            $page = "trainings";
        else if($user->ruolo == 2)
            $page = "myCourses";
        else if($user->ruolo == 1)
            $page = "users";

        header('location: ../../mainpage.php?page='.$page);
    } else header('location: ../../User/register.php?error='.$user);
    exit;

?>
