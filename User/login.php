<!DOCTYPE HTML>
<html>

    <head>
        <title>Login - FitWeb</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="Palestra, Fitness, Training, Personal Trainer, Attrezzi">
        <meta name="description" content="Portale web per pianificare allenamenti e seguire i corsi dei nostri migliori personal trainer">

        <link rel="icon" href="../favicon.png"  type="image/png">
        <link rel="stylesheet" type="text/css" href="../Style/root.css">
        <link rel="stylesheet" type="text/css" href="../Style/form-style.css">

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

        <section class="flex-column section-form">
            <a href="../" class="flex-align-center flex-justify-center home-btn no-select">
                <span class="material-icons">
                    home
                </span>
            </a>
            <form class="flex-column" action="../Php/Scripts/login-script.php" method="POST">
                <div class="flex-align-center flex-justify-center form-element form-header no-select">
                    <span class="material-icons">
                        fitness_center
                    </span>
                    Fitweb
                </div>
                <div class="flex-align-center flex-justify-center form-element form-header no-select">
                    Login
                </div>
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
                        <input type="password" name="psw" class="input-txt-box" placeholder="Password" autocomplete="off">
                        <span class="flex-align-center flex-justify-center material-icons no-select">
                            lock
                        </span>
                    </div>
                    <label <?php echo 'class="flex-align-center form-label error-label no-select '.($error == 2 || $error == 3 ? 'err-active' : '').'"'; ?>>
                        <?php echo ($error == 2 || $error == 3 ? 'Password errata' : ''); ?>
                        <button class="flex-align-center close-err-btn">
                            <span class="material-icons">
                                close
                            </span>
                        </button>
                    </label>
                </div>
                <div class="flex-column flex-align-center flex-justify-center form-element">
                    <input type="submit" class="flex-justify-center submit-button" value="Accedi">
                    <a href="./register.php" class="flex-align-center flex-justify form-link">Registrati</a>
                </div>
            </form>
        </section>
    </body>

</html>
