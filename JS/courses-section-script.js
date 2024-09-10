
let countList = 10;
$(document).ready(() => {

    $(".tab-btn").click(function() {
        $(".tab-btn").removeClass("tab-active");
        $(this).addClass("tab-active");

        let tab = $(this).attr("data-tab");
        let reqManager = new RequestManager();
        reqManager.request("./Php/Templates/courses-list-template.php", {
            tab: tab,
            count: countList
        }, (data) => {
            $(".courses-list").remove();
            $(".courses-container").prepend(data);

            if(countList >= $(".courses-list").attr("data-courses-count"))
                $(".load-button-container").addClass("not-diplay");
            else $(".load-button-container").removeClass("not-diplay");
            loadJsEvents('coursesListLoad');
        });
    });

    $(".load-button").click(function() {
        countList += 10;
        let page = $(".courses-list").attr("data-current-tab");
        $(".tab-btn[data-tab='" + page + "']").trigger("click");
    });

    $(".tab-btn[data-tab='all-courses']").trigger("click");

});
