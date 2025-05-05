<?php
session_start();
require_once '../config/config.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos del usuario
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT nombre, email, tipo FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

$error = '';
$success = '';

// Procesar formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($nombre) || empty($email)) {
        $error = "El nombre y email son obligatorios";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email inválido";
    } else {
        // Verificar si el email ya existe (excepto para el usuario actual)
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Este email ya está registrado por otro usuario";
        } else {
            // Si se proporcionó una nueva contraseña
            if (!empty($new_password)) {
                if (strlen($new_password) < 6) {
                    $error = "La nueva contraseña debe tener al menos 6 caracteres";
                } elseif ($new_password !== $confirm_password) {
                    $error = "Las contraseñas no coinciden";
                } else {
                    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, contraseña = ? WHERE id = ?");
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt->bind_param("sssi", $nombre, $email, $hashed_password, $user_id);
                }
            } else {
                $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
                $stmt->bind_param("ssi", $nombre, $email, $user_id);
            }
            
            if ($stmt->execute()) {
                $_SESSION['user_name'] = $nombre;
                $success = "Perfil actualizado exitosamente";
                $usuario['nombre'] = $nombre;
                $usuario['email'] = $email;
            } else {
                $error = "Error al actualizar el perfil";
            }
        }
    }
}

$pageTitle = 'Mi Perfil';
include '../includes/header.php';
?>

<main class="perfil-page">
    <div class="container">
        <div class="perfil-form-container">
            <h2>Mi Perfil</h2>
            
            <?php if($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="perfil.php" class="perfil-form">
                <div class="form-group">
                    <label for="nombre">Nombre completo:</label>
                    <input type="text" id="nombre" name="nombre" required 
                           value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo htmlspecialchars($usuario['email']); ?>">
                </div>

                <div class="form-section">
                    <h3>Cambiar Contraseña</h3>
                    <p class="form-hint">Deja estos campos en blanco si no deseas cambiar tu contraseña</p>
                    
                    <div class="form-group">
                        <label for="new_password">Nueva Contraseña:</label>
                        <input type="password" id="new_password" name="new_password">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                        <input type="password" id="confirm_password" name="confirm_password">
                    </div>
                </div>

                <button type="submit" class="btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>