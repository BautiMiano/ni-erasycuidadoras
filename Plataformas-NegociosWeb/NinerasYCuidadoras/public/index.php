<?php
session_start();
require_once '../config/config.php';
$pageTitle = 'Inicio - Niñeras y Cuidadoras';
include '../includes/header.php'; // Cambiar la ruta
?>

<main>
    <header class="hero">
        <div class="container">
            <h1>Servicio Personalizado de Cuidados</h1>
            <p class="hero-text">
                Ofrecemos un servicio personalizado de contratación de niñeras y cuidadoras 
                para adultos mayores, adaptado a tus necesidades.
            </p>
            <div class="hero-buttons">
                <a href="#servicios" class="btn-primary">Ver Servicios</a>
            </div>
        </div>
    </header>

    <section id="servicios" class="services">
        <div class="container">
            <h2>Nuestros Servicios</h2>
            <div class="services-grid">
                <!-- Los servicios se cargarán dinámicamente desde la base de datos -->
                <?php
                $query = "SELECT * FROM servicios";
                $result = $conn->query($query);
                
                if ($result->num_rows > 0) {
                    while($servicio = $result->fetch_assoc()) {
                        echo '<div class="service-card">';
                        echo '<h3>' . htmlspecialchars($servicio['nombre']) . '</h3>';
                        echo '<p>' . htmlspecialchars($servicio['descripcion']) . '</p>';
                        echo '<p class="duration">Duración: ' . htmlspecialchars($servicio['duracion']) . '</p>';
                        echo '<a href="consultar.php?id=' . $servicio['id'] . '" class="btn-primary">Consultar</a>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; // Cambiar la ruta ?>