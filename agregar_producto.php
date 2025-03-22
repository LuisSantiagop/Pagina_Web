<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];  // Recuperar el ID si lo estás pasando manualmente
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    
    // Consulta para agregar el producto
    $sql = "INSERT INTO productos (id_producto, nombre, categoria, descripcion, precio, cantidad)
            VALUES ('$id_producto', '$nombre', '$categoria', '$descripcion', '$precio', '$cantidad')";
    

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
