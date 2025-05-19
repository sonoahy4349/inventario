document.getElementById("loginForm").addEventListener("submit", async function(event) {
    event.preventDefault(); // Evita la recarga de la página

    let username = document.getElementById("username").value;
    let password = document.getElementById("pass").value;
    let mensaje = document.getElementById("mensaje");

    if (!username || !password) {
        mensaje.innerText = "Por favor, completa todos los campos.";
        return;
    }

    let datos = new FormData();
    datos.append("username", username);
    datos.append("pass", password);

    try {
        let response = await fetch("../models/login.php", {
            method: "POST",
            body: datos
        });

        let resultado = await response.json();

        if (resultado.success) {
            mensaje.style.color = "green";
            mensaje.innerText = "Inicio de sesión exitoso. Redirigiendo...";
            setTimeout(() => {
                window.location.href = "dashboard.php"; // Redirigir al dashboard
            }, 2000);
        } else {
            mensaje.innerText = resultado.message;
        }
    } catch (error) {
        console.error("Error:", error);
        mensaje.innerText = "Hubo un error en la solicitud.";
    }
});
