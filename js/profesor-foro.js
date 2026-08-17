$(function () {
    var preguntas = window.EDULECTO_PREGUNTAS_FORO_PROFESOR || [];
    var indiceActual = 0;

    var $dibujo = $("#dibujo");
    var $entrada = $("#respuesta");
    var $contador = $("#contador");
    var $btnAnterior = $("#btnAnterior");
    var $btnAgregar = $("#btnAgregar");
    var $campoDibujoNuevo = $("#campoDibujoNuevo");
    var $dibujoNuevo = $("#dibujoNuevo");

    function esNuevaPregunta() {
        return indiceActual >= preguntas.length;
    }

    function mostrarPregunta() {
        if (preguntas.length === 0 || esNuevaPregunta()) {
            $dibujo.text(esNuevaPregunta() && preguntas.length > 0 ? "🆕" : "");
            $entrada.val("");
            $campoDibujoNuevo.show();
            $dibujoNuevo.val("");
            $contador.text(preguntas.length === 0
                ? "Aún no tienes preguntas. Agrega la primera."
                : "Nueva pregunta " + (preguntas.length + 1));
            $entrada.trigger("focus");
            return;
        }

        $campoDibujoNuevo.hide();
        var pregunta = preguntas[indiceActual];
        $dibujo.text(pregunta.dibujo_emoji);
        $entrada.val(pregunta.respuesta_correcta);
        $contador.text("Pregunta " + (indiceActual + 1) + " de " + preguntas.length);
        $entrada.trigger("focus");
    }

    $btnAnterior.on("click", function () {
        if (indiceActual > 0) {
            indiceActual--;
            mostrarPregunta();
        }
    });

    $btnAgregar.on("click", function () {
        var respuesta = $.trim($entrada.val()).toLowerCase();

        if (respuesta === "") {
            $contador.text("Escribe la respuesta correcta antes de agregar");
            return;
        }

        var datos = { id: 0, respuesta: respuesta };
        var esNueva = esNuevaPregunta();

        if (esNueva) {
            var dibujo = $.trim($dibujoNuevo.val());
            if (dibujo === "") {
                $contador.text("Ingresa el emoji o dibujo de la pregunta");
                return;
            }
            datos.dibujo = dibujo;
        } else {
            datos.id = preguntas[indiceActual].id_pregunta;
        }

        $btnAgregar.prop("disabled", true);

        $.ajax({
            url: "ajax.php?action=profesorForoGuardar",
            method: "POST",
            dataType: "json",
            data: datos
        }).done(function (respuestaServidor) {
            if (esNueva) {
                preguntas.push({
                    id_pregunta: respuestaServidor.id,
                    dibujo_emoji: datos.dibujo,
                    respuesta_correcta: respuesta
                });
            } else {
                preguntas[indiceActual].respuesta_correcta = respuesta;
            }

            if (indiceActual < preguntas.length - 1) {
                indiceActual++;
                mostrarPregunta();
            } else {
                indiceActual = preguntas.length;
                $contador.text("Todas las preguntas del foro fueron guardadas");
                mostrarPregunta();
            }
        }).fail(function (xhr) {
            var respuestaServidor = xhr.responseJSON || { mensaje: "No se pudo guardar la pregunta." };
            $contador.text(respuestaServidor.mensaje);
        }).always(function () {
            $btnAgregar.prop("disabled", false);
        });
    });

    $entrada.on("keydown", function (e) {
        if (e.key === "Enter") {
            $btnAgregar.trigger("click");
        }
    });

    mostrarPregunta();
});
