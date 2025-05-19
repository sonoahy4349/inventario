document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const messageElement = document.getElementById('message');
    const formData = new FormData(form);
    
    // Convertir FormData a objeto simple
    const data = {};
    formData.forEach((value, key) => data[key] = value);
    
    messageElement.textContent = 'Verificando credenciales...';
    messageElement.style.color = 'blue';

    try {
        const response = await fetch('../models/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        
        if (result.success) {
            messageElement.textContent = 'Inicio de sesión exitoso! Redirigiendo...';
            messageElement.style.color = 'green';
            setTimeout(() => {
                window.location.href = result.redirect;
            }, 1000);
        } else {
            messageElement.textContent = result.message || 'Error desconocido';
            messageElement.style.color = 'red';
        }
    } catch (error) {
        messageElement.textContent = 'Error de conexión: ' + error.message;
        messageElement.style.color = 'red';
        console.error('Error:', error);
    }
});