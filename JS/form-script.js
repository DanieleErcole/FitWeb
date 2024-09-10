

$(document).ready(function() {

    initTextBoxes();
    $("input[type='submit']").prop("disabled", true);

    $("form").submit(function() {
        if($("#psw-check").length && !checkPasswords()) {
            $(".input-txt-box.check").parent().addClass("error-class");
            return false;
        }
    });

    $(".input-txt-box").focusin(function() {
        $(this).parent().removeClass("error-class");
        $(this).parent().addClass("focus-class");
    });

    $(".input-txt-box").focusout(function() {
        $(this).parent().removeClass("focus-class");
    });

    for(let txtBox of getByClass("input-txt-box")) {
        txtBox.addEventListener('input', function() {
            let empty = false;
            $(".input-txt-box").each(function() {
                if(!empty && $(this).val() === "")
                    empty = true;
            });
            $("input[type='submit']").prop("disabled", empty);
        });
    }

    $(".close-err-btn").click(function() {
        $(this).parent().toggle(200);
        return false;
    });

});

function checkPasswords() {
    return $("#psw").val() == $("#psw-check").val();
}
