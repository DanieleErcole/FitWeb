<!DOCTYPE HTML>
<html>

    <head>
        <title>Registrazione - FitWeb</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="Palestra, Fitness, Training, Personal Trainer, Attrezzi">
        <meta name="description" content="Portale web per pianificare allenamenti e seguire i corsi dei nostri migliori personal trainer">

        <link rel="stylesheet" type="text/css" href="../Style/root.css">
        <link rel="stylesheet" type="text/css" href="../Style/form-style.css">

        <link rel="icon" href="../favicon.png"  type="image/png">
        <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">

        <script src="../JS/jquery.min.js"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
        <script src="https://kit.fontawesome.com/65d820818e.js" crossorigin="anonymous"></script>

        <script src="../JS/functions.js"></script>
        <script src="../JS/RequestManager.js"></script>
        <script src="../JS/form-script.js"></script>
    </head>

    <?php $error = !isset($_REQUEST["error"]) ? -1 : $_REQUEST["error"]; ?>
    <body class="flex-align-center flex-justify-center">

        <section class="flex-column section-form register">
            <a href="../" class="flex-align-center flex-justify-center home-btn no-select">
                <span class="material-icons">
                    home
                </span>
            </a>
            <div class="flex-align-center flex-justify-center form-element form-header no-select">
                <span class="material-icons">
                    fitness_center
                </span>
                Fitweb
            </div>
            <div class="flex-align-center flex-justify-center form-element form-header no-select">
                Register
            </div>
            <form class="flex-column flex-justify-center register" action="../Php/Scripts/register-script.php" method="POST">
                <div class="flex-row form-content flex-justify-center register">
                    <div class="flex-column form-element">
                        <div class="flex-row input-container">
                            <input type="text" name="email" class="input-txt-box" placeholder="Email" autocomplete="on">
                            <span class="flex-align-center flex-justify-center material-icons no-select">
                                email
                            </span>
                        </div>
                        <label <?php echo 'class="flex-align-center form-label error-label no-select '.($error == 1 || $error == 3 ? 'err-active' : '').'"'; ?>>
                            <?php echo ($error == 1 || $error == 3 ? 'Email errata' : ''); ?>
                            <button class="flex-align-center close-err-btn">
                                <span class="material-icons">
                                    close
                                </span>
                            </button>
                        </label>
                    </div>
                    <div class="flex-column form-element">
                        <div class="flex-row input-container">
                            <input id="psw" type="password" name="psw" class="input-txt-box" placeholder="Password" autocomplete="off">
                            <span class="flex-align-center flex-justify-center material-icons no-select">
                                lock
                            </span>
                        </div>
                        <label <?php echo 'class="flex-align-center form-label error-label no-select '.($error == 2 || $error == 3 ? 'err-active' : '').'"'; ?>>
                            <?php echo ($error == 2 || $error == 3 ? 'Password già presente' : ''); ?>
                            <button class="flex-align-center close-err-btn">
                                <span class="material-icons">
                                    close
                                </span>
                            </button>
                        </label>
                    </div>
                    <div class="flex-column form-element">
                        <div class="flex-row input-container">
                            <input id="psw-check" type="password" name="psw-check" class="input-txt-box check" placeholder="Conferma password" autocomplete="off">
                            <span class="flex-align-center flex-justify-center material-icons no-select">
                                lock_open
                            </span>
                        </div>
                    </div>
                    <div class="flex-column form-element">
                        <div class="flex-row input-container">
                            <input type="text" name="nome" class="input-txt-box" placeholder="Nome" autocomplete="on">
                            <span class="flex-align-center flex-justify-center material-icons no-select">
                                person
                            </span>
                        </div>
                    </div>
                    <div class="flex-column form-element">
                        <div class="flex-row input-container">
                            <input type="text" name="cognome" class="input-txt-box" placeholder="Cognome" autocomplete="on">
                            <span class="flex-align-center flex-justify-center material-icons no-select">
                                person_outline
                            </span>
                        </div>
                    </div>
                    <div class="flex-column form-element">
                        <div class="flex-row input-container">
                            <input type="text" name="via" class="input-txt-box" placeholder="Via" autocomplete="on">
                            <span class="flex-align-center flex-justify-center material-icons no-select">
                                add_road
                            </span>
                        </div>
                    </div>
                    <div class="flex-column form-element">
                        <div class="flex-row input-container">
                            <input type="text" name="civico" class="input-txt-box" placeholder="Civico" autocomplete="on">
                            <span class="flex-align-center flex-justify-center material-icons no-select">
                                tag
                            </span>
                        </div>
                    </div>
                    <div class="flex-column form-element">
                        <div class="flex-row input-container">
                            <input type="text" name="citta" class="input-txt-box" placeholder="Città" autocomplete="on">
                            <span class="flex-align-center flex-justify-center material-icons no-select">
                                apartment
                            </span>
                        </div>
                    </div>
                    <div class="flex-column form-element">
                        <div class="flex-row input-container">
                            <input type="text" name="CAP" class="input-txt-box" placeholder="CAP" autocomplete="on">
                            <span class="flex-align-center flex-justify-center material-icons no-select">
                                location_city
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex-column flex-align-center flex-justify-center form-element">
                    <input type="submit" class="flex-justify-center submit-button" value="Registrati">
                    <a href="./login.php" class="flex-align-center flex-justify form-link">Accedi</a>
                </div>
            </form>
        </section>
    </body>

</html>
