<?php
// Incluye el archivo de conexión con la base de datos
include 'db_connection.php';
//Verifica si la conexión fue exitosa antes de usar la variable $conn
if ($conn) {
    echo "Conexión exitosa con la base de datos.";
} else {
    // Mostrar mensaje de error detallado en caso de fallo en la conexión
    echo "Error al conectar con la base de datos: " . $conn->connect_error;
}
?>
