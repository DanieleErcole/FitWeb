<?php

    require_once '../../Php/Classes/Utente.php';
    require_once '../../Php/Classes/Debugger.php';

    $email = trim($_POST['email']);
    $password = trim($_POST['psw']);
    $user = Utente::login($email, $password);

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
    } else header('location: ../../User/login.php?error='.$user);
    exit;

?>
