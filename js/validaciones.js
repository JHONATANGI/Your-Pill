document.getElementById("loginForm").addEventListener("submit", function(event) {
    let email = document.querySelector("[name='email']").value;
    let password = document.querySelector("[name='password']").value;

    if (!email.includes("@") || password.length < 6) {
        alert("Por favor, ingresa un email válido y una contraseña de al menos 6 caracteres.");
        event.preventDefault();
    }
});

  document.querySelector("form").addEventListener("submit", function (e) {
    const email = document.getElementById("email");
    const password = document.getElementById("password");

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email.value)) {
      alert("Por favor ingresa un correo válido.");
      email.focus();
      e.preventDefault();
      return;
    }

    if (password.value.length < 6) {
      alert("La contraseña debe tener al menos 6 caracteres.");
      password.focus();
      e.preventDefault();
      return;
    }
  });

  document.getElementById("email").addEventListener("input", function () {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  this.setCustomValidity(
    emailRegex.test(this.value) ? "" : "Correo inválido"
  );
});