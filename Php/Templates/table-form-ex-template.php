<?php

    if(!isset($isNotAsync)) {
        $index = $_REQUEST["index"];
        $exName = $_REQUEST["exName"];
        $exTime = $_REQUEST["exTime"];
        $exWeight = $_REQUEST["exWeight"];
        $exRip = $_REQUEST["exRip"];
        $exSerie = $_REQUEST["exSerie"];
        $exBreak = $_REQUEST["exBreak"];
    }

?>
<div class="flex-column ex-item" <?php echo 'data-ex-index="'.$index.'"'; ?>>
    <button class="flex-row ex-item-remove-btn">
        <span class="material-icons">
            close
        </span>
    </button>
    <div class="ex-name"><?php echo $exName; ?></div>
    <div class="ex-time"><?php echo $exTime; ?></div>
    <div class="ex-weight"><?php echo $exWeight; ?> Kg</div>
    <div class="ex-count">Ripetizioni: <?php echo $exRip; ?></div>
    <div class="ex-serie">Serie: <?php echo $exSerie; ?></div>
    <div class="ex-break">Riposo: <?php echo $exBreak; ?></div>
</div>
