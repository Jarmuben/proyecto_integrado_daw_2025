 <?php
session_start();
// Verifica si el usuario administrador está logueado antes de permitir el acceso.
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.html?login_error=1');
    exit;
}

include 'db_connection.php';
// Obtiene parámetros de la URL de forma segura
$action = $_GET['action'] ?? null;
$tabla = $_GET['tabla'] ?? null;
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : null;
// Lista de tablas válidas para evitar inyección SQL
$tablas_validas = ['farmacias', 'medicos', 'eventos_culturales', 'transportes'];

// Función para obtener los nombres de las columnas de una tabla
function obtenerColumnasTabla($conn, $tabla) {
    $sql = "SHOW COLUMNS FROM `$tabla`";
    $result = $conn->query($sql);
    $columnas = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $columnas[] = $row['Field'];// Se extraen los nombres de las columnas
        }
        $result->free();
    }
    return $columnas;
}

// Procesar edición de registros (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit' && $tabla && $id && in_array($tabla, $tablas_validas)) {
    $columnas = obtenerColumnasTabla($conn, $tabla);
    $campos = [];
    $tipos = "";
    $valores = [];
    // Prepara los campos para la actualización evitando modificar la columna 'id'
    foreach ($columnas as $columna) {
        if ($columna !== 'id' && isset($_POST[$columna])) {
            $campos[] = "`$columna` = ?";
            $valores[] = $_POST[$columna];
            $tipos .= "s"; 
        }
    }
    $valores[] = $id;
    $tipos .= "i";

    if (!empty($campos)) {
        $sql_update = "UPDATE `$tabla` SET " . implode(', ', $campos) . " WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        if ($stmt_update) {
            $stmt_update->bind_param($tipos, ...$valores);
            if ($stmt_update->execute()) {
                $_SESSION['flash_message'] = ucfirst($tabla) . " actualizado correctamente.";
            } else {
                $_SESSION['error_message'] = "Error al actualizar " . ucfirst($tabla) . ": " . $stmt_update->error;
            }
            $stmt_update->close();
        } else {
            $_SESSION['error_message'] = "Error al preparar la consulta de actualización.";
        }
    }
    header("Location: panel.php?tabla=" . urlencode($tabla));
    exit;
}

//Procesa inserción de nuevos registros(POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add' && $_POST['tabla_add'] && in_array($_POST['tabla_add'], $tablas_validas)) {
    $tabla_add = $_POST['tabla_add'];
    $columnas = obtenerColumnasTabla($conn, $tabla_add);
    $campos = [];
    $placeholders = [];
    $tipos = "";
    $valores = [];
    foreach ($columnas as $columna) {
        if ($columna !== 'id' && isset($_POST[$columna])) {
            $campos[] = "`$columna`";
            $placeholders[] = "?";
            $valores[] = $_POST[$columna];
            $tipos .= "s"; 
        }
    }

    if (!empty($campos)) {
        $sql_insert = "INSERT INTO `$tabla_add` (" . implode(', ', $campos) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt_insert = $conn->prepare($sql_insert);
        if ($stmt_insert) {
            $stmt_insert->bind_param($tipos, ...$valores);
            if ($stmt_insert->execute()) {
                $_SESSION['flash_message'] = ucfirst($tabla_add) . " añadido correctamente.";
            } else {
                $_SESSION['error_message'] = "Error al añadir a " . ucfirst($tabla_add) . ": " . $stmt_insert->error;
            }
            $stmt_insert->close();
        } else {
            $_SESSION['error_message'] = "Error al preparar la consulta de inserción.";
        }
    }
    header("Location: panel.php?tabla=" . urlencode($tabla_add));
    exit;
}

//Obtiene los registros de la tabla seleccionada para mostrar en la interfaz
$datos_tabla = [];
if ($tabla && in_array($tabla, $tablas_validas)) {
    $sql_select = "SELECT * FROM `$tabla`";
    $result_select = $conn->query($sql_select);
    if ($result_select) {
        $datos_tabla = $result_select->fetch_all(MYSQLI_ASSOC);
        $result_select->free();
    }
}

//Procesar eliminación de registros de la tabla
if ($action === 'delete' && $tabla && $id && in_array($tabla, $tablas_validas)) {
    $sql_delete = "DELETE FROM `$tabla` WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);
    if ($stmt_delete->execute()) {
        $_SESSION['flash_message'] = ucfirst($tabla) . " eliminado correctamente.";
    } else {
        $_SESSION['error_message'] = "Error al eliminar " . ucfirst($tabla) . ": " . $stmt_delete->error;
    }
    if ($stmt_delete) $stmt_delete->close();
    header("Location: panel.php?tabla=" . urlencode($tabla));
    exit;
}

// Lógica para obtener los datos del registro a editar
$row_edit = null;
if ($action === 'edit' && $tabla && $id && in_array($tabla, $tablas_validas)) {
    // consulta segura para obtener el registro específico
    $sql_edit = "SELECT * FROM `$tabla` WHERE id = ?";
    $stmt_edit = $conn->prepare($sql_edit);
    $stmt_edit->bind_param("i", $id);
    $stmt_edit->execute();
    $result_edit = $stmt_edit->get_result();
    $row_edit = $result_edit->fetch_assoc();
    $stmt_edit->close();
}

// Lógica para determinar qué formulario mostrar (editar o añadir)
$mostrar_formulario = ($action === 'edit' || $action === 'add') && $tabla && in_array($tabla, $tablas_validas);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .actions a { margin-right: 10px; text-decoration: none; }
        .form-container { margin-top: 30px; border: 1px solid #ccc; padding: 15px; border-radius: 5px; }
        .form-container h2 { margin-top: 0; }
        .form-container label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="time"] { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .form-container button { padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .form-container button:hover { background-color: #0056b3; }
        .button-link { display: inline-block; padding: 8px 15px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; }
        .button-link:hover { background-color: #1e7e34; }
        .delete-link { display: inline-block; padding: 8px 15px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; }
        .delete-link:hover { background-color: #c82333; }
        .error-message { color: red; margin-top: 10px; }
        .success-message { color: green; margin-top: 10px; }
        .table-selector { text-align: center; margin-bottom: 20px; }
        .table-selector a { display: inline-block; margin: 0 10px; text-decoration: none; padding: 8px 15px; border: 1px solid #ccc; border-radius: 5px; }
        .table-selector a.active { background-color: #f0f0f0; font-weight: bold; }
        .back-link { display: block; margin-top: 20px; text-align: center; text-decoration: none; color: #007bff; }
        .back-link:hover { color: #0056b3; }
    </style>
</head>
<body>
    <!-- Enlace de cierre de sesión -->
    <a href="auth.php?action=logout" style="float: right; margin-bottom: 10px;">Cerrar sesión</a>
    <h1>Panel de Administración</h1>
    <p style="text-align: center;">Bienvenido, <?php echo htmlspecialchars($_SESSION['admin_usuario'] ?? 'Admin'); ?>.</p>
<!-- Mensajes de éxito o error para mostrar feedback al usuario -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <p class="success-message"><?php echo $_SESSION['flash_message']; unset($_SESSION['flash_message']); ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <p class="error-message"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></p>
    <?php endif; ?>
 <!-- Selector de tablas para gestionar diferentes categorías -->
    <div class="table-selector">
        <?php foreach ($tablas_validas as $una_tabla): ?>
            <a href="?tabla=<?php echo urlencode($una_tabla); ?>" class="<?php echo ($tabla === $una_tabla) ? 'active' : ''; ?>"><?php echo ucfirst(str_replace('_', ' ', $una_tabla)); ?></a>
        <?php endforeach; ?>
    </div>

    <?php if ($tabla && in_array($tabla, $tablas_validas) && !$mostrar_formulario): ?>
         <!-- Se muestra la tabla de registros existentes -->
        <h2>Tabla <?php echo ucfirst(str_replace('_', ' ', $tabla)); ?></h2>
        <p><a href="?action=add&tabla=<?php echo urlencode($tabla); ?>" class="button-link">Añadir Nuevo</a></p>

        <?php if (!empty($datos_tabla)): ?>
            <table>
                <thead>
                    <tr>
                        <?php foreach (array_keys($datos_tabla[0]) as $columna): ?>
                            <th><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $columna))); ?></th>
                        <?php endforeach; ?>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos_tabla as $fila): ?>
                        <tr>
                            <?php foreach ($fila as $columna => $valor): ?>
                                <td><?php echo htmlspecialchars($valor); ?></td>
                            <?php endforeach; ?>
                            <td class="actions">
                                <a href="?action=edit&tabla=<?php echo urlencode($tabla); ?>&id=<?php echo $fila['id']; ?>" class="button-link">Editar</a>
                                <a href="?action=delete&tabla=<?php echo urlencode($tabla); ?>&id=<?php echo $fila['id']; ?>" class="delete-link" onclick="return confirm('¿Estás seguro de que quieres eliminar este registro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay datos en la tabla <?php echo ucfirst(str_replace('_', ' ', $tabla)); ?>.</p>
        <?php endif; ?>
    <?php elseif ($mostrar_formulario): ?>
        <!-- Formulario para editar o añadir registros -->
        <div class="form-container">
            <h2><?php echo ($action === 'edit' ? 'Editar ' : 'Añadir Nuevo ') . ucfirst(str_replace('_', ' ', $tabla)); ?></h2>
            <form action="?tabla=<?php echo urlencode($tabla); ?>" method="POST">
                <input type="hidden" name="action" value="<?php echo htmlspecialchars($action); ?>">
                <input type="hidden" name="tabla_add" value="<?php echo htmlspecialchars($tabla); ?>">
                <?php if ($action === 'edit'): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <?php endif; ?>

                <?php
                // Generar campos dinámicos basados en la estructura de la tabla
                $columnas_form = obtenerColumnasTabla($conn, $tabla);
                foreach ($columnas_form as $columna):
                    if ($columna !== 'id'):
                        $label = ucfirst(str_replace('_', ' ', $columna));
                        $valor = htmlspecialchars($row_edit[$columna] ?? '');
                        $tipo_input = 'text';
                        if ($columna === 'Fecha') $tipo_input = 'date';
                        if ($columna === 'Hora') $tipo_input = 'time';
                        ?>
                        <label for="<?php echo htmlspecialchars($columna); ?>"><?php echo $label; ?>:</label>
                        <input type="<?php echo $tipo_input; ?>" id="<?php echo htmlspecialchars($columna); ?>" name="<?php echo htmlspecialchars($columna); ?>" value="<?php echo $valor; ?>" required>
                        <?php
                    endif;
                endforeach;
                ?>
                <button type="submit"><?php echo ($action === 'edit' ? 'Actualizar' : 'Añadir'); ?></button>
                <a href="?tabla=<?php echo urlencode($tabla); ?>" class="back-link">Volver a la tabla</a>
            </form>
        </div>
    <?php else: ?>
        <p>Selecciona una tabla para administrar.</p>
    <?php endif; ?>

</body>
</html>