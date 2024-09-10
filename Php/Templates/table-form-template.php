<?php

    require_once '../../Php/Classes/EntityController.php';
    require_once '../../Php/Classes/Debugger.php';

    $path = $_REQUEST["path"];
    $method = $_REQUEST["method"];
    $tID = isset($_REQUEST["tableId"]) ? $_REQUEST["tableId"] : -1;

    $tableDays = array();
    if($tID != -1) {
        $controller = new EntityController(array("tabella_di_allenamento"), "tabellaAllenamento");
        $table = $controller->find($tID, "Id");
        $controller->closeConnection();

        $controller = new EntityController(array("tabella_si_svolge_in_giorno", "giorno"), "dbObj");
        $tableDays = $controller->findWhereAssoc(array("tabella_si_svolge_in_giorno.Data", "tabella_si_svolge_in_giorno.Ripetizione", "giorno.Nome", "giorno.Id"), array("tabella_si_svolge_in_giorno.Tabella = ".$tID, "tabella_si_svolge_in_giorno.Giorno = giorno.Id"), array("AND"));
        $controller->closeConnection();

        $i = 1;
        $c = 1;
        $dateInputs = array();
        $daysInputs = array();
        foreach($tableDays as $tD) {
            if($tD["Data"] != "0000-00-00") {
                $dateInputs[] = '<input type="hidden" name="data-'.$i.'" value="'.$tD["Data"].'">';
                $i++;
            } else if($tD["Ripetizione"] == 1) {
                $daysInputs[] = '<input type="hidden" name="ripData-'.$c.'" value="'.$tD["Id"].'">';
                $c++;
            }
        }

        $controller = new EntityController(array("esercizio", "esercizio_associato_a_tabella"), "esercizio");
        $exercises = $controller->findWhere(array("esercizio_associato_a_tabella.Tabella = ".$tID,
            "esercizio_associato_a_tabella.Esercizio = esercizio.Id"), array("AND"),
                array("esercizio.Id",
                    "esercizio.Nome",
                    "esercizio.Tempo",
                    "esercizio.Pesi",
                    "esercizio.Ripetizioni",
                    "esercizio.Serie",
                    "esercizio.Riposo"));
        $controller->closeConnection();
    }

?>
<div class="flex-column form-cont">
    <div class="flex-row f-title">
        <?php echo $method == "add" ? 'Nuova tabella' : "Modifica tabella"; ?>
    </div>
    <div class="flex-row form-table-attrs">
        <input type="text" name="tableName" class="input-txt-box" <?php echo $method == "add" ? 'placeholder="Nome tabella"' : 'value="'.$table->tableName.'"'; ?>>
        <div class="flex-row time-wrapper-cont">
            <label class="flex-align-center f-label">Ora inizio</label>
            <input type="time" name="hour" class="input-time-box" <?php echo $method == "add" ? 'placeholder="Nome tabella"' : 'value="'.explode(":", $table->hour)[0].':'.explode(":", $table->hour)[1].'"' ; ?>>
        </div>
    </div>
    <div class="flex-row time-wrapper-cont date">
        <input type="date" name="exDate" class="input-txt-box" placeholder="Data">
        <button class="flex-row flex-align-center flex-justify-center add-data-btn">Aggiungi data</button>
    </div>
    <div class="flex-row f-ex-title">
        Giorni della settimana
    </div>
    <div class="flex-row form-table-attrs week">
        <?php
            $array = array("Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica");
            foreach($array as $a) {
                $isDay = false;
                foreach($tableDays as $tD) {
                    if($tD["Nome"] == $a && $tD["Data"] == "0000-00-00") {
                        echo '<div class="flex-row check-wrap">
                            <input type="checkbox" name="'.$tD["Nome"].'" value="'.$tD["Id"].'" checked="">
                            <label class="flex-align-center" for="'.$tD["Nome"].'">'.$tD["Nome"].'</label>
                        </div>';
                        $isDay = true;
                        break;
                    }
                }
                if(!$isDay) {
                    echo '<div class="flex-row check-wrap">
                        <input type="checkbox" name="'.$a.'" value="'.(array_search($a, $array) + 1).'">
                        <label class="flex-align-center" for="'.$a.'">'.$a.'</label>
                    </div>';
                }
            }
        ?>
    </div>
    <div class="flex-row f-ex-title">
        Nuovo esercizio
    </div>
    <div class="flex-row flex-align-center flex-justify-center form-add-ex">
        <div class="flex-column flex-justify-center form-group">
            <select name="exName" class="input-txt-box">
                <?php
                    $controller = new EntityController(array("esercizio"), "esercizio");
                    $exs = $controller->findWhere(array(), array(),array("esercizio.Id",
                        "esercizio.Nome", "esercizio.Tempo", "esercizio.Pesi", "esercizio.Ripetizioni",
                        "esercizio.Serie", "esercizio.Riposo"));
                    $controller->closeConnection();

                    foreach($exs as $e)
                        echo '<option value="'.$e->id.'">'.$e->nome.'</option>';
                ?>
            </select>
            <div class="flex-row time-wrapper-cont">
                <label class="flex-align-center f-label">Tempo esercizio</label>
                <input type="time" name="exTime" class="input-time-box" placeholder="Tempo esercizio">
            </div>
            <input type="number" name="exWeight" class="input-number-box" placeholder="Pesi in Kg">
        </div>
        <div class="flex-column flex-justify-center form-group">
            <input type="number" name="exRip" class="input-number-box" placeholder="Ripetizioni">
            <input type="number" name="exSerie" class="input-number-box" placeholder="Serie">
            <div class="flex-row time-wrapper-cont">
                <label class="flex-align-center f-label">Riposo</label>
                <input type="time" name="exBreak" class="input-time-box" placeholder="Riposo">
            </div>
        </div>
        <button class="flex-row flex-align-center flex-justify-center add-ex-btn">Aggiungi esercizio</button>
    </div>
    <div class="flex-column ex-list">
        <?php
            if($tID != -1) {
                $isNotAsync = true;
                foreach($exercises as $ex) {
                    $index = $ex->id;
                    $exName = $ex->nome;
                    $exTime = $ex->tempo;
                    $exWeight = $ex->pesi;
                    $exRip = $ex->ripetizioni;
                    $exSerie = $ex->serie;
                    $exBreak = $ex->riposo;
                    include './table-form-ex-template.php';
                }
            }
        ?>
    </div>
    <form class="flex-row" <?php echo 'action="'.$path.'/Php/Scripts/action-table-script.php"'; ?> method="POST" accept-charset="utf-8">
        <input type="submit" name="sub-btn" class="flex-row form-sub-btn" <?php echo 'value="'.($method == "add" ? 'Crea tabella' : 'Modifica tabella').'"'; ?>>
        <input type="hidden" name="method" <?php echo 'value="'.$method.'"'; ?>>
        <?php
            if($tID != -1) {
                $i = 1;
                foreach($exercises as $ex) {
                    echo '<input type="hidden" name="exIndex-'.$i.'" value="'.$ex->id.'">';
                    echo '<input type="hidden" name="exName-'.$i.'" value="'.$ex->nome.'">';
                    echo '<input type="hidden" name="exTime-'.$i.'" value="'.$ex->tempo.'">';
                    echo '<input type="hidden" name="exWeight-'.$i.'" value="'.$ex->pesi.'">';
                    echo '<input type="hidden" name="exRip-'.$i.'" value="'.$ex->ripetizioni.'">';
                    echo '<input type="hidden" name="exSerie-'.$i.'" value="'.$ex->serie.'">';
                    echo '<input type="hidden" name="exBreak-'.$i.'" value="'.$ex->riposo.'">';
                    $i++;
                }

                foreach($daysInputs as $d)
                    echo $d;

                foreach($dateInputs as $d)
                    echo $d;
            }
        ?>
        <?php echo $tID > -1 ? '<input type="hidden" name="tableID" value="'.$tID.'">' : ''; ?>
    </form>
<div>
