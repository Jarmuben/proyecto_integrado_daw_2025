<?php
// Configuración básica para la conexión a la base de datos MySQL.
$conn = new mysqli('127.0.0.1', 'adminjesus', 'jesus123', 'benalmadena65', 33065);

/*Verifica si hubo algún error durante el intento de conexión a la base de datos.
 Si la conexión falla, se registra el error en el log del servidor y se detiene la ejecución del script
 mostrando un mensaje de error al usuario.
 */
if ($conn->connect_error) {
    error_log("Error de conexión: " . $conn->connect_error);
    exit("No se pudo conectar a la base de datos. Intenta más tarde.");
}

// Configuración para manejar caracteres especiales
$conn->set_charset("utf8");
