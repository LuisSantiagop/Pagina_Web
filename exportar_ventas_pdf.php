<?php
require 'conexion.php';       // Archivo de conexión a la base de datos
require 'tcpdf/tcpdf.php';    // Ruta a la librería TCPDF

// Crear un nuevo documento PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Configuración general del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('La Carreta');
$pdf->SetTitle('Reporte de Ventas');
$pdf->SetSubject('Reporte generado automáticamente');
$pdf->SetKeywords('PDF, ventas, reporte, cervecería');

// Agregar logotipo en el encabezado
$logo = 'logo.png'; // Ruta al archivo del logotipo
$pdf->SetHeaderData($logo, 30, 'La Carreta', "Reporte generado el: " . date('Y-m-d H:i:s'));

// Configuración de fuentes del encabezado y pie de página
$pdf->setHeaderFont(['helvetica', '', 12]);
$pdf->setFooterFont(['helvetica', '', 10]);

// Configuración de márgenes
$pdf->SetMargins(10, 30, 10);  // Márgenes del documento (izquierda, arriba, derecha)
$pdf->SetHeaderMargin(10);     // Margen del encabezado
$pdf->SetFooterMargin(15);     // Margen del pie de página
$pdf->SetAutoPageBreak(true, 20); // Salto de página automático al llegar al final

// Añadir una página
$pdf->AddPage();

// Título del documento
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Historial de Ventas', 0, 1, 'C');
$pdf->Ln(5); // Espacio entre el título y la tabla

// Encabezados de la tabla
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(240, 240, 240); // Color de fondo para encabezados
$pdf->SetTextColor(0);             // Color del texto
$pdf->SetDrawColor(200, 200, 200); // Color de las líneas de la tabla
$pdf->SetLineWidth(0.3);           // Grosor de las líneas

// Crear encabezados
$widths = [20, 30, 50, 20, 30, 30]; // Ancho de las columnas
$headers = ['ID Venta', 'ID Producto', 'Nombre Producto', 'Cantidad', 'Total', 'Fecha'];
foreach ($headers as $key => $header) {
    $pdf->Cell($widths[$key], 8, $header, 1, 0, 'C', 1);
}
$pdf->Ln();

// Configuración de datos de la tabla
$pdf->SetFont('helvetica', '', 10);
$pdf->SetFillColor(255, 255, 255); // Color de fondo de las celdas
$pdf->SetTextColor(0);            // Color del texto
$pdf->SetLineWidth(0.2);          // Líneas más delgadas

// Consultar datos de la base de datos
$sql = "SELECT ventas.id_venta, ventas.id_producto, productos.nombre AS nombre_producto, 
               ventas.cantidad, ventas.total, ventas.fecha 
        FROM ventas 
        INNER JOIN productos ON ventas.id_producto = productos.id_producto";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $fill = 0; // Alternar fondo de las filas
    while ($row = $result->fetch_assoc()) {
        // Imprimir cada columna
        $pdf->Cell($widths[0], 8, $row['id_venta'], 'LR', 0, 'C', $fill);
        $pdf->Cell($widths[1], 8, $row['id_producto'], 'LR', 0, 'C', $fill);
        $pdf->Cell($widths[2], 8, substr($row['nombre_producto'], 0, 30), 'LR', 0, 'L', $fill);
        $pdf->Cell($widths[3], 8, $row['cantidad'], 'LR', 0, 'C', $fill);
        $pdf->Cell($widths[4], 8, '$' . number_format($row['total'], 2), 'LR', 0, 'R', $fill);
        $pdf->Cell($widths[5], 8, $row['fecha'], 'LR', 1, 'C', $fill);

        $fill = !$fill; // Alternar color de fondo
    }
    // Dibujar la línea inferior de la tabla
    $pdf->Cell(array_sum($widths), 0, '', 'T');
} else {
    $pdf->Cell(0, 8, 'No hay ventas registradas.', 1, 1, 'C', 0);
}

// Salida del archivo
$pdf->Output('ventas.pdf', 'I');
?>
