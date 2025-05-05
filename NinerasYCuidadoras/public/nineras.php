<?php
session_start();
require_once '../config/config.php';
$pageTitle = 'Servicios de Cuidadoras';
include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios de Niñeras</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <main>
        <section class="services">
            <div class="container">
                <h2>Servicios de Niñeras</h2>
                <div class="services-grid">
                    <?php
                    $query = "SELECT * FROM servicios WHERE tipo = 'niñera'";
                    $result = $conn->query($query);
                    
                    if ($result->num_rows > 0) {
                        while($servicio = $result->fetch_assoc()) {
                            echo '<div class="service-card">';
                            echo '<h3>' . htmlspecialchars($servicio['nombre']) . '</h3>';
                            echo '<p>' . htmlspecialchars($servicio['descripcion']) . '</p>';
                            echo '<p class="duration">Duración: ' . htmlspecialchars($servicio['duracion']) . '</p>';
                            echo '<a href="consultar.php?id=' . $servicio['id'] . '&tipo=ninera" class="btn-primary">Consultar</a>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>