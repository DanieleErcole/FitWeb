<?php
    session_start();
    require_once '../../Php/Classes/EntityController.php';
    require_once '../../Php/Classes/Utente.php';
    require_once '../../Php/Classes/Debugger.php';

    $tab = $_REQUEST["tab"];
    $count = $_REQUEST["count"];

    if($tab == "all-courses") {
        $isMyCourse = false;
        $entityController = new EntityController(array("corso", "utente"), "dbObj");
        $courses = $entityController->findWhereAssoc(array(
                "corso.Id",
                "corso.Nome",
                "corso.Descrizione",
                "corso.Prezzo",
                "corso.Utente"),
            array("corso.Utente = utente.Id"));
        $entityController->closeConnection();

        $entityController = new EntityController(array("corso", "utente"), "utente");
        $users = $entityController->findWhere(array("corso.Utente = utente.Id"));
        $entityController->closeConnection();

        //trovo i corsi acquistati dall'utente corrente
        $entityController = new EntityController(array("corso", "utente_acquista_corso"), "dbObj");
        $userCrs = $entityController->findWhereAssoc(array("corso.Id"), array("utente_acquista_corso.Utente = ".$_SESSION["id"],
            "utente_acquista_corso.Corso = Corso.Id"), array("AND"));
        $entityController->closeConnection();

        $countTot = count($courses);
    } else {
        $isMyCourse = true;
        $entityController = new EntityController(array("corso", "utente_acquista_corso"), "dbObj");
        $courses = $entityController->findWhereAssoc(array(
                "corso.Id",
                "corso.Nome",
                "corso.Descrizione",
                "corso.Prezzo",
                "corso.Utente"),
            array("utente_acquista_corso.Utente = ".$_SESSION["id"], "utente_acquista_corso.Corso = Corso.Id"), array("AND"));
        $entityController->closeConnection();

        $countTot = count($courses);
    }

?>
<div class="flex-column courses-list" <?php echo 'data-current-tab="'.$tab.'"'; echo 'data-courses-count="'.$countTot.'"'; ?>>
    <?php
        if($tab == "all-courses") {
            for($i = 0; $i < count($courses) && $i < $count; $i++) {
                $c = $courses[$i];
                $isBought = false;
                foreach($userCrs as $cr) {
                    if($cr["Id"] == $c["Id"]) {
                        $isBought = true;
                        break;
                    }
                }

                foreach($users as $user) {
                    if($user->id == $c["Utente"]) {
                        include 'course-item-template.php';
                        break;
                    }
                }
            }
        } else {
            for($i = 0; $i < count($courses) && $i < $count; $i++) {
                $c = $courses[$i];
                $entityController = new EntityController(array("corso", "utente"), "utente");
                $users = $entityController->findWhere(array("corso.Utente = utente.Id", "utente.Id = ".$c["Utente"]), array("AND"));
                $entityController->closeConnection();

                foreach($users as $user) {
                    include 'course-item-template.php';
                    break;
                }
            }
        }
    ?>
</div>
