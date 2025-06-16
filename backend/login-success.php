<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol_id'])) {
    header("Location: login.html");
    exit();
}
$rol_id = $_SESSION['rol_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bienvenido</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background: #f4f4f4;">
  <div id="toast-container" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;"></div>

  <script>
    function mostrarToast(mensaje, tipo = 'exito') {
      const colores = {
        exito: '#4CAF50',
        error: '#f44336',
        advertencia: '#ff9800'
      };

      const toast = document.createElement('div');
      toast.textContent = mensaje;
      toast.style.backgroundColor = colores[tipo] || '#333';
      toast.style.color = 'white';
      toast.style.padding = '14px 24px';
      toast.style.borderRadius = '6px';
      toast.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
      toast.style.marginTop = '10px';
      toast.style.opacity = '0';
      toast.style.transition = 'opacity 0.4s ease';
      toast.style.fontSize = '16px';

      document.getElementById('toast-container').appendChild(toast);
      setTimeout(() => (toast.style.opacity = '1'), 100);
      setTimeout(() => toast.remove(), 3000);
    }

    // Mostrar toast de bienvenida
    mostrarToast("Sesión iniciada con éxito 🎉", "exito");

    // Redirigir según rol
    setTimeout(() => {
      <?php
        if ($rol_id == 1) {
          echo "window.location.href = 'medico_dashboard.php';";
        } else {
          echo "window.location.href = '../frontend/principal.html';";
        }
      ?>
    }, 3000);
  </script>
</body>
</html>