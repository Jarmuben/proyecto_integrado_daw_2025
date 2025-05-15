<?php
// Incluye el archivo de conexión a la base de datos.
include 'db_connection.php';
// Verifica si se ha recibido una acción vía POST.
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    // Se comprueba si la acción es "ver_datos".
    if ($action == 'ver_datos') {
        // Se define la consulta SQL para obtener todos los administradores.
        $sql = "SELECT * FROM administradores";
        $result = $conn->query($sql);
        // Verifica si la consulta devuelve resultados.
        if ($result->num_rows > 0) {
            // Genera la tabla HTML para mostrar los datos.
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Email</th></tr>";
            while ($row = $result->fetch_assoc()) {
                // Imprime los datos de cada administrador en la tabla.
                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['nombre'] . "</td><td>" . $row['email'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            // Mensaje en caso de que no se encuentren datos.
            echo "No se encontraron datos.";
        }
    } else {
        // Mensaje en caso de recibir una acción desconocida.
        echo "Acción desconocida.";
    }
} else {
    // Cierra la conexión a la base de datos.
    echo "No se recibió ninguna acción.";
}

$conn->close();
