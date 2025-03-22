<?php
// Conexión a la base de datos
require 'conexion.php'; // Asegúrate de incluir tu archivo de conexión.

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera los datos enviados
    $id = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $categoria = $_POST['categoria'];

    // Validación básica (puedes agregar más validaciones si lo deseas)
    if (empty($id) || empty($nombre) || empty($descripcion) || empty($precio) || empty($cantidad) || empty($categoria)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Validación adicional para precio y cantidad
    if (!is_numeric($precio) || !is_numeric($cantidad)) {
        echo "El precio y la cantidad deben ser números.";
        exit;
    }

    // Preparar la consulta para actualizar el producto
    $sql = "UPDATE productos SET 
                nombre = ?, 
                descripcion = ?, 
                precio = ?, 
                cantidad = ?, 
                categoria = ?
            WHERE id_producto = ?";

    // Prepara la consulta
    if ($stmt = $conn->prepare($sql)) {
        // Vincula los parámetros
        $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $cantidad, $categoria, $id);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Redirige a la página principal con un mensaje de éxito
            header("Location: index.php?msg=Producto actualizado correctamente");
            exit;
        } else {
            echo "Error al actualizar el producto: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    // Cierra la conexión
    $conn->close();
}
?>
