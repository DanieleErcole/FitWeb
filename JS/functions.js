
$(document).ready(() => {

    $(".overlay-close-button").click(() => {
        $(".main-overlay").addClass("overlay-not-active");
    });

    $(".floating-button").click(() => {
        $(".main-overlay").removeClass("overlay-not-active");
    });

});

function getById(id) {
    return document.getElementById(id);
}

function getByClass(className) {
    return document.getElementsByClassName(className);
}

function getByClasses(classString) {
    return document.querySelectorAll(classString);
}

function initTextBoxes() {
    for(let txtBox of getByClass("input-txt-box"))
        txtBox.value = "";
}

function getCurrentPath() {
    let array = location.pathname.split("/");
    return array[array.length - 1] == "" || array[array.length - 1].split("?")[0] == "index.php" ? "." : "..";
}

function loadJsEvents(mode) {
    let evtLoader = new EventLoader(mode);
    evtLoader.loadPageEvents();
}
