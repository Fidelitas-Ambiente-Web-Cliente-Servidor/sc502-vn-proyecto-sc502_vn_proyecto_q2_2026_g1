$(function () {
    var ejercicios = window.EDULECTO_EJERCICIOS || [];

    var $cuerpoEjercicios = $("#cuerpoEjercicios");
    var $vistaListado = $("#vistaListado");
    var $vistaFormulario = $("#vistaFormulario");
    var $btnMostrarForm = $("#btnMostrarForm");
    var $btnCancelarActividad = $("#btnCancelarActividad");
    var $btnAgregarActividad = $("#btnAgregarActividad");
    var $nombreActividad = $("#nombreActividad");
    var $descripcionActividad = $("#descripcionActividad");
    var $tipoActividad = $("#tipoActividad");
    var $nivelActividad = $("#nivelActividad");
    var $estadoActividad = $("#estadoActividad");

    function renderEjercicios() {
        $cuerpoEjercicios.empty();

        if (ejercicios.length === 0) {
            $cuerpoEjercicios.append('<tr><td colspan="5">Todavía no has creado ejercicios.</td></tr>');
            return;
        }

        ejercicios.forEach(function (ej, indice) {
            var $fila = $("<tr>").html(
                '<td class="nombre-ejercicio" data-id="' + ej.id_actividad + '">' + ej.nombre + "</td>" +
                '<td><button class="boton-mini" data-accion="editar" data-indice="' + indice + '">Editar</button></td>' +
                "<td>" + ej.nivel + "</td>" +
                '<td><button class="boton-mini" data-accion="guardar" data-indice="' + indice + '">Guardar</button></td>' +
                '<td><button class="boton-mini eliminar" data-accion="eliminar" data-indice="' + indice + '">Eliminar</button></td>'
            );
            $cuerpoEjercicios.append($fila);
        });

        $cuerpoEjercicios.find("button").on("click", function () {
            var indice = Number($(this).data("indice"));
            var accion = $(this).data("accion");
            var $celdaNombre = $(this).closest("tr").find(".nombre-ejercicio");
            var idActividad = ejercicios[indice].id_actividad;

            if (accion === "editar") {
                $celdaNombre.attr("contenteditable", "true").trigger("focus");
            } else if (accion === "guardar") {
                $celdaNombre.attr("contenteditable", "false");
                var nuevoNombre = $.trim($celdaNombre.text());
                ejercicios[indice].nombre = nuevoNombre;

                $.ajax({
                    url: "ajax.php?action=profesorEjercicioActualizar",
                    method: "POST",
                    dataType: "json",
                    data: { id: idActividad, nombre: nuevoNombre }
                }).fail(function () {
                    alert("No se pudo guardar el cambio.");
                });
            } else if (accion === "eliminar") {
                if (!confirm("¿Eliminar esta actividad?")) return;

                $.ajax({
                    url: "ajax.php?action=profesorEjercicioEliminar",
                    method: "POST",
                    dataType: "json",
                    data: { id: idActividad }
                }).done(function () {
                    ejercicios.splice(indice, 1);
                    renderEjercicios();
                }).fail(function () {
                    alert("No se pudo eliminar la actividad.");
                });
            }
        });
    }

    function mostrarFormulario() {
        $vistaListado.hide();
        $vistaFormulario.show();
        $nombreActividad.val("");
        $descripcionActividad.val("");
        $tipoActividad.val("crucigrama");
        $nivelActividad.val(1);
        $estadoActividad.val("Activo");
        $nombreActividad.trigger("focus");
    }

    function mostrarListado() {
        $vistaFormulario.hide();
        $vistaListado.show();
    }

    $btnMostrarForm.on("click", mostrarFormulario);
    $btnCancelarActividad.on("click", mostrarListado);

    $btnAgregarActividad.on("click", function () {
        var nombre = $.trim($nombreActividad.val());
        var descripcion = $.trim($descripcionActividad.val());

        if (nombre === "" || descripcion === "") {
            alert("Completa el nombre y la descripción de la actividad.");
            return;
        }

        $.ajax({
            url: "ajax.php?action=profesorEjercicioCrear",
            method: "POST",
            dataType: "json",
            data: {
                nombre: nombre,
                descripcion: descripcion,
                tipo: $tipoActividad.val(),
                nivel: $nivelActividad.val(),
                estado: $estadoActividad.val()
            }
        }).done(function (respuesta) {
            ejercicios.push({
                id_actividad: respuesta.id,
                nombre: nombre,
                nivel: $nivelActividad.val()
            });
            renderEjercicios();
            mostrarListado();
        }).fail(function (xhr) {
            var respuesta = xhr.responseJSON || { mensaje: "No se pudo crear la actividad." };
            alert(respuesta.mensaje);
        });
    });

    if (window.location.hash === "#crear") {
        mostrarFormulario();
    }

    renderEjercicios();
});
