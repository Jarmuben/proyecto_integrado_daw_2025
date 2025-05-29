# proyecto_integrado_daw_2025
Repositorio creado para almacenar los contenidos del proyecto final daw 2025.

Benalmadena65+

## 1. Descripción
Benalmadena65+ es una plataforma web diseñada para ayudar a las personas mayores de 65 años con escasos conocimientos digitales a acceder fácilmente a los servicios esenciales de la localidad de Benalmádena. 
La interfaz está optimizada para ser accesible, intuitiva y amigable.

## 2. Objetivos
El objetivo de este proyecto es:

- Reducir la brecha digital entre las personas mayores y el acceso a información relevante.
- Facilitar la navegación web a usuarios con poca alfabetización tecnológica.
- Garantizar accesibilidad y usabilidad en la interfaz.

## 3. Tecnologías Utilizadas
- Frontend: HTML, CSS y JavaScript (sin frameworks externos).
- Backend: PHP.
- Base de datos Mysql (phpMyAdmin).
- Entorno de desarrollo: XAMPP,Visual Studio Code, Live Server..
- Control de versiones: Git/GitHub.

## 4. Características Principales
- Directorio de Servicios: Información sobre médicos (podólogos, etc.), farmacias, transporte público y eventos culturales.  
- Interfaz accesible: Diseño con iconos grandes, textos legibles y navegación intuitiva.  
- Carga dinámica de datos:Los servicios se obtienen de una base de datos en MySQL mediante PHP.  
- Gestión administrativa: Panel de administración con autenticación segura.  
- Pruebas automatizadas: `test.js` para verificar el correcto funcionamiento del frontend y backend.  
- Diseño adaptativo: Implementación de Flexbox y medidas relativas (vh, vw, %) para mejorar la responsividad.  

## 5. Estructura del Proyecto  
La organización de archivos sigue una estructura clara para mantener la modularidad y facilitar el mantenimiento:

/proyecto_integrado_daw_2025
│──/css # Estilos de la interfaz 
│── /js # Funcionalidad y lógica de interactividad 
│── /img # Recursos gráficos 
│── index.html # Página principal de la aplicación 
│── styles.css # Archivo de estilos 
│── script.js # Código JavaScript 
│── test.js # Pruebas automatizadas 
│── db_connection.php # Configuración de conexión a la base de datos 
│── get_data.php # API para obtener información 
│── auth.php # Autenticación y gestión de sesión 
│── panel.php # Panel de administración

## 6. Base de Datos (MySQL + phpMyAdmin)  

Este proyecto utiliza MySQL como sistema de gestión de base de datos y phpMyAdmin para su administración.  
Las principales tablas del sistema almacenan información clave para garantizar un acceso rápido y estructurado a los servicios esenciales:  

- `farmacias`  Datos de farmacias disponibles (nombre, dirección, teléfono, horario).  
- `medicos`  Información sobre médicos y especialistas (nombre, especialidad, ubicación, contacto).  
- `eventos_culturales` Información sobre eventos culturales y actividades disponibles (nombre del evento, fecha, ubicación, descripción).  
- `transporte`  Opciones de transporte público (tipo, ruta, horarios, contacto).  
- `usuarios_admin`  Gestión de administradores y acceso seguro al sistema.  

La conexión y gestión de la base de datos se realiza a través de `db_connection.php`, mientras que `get_data.php` facilita la recuperación de información en formato JSON para su uso en el frontend.  

## 7. Despliegue de la Aplicación
   
### 1. Requisitos Previos
Antes de desplegar la aplicación, asegúrate de contar con:
- XAMPP instalado y en funcionamiento (Apache y MySQL activos).
- PHP compatible con el código del proyecto.
- Base de datos `benalmadena65` correctamente configurada.
- Navegador web para probar la aplicación.
- Editor de texto (Visual Studio Code, Sublime Text o similar) para realizar ajustes.

---

### 2. Instalación y Configuración
#### Paso 1: Configurar el entorno
1. Iniciar XAMPP y activar Apache y MySQL desde el panel de control.
2. Verificar el funcionamiento accediendo a `http://localhost/`.

#### Paso 2: Configurar la base de datos
1. Abre `phpMyAdmin` desde `http://localhost/phpmyadmin`.
2. Crea una base de datos con el nombre `benalmadena65`.
3. Importa el archivo `benalmadena65.sql` para cargar las tablas necesarias (`administradores`, `farmacias`, `medicos`, `citas`, `transportes`).

#### Paso 3: Configurar la conexión en los archivos PHP
Verifica que los archivos PHP que interactúan con la base de datos (`auth.php`, `get_data.php`, `db_connection.php`, etc.) tengan la conexión correcta con MySQL:

$conexion = new mysqli("localhost", "root", "", "benalmadena65");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

### Paso 4: Ubicar los archivos en el servidor local**
1. Copia la carpeta del proyecto en:
C:/xampp/htdocs/Proyectos/proyecto_benalmadena65+/

2. Verifica que los archivos principales estén organizados correctamente:
- Frontend: `index.html`, `styles.css`, `script.js`
- Backend: `auth.php`, `get_data.php`, `db_connection.php`
- Base de datos: `benalmadena65.sql`

### Paso 5: Ejecutar la aplicación
Accede al proyecto desde el navegador en:
http://localhost/Proyectos/proyecto_benalmadena65+/
Desde aquí, puedes probar las funciones de la aplicación.

---
GUIA ADICIONAL
### Pruebas del sistema
Para asegurar el correcto funcionamiento de la aplicación, realiza las siguientes pruebas:
- Autenticación: Inicia sesión en la plataforma y verifica que la sesión se inicie correctamente.
- Carga de datos: Interactúa con los botones de la interfaz y confirma que `get_data.php` devuelve los datos esperados.
- Panel administrativo: Asegúrate de que `panel.php` carga los datos correctamente en la interfaz.
- Cierre de sesión: Verifica que `auth.php` y `logout.php` cierren la sesión sin errores.

---

### Solución de problemas
Si la aplicación no funciona correctamente, revisa estos puntos:
- Apache o MySQL no están activos → Inicia ambos desde XAMPP.
- Error de conexión a la base de datos** → Verifica que `benalmadena65` existe en `phpMyAdmin`.
- Página en blanco o errores en PHP → Activa `display_errors` en `php.ini` o usa:
 
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
Los datos no se cargan → Comprueba que get_data.php está devolviendo JSON correctamente y que script.js lo está procesando bien.
