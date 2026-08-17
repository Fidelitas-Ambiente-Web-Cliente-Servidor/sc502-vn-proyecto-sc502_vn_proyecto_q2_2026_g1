$(function () {
    var porcentaje = window.EDULECTO_PORCENTAJE || 0;
    setTimeout(function () {
        $("#relleno").css("width", porcentaje + "%");
    }, 200);
});
