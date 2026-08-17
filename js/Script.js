function showToast(message, type) {
    type = type || "default";
    var $toast = $(".toast");
    if ($toast.length === 0) {
        $toast = $("<div>").addClass("toast").appendTo("body");
    }
    $toast.text(message);
    $toast.removeClass("toast-error");
    if (type === "error") {
        $toast.addClass("toast-error");
    }

    $toast.removeClass("show");
    void $toast[0].offsetWidth;
    $toast.addClass("show");

    clearTimeout($toast.data("hideTimer"));
    var timer = setTimeout(function () {
        $toast.removeClass("show");
    }, 3200);
    $toast.data("hideTimer", timer);
}

function isValidEmail(value) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($.trim(value));
}

function setFieldError($field, message) {
    var $error = $field.find(".field-error");
    var $input = $field.find("input, select");
    if (message) {
        $field.addClass("has-error");
        $error.text(message);
        $input.addClass("is-invalid");
    } else {
        $field.removeClass("has-error");
        $input.removeClass("is-invalid");
    }
}

function initPasswordToggles() {
    $(".toggle-visibility").on("click", function () {
        var $btn = $(this);
        var $input = $btn.closest(".input-wrap").find("input");
        var isHidden = $input.attr("type") === "password";
        $input.attr("type", isHidden ? "text" : "password");
        $btn.attr("aria-label", isHidden ? "Ocultar contraseña" : "Mostrar contraseña");
        $btn.toggleClass("is-visible", isHidden);
    });
}

function initLoginForm() {
    var $form = $("#login-form");
    if ($form.length === 0) return;

    $form.on("submit", function (e) {
        e.preventDefault();
        var valid = true;

        var $emailField = $form.find("#field-email");
        var $passField = $form.find("#field-password");
        var email = $form.find("#email").val();
        var password = $form.find("#password").val();

        if (!isValidEmail(email)) {
            setFieldError($emailField, "Ingresá un correo electrónico válido.");
            valid = false;
        } else {
            setFieldError($emailField, "");
        }

        if (!password) {
            setFieldError($passField, "Ingresá tu contraseña.");
            valid = false;
        } else {
            setFieldError($passField, "");
        }

        if (!valid) {
            showToast("Revisá los campos marcados en rojo.", "error");
            return;
        }

        var $submitBtn = $form.find("button[type='submit']");
        $submitBtn.prop("disabled", true).text("Ingresando...");

        $.ajax({
            url: "ajax.php?action=login",
            method: "POST",
            dataType: "json",
            data: { email: email, password: password }
        }).done(function (respuesta) {
            showToast(respuesta.mensaje);
            setTimeout(function () {
                window.location.href = respuesta.redirect;
            }, 500);
        }).fail(function (xhr) {
            var respuesta = xhr.responseJSON || { mensaje: "No se pudo iniciar sesión." };
            showToast(respuesta.mensaje, "error");
            $submitBtn.prop("disabled", false).text("Iniciar sesión");
        });
    });
}

function initForgotPasswordForm() {
    var $form = $("#forgot-form");
    if ($form.length === 0) return;

    $form.on("submit", function (e) {
        e.preventDefault();
        var $emailField = $form.find("#field-email");
        var email = $form.find("#email").val();

        if (!isValidEmail(email)) {
            setFieldError($emailField, "Ingresá un correo electrónico válido.");
            showToast("Revisá tu correo electrónico.", "error");
            return;
        }
        setFieldError($emailField, "");

        var $submitBtn = $form.find("button[type='submit']");
        $submitBtn.prop("disabled", true).text("Enviando...");

        $.ajax({
            url: "ajax.php?action=forgotPassword",
            method: "POST",
            dataType: "json",
            data: { email: email }
        }).done(function (respuesta) {
            window.location.href = respuesta.redirect;
        }).fail(function (xhr) {
            var respuesta = xhr.responseJSON || { mensaje: "No se pudo procesar la solicitud." };
            showToast(respuesta.mensaje, "error");
            $submitBtn.prop("disabled", false).text("Enviar enlace de recuperación");
        });
    });
}

function initEmailSentScreen() {
    var $resendBtn = $("#resend-btn");
    if ($resendBtn.length === 0) return;

    $resendBtn.on("click", function () {
        $resendBtn.prop("disabled", true);
        var originalHtml = $resendBtn.html();
        $resendBtn.text("Reenviando...");

        $.ajax({
            url: "ajax.php?action=resendEmail",
            method: "POST",
            dataType: "json"
        }).done(function (respuesta) {
            showToast(respuesta.mensaje);
        }).fail(function (xhr) {
            var respuesta = xhr.responseJSON || { mensaje: "No se pudo reenviar el correo." };
            showToast(respuesta.mensaje, "error");
        }).always(function () {
            $resendBtn.html(originalHtml);
            $resendBtn.prop("disabled", false);
        });
    });
}

function initRegisterForm() {
    var $form = $("#register-form");
    if ($form.length === 0) return;

    $form.find("#userType").on("change", function () {
        var tipo = $(this).val();
        $("#field-edad").toggle(tipo === "estudiante");
        $("#field-especialidad").toggle(tipo === "docente");
    });

    $form.on("submit", function (e) {
        e.preventDefault();
        var valid = true;

        var $nameField = $form.find("#field-name");
        var $emailField = $form.find("#field-email");
        var $passField = $form.find("#field-password");
        var $confirmField = $form.find("#field-confirm");
        var $typeField = $form.find("#field-type");
        var $edadField = $form.find("#field-edad");

        var name = $.trim($form.find("#name").val());
        var email = $form.find("#email").val();
        var password = $form.find("#password").val();
        var confirm = $form.find("#confirm").val();
        var userType = $form.find("#userType").val();
        var edad = $form.find("#edad").val();
        var especialidad = $form.find("#especialidad").val();

        if (!name) {
            setFieldError($nameField, "Ingresá tu nombre completo.");
            valid = false;
        } else {
            setFieldError($nameField, "");
        }

        if (!isValidEmail(email)) {
            setFieldError($emailField, "Ingresá un correo electrónico válido.");
            valid = false;
        } else {
            setFieldError($emailField, "");
        }

        if (password.length < 8) {
            setFieldError($passField, "La contraseña debe tener al menos 8 caracteres.");
            valid = false;
        } else {
            setFieldError($passField, "");
        }

        if (confirm !== password || !confirm) {
            setFieldError($confirmField, "Las contraseñas no coinciden.");
            valid = false;
        } else {
            setFieldError($confirmField, "");
        }

        if (!userType) {
            setFieldError($typeField, "Seleccioná un tipo de usuario.");
            valid = false;
        } else {
            setFieldError($typeField, "");
        }

        if (userType === "estudiante" && (!edad || edad < 1)) {
            setFieldError($edadField, "Ingresá una edad válida.");
            valid = false;
        } else {
            setFieldError($edadField, "");
        }

        if (!valid) {
            showToast("Revisá los campos marcados en rojo.", "error");
            return;
        }

        var $submitBtn = $form.find("button[type='submit']");
        $submitBtn.prop("disabled", true).text("Registrando...");

        $.ajax({
            url: "ajax.php?action=register",
            method: "POST",
            dataType: "json",
            data: {
                name: name,
                email: email,
                password: password,
                confirm: confirm,
                userType: userType,
                edad: edad,
                especialidad: especialidad
            }
        }).done(function (respuesta) {
            window.location.href = respuesta.redirect;
        }).fail(function (xhr) {
            var respuesta = xhr.responseJSON || { mensaje: "No se pudo completar el registro." };
            showToast(respuesta.mensaje, "error");
            $submitBtn.prop("disabled", false).html('Registrarse');
        });
    });
}

$(document).ready(function () {
    initPasswordToggles();
    initLoginForm();
    initForgotPasswordForm();
    initEmailSentScreen();
    initRegisterForm();
});