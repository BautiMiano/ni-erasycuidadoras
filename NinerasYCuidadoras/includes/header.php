<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Niñeras y Cuidadoras'; ?></title>
    <link rel="stylesheet" href="/NinerasYCuidadoras/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">Niñeras & Cuidadoras</a>
            <div class="nav-links">
                <a href="index.php">Inicio</a>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle">Servicios</a>
                    <div class="dropdown-menu">
                        <a href="nineras.php">Niñeras</a>
                        <a href="cuidadoras.php">Cuidadoras</a>
                    </div>
                </div>
                <a href="proceso.php">Cómo Funciona</a>
                <a href="nosotros.php">Nosotros</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="perfil.php">Mi Perfil</a>
                    <a href="logout.php" class="btn-secondary" >Cerrar Sesión</a>
                <?php else: ?>
                    <a href="login.php" class="btn-primary">Iniciar Sesión</a>
                    <a href="registro.php" class="btn-secondary">Registrarse</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</body>
</html>