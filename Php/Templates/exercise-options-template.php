<?php
    require_once '../../Php/Classes/EntityController.php';
    require_once '../../Php/Classes/Debugger.php';

    if(!isset($table))
        $table = $_REQUEST["table"];

    $controller = new EntityController(array("esercizio", "esercizio_associato_a_tabella"), "dbObj");
    $exs = $controller->findWhereAssoc(array("esercizio.Id", "esercizio.Nome"), array("esercizio_associato_a_tabella.Tabella = ".$table, "esercizio.Id = esercizio_associato_a_tabella.Esercizio"), array("AND"));
    $controller->closeConnection();

    foreach($exs as $ex) {
        echo '<option value="'.$ex["Id"].'">'.$ex["Nome"].'</option>';
    }
?>
