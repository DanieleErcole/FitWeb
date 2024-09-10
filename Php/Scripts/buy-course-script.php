<?php

    session_start();
    require_once '../../Php/Classes/EntityController.php';
    require_once '../../Php/Classes/Debugger.php';

    $courseID = $_REQUEST["courseID"];
    $date = (new DateTime("now"))->format("Y-m-d");
    $entityController = new EntityController(array("utente_acquista_corso"), "dbObj");
    $entityController->create(array(
        "Utente" => $_SESSION["id"],
        "Corso" => $courseID,
        "Data" => "'".$date."'"
    ));
    exit();

?>
