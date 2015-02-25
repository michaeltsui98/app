$(document).ready(function () {
    $("input[name='txt_my_search']").unbind().bind("keyup", function (e) {
        if (e.keyCode == "13") {
            window.location.href = encodeURI($(this).parent().find("input[name='btn_my_search']").attr("data-url") + $("input[name='txt_my_search']").val());
        }
    });
    $("input[name='btn_my_search']").unbind().bind("click", function () {
        window.location.href = encodeURI($(this).attr("data-url") + $("input[name='txt_my_search']").val());
        return false;
    });
});