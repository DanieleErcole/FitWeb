<?php

    require_once '../../Php/Classes/EntityController.php';
    require_once '../../Php/Classes/Debugger.php';

    session_start();
    $method = $_REQUEST["method"];
    $tableID = isset($_REQUEST["tableID"]) ? $_REQUEST["tableID"] : -1;

    if($method == "delete") {
        $entityController = new EntityController(array("tabella_di_allenamento"), "tabellaAllenamento");
        $entityController->delete(array("tabella_di_allenamento.Id = ".$tableID));
        $entityController->closeConnection();
    } else if($method == "add") {
        //NOTA: poi mettere l'ID del corso
        $entityController = new EntityController(array("tabella_di_allenamento"), "tabellaAllenamento");
        $entityController->create(array(
            "NomeTabella" => "'".$_REQUEST["tableName"]."'",
            "OraInizio" => "'".$_REQUEST["startTime"]."'",
            "Utente" => $_SESSION["id"],
            "corso" => $_SESSION["ruolo"] != 2 ? "null" : $_SESSION["tableCourse"]
        ));
        $tableID = $entityController->getLastId();
        $entityController->closeConnection();

        $entityController = new EntityController(array("tabella_si_svolge_in_giorno"), "dbObj");
        //NOTA: inserisco i giorni specifici
        $i = 1;
        $dates = array();
        while(isset($_REQUEST["data-".$i])) {
            $dates[] = $_REQUEST["data-".$i];
            $i++;
        }

        foreach($dates as $d) {
            $date = DateTime::createFromFormat("Y-m-d", $d);
            $entityController->create(array(
                "Tabella" => $tableID,
                "Giorno" => $date->format("w") == 0 ? 7 : $date->format("w"),
                "Ripetizione" => 0,
                "Data" => "'".$d."'",
            ));
        }

        //NOTA: inserisco i giorni ripetuti
        $i = 1;
        $dates = array();
        while(isset($_REQUEST["ripData-".$i])) {
            $dates[] = $_REQUEST["ripData-".$i];
            $i++;
        }

        foreach($dates as $d) {
            $entityController->create(array(
                "Tabella" => $tableID,
                "Giorno" => $d,
                "Ripetizione" => 1,
                "Data" => "'0000-00-00'",
            ));
        }
        $entityController->closeConnection();

        $entityController = new EntityController(array("esercizio"), "esercizio");
        $exercises = $entityController->findWhere(array());

        $exNum = $_REQUEST["exCounter"];
        for($i = 1; $i <= $exNum; $i++) {
            $exFound = false;
            foreach($exercises as $ex) {
                if($ex->nome == $_REQUEST["exName-".$i] && $ex->tempo == $_REQUEST["exTime-".$i] && $ex->pesi == $_REQUEST["exWeight-".$i] && $ex->ripetizioni == $_REQUEST["exRip-".$i] && $ex->serie == $_REQUEST["exSerie-".$i]
                    && $ex->riposo == $_REQUEST["exBreak-".$i]) {
                    $exFound = true;
                    $exId = $ex->id;
                    break;
                }
            }

            if(!$exFound) {
                $entityController->create(array(
                    "Nome" => "'".$_REQUEST["exName-".$i]."'",
                    "Tempo" => ($_REQUEST["exTime-".$i] == "00:00" ? "null" : "'".$_REQUEST["exTime-".$i]."'"),
                    "Pesi" => ($_REQUEST["exWeight-".$i] == null ? "null" : $_REQUEST["exWeight-".$i]),
                    "Ripetizioni" => ($_REQUEST["exRip-".$i] == null ? "null" : $_REQUEST["exRip-".$i]),
                    "Serie" => ($_REQUEST["exSerie-".$i] == null ? "null" : $_REQUEST["exSerie-".$i]),
                    "Riposo" => ($_REQUEST["exBreak-".$i] == "00:00" ? "null" : "'".$_REQUEST["exBreak-".$i]."'")
                ));
                $exId = $entityController->getLastId();
                $entityController->closeConnection();

                //NOTA: inserire i muscoli nell'associazione esercizio_allena_muscolo, trovo i muscoli allenati da un es con quel nome, tanto io prendo nel form i nomi di esercizi per forza presenti nel db
                $entityController = new EntityController(array("muscolo", "esercizio_allena_muscolo", "esercizio"), "muscolo");
                $musclesFound = $entityController->findWhere(array("esercizio.Nome = '".$_REQUEST["exName-".$i]."'", "esercizio.Id = esercizio_allena_muscolo.Esercizio", "muscolo.Id = esercizio_allena_muscolo.Muscolo"), array("AND", "AND"), array("muscolo.Id", "muscolo.Nome"));
                $entityController->closeConnection();

                $entityController = new EntityController(array("esercizio_allena_muscolo"), "dbObj");
                foreach($musclesFound as $muscle) {
                    $entityController->create(array(
                        "Esercizio" => $exId,
                        "Muscolo" => $muscle->id
                    ));
                }
                $entityController->closeConnection();
            }

            $entityController = new EntityController(array("esercizio_associato_a_tabella"), "dbObj");
            $entityController->create(array(
                "Esercizio" => $exId,
                "Tabella" => $tableID
            ));
            $entityController->closeConnection();
        }
    } else if($method == "edit") {
        $entityController = new EntityController(array("tabella_di_allenamento"), "tabellaAllenamento");
        $entityController->update(array("tabella_di_allenamento.NomeTabella", "tabella_di_allenamento.OraInizio"),
            array("'".$_REQUEST["tableName"]."'", "'".$_REQUEST["startTime"]."'"),
            array("tabella_di_allenamento.Id = ".$tableID), array());
        $entityController->closeConnection();

        $entityController = new EntityController(array("tabella_si_svolge_in_giorno"), "dbObj");
        $entityController->delete(array("tabella_si_svolge_in_giorno.Tabella = ".$tableID));

        //NOTA: inserisco i giorni specifici
        $i = 1;
        $dates = array();
        while(isset($_REQUEST["data-".$i])) {
            $dates[] = $_REQUEST["data-".$i];
            $i++;
        }

        foreach($dates as $d) {
            $date = DateTime::createFromFormat("Y-m-d", $d);
            $entityController->create(array(
                "Tabella" => $tableID,
                "Giorno" => $date->format("w") == 0 ? 7 : $date->format("w"),
                "Ripetizione" => 0,
                "Data" => "'".$d."'",
            ));
        }

        //NOTA: inserisco i giorni ripetuti
        $i = 1;
        $dates = array();
        while(isset($_REQUEST["ripData-".$i])) {
            $dates[] = $_REQUEST["ripData-".$i];
            $i++;
        }

        foreach($dates as $d) {
            $entityController->create(array(
                "Tabella" => $tableID,
                "Giorno" => $d,
                "Ripetizione" => 1,
                "Data" => "'0000-00-00'",
            ));
        }
        $entityController->closeConnection();

        $entityController = new EntityController(array("esercizio_associato_a_tabella"), "dbObj");
        $entityController->delete(array("esercizio_associato_a_tabella.Tabella = ".$tableID));
        $entityController->closeConnection();

        $entityController = new EntityController(array("esercizio"), "esercizio");
        $exercises = $entityController->findWhere(array());

        $exNum = $_REQUEST["exCounter"];
        for($i = 1; $i <= $exNum; $i++) {
            $exFound = false;
            foreach($exercises as $ex) {
                if($ex->nome == $_REQUEST["exName-".$i] && $ex->tempo == $_REQUEST["exTime-".$i] && $ex->pesi == $_REQUEST["exWeight-".$i] && $ex->ripetizioni == $_REQUEST["exRip-".$i] && $ex->serie == $_REQUEST["exSerie-".$i]
                    && $ex->riposo == $_REQUEST["exBreak-".$i]) {
                    $exFound = true;
                    $exId = $ex->id;
                    break;
                }
            }

            if(!$exFound) {
                $entityController->create(array(
                    "Nome" => "'".$_REQUEST["exName-".$i]."'",
                    "Tempo" => ($_REQUEST["exTime-".$i] == "00:00" ? "null" : "'".$_REQUEST["exTime-".$i]."'"),
                    "Pesi" => ($_REQUEST["exWeight-".$i] == null ? "null" : $_REQUEST["exWeight-".$i]),
                    "Ripetizioni" => ($_REQUEST["exRip-".$i] == null ? "null" : $_REQUEST["exRip-".$i]),
                    "Serie" => ($_REQUEST["exSerie-".$i] == null ? "null" : $_REQUEST["exSerie-".$i]),
                    "Riposo" => ($_REQUEST["exBreak-".$i] == "00:00" ? "null" : "'".$_REQUEST["exBreak-".$i]."'")
                ));
                $exId = $entityController->getLastId();
                $entityController->closeConnection();

                //NOTA: inserire i muscoli nell'associazione esercizio_allena_muscolo, trovo i muscoli allenati da un es con quel nome, tanto io prendo nel form i nomi di esercizi per forza presenti nel db
                $entityController = new EntityController(array("muscolo", "esercizio_allena_muscolo", "esercizio"), "muscolo");
                $musclesFound = $entityController->findWhere(array("esercizio.Nome = '".$_REQUEST["exName-".$i]."'", "esercizio.Id = esercizio_allena_muscolo.Esercizio", "muscolo.Id = esercizio_allena_muscolo.Muscolo"), array("AND", "AND"), array("muscolo.Id", "muscolo.Nome"));
                $entityController->closeConnection();

                $entityController = new EntityController(array("esercizio_allena_muscolo"), "dbObj");
                foreach($musclesFound as $muscle) {
                    $entityController->create(array(
                        "Esercizio" => $exId,
                        "Muscolo" => $muscle->Id
                    ));
                }
                $entityController->closeConnection();
            }

            $entityController = new EntityController(array("esercizio_associato_a_tabella"), "dbObj");
            $entityController->create(array(
                "Esercizio" => $exId,
                "Tabella" => $tableID
            ));
            $entityController->closeConnection();
        }
    }

    header('location: ../../mainpage.php?page=trainings');

?>
