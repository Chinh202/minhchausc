function initNav(nav_colorTextActive, nav_colorTextNornal) {
//    $('.navbar').css({'background-image': 'url("' + nav_bg + '")'});
    $(".navbar-nav li a").css('color', '#fff');
    $(".active a").css({'color': nav_colorTextActive, 'font-weight': 'bold'});
    $(".nav a").on("click", function () {
        $(".nav").find(".active").removeClass("active");
        $(".navbar-nav li a").css({ 'color': nav_colorTextNornal});
        $(this).parent().addClass("active");
        $(".active a:hover").css({ 'color': nav_colorTextActive});
    });
}
function jumbo() {
    $('#body-content').css({ 'padding-bottom': '48px', 'padding-top': '48px' });
}
