
$(document).ready(() => {

    $(".menu-toggle").click(() => {
        if(!$("nav").hasClass("menu-active")) {
            $(".menu-toggle").addClass("btn-menu-active");
            $("nav").addClass("menu-active");
        } else {
            $(".menu-toggle").removeClass("btn-menu-active");
            $("nav").removeClass("menu-active");
        }
    });

});
