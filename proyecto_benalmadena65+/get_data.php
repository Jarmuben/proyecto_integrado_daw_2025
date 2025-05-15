 <?php
// API para gestionar datos (farmacias, médicos, eventos culturales, transportes).
// Incluye el archivo de conexión a la base de datos
include 'db_connection.php';

// Obtiene el tipo solicitado desde el parámetro 'tipo' (farmacias, médicos, eventos_culturales, transportes)
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;

// Valida que se haya recibido el tipo
if (!$tipo) {
    http_response_code(400); // Error de solicitud incorrecta
    echo json_encode(["error" => "No se proporcionó el tipo de datos solicitado."]);
    exit;
}

// Valida que el tipo corresponda a una tabla válida
$tablas_validas = ['farmacias', 'medicos', 'eventos_culturales', 'transportes'];
if (!in_array($tipo, $tablas_validas)) {
    http_response_code(400); // Código de error 400: Solicitud incorrecta
    echo json_encode(["error" => "El tipo solicitado no es válido."]);
    exit;
}

// Manejo de inserción
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre']) && isset($_POST['direccion'])) {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];

    // Verifica que el tipo es válido antes de insertar
    if (!in_array($tipo, $tablas_validas)) {
        http_response_code(400);
        echo json_encode(["error" => "El tipo solicitado no es válido para inserción."]);
        exit;
    }

    $sql_insert = "INSERT INTO `$tipo` (nombre, direccion) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    
    if ($stmt_insert) {
        $stmt_insert->bind_param("ss", $nombre, $direccion);
        if ($stmt_insert->execute()) {
            echo json_encode(["success" => "Registro añadido correctamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al añadir el registro: " . $stmt_insert->error]);
        }
        $stmt_insert->close();
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error al preparar la consulta de inserción."]);
    }
    exit;
}

// Manejo de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int) $_GET['id']; 

    // Verifica que el tipo es válido antes de eliminar
    if (!in_array($tipo, $tablas_validas)) {
        http_response_code(400);
        echo json_encode(["error" => "El tipo solicitado no es válido para eliminación."]);
        exit;
    }

    $sql_delete = "DELETE FROM `$tipo` WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    
    if ($stmt_delete) {
        $stmt_delete->bind_param("i", $id);
        if ($stmt_delete->execute()) {
            echo json_encode(["success" => "Registro eliminado correctamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el registro: " . $stmt_delete->error]);
        }
        $stmt_delete->close();
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error al preparar la consulta de eliminación."]);
    }
    exit;
}

// Consulta SQL para obtener los datos de la tabla solicitada
$query = "SELECT * FROM `$tipo`";
$result = $conn->query($query);

// Verifica si la consulta fue exitosa
if (!$result) {
    http_response_code(500); // Código de error 500: Error interno del servidor
    echo json_encode(["error" => "Error al obtener los datos de la tabla: " . $conn->error]);
    exit;
}

// Crea un array para almacenar los resultados
$datos = [];
while ($row = $result->fetch_assoc()) {
    $datos[] = $row; // Agregar cada fila al array
}

// Devuelve los datos en formato JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($datos);
?>
