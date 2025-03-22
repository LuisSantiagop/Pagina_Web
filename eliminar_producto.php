            <?php
            require 'conexion.php';

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "DELETE FROM productos WHERE id_producto = $id";

                if ($conn->query($sql) === TRUE) {
                    header("Location: index.php");
                } else {
                    echo "Error: " . $conn->error;
                }
            }
            ?>
