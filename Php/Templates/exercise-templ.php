<?php
    require_once '../../Php/Classes/EntityController.php';
    require_once '../../Php/Classes/Giorno.php';
    require_once '../../Php/Classes/Debugger.php';
?>
<div class="flex es-column">
    <div class="col-block no-select">
        <span class="flex-align-center inner-block-el material-icons">
            run_circle
        </span>
        <div class="flex-align-center inner-block-el es-name"><?php echo $ex->nome; ?></div>
        <div class="flex-align-center inner-block-el es-time">
            <span class="material-icons">
                timer
            </span>
            <?php echo $ex->tempo == null ? '00:00' : (explode(":", $ex->tempo)[1].":".explode(":", $ex->tempo)[2]); ?>
        </div>
        <div class="flex-align-center inner-block-el es-weight">
            <span class="material-icons">
                fitness_center
            </span>
            <?php echo $ex->pesi == null ? 'N/A' : $ex->pesi.' Kg'; ?>
        </div>

        <div class="flex-align-center inner-block-el es-muscles">
            <?php
                $entityController = new EntityController(array("muscolo", "esercizio_allena_muscolo"), "muscolo");
                $muscles = $entityController->findWhere(array("esercizio_allena_muscolo.Esercizio = ".$ex->id,
                    "esercizio_allena_muscolo.Muscolo = muscolo.Id"), array("AND"), array("muscolo.Id", "muscolo.Nome"));
                $entityController->closeConnection();

                $array = array();
                foreach($muscles as $m)
                    $array[] = $m->nome;

                echo implode(", ", $array);
            ?>
        </div>

        <div class="flex-align-center inner-block-el es-count">Ripetizioni: <?php echo $ex->ripetizioni == null ? 'N/A' : $ex->ripetizioni; ?></div>
        <div class="flex-align-center inner-block-el es-serie">Serie: <?php echo $ex->serie == null ? 'N/A' : $ex->serie; ?></div>
        <div class="flex-align-center inner-block-el es-break">Riposo: <?php echo $ex->riposo == null ? '00:00' : (explode(":", $ex->riposo)[1].":".explode(":", $ex->riposo)[2]); ?></div>
    </div>
</div>
