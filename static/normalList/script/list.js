window.onscroll = function () {
    var bodyScrollTop = $(document).scrollTop();
    if (bodyScrollTop >= $("div.top").height() + $("div.logo_search").height()) {
        $("div.nav").css({ "position": "fixed", "top": "0" });
    }
    else {
        $("div.nav").css({ "position": "relative" });
    }
};