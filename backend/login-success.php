<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol_id'])) {
  header("Location: login.php");
  exit();
}
$rol_id = $_SESSION['rol_id'];
$nombre = isset($_SESSION['primer_nombre']) ? $_SESSION['primer_nombre'] : 'Usuario';
$apellido = isset($_SESSION['primer_apellido']) ? $_SESSION['primer_apellido'] : 'Usuario';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>¡Bienvenido!</title>
</head>
<style>
  @keyframes pillShake {
    0% {
      transform: rotate(0);
    }

    20% {
      transform: rotate(8deg);
    }

    40% {
      transform: rotate(-8deg);
    }

    60% {
      transform: rotate(6deg);
    }

    80% {
      transform: rotate(-6deg);
    }

    100% {
      transform: rotate(0);
    }
  }

  @keyframes bouncePill {
    0% {
      transform: translateY(0);
    }

    30% {
      transform: translateY(-4px);
    }

    60% {
      transform: translateY(2px);
    }

    100% {
      transform: translateY(0);
    }
  }

  .shaky-bottle {
    animation: pillShake 0.7s ease;
    transform-origin: center;
  }

  .vibrante {
    animation: bouncePill 0.7s ease;
  }
</style>

<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
  <div id="overlay-toast" style="display: none;"></div>

  <script>
    function mostrarOverlayCentral(mensaje, tipo = 'exito') {
      const colores = {
        exito: '#60A5FA',
        error: '#f44336',
        advertencia: '#ff9800'
      };

      const iconos = {
        exito: `
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 24 24">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
          </svg>`,
        error: `
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10
              10-4.48 10-10S17.52 2 12 2zm5 13l-1.41 1.41L12
              13.41l-3.59 3.59L7 15l3.59-3.59L7 7.83 8.41 6.41
              12 10l3.59-3.59L17 7.83l-3.59 3.58L17 15z"/>
          </svg>`,
        advertencia: `
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 24 24">
            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
          </svg>`
      };

      const overlay = document.getElementById('overlay-toast');
      overlay.style.position = 'fixed';
      overlay.style.top = 0;
      overlay.style.left = 0;
      overlay.style.width = '100%';
      overlay.style.height = '100%';
      overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
      overlay.style.display = 'flex';
      overlay.style.alignItems = 'center';
      overlay.style.justifyContent = 'center';
      overlay.style.zIndex = 9999;

      const box = document.createElement('div');
      box.style.backgroundColor = colores[tipo];
      box.style.color = 'white';
      box.style.padding = '28px 40px';
      box.style.borderRadius = '12px';
      box.style.boxShadow = '0 8px 20px rgba(0,0,0,0.3)';
      box.style.fontSize = '20px';
      box.style.fontFamily = 'Arial, sans-serif';
      box.style.textAlign = 'center';
      box.style.maxWidth = '90%';
      box.style.opacity = '0';
      box.style.transition = 'opacity 0.4s ease';

      const animado = document.createElement('div');
      animado.innerHTML = `
  <svg id="frascoPastillas" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 64 64">
    <!-- Frasco -->
    <rect x="20" y="8" width="24" height="48" rx="6" ry="6" fill="#2196F3" stroke="white" stroke-width="2"/>
    <!-- Tapa -->
    <rect x="18" y="4" width="28" height="8" rx="2" ry="2" fill="#0D47A1"/>
    <!-- Pastillas -->
    <circle class="vibrante" cx="32" cy="24" r="3" fill="white"/>
    <circle class="vibrante" cx="28" cy="32" r="3" fill="#FFC107"/>
    <circle class="vibrante" cx="36" cy="36" r="3" fill="#FF5252"/>
  </svg>
  <audio id="pillSound" src="data:audio/mp3;base64,//uQx..."></audio>
`;
      const frasco = document.getElementById('frascoPastillas');
      const sonido = document.getElementById('pillSound');

      if (frasco) frasco.classList.add('shaky-bottle');
      if (sonido) sonido.play().catch(() => {});

      const texto = document.createElement('div');
      texto.textContent = mensaje;

      overlay.innerHTML = ''; // Limpiar overlay

      box.appendChild(animado);
      box.appendChild(texto);
      overlay.appendChild(box);

      setTimeout(() => {
        box.style.opacity = '1';

        const pastillero = document.getElementById('pildorero');
        const sonido = document.getElementById('pillSound');

        if (pastillero) {
          pastillero.classList.add('sacudida');
        }

        if (sonido) {
          sonido.volume = 0.7;
          sonido.play().catch(() => console.warn("Audio no pudo reproducirse"));
        }
      }, 100);
      setTimeout(() => {
        overlay.style.opacity = '0';
        setTimeout(() => {
          overlay.style.display = 'none';
          <?php
          if ($rol_id == 1) {
            echo "window.location.href = 'medico_dashboard.php';";
          } else {
            echo "window.location.href = '../frontend/vista_medico.html';";
          }
          ?>
        }, 400);
      }, 3000);
    }

    document.addEventListener('DOMContentLoaded', () => {
      mostrarOverlayCentral("¡Bienvenido, <?php echo htmlspecialchars($nombre); ?>!", "exito");
    });
  </script>
</body>

</html>