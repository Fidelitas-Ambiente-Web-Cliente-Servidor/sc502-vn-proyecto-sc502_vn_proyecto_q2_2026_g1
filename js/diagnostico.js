$(function () {
    var preguntas = window.EDULECTO_PREGUNTAS || [];
    var actual = 0;
    var respuestas = new Array(preguntas.length).fill(null);

    var $textoPregunta = $("#textoPregunta");
    var $contenedorOpciones = $("#opciones");
    var $btnAnterior = $("#btnAnterior");
    var $btnSiguiente = $("#btnSiguiente");

    function mostrarPregunta() {
        var pregunta = preguntas[actual];
        $textoPregunta.text(pregunta.texto);
        $contenedorOpciones.empty();

        pregunta.opciones.forEach(function (opcion, i) {
            var $btn = $("<button>")
                .addClass("boton boton-opcion")
                .text(opcion);
            if (respuestas[actual] === i) {
                $btn.addClass("seleccionada");
            }
            $btn.on("click", function () {
                respuestas[actual] = i;
                mostrarPregunta();
            });
            $contenedorOpciones.append($btn);
        });

        $btnSiguiente.text(actual === preguntas.length - 1 ? "Finalizar" : "Siguiente");
    }

    $btnAnterior.on("click", function () {
        if (actual > 0) {
            actual--;
            mostrarPregunta();
        }
    });

    $btnSiguiente.on("click", function () {
        if (respuestas[actual] === null) {
            alert("Seleccione una respuesta para continuar");
            return;
        }

        if (actual < preguntas.length - 1) {
            actual++;
            mostrarPregunta();
        } else {
            finalizarDiagnostico();
        }
    });

    function finalizarDiagnostico() {
        $btnSiguiente.prop("disabled", true).text("Enviando...");

        $.ajax({
            url: "ajax.php?action=diagnosticoFinalizar",
            method: "POST",
            dataType: "json",
            data: { respuestas: JSON.stringify(respuestas) }
        }).done(function (respuesta) {
            window.location.href = respuesta.redirect;
        }).fail(function () {
            alert("No se pudo guardar el diagnóstico. Intenta de nuevo.");
            $btnSiguiente.prop("disabled", false).text("Finalizar");
        });
    }

    mostrarPregunta();
});
