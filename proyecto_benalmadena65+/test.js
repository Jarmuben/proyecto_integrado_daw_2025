// TEST AUTOMÁTICO PARA BACKEND Y FRONTEND

// Simula clic en cada botón y verificar carga de datos en #info
document.querySelectorAll(".button").forEach((button) => {
  button.addEventListener("click", function () {
    let tipo = this.classList[1]; // Captura el tipo de datos desde la clase del botón
    if (tipo === "citas") tipo = "eventos_culturales"; // Cambia "citas" por "eventos_culturales"

    console.log(`Probando botón: ${tipo}`);
    // Hacer solicitud al backend para obtener los datos de la categoría seleccionada
    fetch("get_data.php?tipo=" + tipo)
      .then((response) => response.json())
      .then((data) => {
        console.log(`Datos cargados para ${tipo}:`, data);
        //Validar que la respuesta contiene datos antes de mostrarlos
        if (Array.isArray(data) && data.length > 0) {
          mostrarInformacion(tipo, data);
          document.getElementById("info").style.display = "block";
          console.log(`Los datos de ${tipo} se muestran correctamente.`);
        } else {
          console.error(`No se encontraron datos para ${tipo}`);
          document.getElementById(
            "info"
          ).innerHTML = `<p>No hay información disponible.</p>`;
        }
      })
      .catch((error) => {
        console.error(`Error al obtener datos de ${tipo}:`, error);
        document.getElementById(
          "info"
        ).innerHTML = `<p style="color: red;">Error al cargar los datos.</p>`;
      });
    // Comprobación automática tras 5 segundos: verifica que el contenedor #info se ha actualizado
    setTimeout(() => {
      const infoContainer = document.getElementById("info");
      console.log(
        `Contenido en #info tras clic en ${tipo}:`,
        infoContainer.innerHTML.trim()
      );

      if (infoContainer.innerHTML.trim() === "") {
        console.error(`ERROR: No se están mostrando datos en #info.`);
      } else {
        console.log(`Los datos aparecen correctamente en #info.`);
      }
    }, 5000);
  });
});

// Prueba de autenticación (`auth.php`)
fetch("auth.php", {
  method: "POST",
  headers: { "Content-Type": "application/x-www-form-urlencoded" },
  body: new URLSearchParams({ usuario: "adminjesus", contrasena: "jesus123" }),
})
  .then((response) => response.json())
  .then((data) => {
    console.log("Respuesta de `auth.php` (login):", data);
    if (data.success) {
      console.log("Login exitoso.");
    } else {
      console.error("Error: Fallo en autenticación.");
    }
  })
  .catch((error) => console.error("Error al conectar con `auth.php`:", error));

// Prueba de cierre de sesión (`auth.php?action=logout`)
fetch("auth.php?action=logout")
  .then((response) => {
    console.log("Cierre de sesión correcto.");
  })
  .catch((error) => console.error("Error al cerrar sesión:", error));
