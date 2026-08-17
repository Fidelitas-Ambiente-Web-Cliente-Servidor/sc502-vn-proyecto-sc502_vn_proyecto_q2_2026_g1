$(function () {
    var estudiantes = window.EDULECTO_ESTUDIANTES || [];
    var $cuerpoEstudiantes = $("#cuerpoEstudiantes");

    function renderEstudiantes() {
        $cuerpoEstudiantes.empty();

        if (estudiantes.length === 0) {
            $cuerpoEstudiantes.append('<tr><td colspan="5">Aún no tienes estudiantes asignados a tus clases.</td></tr>');
            return;
        }

        estudiantes.forEach(function (est, indice) {
            var $fila = $("<tr>").html(
                "<td>" + est.nombre + "</td>" +
                "<td>" + est.edad + " años</td>" +
                "<td>" + est.nivel + "</td>" +
                '<td class="celda-progreso">' +
                    '<div class="etiqueta-barra"><span></span><span>' + est.progreso + '%</span></div>' +
                    '<div class="barra"><div class="barra-relleno" style="width:' + est.progreso + '%"></div></div>' +
                "</td>" +
                '<td><button class="boton-mini" data-indice="' + indice + '">Ver detalles</button></td>'
            );
            $cuerpoEstudiantes.append($fila);
        });

        $cuerpoEstudiantes.find(".boton-mini").on("click", function () {
            var est = estudiantes[$(this).data("indice")];
            alert("Detalle de " + est.nombre + ": nivel " + est.nivel + ", progreso " + est.progreso + "%");
        });
    }

    renderEstudiantes();
});
