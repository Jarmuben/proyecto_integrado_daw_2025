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
- `citas_culturales` Eventos culturales y actividades disponibles (evento, fecha, ubicación, descripción).  
- `transporte`  Opciones de transporte público (tipo, ruta, horarios, contacto).  
- `usuarios_admin`  Gestión de administradores y acceso seguro al sistema.  

La conexión y gestión de la base de datos se realiza a través de `db_connection.php`, mientras que `get_data.php` facilita la recuperación de información en formato JSON para su uso en el frontend.  
