 <?php
    // Inicia la sesión para manejar la autenticación de usuarios
    session_start();
    include 'db_connection.php'; // Incluye el archivo de conexión con la base de datos

    //Define la respuesta por defecto (para el caso de login)
    header('Content-Type: application/json'); //Establece el tipo de contenido de la respuesta en JSON.
    $response = ['success' => false, 'message' => 'Método no permitido o datos incorrectos.'];

    //Procesa el cierre de sesión GET (logout) 
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        // Elimina las variables de sesión y destruye la sesión actual.
        session_unset();
        session_destroy();
        // Redirige al usuario a la página de inicio tras el cierre de sesión.
        header('Location: index.html');
        exit; // Finaliza la ejecución del script para asegurar la redirección.
    }

    //   Procesar el inicio de sesión Login (POST) 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Mensaje de error por defecto en caso de fallo de autenticación.
        $response = ['success' => false, 'message' => 'Usuario o contraseña incorrectos.'];
        // Verifica la presencia de los campos 'usuario' y 'contrasena' en la solicitud POST.
        if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
            $usuario = $_POST['usuario'];
            $contrasena = $_POST['contrasena'];

            //Emplea una consulta preparada para prevenir inyecciones SQL.
            $sql = "SELECT id, usuario, contrasena FROM administradores WHERE usuario = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Vincula el parámetro a la consulta preparada.
                $stmt->bind_param("s", $usuario);
                $stmt->execute(); // Ejecuta la consulta.
                $result = $stmt->get_result(); // Obtiene el resultado de la consulta.

                //Verifica si se encontró un usuario que coincide con el nombre de usuario proporcionado.
                if ($result->num_rows === 1) {
                    $admin = $result->fetch_assoc(); // Obtiene los datos del administrador.

                    // Comparación directa de contraseña SIN `password_verify()`
                    if ($contrasena === $admin['contrasena']) {
                        // Establece las variables de sesión para indicar que el usuario ha iniciado sesión.
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['admin_usuario'] = $admin['usuario'];

                        //  Respuesta JSON incluyendo la URL de redirección en caso de éxito.
                        $response = ['success' => true, 'redirect' => 'panel.php'];
                    } else {
                        $response['message'] = 'Contraseña incorrecta.';
                    }
                }
                $stmt->close(); // Cierra la sentencia preparada.
            } else {
                $response['message'] = 'Error en la consulta a la base de datos.';
            }
        } else {
            $response['message'] = 'Faltan usuario o contraseña.';
        }
        $conn->close(); // Cierra la conexión a la base de datos.

        // Devuelve la respuesta en formato JSON
        echo json_encode($response);
        exit;
    }

    // Si la solicitud no es un POST para el inicio de sesión o un GET para el cierre, devuelve un error.
    $conn->close();
    echo json_encode($response);
    ?>
