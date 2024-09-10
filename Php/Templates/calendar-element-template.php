<div class="flex-column calendar-container-single">
    <div class="flex-align-center cal-header-el upper">
        <?php
            $s = utf8_encode($dayName);
            echo utf8_decode($s); 
        ?>
        <span <?php echo 'class="material-icons '.($isToday ? 'today' : '').' no-select"'; ?>>
            today
        </span>
    </div>
    <div class="flex-align-center cal-header-el bottom"><?php echo $dayDate; ?></div>
    <div class="flex-column calendar-column">
        <?php echo $colBlock; ?>
    </div>
</div>
