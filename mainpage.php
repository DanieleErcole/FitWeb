<!DOCTYPE HTML>
<html>
    <?php
        session_start();
        header('Content-Type: text/html; charset=ISO-8859-1');
    ?>
    <head>
        <title>
            <?php
                switch($_SESSION["ruolo"]) {
                    case 3:
                        echo 'Area utente - FitWeb';
                        break;
                    case 2:
                        echo 'Area personal trainer - FitWeb';
                        break;
                    case 1:
                        echo 'Area admin - FitWeb';
                        break;
                }
            ?>
        </title>
        <meta charset="ISO-8859-1">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="Palestra, Fitness, Training, Personal Trainer, Attrezzi">
        <meta name="description" content="Portale web per pianificare allenamenti e seguire i corsi dei nostri migliori personal trainer">

        <link rel="icon" href="./favicon.png"  type="image/png">
        <link rel="stylesheet" type="text/css" href="./Style/root.css">
        <link rel="stylesheet" type="text/css" href="./Style/nav-side.css">
        <link rel="stylesheet" type="text/css" href="./Style/nav-main.css">
        <link rel="stylesheet" type="text/css" href="./Style/style-main.css">

        <!--NOTA: seleziono i fogli di stile in base alla pagina-->
        <?php
            switch($_REQUEST["page"]) {
                case 'trainings':
                    echo '<link rel="stylesheet" type="text/css" href="./Style/training-style.css">
                    <link rel="stylesheet" type="text/css" href="./Style/add-table-form-style.css">
                    <link rel="stylesheet" type="text/css" href="./Style/perform-form-style.css">';
                    break;
                case 'courses':
                    echo '<link rel="stylesheet" type="text/css" href="./Style/courses-style.css">';
                    break;
                case 'stats':
                    echo '';
                    break;
                case 'settings':
                    echo '';
                    break;
            }
        ?>

        <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">

        <script src="./JS/jquery.min.js"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
        <script src="https://kit.fontawesome.com/65d820818e.js" crossorigin="anonymous"></script>

        <!--NOTA: script e classi js di base per il funzionamento del portale (es richieste AJAX, caricamento
        degli eventi solo in base alla pagina nella quale si trova l'utente ecc.)-->
        <script src="./JS/functions.js"></script>
        <script src="./JS/RequestManager.js"></script>
        <script src="./JS/EventLoader.js"></script>
        <script src="./JS/nav-main-script.js"></script>

        <!--NOTA: seleziono gli script in base alla pagina-->
        <?php
            switch($_REQUEST["page"]) {
                case 'trainings':
                    echo '<script src="./JS/training-section-script.js"></script>';
                    break;
                case 'courses':
                    echo '<script src="./JS/courses-section-script.js"></script>';
                    break;
                case 'stats':
                    echo '';
                    break;
                case 'settings':
                    echo '';
                    break;
            }
        ?>
    </head>

    <body class="flex-column" <?php echo 'data-page="'.$_REQUEST["page"].'"'; ?>>

        <div class="flex-align-center flex-justify-center main-overlay overlay-not-active">
            <div class="flex-column flex-align-center flex-justify-center table-form-container">
                <button class="flex overlay-close-button">
                    <span class="material-icons">
                        close
                    </span>
                </button>
            </div>
        </div>

        <?php include './nav-main.php'; ?>
        <section class="flex-row main-section">
            <?php include './nav-side.php'; ?>
            <div class="flex-column content-container">
                <?php
                    switch($_REQUEST["page"]) {
                        case 'trainings':
                            include './Trainings/training-page.php';
                            break;
                        case 'courses':
                            include './Courses/courses-page.php';
                            break;
                        case 'stats':
                            include './work-in-progress.php';
                            break;
                        case 'settings':
                            include './work-in-progress.php';
                            break;
                        case 'myCourses':
                            include './work-in-progress.php';
                            break;
                        case 'myTables':
                            include './work-in-progress.php';
                            break;
                        case 'users':
                            include './work-in-progress.php';
                            break;
                        case 'exercises':
                            include './work-in-progress.php';
                            break;
                        case 'muscles':
                            include './work-in-progress.php';
                            break;
                        case 'gyms':
                            include './work-in-progress.php';
                            break;
                    }
                ?>
            </div>
        </section>
    </body>

</html>
