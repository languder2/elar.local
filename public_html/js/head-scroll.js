$(document).ready(function() {
    if($(window).scrollTop()!==0 && $(window).width() > 1199){
        $("header").removeClass("unscrolled");
        $("header").addClass("scrolled");
        $(".white-logo").removeClass("log");
        $(".clr-logo").addClass("clos");
    }
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if($(window).width() > 1199)
        if (scroll >= 100) {
            $("header").removeClass("unscrolled");
            $("header").addClass("scrolled");
            $(".white-logo").removeClass("log");
            $(".clr-logo").addClass("clos");
        } else {
            $("header").removeClass("scrolled");
            $("header").addClass("unscrolled");
            $(".clr-logo").removeClass("clos");
            $(".white-logo").addClass("log");
        }
    });
});
