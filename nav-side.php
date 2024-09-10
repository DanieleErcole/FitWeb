
<nav class="flex-column">
    <div class="profile-container">
        <div class="flex-column flex-justify-center overlay-dark">
            <div class="flex-align-center flex-justify-center avatar-container">
                <img src="./Immagini/default-user.png" alt="user's avatar" class="rounded-img avatar">
            </div>
            <div class="profile-name flex-align-center flex-justify-center"><?php echo $_SESSION["nome"].' '.$_SESSION["cognome"]; ?></div>
        </div>
    </div>
    <div class="separator-element"></div>
    <div class="nav-menu-container">
        <?php
            if($_SESSION["ruolo"] == 3) {
                echo '<a href="./mainpage.php?page=trainings" id="trainings" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "trainings" ? "option-active" : "").'">
                    <span class="material-icons">
                        calendar_today
                    </span>
                    Allenamenti
                </a>
                <a href="./mainpage.php?page=courses" id="courses" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "courses" ? "option-active" : "").'">
                    <span class="material-icons">
                        format_list_bulleted
                    </span>
                    Corsi
                </a>
                <a href="./mainpage.php?page=stats" id="stats" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "stats" ? "option-active" : "").'">
                    <span class="material-icons">
                        tune
                    </span>
                    Statistiche
                </a>
                <a href="./mainpage.php?page=settings" id="settings" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "settings" ? "option-active" : "").'">
                    <span class="material-icons">
                        settings_applications
                    </span>
                    Impostazioni profilo
                </a>';
            } else if($_SESSION["ruolo"] == 2) {
                echo '<a href="./mainpage.php?page=myCourses" id="myCourses" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "myCourses" ? "option-active" : "").'">
                    <span class="material-icons">
                        format_list_bulleted
                    </span>
                    I miei corsi
                </a>
                <a href="./mainpage.php?page=myTables" id="myTables" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "myTables" ? "option-active" : "").'">
                    <span class="material-icons">
                        table_chart
                    </span>
                    Allenamenti
                </a>
                <a href="./mainpage.php?page=settings" id="settings" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "settings" ? "option-active" : "").'">
                    <span class="material-icons">
                        settings_applications
                    </span>
                    Impostazioni profilo
                </a>';
            } else if($_SESSION["ruolo"] == 1) {
                echo '<a href="./mainpage.php?page=users" id="users" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "users" ? "option-active" : "").'">
                    <span class="material-icons">
                        people
                    </span>
                    Utenti
                </a>
                <a href="./mainpage.php?page=exercises" id="exercises" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "exercises" ? "option-active" : "").'">
                    <span class="material-icons">
                        directions_run
                    </span>
                    Esercizi
                </a>
                <a href="./mainpage.php?page=muscles" id="muscles" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "muscles" ? "option-active" : "").'">
                    <span class="material-icons">
                        fitness_center
                    </span>
                    Muscoli
                </a>
                <a href="./mainpage.php?page=gyms" id="gyms" class="flex-row no-select flex-align-center option-item '.($_REQUEST["page"] == "gyms" ? "option-active" : "").'">
                    <span class="material-icons">
                        business
                    </span>
                    Palestre
                </a>';
            }
        ?>
    </div>
    <div class="flex-align-center flex-justify-center separator-upper nav-footer">
        <div class="flex-align-center copyright-text">
            <span class="material-icons">
                copyright
            </span>
            FitWeb Corporation <?php echo date('Y'); ?>
        </div>
    </div>
</nav>
