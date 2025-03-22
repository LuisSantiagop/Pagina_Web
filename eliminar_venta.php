<?php
require 'conexion.php'; // Asegúrate de incluir tu archivo de conexión

// Verificar que el ID de la venta esté presente en el formulario
if (isset($_POST['id_venta'])) {
    $id_venta = intval($_POST['id_venta']); // Asegurarse de que el ID sea un número entero

    // Eliminar la venta de la base de datos
    $sql = "DELETE FROM ventas WHERE id_venta = $id_venta";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirige de vuelta a la página de ventas con mensaje
        exit;
    } else {
        echo "Error al eliminar la venta: " . $conn->error;
    }
} else {
    echo "ID de venta no especificado.";
}

$conn->close();
?>
