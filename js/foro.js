$(function () {
    var preguntas = window.EDULECTO_PREGUNTAS_FORO || [];
    var actual = 0;

    var $dibujo = $("#dibujo");
    var $entrada = $("#respuesta");
    var $feedback = $("#feedback");
    var $btnAnterior = $("#btnAnterior");
    var $btnSiguiente = $("#btnSiguiente");

    function mostrarPregunta() {
        if (preguntas.length === 0) {
            $dibujo.text("");
            $feedback.text("No hay preguntas activas en el foro.").attr("class", "mensaje-feedback incorrecto");
            $entrada.prop("disabled", true);
            $btnSiguiente.prop("disabled", true);
            return;
        }
        $dibujo.text(preguntas[actual].dibujo_emoji);
        $entrada.val("");
        $feedback.text("");
        $entrada.trigger("focus");
    }

    $btnSiguiente.on("click", function () {
        var escrito = $.trim($entrada.val());

        if (escrito === "") {
            $feedback.text("Escribe una respuesta").attr("class", "mensaje-feedback incorrecto");
            return;
        }

        $btnSiguiente.prop("disabled", true);

        $.ajax({
            url: "ajax.php?action=foroResponder",
            method: "POST",
            dataType: "json",
            data: {
                id_pregunta: preguntas[actual].id_pregunta,
                respuesta: escrito
            }
        }).done(function (respuesta) {
            if (respuesta.correcta) {
                $feedback.text("¡Correcto!").attr("class", "mensaje-feedback correcto");

                setTimeout(function () {
                    if (actual < preguntas.length - 1) {
                        actual++;
                        mostrarPregunta();
                    } else {
                        alert("Terminaste todas las preguntas del foro, ¡buen trabajo!");
                        window.location.href = "index.php?page=perfil";
                    }
                    $btnSiguiente.prop("disabled", false);
                }, 800);
            } else {
                $feedback.text("Intenta de nuevo").attr("class", "mensaje-feedback incorrecto");
                $btnSiguiente.prop("disabled", false);
            }
        }).fail(function () {
            $feedback.text("Ocurrió un error, intenta de nuevo").attr("class", "mensaje-feedback incorrecto");
            $btnSiguiente.prop("disabled", false);
        });
    });

    $btnAnterior.on("click", function () {
        if (actual > 0) {
            actual--;
            mostrarPregunta();
        }
    });

    $entrada.on("keydown", function (e) {
        if (e.key === "Enter") {
            $btnSiguiente.trigger("click");
        }
    });

    mostrarPregunta();
});
