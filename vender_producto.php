<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = intval($_POST['id_producto']);
    $cantidad_vendida = intval($_POST['cantidad_vendida']);

    // Obtener información del producto
    $sql = "SELECT * FROM productos WHERE id_producto = $id_producto";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        $cantidad_disponible = $producto['cantidad'];
        $precio = $producto['precio'];

        // Verificar si hay suficiente inventario
        if ($cantidad_vendida > 0 && $cantidad_vendida <= $cantidad_disponible) {
            $nuevo_stock = $cantidad_disponible - $cantidad_vendida;
            $total = $cantidad_vendida * $precio;

            // Actualizar la cantidad en productos
            $sql_update = "UPDATE productos SET cantidad = $nuevo_stock WHERE id_producto = $id_producto";

            // Registrar la venta
            $sql_venta = "INSERT INTO ventas (id_producto, cantidad, total) VALUES ($id_producto, $cantidad_vendida, $total)";

            if ($conn->query($sql_update) === TRUE && $conn->query($sql_venta) === TRUE) {
                echo "Venta registrada exitosamente.";
                header("Location: index.php");
                exit;
            } else {
                echo "Error al registrar la venta: " . $conn->error;
            }
        } else {
            echo "Cantidad insuficiente en inventario.";
        }
    } else {
        echo "Producto no encontrado.";
    }
}
?>
