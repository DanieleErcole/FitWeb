
<?php
    require_once './Php/Classes/EntityController.php';
    require_once './Php/Classes/Giorno.php';
    require_once './Php/Classes/Debugger.php';
?>

<div class="flex-column calendar-section">
    <div class="flex-row calendar-container">
        <?php

            //Trovo la data di oggi
            $date = new DateTime("now");
            $now = $date->format('d/m');
            $d = new DateTime();

            //Prendo l'anno corrente e la settimana corrente, utilizzando strotime per creare un timestamp
            //e strftime per formattarlo con %G = numero anno e %V = numero della settimana dell'anno (seguendo lo standard ISO-8601:1988)
            $str = explode("-", strftime('%G-%V', strtotime($date->format('Y-m-d'))));
            $limitDay1 = $d->setISODate($str[0], $str[1], 1)->format("Y-m-d");
            $limitDay2 = $d->setISODate($str[0], $str[1], 7)->format("Y-m-d");

            //Tabelle create dall'utente
            $entityController = new EntityController(array("tabella_di_allenamento", "utente", "tabella_si_svolge_in_giorno"),
                "dbObj");
            $tables = $entityController->findWhereAssoc(array(
                "tabella_di_allenamento.Id",
                "tabella_di_allenamento.NomeTabella",
                "tabella_di_allenamento.OraInizio",
                "tabella_di_allenamento.Utente",
                "tabella_di_allenamento.Corso",
                "tabella_si_svolge_in_giorno.Giorno",
                "tabella_si_svolge_in_giorno.Ripetizione",
                "tabella_si_svolge_in_giorno.Data",
                "utente.Nome",
                "utente.Cognome"), array("utente.Id = ".$_SESSION["id"],
                    "tabella_di_allenamento.Utente = utente.Id",
                    "tabella_si_svolge_in_giorno.Tabella = tabella_di_allenamento.Id",
                    "(tabella_si_svolge_in_giorno.Ripetizione = 1",
                    "tabella_si_svolge_in_giorno.Data <> '0000-00-00'",
                    "tabella_si_svolge_in_giorno.Data >= '".$limitDay1."'",
                    "tabella_si_svolge_in_giorno.Data <= '".$limitDay2."')"), array("AND", "AND", "AND", "OR", "AND", "AND"));
            $entityController->closeConnection();

            //Tabelle appartenenti ai corsi acquistati dall'utente
            $entityController = new EntityController(array("tabella_di_allenamento", "tabella_si_svolge_in_giorno", "corso", "utente_acquista_corso"),
                "dbObj");
            $tables1 = $entityController->findWhereAssoc(array(
                "tabella_di_allenamento.Id",
                "tabella_di_allenamento.NomeTabella",
                "tabella_di_allenamento.OraInizio",
                "tabella_di_allenamento.Utente",
                "tabella_di_allenamento.Corso",
                "tabella_si_svolge_in_giorno.Giorno",
                "tabella_si_svolge_in_giorno.Ripetizione",
                "tabella_si_svolge_in_giorno.Data"), array("tabella_di_allenamento.Corso IS NOT NULL",
                    "corso.Id = utente_acquista_corso.Corso",
                    "tabella_di_allenamento.Corso = corso.Id",
                    "utente_acquista_corso.Utente = ".$_SESSION["id"],
                    "tabella_si_svolge_in_giorno.Tabella = tabella_di_allenamento.Id",
                    "(tabella_si_svolge_in_giorno.Ripetizione = 1",
                    "tabella_si_svolge_in_giorno.Data <> '0000-00-00'",
                    "tabella_si_svolge_in_giorno.Data >= '".$limitDay1."'",
                    "tabella_si_svolge_in_giorno.Data <= '".$limitDay2."')"), array("AND", "AND", "AND", "AND", "AND", "OR",  "AND", "AND"));
            $entityController->closeConnection();

            if($tables1) {
                for($i = 0; $i < count($tables1); $i++) {
                    $entityController = new EntityController(array("utente"), "utente");
                    $user = $entityController->find($tables1[$i]["Utente"], "Id");
                    $entityController->closeConnection();
                    $tables1[$i]["Nome"] = $user->nome;
                    $tables1[$i]["Cognome"] = $user->cognome;
                }
            }

            //Unione delle tabelle
            $tables = ($tables ? ($tables1 ? array_merge($tables, $tables1) : $tables) : ($tables1 ? $tables1 : array()));

            $entityController = new EntityController(array("giorno"), "giorno");
            $days = $entityController->findWhere(array());
            $entityController->closeConnection();

            $i = 1; //Numero del giorno (Lunedì = 1 e domenica = 7)
            $ex = false;
            //Per ogni giorno assegno le variabili che utilizzerò nel template
            //Ciascuna riga del risultato rappresenta 1 giorno, 1 riga è insieme tabella-giorno
            foreach($days as $d) {
                $dayName = $d->nome;
                //Ottengo la data del giorno in base al numero del giorno, l'anno attuale e il numero della settimana corrente
                $dayDate = $date->setISODate($str[0], $str[1], $i)->format("d/m");
                $isToday = $dayDate == $now;

                $i++; //aumento di 1 il giorno
                $colBlock = "";
                foreach($tables as $table) { //Scorro le righe della tabella
                    if($table["Giorno"] == $d->id) { //Se la tabella si svolge nel giorno attuale assegno le variabili utili per il template
                        $t = $table;
                        $ex = true;

                        $colBlock .= '<div class="col-block flex-column no-select" data-tableid="'.$t["Id"].'">
                            <span class="material-icons">
                                fitness_center
                            </span>
                            <div class="block-table-name">'.$t["NomeTabella"].'</div>
                            <div class="block-table-hour">'.$t["OraInizio"].'</div>
                            <div class="flex-align-center block-table-author">
                                <span class="material-icons">
                                    person
                                </span>
                                '.$t["Nome"].' '.$t["Cognome"].'
                            </div>
                            '.($t["Utente"] == $_SESSION["id"] ? '<button class="flex-align-center flex-justify-center edit-table-button no-select"><span class="flex-align-center flex-justify-center material-icons">edit</span></button>' : '').'
                            '.($t["Utente"] == $_SESSION["id"] ? '<a href="./Php/Scripts/action-table-script.php?method=delete&tableID='.$t["Id"].'" class="flex-align-center flex-justify-center delete-table-button no-select"><span class="flex-align-center flex-justify-center material-icons">delete_outline</span></a>' : '').'
                        </div>';
                    } //Se non ci sono tabelle per il giorno che sta venendo controllato allora significa che è un giorno di riposo
                    //Riposo -> ex = false, non ho bisogno di inizializzare le variabili
                }

                if(!$ex) {
                    $colBlock = '<div class="col-block not-exercise no-select">
                        <span class="material-icons">
                            chair
                        </span>
                        Riposo
                    </div>';
                }

                include "./Php/Templates/calendar-element-template.php";
                $ex = false;
            }

        ?>
    </div>
</div>
<div class="flex-column table-section table-not-active">
    <div class="flex-align-center section-header">
        Tabella di allenamento
        <button class="flex-align-center flex-justify-center close-table-section">
            <span class="material-icons">
                close
            </span>
        </button>
    </div>
    <div class="section-container">
    </div>
</div>
<button class="flex-row flex-align-center flex-justify-center floating-button perform-button">
    <span class="material-icons">
        directions_run
    </span>
    Esegui esercizio
</button>
<button class="flex-row flex-align-center flex-justify-center floating-button">
    <span class="material-icons">
        add
    </span>
    Nuova tabella
</button>
