<?php
    require_once '../../Php/Classes/EntityController.php';
    require_once '../../Php/Classes/Giorno.php';
    require_once '../../Php/Classes/Debugger.php';
?>
<div class="flex t-container">
    <div class="flex-row exercise-wrapper">
        <?php
            $tableID = $_REQUEST["tableId"];

            $entityController = new EntityController(array("esercizio", "esercizio_associato_a_tabella"), "esercizio");
            $exercises = $entityController->findWhere(array("esercizio_associato_a_tabella.Tabella = ".$tableID,
                "esercizio_associato_a_tabella.Esercizio = esercizio.Id"), array("AND"),
                    array("esercizio.Id",
                        "esercizio.Nome",
                        "esercizio.Tempo",
                        "esercizio.Pesi",
                        "esercizio.Ripetizioni",
                        "esercizio.Serie",
                        "esercizio.Riposo"));
            $entityController->closeConnection();

            foreach($exercises as $ex) {
                include __DIR__."/exercise-templ.php";
            }
        ?>
</div>
