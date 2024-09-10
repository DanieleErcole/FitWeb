<?php
    //session_start();
    $array = explode("/", $_SERVER['PHP_SELF']);
    $path = $array[count($array) - 1] == "" || explode("?", $array[count($array) - 1])[0] == "mainpage.php" || explode("?", $array[count($array) - 1])[0] == "index.php" ? "." : "..";
?>
<header class="flex-row">
    <button class="flex-row flex-align-center flex-justify-center menu-toggle no-select">
        <span class="material-icons">
            menu
        </span>
    </button>
    <div class="flex-row flex-align-center title-container no-select">
        <span class="material-icons">
            fitness_center
        </span>
        <p class="title">FitWeb</p>
    </div>
    <div class="separator-parallelogram"></div>
    <div class="flex-row flex-align-center menu-container">
        <div class="separator-parallelogram"></div>
        <a <?php echo 'href="'.$path.'/index.php"'; ?> class="nav-main-btn">
            <span class="material-icons">
                home
            </span>
        </a>
        <a <?php echo 'href="'.$path.'/Php/Scripts/logout-script.php"'; ?> class="nav-main-btn">
            <span class="material-icons">
                logout
            </span>
        </a>
    </div>
</header>
