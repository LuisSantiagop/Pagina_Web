<?php
$host = "localhost"; // Cambiar si es diferente
$user = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$dbname = "cerveceria"; // Nombre de tu base de datos

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
