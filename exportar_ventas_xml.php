<?php
require 'conexion.php'; // Archivo de conexión a la base de datos

// Configurar encabezados para la descarga del archivo XML
header("Content-Type: text/xml");
header("Content-Disposition: attachment; filename=\"ventas.xml\"");

// Generar la cabecera del archivo XML con el DTD incluido
echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<!DOCTYPE ventas [\n";
echo "  <!ELEMENT ventas (venta+)>\n";
echo "  <!ELEMENT venta (id_venta, id_producto, nombre_producto, cantidad, total, fecha)>\n";
echo "  <!ELEMENT id_venta (#PCDATA)>\n";
echo "  <!ELEMENT id_producto (#PCDATA)>\n";
echo "  <!ELEMENT nombre_producto (#PCDATA)>\n";
echo "  <!ELEMENT cantidad (#PCDATA)>\n";
echo "  <!ELEMENT total (#PCDATA)>\n";
echo "  <!ELEMENT fecha (#PCDATA)>\n";
echo "]>\n";

// Raíz del XML
echo "<ventas>\n";

// Consultar datos de ventas desde la base de datos
$sql_ventas = "SELECT ventas.id_venta, ventas.id_producto, productos.nombre AS nombre_producto, 
                      ventas.cantidad, ventas.total, ventas.fecha 
               FROM ventas 
               INNER JOIN productos ON ventas.id_producto = productos.id_producto";
$result_ventas = $conn->query($sql_ventas);

// Generar contenido del XML
if ($result_ventas->num_rows > 0) {
    while ($venta = $result_ventas->fetch_assoc()) {
        echo "  <venta>\n";
        echo "    <id_venta>{$venta['id_venta']}</id_venta>\n";
        echo "    <id_producto>{$venta['id_producto']}</id_producto>\n";
        echo "    <nombre_producto>{$venta['nombre_producto']}</nombre_producto>\n";
        echo "    <cantidad>{$venta['cantidad']}</cantidad>\n";
        echo "    <total>{$venta['total']}</total>\n";
        echo "    <fecha>{$venta['fecha']}</fecha>\n";
        echo "  </venta>\n";
    }
} else {
    // Si no hay datos, incluir una etiqueta vacía
    echo "  <!-- No hay ventas registradas -->\n";
}

echo "</ventas>"; // Cerrar la raíz del XML
?>
