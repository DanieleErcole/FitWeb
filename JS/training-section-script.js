
$(document).ready(() => {

    $(".col-block:not(.not-exercise)").click(function() {
        let tId = $(this).attr("data-tableId");
        let reqManager = new RequestManager();
        reqManager.request("./Php/Templates/training-table-template.php", {
            tableId: tId
        }, (data) => {
            $(".table-section").removeClass("table-not-active");
            $(".table-section").addClass("table-active");
            $(".calendar-section").addClass("restricted");

            $(".table-section .section-container").empty();
            $(".table-section .section-container").append(data);

            loadJsEvents('tableSectionActive');
        }, false);
    });

    $(".col-block:not(.not-exercise) > .edit-table-button").click(function(event) {
        let tId = $(this).parent().attr("data-tableId");
        let reqManager = new RequestManager();
        reqManager.request("./Php/Templates/table-form-template.php", {
            method: "edit",
            tableId: tId
        }, (data) => {
            $(".form-cont").remove();
            $(".table-form-container").append(data);
            $(".main-overlay").removeClass("overlay-not-active");
            loadJsEvents('formTableLoad');
        }, false);
        event.stopPropagation();
    });

    $(".floating-button:not(.perform-button)").click(() => {
        let reqManager = new RequestManager();
        reqManager.request("./Php/Templates/table-form-template.php", {
            method: "add"
        }, (data) => {
            $(".form-cont").remove();
            $(".table-form-container").append(data);
            loadJsEvents('formTableLoad');
        }, false);
    });

    $(".perform-button").click(() => {
        $(".table-form-container").addClass("perf");
        let reqManager = new RequestManager();
        reqManager.request("./Php/Templates/perform-ex-form-template.php", {}, (data) => {
            $(".form-cont").remove();
            $(".table-form-container").append(data);
            loadJsEvents('formUserExLoad');
        }, false);
    });

    $(".overlay-close-button").click(() => {
        if($(".table-form-container").hasClass("perf"))
            $(".table-form-container").removeClass("perf");
    });

});
