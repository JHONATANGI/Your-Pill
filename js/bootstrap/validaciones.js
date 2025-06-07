document.getElementById("loginForm").addEventListener("submit", function(event) {
    let email = document.querySelector("[name='email']").value;
    let password = document.querySelector("[name='password']").value;

    if (!email.includes("@") || password.length < 6) {
        alert("Por favor, ingresa un email válido y una contraseña de al menos 6 caracteres.");
        event.preventDefault();
    }
});