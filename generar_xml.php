<?php
require 'conexion.php';

// Consultar productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

// Crear estructura XML con DTD
header("Content-type: text/xml");
header("Content-Disposition: attachment; filename=productos.xml");

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<!DOCTYPE productos [\n";
echo "  <!ELEMENT productos (producto*)>\n";
echo "  <!ELEMENT producto (id_producto, nombre, descripcion, precio, cantidad, categoria)>\n";
echo "  <!ELEMENT id_producto (#PCDATA)>\n";
echo "  <!ELEMENT nombre (#PCDATA)>\n";
echo "  <!ELEMENT descripcion (#PCDATA)>\n";
echo "  <!ELEMENT precio (#PCDATA)>\n";
echo "  <!ELEMENT cantidad (#PCDATA)>\n";
echo "  <!ELEMENT categoria (#PCDATA)>\n";
echo "]>\n";
echo "<productos>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<producto>";
        echo "<id_producto>" . htmlspecialchars($row['id_producto']) . "</id_producto>";
        echo "<nombre>" . htmlspecialchars($row['nombre']) . "</nombre>";
        echo "<descripcion>" . htmlspecialchars($row['descripcion']) . "</descripcion>";
        echo "<precio>" . htmlspecialchars($row['precio']) . "</precio>";
        echo "<cantidad>" . htmlspecialchars($row['cantidad']) . "</cantidad>";
        echo "<categoria>" . htmlspecialchars($row['categoria']) . "</categoria>";
        echo "</producto>";
    }
}

echo "</productos>";
?>
