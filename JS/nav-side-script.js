//NOTA: i tasti non verranno mai aggiornati
$(document).ready(() => {

    let reqManager = new RequestManager();
    $("#trainings").click(() => {
        //fare richiesta ajax
        //!!! NOTA: non riesce atrovare il nome della cartella root, non ho idea del perchè, non bastano i due punti
        $(".option-item ").removeClass("option-active");
        $(this).addClass("option-active");
        reqManager.request("./Trainings/training-page.php", {}, (data) => {
            $(".content-container").empty();
            $(".content-container").append(data);
            loadJsEvents("initTrainingPage");
        }, false);
    });

    $("#courses").click(() => {
        //fare richiesta ajax
        $(".option-item ").removeClass("option-active");
        $(this).addClass("option-active");

        loadJsEvents("initCousesPage");
    });

    $("#stats").click(() => {
        //fare richiesta ajax
        $(".option-item ").removeClass("option-active");
        $(this).addClass("option-active");

        loadJsEvents("initStatisticsPage");
    });

    $("#settings").click(() => {
        //fare richiesta ajax
        $(".option-item ").removeClass("option-active");
        $(this).addClass("option-active");

        loadJsEvents("initSettingsPage");
    });
    $("#trainings").trigger("click");

});
