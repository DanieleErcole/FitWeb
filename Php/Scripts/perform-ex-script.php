<?php
    require_once '../../Php/Classes/EntityController.php';
    require_once '../../Php/Classes/Debugger.php';

    session_start();

    $table = $_REQUEST["table"];
    $ex = $_REQUEST["exercise"];
    $exTime = $_REQUEST["exTime"];
    $exWeight = $_REQUEST["exWeight"];
    $exRip = $_REQUEST["exRip"];
    $exSerie = $_REQUEST["exSerie"];
    $tDate = $_REQUEST["tDate"];

    $nowTime = strtotime((new DateTime("now"))->format("d/m/Y"));
    $tDateTime = strtotime($tDate);

    if($nowTime <= $tDateTime) {
        $controller = new EntityController(array("esercizio"), "esercizio");
        $ex = $controller->findWhere(array("esercizio.Id = ".$ex));
        $controller->closeConnection();

        $controller = new EntityController(array("utente_esegue_esercizio"), "dbObj");
        $controller->create(array(
            "Utente" => $_SESSION["id"],
            "Esercizio" => $ex[0]->id
        ));
        $controller->closeConnection();
    } else Debugger::logErr("impossibile eseguire un esercizio con una data successiva a quella odierna");

    header('location: ../../mainpage.php?page=trainings');

?>
