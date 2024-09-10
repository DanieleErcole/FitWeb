<!DOCTYPE HTML>
<html>

    <?php session_start(); ?>
    <head>
        <title>Home - FitWeb</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="Palestra, Fitness, Training, Personal Trainer, Attrezzi">
        <meta name="description" content="Portale web per pianificare allenamenti e seguire i corsi dei nostri migliori personal trainer">

        <link rel="stylesheet" type="text/css" href="./Style/root.css">
        <link rel="stylesheet" type="text/css" href="./Style/style-main.css">
        <link rel="stylesheet" type="text/css" href="./Style/home-style.css">

        <link rel="icon" href="./favicon.png"  type="image/png">
        <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">

        <script src="./JS/jquery.min.js"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
        <script src="https://kit.fontawesome.com/65d820818e.js" crossorigin="anonymous"></script>
    </head>

    <body>

        <nav class="flex-row">
            <div class="flex-row flex-align-center title-cont no-select">
                <span class="material-icons">
                    fitness_center
                </span>
                <p class="title">FitWeb</p>
            </div>
            <div class="flex-row nav-menu">
            </div>
            <div class="flex-row flex-align-center links-wrapper">
                <a <?php echo isset($_SESSION["logged"]) && $_SESSION["logged"] ? 'href="./mainpage.php?page=trainings"' : 'href="./User/login.php"'; ?> class="flex-align-center flex-justify-center login-link center"><?php echo isset($_SESSION["logged"]) && $_SESSION["logged"] ? 'Area Utente' : 'Accedi'; ?></a>
                <a href="./User/register.php" class="flex-align-center flex-justify-center signup-link"><div class="flex l-skew">Registrati</div></a>
            </div>
        </nav>

        <section class="flex img-container">
            <div class="flex-column flex-justify-center center-title-cont">
                <div class="flex-column center-title">
                    <div class="flex-align-center flex-justify-center main-title">FitWeb</div>
                    <div class="flex-align-center flex-justify-center sub-title">Aiutaci a prenderti cura del tuo corpo</div>
                    <a href="./User/register.php" class="flex-align-center flex-justify-center title-link">Unisciti</a>
                </div>
                <svg class="intro-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
    	            <path class="elementor-shape-fill" d="M500,98.9L0,6.1V0h1000v6.1L500,98.9z"></path>
                </svg>
            </div>
        </section>
        <section class="flex-justify-center features-section">
            <div class="flex-row feature-list-container">
                <div class="flex-column feature-list-card no-select">
                    <div class="flex-align-center flex-justify-center feature-crd-icon-cont">
                        <div class="flex-align-center flex-justify-center feature-crd-icon">
                            <span class="material-icons">
                                self_improvement
                            </span>
                        </div>
                    </div>
                    <div class="flex-justify-center feature-crd-title">Numerosa varietà di servizi</div>
                    <div class="flex-justify-center feature-crd-text">
                        La nostra catena offre una numerosa varietà di servizi a tutti i suoi clienti.
                    </div>
                </div>
                <div class="flex-column feature-list-card no-select">
                    <div class="flex-align-center flex-justify-center feature-crd-icon-cont">
                        <div class="flex-align-center flex-justify-center feature-crd-icon">
                            <span class="material-icons">
                                supervised_user_circle
                            </span>
                        </div>
                    </div>
                    <div class="flex-justify-center feature-crd-title">Corsi dei nostri personal trainer</div>
                    <div class="flex-justify-center feature-crd-text">
                        Offriamo ai nostri clienti numerosi corsi organizzati dai nostri professionisti nel settore.
                    </div>
                </div>
                <div class="flex-column feature-list-card no-select">
                    <div class="flex-align-center flex-justify-center feature-crd-icon-cont">
                        <div class="flex-align-center flex-justify-center feature-crd-icon">
                            <span class="material-icons">
                                emoji_people
                            </span>
                        </div>
                    </div>
                    <div class="flex-justify-center feature-crd-title">Esercizi per tutte le età</div>
                    <div class="flex-justify-center feature-crd-text">
                        I nostri professionisti possono allenare persone di ogni età. Bambini, ragazzi, adulti, chiunque può avere l'opportunità di condurre uno stile di vita sano.
                    </div>
                </div>
            </div>
        </section>
        <section class="flex-column flex-justify-center services-section">
            <div class="flex-justify-center services-header">Servizi per i nostri membri</div>
            <div class="flex-row services-list">
                <div class="flex-row service-box">
                    <div class="box-icon-cont no-select">
                        <div class="box-icon">
                            <span class="material-icons">
                                fitness_center
                            </span>
                        </div>
                    </div>
                    <div class="flex-column content-cont">
                        <div class="box-title">Allenamenti personalizzati</div>
                        <div class="box-text">I nostri personal trainer possono offrire anche corsi adeguati alle esigenze dei singoli clienti, grazie alla facile gestione offerta della nostra piattaforma.</div>
                    </div>
                </div>
                <div class="flex-row service-box">
                    <div class="box-icon-cont no-select">
                        <div class="box-icon">
                            <span class="material-icons">
                                home
                            </span>
                        </div>
                    </div>
                    <div class="flex-column content-cont">
                        <div class="box-title">Allenamenti anche a casa</div>
                        <div class="box-text">Programmi e tabelle di allenamento facilmente seguibili anche a casa.</div>
                    </div>
                </div>
                <div class="flex-row service-box">
                    <div class="box-icon-cont no-select">
                        <div class="box-icon">
                            <span class="material-icons">
                                dashboard
                            </span>
                        </div>
                    </div>
                    <div class="flex-column content-cont">
                        <div class="box-title">Portale web accessibile ovunque</div>
                        <div class="box-text">Portale web accessibile ovunque, sia da pc desktop, tablet, smartphone o su qualunque dispositivo riesca ad accedere ad un browser.</div>
                    </div>
                </div>
                <div class="flex-row service-box">
                    <div class="box-icon-cont no-select">
                        <div class="box-icon">
                            <span class="material-icons">
                                tap_and_play
                            </span>
                        </div>
                    </div>
                    <div class="flex-column content-cont">
                        <div class="box-title">Attrezzi smart nelle nostre palestre</div>
                        <div class="box-text">Le nostre palestre sono dotate dei migliori attrezzi smart all'avanguardia, dotati di schermo touch screen e connessi in rete per accedere alla nostra piattaforma.</div>
                    </div>
                </div>
                <div class="flex-row service-box">
                    <div class="box-icon-cont no-select">
                        <div class="box-icon">
                            <span class="material-icons">
                                accessible
                            </span>
                        </div>
                    </div>
                    <div class="flex-column content-cont">
                        <div class="box-title">Assistenza anche a clienti con disabilità</div>
                        <div class="box-text">Il nostro personale specializzato fornisce anche assistenza e allenamenti alle persone con disabilità.</div>
                    </div>
                </div>
                <div class="flex-row service-box">
                    <div class="box-icon-cont no-select">
                        <div class="box-icon">
                            <span class="material-icons">
                                format_list_bulleted
                            </span>
                        </div>
                    </div>
                    <div class="flex-column content-cont">
                        <div class="box-title">Accesso ai corsi dei personal trainer</div>
                        <div class="box-text">Ai nostri clienti è data la possibilità di acquistare i vari corsi organizzati dai personal trainer, che offriranno diverse tabelle di allenamento agli utenti.</div>
                    </div>
                </div>
            </div>
        </section>
        <section class="flex img-last-section">
        </section>
        <footer class="flex-column">
            <div class="flex-row footer-cont-upper">
                <div class="flex-column footer-column">
                    <div class="footer-column-header">FitWeb</div>
                    <div class="flex-justify-center footer-column-element">
                        <a href="./index.php" class="h-link">
                            <span class="material-icons">
                                fitness_center
                            </span>
                        </a>
                    </div>
                </div>
                <div class="flex-column footer-column">
                    <div class="footer-column-header">Contact Us</div>
                    <div class="footer-column-element">info@fitweb.com</div>
                    <div class="footer-column-element">021-278-2105</div>
                </div>
                <div class="flex-column footer-column">
                    <div class="footer-column-header">Socials</div>
                    <a href="https://www.instagram.com" class="s-link footer-column-element">Instagram</a>
                    <a href="https://www.facebook.com" class="s-link footer-column-element">Facebook</a>
                </div>
            </div>
            <div class="flex-row footer-cont-lower">
                <div class="flex-align-center copyright-text">
                    <span class="material-icons">
                        copyright
                    </span>
                    FitWeb Corporation <?php echo date('Y'); ?>
                </div>
            </div>
        </footer>

    </body>

</html>
