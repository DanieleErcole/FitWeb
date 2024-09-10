
class EventLoader {

    constructor(pageMode) {
        let array = location.pathname.split("/");
        this.path = array[array.length - 1] == "" || array[array.length - 1].split("?")[0] == "index.php" ? "." : "..";
        this.pageMode = pageMode;
    }

    loadPageEvents() {
        switch(this.pageMode) {
            case 'tableSectionActive':
                this.loadTableSectionActiveEvt();
                break;
            case 'coursesListLoad':
                this.loadCoursesListLoadEvt();
                break;
            case 'formTableLoad':
                this.loadFormTableLoadEvt();
                break;
            case 'addExFormEvt':
                this.loadAddExFormEvt();
                break;
            case 'formUserExLoad':
                this.loadUserExFormEvt();
                break;
        }
    }

    loadTableSectionActiveEvt() {
        $(".close-table-section").click(() => {
            $(".table-section .section-container").empty();
            $(".table-section").removeClass("table-active");
            $(".table-section").addClass("table-not-active");
            $(".calendar-section").removeClass("restricted");
        });
    }

    loadCoursesListLoadEvt() {
        $(".course-item-btn:not(.course-item-btn:disabled)").click(function() {
            let element = $(this);
            let reqManager = new RequestManager();
            reqManager.request("./Php/Scripts/buy-course-script.php", {
                courseID: element.attr("data-course-id")
            }, (data) => {
                $(".tab-btn[data-tab='all-courses']").trigger("click");
            });
        });
    }

    loadFormTableLoadEvt() {
        if($(".table-form-container").height() > $(".main-overlay").height())
            $(".main-overlay").addClass("ov-no-align");
        else $(".main-overlay").removeClass("ov-no-align");

        $(".add-data-btn").click(function() {
            let counter = $(".table-form-container form > input[name^='data']").length;
            counter++;
            let data = $("input[name='exDate']").val();
            $(".table-form-container form").append('<input type="hidden" name="data-' + counter + '" value="' + data + '">');
            $("input[name='exDate']").val("");
        });

        $(".add-ex-btn").click(function() {
            let element = $(this);
            let reqManager = new RequestManager();

            let exName = $(".table-form-container select > option[value='" + $(".table-form-container select").val() + "']").text();
            let exTime = $(".table-form-container input[name='exTime']").val();
            let exWeight = $(".table-form-container input[name='exWeight']").val();
            let exRip = $(".table-form-container input[name='exRip']").val();
            let exSerie = $(".table-form-container input[name='exSerie']").val();
            let exBreak = $(".table-form-container input[name='exBreak']").val();

            let counter = $(".table-form-container form > input[name^='exName']").length;
            counter++;

            $(".table-form-container form").append('<input type="hidden" name="exIndex-' + counter + '" value="' + $(".table-form-container select").val() + '">');
            $(".table-form-container form").append('<input type="hidden" name="exName-' + counter + '" value="' + exName + '">');
            $(".table-form-container form").append('<input type="hidden" name="exTime-' + counter + '" value="' + exTime + '">');
            $(".table-form-container form").append('<input type="hidden" name="exWeight-' + counter + '" value="' + exWeight + '">');
            $(".table-form-container form").append('<input type="hidden" name="exRip-' + counter + '" value="' + exRip + '">');
            $(".table-form-container form").append('<input type="hidden" name="exSerie-' + counter + '" value="' + exSerie + '">');
            $(".table-form-container form").append('<input type="hidden" name="exBreak-' + counter + '" value="' + exBreak + '">');

            reqManager.request("./Php/Templates/table-form-ex-template.php", {
                index: counter,
                exName: exName,
                exTime: exTime,
                exWeight: exWeight,
                exRip: exRip,
                exSerie: exSerie,
                exBreak: exBreak
            }, (data) => {
                $(".ex-list").append(data);
                loadJsEvents('addExFormEvt');
            });

            $(".table-form-container input[name='exTime']").val("");
            $(".table-form-container input[name='exWeight']").val("");
            $(".table-form-container input[name='exRip']").val("");
            $(".table-form-container input[name='exSerie']").val("");
            $(".table-form-container input[name='exBreak']").val("");
        });

        $(".check-wrap input").change(function() {
            let txt = $(this).val();
            let counter = $(".table-form-container form input[name^='ripData']").length;
            counter++;

            if(this.checked) {
                $(".table-form-container form").append('<input type="hidden" name="ripData-' + counter + '" value="' + txt + '">');
            } else {
                for(let el of $(".table-form-container form > input[name^='ripData-']").toArray())
                    if($(el).val() == txt)
                        txt = $(el).attr("name");
                $(".table-form-container form > input[name='" + txt + "']").remove();

                let array = new Array();
                for(let el of $(".table-form-container form > input[name^='ripData-']").toArray()) {
                    array.push($(el).val());
                    $(el).remove();
                }

                let i = 1;
                for(let val of array) {
                    $(".table-form-container form").append('<input type="hidden" name="ripData-' + i + '" value="' + val + '">');
                    i++;
                }
            }
        });

        $(".table-form-container:not(.perf) form").submit(function(event) {
            let exCounter = $(".table-form-container form > input[name^='exName']").length;
            $(".table-form-container form").append('<input type="hidden" name="exCounter" value="' + exCounter + '">');

            $(".table-form-container form").append('<input type="hidden" name="tableName" value="' + $(".table-form-container input[name='tableName']").val() + '">');
            $(".table-form-container form").append('<input type="hidden" name="startTime" value="' + $(".table-form-container input[name='hour']").val() + '">');
            return true;
        });

        $(".ex-item-remove-btn").click(function() {
            let index = $(this).parent().attr("data-ex-index");
            $(".table-form-container input[name='exIndex-" + index + "']").remove();
            $(".table-form-container input[name='exName-" + index + "']").remove();
            $(".table-form-container input[name='exTime-" + index + "']").remove();
            $(".table-form-container input[name='exWeight-" + index + "']").remove();
            $(".table-form-container input[name='exRip-" + index + "']").remove();
            $(".table-form-container input[name='exSerie-" + index + "']").remove();
            $(".table-form-container input[name='exBreak-" + index + "']").remove();
            $(this).parent().remove();
        });
    }

    loadAddExFormEvt() {
        $(".ex-item-remove-btn").click(function() {
            let index = $(this).parent().attr("data-ex-index");
            $(".table-form-container input[name='exIndex-" + index + "']").remove();
            $(".table-form-container input[name='exName-" + index + "']").remove();
            $(".table-form-container input[name='exTime-" + index + "']").remove();
            $(".table-form-container input[name='exWeight-" + index + "']").remove();
            $(".table-form-container input[name='exRip-" + index + "']").remove();
            $(".table-form-container input[name='exSerie-" + index + "']").remove();
            $(".table-form-container input[name='exBreak-" + index + "']").remove();
            $(this).parent().remove();
        });
    }

    loadUserExFormEvt() {
        if($(".table-form-container").height() > $(".main-overlay").height())
            $(".main-overlay").addClass("ov-no-align");
        else $(".main-overlay").removeClass("ov-no-align");

        $("select[name='table']").change(function() {
            let reqManager = new RequestManager();
            reqManager.request("./Php/Templates/exercise-options-template.php", {
                table: $(this).val()
            }, (data) => {
                $("select[name='exercise']").empty();
                $("select[name='exercise']").append(data);
            }, false);
        });
    }

}
