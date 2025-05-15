 // Función para mostrar datos en el contenedor #info
 // Recibe el tipo de datos y un listado con la información obtenida del servidor
function mostrarInformacion(tipo, listado) {
    console.log("Actualizando el contenedor con datos de:", tipo);
    console.log("Listado recibido:", listado);

    const contenedor = document.getElementById("info");
// Muestra el título de la sección con el tipo de datos
    contenedor.innerHTML = `<h2>${tipo.toUpperCase()}</h2>`;

    listado.forEach(item => {
        const itemDiv = document.createElement("div");
        // Filtra la clave "id" para evitar mostrarla
        itemDiv.innerHTML = Object.keys(item)
            .filter(key => key !== "id") 
            .map(key => `<p><strong>${key}:</strong> ${item[key]}</p>`)
            .join(""); 
        contenedor.appendChild(itemDiv);
    });
}

// Detectar eventos en el documento para asegurar que se asignan a los botones correctos
document.addEventListener("DOMContentLoaded", () => {
    //Modal de login
    const modal = document.getElementById("loginModal");
    const openBtn = document.getElementById("openLoginBtn");
    const closeBtn = document.querySelector(".modal-content .close-btn");
    const loginForm = document.getElementById("loginForm");
    const loginError = document.getElementById("loginError");

    function openModal() {
        modal.style.display = "block";
        loginError.style.display = "none";
        loginError.textContent = "";
    }

    function closeModal() {
        modal.style.display = "none";
    }
 // Asignar eventos para abrir/cerrar el modal
    if (openBtn) openBtn.addEventListener("click", openModal);
    if (closeBtn) closeBtn.addEventListener("click", closeModal);
    window.addEventListener("click", (event) => {
        if (event.target === modal) closeModal();
    });
   // Manejo del formulario de login con AJAX
    if (loginForm) {
        loginForm.addEventListener("submit", (event) => {
            event.preventDefault();// Evita la recarga de la página en el envío
            loginError.style.display = "none";

            const formData = new FormData(loginForm);

            fetch("auth.php", { method: "POST", body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirección al panel de administración en caso de éxito
                        window.location.href = "panel.php";
                    } else {
                        loginError.textContent = data.message || "Error desconocido.";
                        loginError.style.display = "block";
                    }
                })
                .catch(error => {
                    //Posibles errores de red o de respuesta del servidor
                    console.error("Error en fetch:", error);
                    loginError.textContent = "Error de conexión. Inténtalo de nuevo.";
                    loginError.style.display = "block";
                });
        });
    }
});

// Manejo de carga de datos al hacer clic en los botones de categorías
document.querySelectorAll(".button").forEach(button => {
    button.addEventListener("click", function () {
        const tipo = this.classList[1]; // Captura directamente el tipo de la clase del botón


        console.log("Tipo enviado al servidor:", tipo);
        console.log("URL solicitada:", "get_data.php?tipo=" + tipo);

        fetch("get_data.php?tipo=" + tipo)
            .then(response => {
                console.log("Estado de la respuesta:", response.status);
                 //Se espera una respuesta JSON con un listado de elementos
                return response.json();
            })
            .then(data => {
                console.log("Datos recibidos del servidor:", data);

                if (data.length > 0) {
                    mostrarInformacion(tipo, data);
                    document.getElementById("info").style.display = "block";
                } else {
                    console.log(`No se encontraron datos para ${tipo}`);
                    document.getElementById("info").innerHTML = `<p>No se encontraron datos para ${tipo}.</p>`;
                    document.getElementById("info").style.display = "block";
                }
            })
            .catch(error => {
                // Manejo de errores en la solicitud o respuesta inesperada
                console.error("Error al cargar datos:", error);
                document.getElementById("info").innerHTML = `<p style="color: red;">Error al cargar los datos. Por favor, inténtelo de nuevo más tarde.</p>`;
                document.getElementById("info").style.display = "block";
            });
    });
});
