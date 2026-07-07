
/**
 * Muestra un mensaje flotante breve (toast) en la parte inferior de la pantalla.
 */
function showToast(message, type = "default") {
  let toast = document.querySelector(".toast");
  if (!toast) {
    toast = document.createElement("div");
    toast.className = "toast";
    document.body.appendChild(toast);
  }
  toast.textContent = message;
  toast.classList.remove("toast-error");
  if (type === "error") toast.classList.add("toast-error");
 
  // reiniciar animación si ya estaba visible
  toast.classList.remove("show");
  // forzar reflow
  void toast.offsetWidth;
  toast.classList.add("show");
 
  clearTimeout(toast._hideTimer);
  toast._hideTimer = setTimeout(() => {
    toast.classList.remove("show");
  }, 3200);
}
 
/**
 * Valida un correo electrónico con una expresión regular simple.
 */
function isValidEmail(value) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
}
 
/**
 * Marca o limpia el estado de error de un campo (.field).
 */
function setFieldError(fieldEl, message) {
  const errorEl = fieldEl.querySelector(".field-error");
  const inputEl = fieldEl.querySelector("input, select");
  if (message) {
    fieldEl.classList.add("has-error");
    if (errorEl) errorEl.textContent = message;
    if (inputEl) inputEl.classList.add("is-invalid");
  } else {
    fieldEl.classList.remove("has-error");
    if (inputEl) inputEl.classList.remove("is-invalid");
  }
}
 
/**
 * Activa los botones de mostrar/ocultar contraseña (icono de ojo).
 */
function initPasswordToggles() {
  document.querySelectorAll(".toggle-visibility").forEach((btn) => {
    btn.addEventListener("click", () => {
      const input = btn.closest(".input-wrap").querySelector("input");
      const isHidden = input.type === "password";
      input.type = isHidden ? "text" : "password";
      btn.setAttribute("aria-label", isHidden ? "Ocultar contraseña" : "Mostrar contraseña");
      btn.classList.toggle("is-visible", isHidden);
    });
  });
}
 
/*  Formulario: Iniciar sesión  */
 
function initLoginForm() {
  const form = document.querySelector("#login-form");
  if (!form) return;
 
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    let valid = true;
 
    const emailField = form.querySelector("#field-email");
    const passField = form.querySelector("#field-password");
    const email = form.querySelector("#email").value;
    const password = form.querySelector("#password").value;
 
    if (!isValidEmail(email)) {
      setFieldError(emailField, "Ingresá un correo electrónico válido.");
      valid = false;
    } else {
      setFieldError(emailField, "");
    }
 
    if (!password) {
      setFieldError(passField, "Ingresá tu contraseña.");
      valid = false;
    } else {
      setFieldError(passField, "");
    }
 
    if (!valid) {
      showToast("Revisá los campos marcados en rojo.", "error");
      return;
    }
 
    const submitBtn = form.querySelector("button[type='submit']");
    submitBtn.disabled = true;
    submitBtn.textContent = "Ingresando...";
 
    setTimeout(() => {
      showToast("¡Bienvenido de nuevo!");
      submitBtn.disabled = false;
      submitBtn.textContent = "Iniciar sesión";
      // Aquí normalmente se redirige al dashboard tras un login real:
      // window.location.href = "dashboard.html";
    }, 900);
  });
}
 
/*  Formulario: Olvidé mi contraseña  */
 
function initForgotPasswordForm() {
  const form = document.querySelector("#forgot-form");
  if (!form) return;
 
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const emailField = form.querySelector("#field-email");
    const email = form.querySelector("#email").value;
 
    if (!isValidEmail(email)) {
      setFieldError(emailField, "Ingresá un correo electrónico válido.");
      showToast("Revisá tu correo electrónico.", "error");
      return;
    }
    setFieldError(emailField, "");
 
    const submitBtn = form.querySelector("button[type='submit']");
    submitBtn.disabled = true;
    submitBtn.textContent = "Enviando...";
 
    setTimeout(() => {
      // Guardamos el correo para mostrarlo en la siguiente pantalla si hace falta
      sessionStorage.setItem("edulecto_recovery_email", email);
      window.location.href = "email-sent.html";
    }, 700);
  });
}
 
/*  Pantalla: Correo enviado  */
 
function initEmailSentScreen() {
  const resendBtn = document.querySelector("#resend-btn");
  if (!resendBtn) return;
 
  resendBtn.addEventListener("click", () => {
    resendBtn.disabled = true;
    const originalText = resendBtn.innerHTML;
    resendBtn.textContent = "Reenviando...";
 
    setTimeout(() => {
      showToast("Correo de recuperación reenviado.");
      resendBtn.innerHTML = originalText;
      resendBtn.disabled = false;
    }, 900);
  });
}
 
/*  Formulario: Crear cuenta  */
 
function initRegisterForm() {
  const form = document.querySelector("#register-form");
  if (!form) return;
 
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    let valid = true;
 
    const nameField = form.querySelector("#field-name");
    const emailField = form.querySelector("#field-email");
    const passField = form.querySelector("#field-password");
    const confirmField = form.querySelector("#field-confirm");
    const typeField = form.querySelector("#field-type");
 
    const name = form.querySelector("#name").value.trim();
    const email = form.querySelector("#email").value;
    const password = form.querySelector("#password").value;
    const confirm = form.querySelector("#confirm").value;
    const userType = form.querySelector("#userType").value;
 
    if (!name) {
      setFieldError(nameField, "Ingresá tu nombre completo.");
      valid = false;
    } else {
      setFieldError(nameField, "");
    }
 
    if (!isValidEmail(email)) {
      setFieldError(emailField, "Ingresá un correo electrónico válido.");
      valid = false;
    } else {
      setFieldError(emailField, "");
    }
 
    if (password.length < 8) {
      setFieldError(passField, "La contraseña debe tener al menos 8 caracteres.");
      valid = false;
    } else {
      setFieldError(passField, "");
    }
 
    if (confirm !== password || !confirm) {
      setFieldError(confirmField, "Las contraseñas no coinciden.");
      valid = false;
    } else {
      setFieldError(confirmField, "");
    }
 
    if (!userType) {
      setFieldError(typeField, "Seleccioná un tipo de usuario.");
      valid = false;
    } else {
      setFieldError(typeField, "");
    }
 
    if (!valid) {
      showToast("Revisá los campos marcados en rojo.", "error");
      return;
    }
 
    const submitBtn = form.querySelector("button[type='submit']");
    submitBtn.disabled = true;
    submitBtn.textContent = "Registrando...";
 
    setTimeout(() => {
      window.location.href = "account-created.html";
    }, 800);
  });
}
 
/*  Inicialización general  */
 
document.addEventListener("DOMContentLoaded", () => {
  initPasswordToggles();
  initLoginForm();
  initForgotPasswordForm();
  initEmailSentScreen();
  initRegisterForm();
});
 