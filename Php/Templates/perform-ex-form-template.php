
<?php
    require_once '../../Php/Classes/EntityController.php';
    require_once '../../Php/Classes/Debugger.php';
    $path = $_REQUEST["path"];
    session_start();
?>
<div class="flex-column form-cont">
    <div class="flex-row f-title">
        Esegui esercizio
    </div>
    <form class="flex-column" <?php echo 'action="'.$path.'/Php/Scripts/perform-ex-script.php"'; ?> method="POST" accept-charset="utf-8">
        <div class="flex-row f-row">
            <select name="table" class="input-txt-box">
                <?php
                    $date = new DateTime("now");
                    $now = $date->format('d/m');
                    $d = new DateTime();
                    $str = explode("-", strftime('%G-%V', strtotime($date->format('Y-m-d'))));
                    $limitDay1 = $d->setISODate($str[0], $str[1], 1)->format("Y-m-d");
                    $limitDay2 = $d->setISODate($str[0], $str[1], 7)->format("Y-m-d");

                    $controller = new EntityController(array("tabella_di_allenamento", "utente", "tabella_si_svolge_in_giorno"), "dbObj");
                    $tables = $controller->findWhereAssoc(array("tabella_di_allenamento.Id", "tabella_di_allenamento.NomeTabella"), array("tabella_di_allenamento.Utente = ".$_SESSION["id"], "tabella_si_svolge_in_giorno.Tabella = tabella_di_allenamento.Id", "(tabella_si_svolge_in_giorno.Ripetizione = 1", "tabella_si_svolge_in_giorno.Data <> '0000-00-00'", "tabella_si_svolge_in_giorno.Data >= '".$limitDay1."'", "tabella_si_svolge_in_giorno.Data <= '".$limitDay2."')"),
                        array("AND", "AND", "OR", "AND", "AND"));
                    $controller->closeConnection();

                    $controller = new EntityController(array("tabella_di_allenamento", "corso", "utente_acquista_corso", "tabella_si_svolge_in_giorno"), "dbObj");
                    $tables1 = $controller->findWhereAssoc(array("tabella_di_allenamento.Id", "tabella_di_allenamento.NomeTabella"), array("tabella_di_allenamento.Corso IS NOT NULL", "corso.Id = utente_acquista_corso.Corso", "tabella_di_allenamento.Corso = corso.Id", "utente_acquista_corso.Utente = ".$_SESSION["id"], "tabella_si_svolge_in_giorno.Tabella = tabella_di_allenamento.Id", "(tabella_si_svolge_in_giorno.Ripetizione = 1", "tabella_si_svolge_in_giorno.Data <> '0000-00-00'", "tabella_si_svolge_in_giorno.Data >= '".$limitDay1."'", "tabella_si_svolge_in_giorno.Data <= '".$limitDay2."')"),
                        array("AND", "AND", "AND", "OR", "AND", "AND", "AND", "AND"));
                    $controller->closeConnection();
                    $tables = ($tables ? ($tables1 ? array_merge($tables, $tables1) : $tables) : ($tables1 ? $tables1 : array()));

                    //NOTA: filtro le tabelle che si ripetono
                    $tCount = count($tables);
                    for($i = 0; $i < $tCount; $i++) {
                        for($c = $i + 1; $c < $tCount; $c++) {
                            if($tables[$i]["Id"] == $tables[$c]["Id"]) {
                                array_splice($tables, $c, 1);
                                $tCount--;
                                $c--;
                            }
                        }
                    }

                    $first = true;
                    foreach($tables as $t) {
                        if($first) {
                            $table = $t["Id"]; //NOTA: variabile utilizzata nel template degli esercizi
                            $first = false;
                        }
                        echo '<option value="'.$t["Id"].'">'.$t["NomeTabella"].'</option>';
                    }
                ?>
            </select>
            <select name="exercise" class="input-txt-box">
                <?php include './exercise-options-template.php'; ?>
            </select>
        </div>
        <div class="flex-row f-row">
            <input type="time" name="exTime" class="" placeholder="Tempo di esecuzione">
            <input type="number" name="exWeight" class="" placeholder="Pesi">
        </div>
        <div class="flex-row f-row">
            <input type="number" name="exRip" class="" placeholder="Ripetizioni">
            <input type="number" name="exSerie" class="" placeholder="Serie">
        </div>
        <div class="flex-row f-row">
            <input type="date" name="tDate" class="input-txt-box" placeholder="Data">
        </div>
        <input type="submit" name="sub-btn" class="flex-row form-sub-btn" value="Esegui">
    </form>
<div>
