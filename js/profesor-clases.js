$(function () {
    var eventosClases = window.EDULECTO_EVENTOS_CLASES || {};
    var diasEnMes = window.EDULECTO_DIAS_EN_MES || 30;
    var primerDiaSemana = window.EDULECTO_PRIMER_DIA_SEMANA || 0;
    var misClases = window.EDULECTO_MIS_CLASES || [];

    var claseTipo = {
        futura: "escritura-futura",
        hoy: "lectura-hoy",
        pasada: "escritura-pasada"
    };

    var $cuerpoCalendario = $("#cuerpoCalendario");
    var $pestanas = $(".pestana");
    var filtroActivo = null;

    var $cuerpoClases = $("#cuerpoClases");
    var $vistaCalendario = $("#vistaCalendario");
    var $vistaFormularioClase = $("#vistaFormularioClase");
    var $btnMostrarFormClase = $("#btnMostrarFormClase");
    var $btnCancelarClase = $("#btnCancelarClase");
    var $btnGuardarClase = $("#btnGuardarClase");
    var $btnEliminarClase = $("#btnEliminarClase");
    var $tituloFormClase = $("#tituloFormClase");
    var $claseId = $("#claseId");
    var $temaClase = $("#temaClase");
    var $fechaClase = $("#fechaClase");
    var $horaClase = $("#horaClase");

    function construirCalendario() {
        $cuerpoCalendario.empty();
        var diaActual = 1;

        for (var fila = 0; fila < 6 && diaActual <= diasEnMes; fila++) {
            var $tr = $("<tr>");

            for (var col = 0; col < 7; col++) {
                var $td = $("<td>");

                if ((fila === 0 && col < primerDiaSemana) || diaActual > diasEnMes) {
                    $tr.append($td);
                    continue;
                }

                var evento = eventosClases[diaActual];
                var html = '<span class="numero-dia">' + diaActual + "</span>";

                if (evento) {
                    var visible = (filtroActivo === null || filtroActivo === evento.tipo);
                    html += '<span class="evento ' + claseTipo[evento.tipo] + '" style="' +
                        (visible ? "" : "display:none;") + '">' + evento.texto + "</span>";
                }

                $td.html(html);
                $tr.append($td);
                diaActual++;
            }

            $cuerpoCalendario.append($tr);
            if (diaActual > diasEnMes) break;
        }
    }

    $pestanas.on("click", function () {
        $pestanas.addClass("atenuada");
        $(this).removeClass("atenuada");
        filtroActivo = $(this).data("filtro");
        construirCalendario();
    });

    function renderClases() {
        $cuerpoClases.empty();

        if (misClases.length === 0) {
            $cuerpoClases.append('<tr><td colspan="5">Todavía no agendaste ninguna clase.</td></tr>');
            return;
        }

        misClases.forEach(function (clase, indice) {
            var $fila = $("<tr>").html(
                "<td>" + clase.tema + "</td>" +
                "<td>" + clase.fecha + "</td>" +
                "<td>" + clase.hora.substring(0, 5) + "</td>" +
                "<td>" + clase.total_estudiantes + "</td>" +
                '<td><button class="boton-mini" data-indice="' + indice + '">Editar</button></td>'
            );
            $cuerpoClases.append($fila);
        });

        $cuerpoClases.find("button").on("click", function () {
            var clase = misClases[$(this).data("indice")];
            abrirFormularioEdicion(clase.id_clase);
        });
    }

    function limpiarChecks() {
        $(".chk-estudiante-clase").prop("checked", false);
    }

    function mostrarFormulario() {
        $vistaCalendario.hide();
        $vistaFormularioClase.show();
    }

    function mostrarCalendario() {
        $vistaFormularioClase.hide();
        $vistaCalendario.show();
    }

    function abrirFormularioNuevo() {
        $tituloFormClase.text("Agendar nueva clase");
        $claseId.val(0);
        $temaClase.val("");
        $fechaClase.val("");
        $horaClase.val("");
        limpiarChecks();
        $btnEliminarClase.hide();
        mostrarFormulario();
        $temaClase.trigger("focus");
    }

    function abrirFormularioEdicion(idClase) {
        $.ajax({
            url: "ajax.php?action=profesorClaseObtener",
            method: "GET",
            dataType: "json",
            data: { id: idClase }
        }).done(function (respuesta) {
            var clase = respuesta.clase;
            $tituloFormClase.text("Editar clase");
            $claseId.val(clase.id_clase);
            $temaClase.val(clase.tema);
            $fechaClase.val(clase.fecha);
            $horaClase.val(clase.hora.substring(0, 5));

            limpiarChecks();
            respuesta.estudiantes.forEach(function (idEstudiante) {
                $(".chk-estudiante-clase[value='" + idEstudiante + "']").prop("checked", true);
            });

            $btnEliminarClase.show();
            mostrarFormulario();
        }).fail(function () {
            alert("No se pudo cargar la clase.");
        });
    }

    $btnMostrarFormClase.on("click", abrirFormularioNuevo);
    $btnCancelarClase.on("click", mostrarCalendario);

    $btnGuardarClase.on("click", function () {
        var tema = $.trim($temaClase.val());
        var fecha = $fechaClase.val();
        var hora = $horaClase.val();

        if (tema === "" || fecha === "" || hora === "") {
            alert("Completa el tema, la fecha y la hora de la clase.");
            return;
        }

        var estudiantesSeleccionados = $(".chk-estudiante-clase:checked").map(function () {
            return $(this).val();
        }).get();

        var idClase = Number($claseId.val());
        var accion = idClase > 0 ? "profesorClaseActualizar" : "profesorClaseCrear";
        var datos = {
            tema: tema,
            fecha: fecha,
            hora: hora,
            estudiantes: JSON.stringify(estudiantesSeleccionados)
        };
        if (idClase > 0) {
            datos.id = idClase;
        }

        $btnGuardarClase.prop("disabled", true);

        $.ajax({
            url: "ajax.php?action=" + accion,
            method: "POST",
            dataType: "json",
            data: datos
        }).done(function () {
            window.location.reload();
        }).fail(function (xhr) {
            var respuesta = xhr.responseJSON || { mensaje: "No se pudo guardar la clase." };
            alert(respuesta.mensaje);
            $btnGuardarClase.prop("disabled", false);
        });
    });

    $btnEliminarClase.on("click", function () {
        var idClase = Number($claseId.val());
        if (idClase <= 0) return;
        if (!confirm("¿Eliminar esta clase? Se quitará también la asignación de estudiantes.")) return;

        $.ajax({
            url: "ajax.php?action=profesorClaseEliminar",
            method: "POST",
            dataType: "json",
            data: { id: idClase }
        }).done(function () {
            window.location.reload();
        }).fail(function () {
            alert("No se pudo eliminar la clase.");
        });
    });

    construirCalendario();
    renderClases();
});
