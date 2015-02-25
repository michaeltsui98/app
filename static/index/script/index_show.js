$(document).ready(function () {
    if ($("#div_active").find("li").length >= 5) {//当动态多于5条是才实现滚动
        setInterval(function () {
            $("#div_active").find("ul.list_pic40").animate({
                top: "-112px"
            }, 500, function () {
                $(this).css({ top: "0px" }).find("li:first").appendTo(this);
            });
        }, 3000);
    }
});