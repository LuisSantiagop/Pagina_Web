    <?php
    require 'conexion.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>La Carreta</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
                font-family: Arial, sans-serif;
            }

            .navbar {
                background-color: #0d3693;
            }
            .navbar-brand {
                font-weight: bold;
                color: #85c1e9  !important;
                font-size: 5.5rem; /* Puedes ajustar el tamaño según lo desees */
            }

            .table thead {
                background-color: #ffc107;
                color: #343a40;
            }

            .btn-primary {
                background-color: #ffc107;
                border-color: #ffc107;
                color: #343a40;
            }

            .btn-primary:hover {
                background-color: #e0a800;
                border-color: #e0a800;
            }

            .btn-warning {
                background-color: #ff851b;
                border-color: #ff851b;
                color: #fff;
            }

            .btn-danger {
                background-color: #dc3545;
                color: white;
            }

            .btn-danger:hover {
                background-color: #bd2130;
            }

            /* Estilos para los botones de exportar */
            .btn-export {
                font-size: 16px;
                padding: 10px 20px;
                margin: 5px;
                border-radius: 5px;
                font-weight: bold;
                transition: all 0.3s ease;
            }

            .btn-info {
                background-color: #17a2b8;
                color: white;
                border: none;
            }

            .btn-info:hover {
                background-color: #138496;
                color: white;
                cursor: pointer;
            }

            .btn-success {
                background-color: #28a745;
                color: white;
                border: none;
            }

            .btn-success:hover {
                background-color: #218838;
                color: white;
                cursor: pointer;
            }

            .d-flex {
                display: flex;
                justify-content: space-between; /* Alinea los botones con espacio entre ellos */
                gap: 15px; /* Espacio entre los botones */
            }

            .container {
                background-color: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-top: 30px;
            }

            footer {
                margin-top: 20px;
                text-align: center;
                background-color: #343a40;
                color: #fff;
                padding: 10px;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">LA CARRETA</a>
            <img src="carreta.jpg" alt="don ramon" class="navbar-brand">
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container mt-4">
        <h1 class="text-center text-warning">Administración de Productos</h1>
        <p class="text-center text-muted">Gestión de Productos Abarroteros.</p>
        <hr>

   <!-- Formulario para Agregar Productos -->
<div class="mb-4">
    <h4 class="text-warning">Agregar Producto</h4>
    <form action="agregar_producto.php" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="id_producto" class="form-label">ID del Producto</label>
                <input type="number" class="form-control" id="id_producto" name="id_producto" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="2" required></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </form>
</div>


    <!-- Tabla de Productos -->
    <h4 class="text-warning">Productos Registrados</h4>
    <div class="d-flex justify-content-between mb-3">
        <a href="generar_pdf.php" class="btn btn-success">Descargar PDF</a>
        <a href="generar_xml.php" class="btn btn-info text-white">Descargar XML</a>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_producto']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>\${$row['precio']}</td>
                        <td>{$row['cantidad']}</td>
                        <td>{$row['categoria']}</td>
                        <td>
                            <button 
                                class='btn btn-warning btn-sm edit-btn' 
                                data-id='{$row['id_producto']}'
                                data-nombre='{$row['nombre']}'
                                data-descripcion='{$row['descripcion']}'
                                data-precio='{$row['precio']}'
                                data-cantidad='{$row['cantidad']}'
                                data-categoria='{$row['categoria']}'
                                data-bs-toggle='modal' 
                                data-bs-target='#editModal'>Editar</button>
                            <a href='eliminar_producto.php?id={$row['id_producto']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Seguro que deseas eliminar este producto?\")'>Eliminar</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='text-center text-muted'>No hay productos registrados</td></tr>";
        }
        ?>
        </tbody>


<!-- nueva tabla-->

<table class="table table-hover">


    <!-- NUEVO: Formulario para Registrar Ventas -->
    <h4 class="text-warning mt-5">Registrar Venta</h4>
    <form action="vender_producto.php" method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="id_producto" class="form-label">ID Producto</label>
                <input type="number" class="form-control" id="id_producto" name="id_producto" required>
            </div>
            <div class="col-md-4">
                <label for="cantidad_vendida" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad_vendida" name="cantidad_vendida" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Registrar Venta</button>
            </div>
        </div>
    </form>

    <!-- NUEVO: Tabla para Historial de Ventas -->
    <h4 class="text-warning">Productos Registrados</h4>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>ID Producto</th>
                <th>Nombre del Producto</th> <!-- Nuevo encabezado -->
                <th>Cantidad</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
        
        <?php
        
        // Consulta para obtener datos de ventas y el nombre del producto
        $sql_ventas = "SELECT ventas.id_venta, ventas.id_producto, productos.nombre AS nombre_producto, 
                            ventas.cantidad, ventas.total, ventas.fecha 
                    FROM ventas 
                    INNER JOIN productos ON ventas.id_producto = productos.id_producto"; // Relación entre las tablas
        $result_ventas = $conn->query($sql_ventas);

        if ($result_ventas->num_rows > 0) {
            while ($venta = $result_ventas->fetch_assoc()) {
                echo "<tr>
                        <td>{$venta['id_venta']}</td>
                        <td>{$venta['id_producto']}</td>
                        <td>{$venta['nombre_producto']}</td> <!-- Mostrando el nombre del producto -->
                        <td>{$venta['cantidad']}</td>
                        <td>\${$venta['total']}</td>
                        <td>{$venta['fecha']}</td>
                        <td>
                            <!-- Formulario para eliminar la venta -->
                            <form action='eliminar_venta.php' method='POST' onsubmit='return confirm(\"¿Estás seguro de que quieres eliminar esta venta?\");'>
                                <input type='hidden' name='id_venta' value='{$venta['id_venta']}'>
                                <button type='submit' class='btn btn-danger'>Eliminar</button>
                            </form>
                        </td>
                    </tr>";
            }
        }else {
            echo "<tr><td colspan='6' class='text-center text-muted'>No hay ventas registradas</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <!-- Botones para exportar ventas -->
    <div class="d-flex justify-content-between mb-3">
    <a href="exportar_ventas_pdf.php" class="btn btn-success">Descargar PDF</a>
    <a href="exportar_ventas_xml.php" class="btn btn-info text-white">Descargar XML</a>
    </div>
    </div> 



    </table>


    </table>
</div>

<!-- Modal para Editar Producto -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="editModalLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="editar_producto.php">
                <div class="modal-body">
                    <input type="hidden" name="id_producto" id="edit_id_producto">
                    <div class="mb-3">
                        <label for="edit_nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_categoria" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="edit_categoria" name="categoria" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_precio" class="form-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="edit_precio" name="precio" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="edit_cantidad" name="cantidad" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>






    <!-- Footer -->
    <footer>
        <p>Abarroteria LA CARRETA© 2024. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('edit_id_producto').value = this.dataset.id;
                document.getElementById('edit_nombre').value = this.dataset.nombre;
                document.getElementById('edit_descripcion').value = this.dataset.descripcion;
                document.getElementById('edit_precio').value = this.dataset.precio;
                document.getElementById('edit_cantidad').value = this.dataset.cantidad;
                document.getElementById('edit_categoria').value = this.dataset.categoria;
            });
        });
    });
</script>
</body>
</html>