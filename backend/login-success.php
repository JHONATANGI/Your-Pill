<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol_id'])) {
  if (isset($_SESSION['origen_login']) && $_SESSION['origen_login'] == 'medico') {
    header("Location: ../frontend/login_medico.html");
  } else {
    header("Location: ../frontend/login_usuario.html");
  }
  exit();
}

$rol_id = $_SESSION['rol_id'];
$nombre = isset($_SESSION['primer_nombre']) ? $_SESSION['primer_nombre'] : 'Invitado';
$apellido = isset($_SESSION['primer_apellido']) ? $_SESSION['primer_apellido'] : '';
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
    // Capturar rol_id desde PHP y convertirlo a JavaScript
    const rol_id = <?php echo intval($rol_id); ?>;

    // SVG para médicos
    function medicoSVG() {
      return `
<svg width="300" height="100" viewBox="0 0 300 100" xmlns="http://www.w3.org/2000/svg" style="display:block; margin:auto;">
  <path
    d="M0,50 L30,50 L40,30 L50,70 L60,50 L80,50 L100,20 L110,80 L120,50 L160,50"
    stroke="#ffffffff"
    stroke-width="3"
    fill="none"
    stroke-linejoin="round"
    stroke-linecap="round">
    <animate attributeName="stroke-dashoffset" values="300;0" dur="2s" repeatCount="indefinite" />
    <animate attributeName="stroke-dasharray" values="300;0" dur="2s" repeatCount="indefinite" />
  </path>

  <style>
    path {
      stroke-dasharray: 300;
      stroke-dashoffset: 300;
      animation: pulseLine 2s linear infinite;
    }

    @keyframes pulseLine {
      from { stroke-dashoffset: 300; }
      to   { stroke-dashoffset: 0; }
    }
  </style>
</svg>

    `;
    }

    // SVG para pacientes (frasco con pastillas)
    function usuarioSVG() {
      return `
      <svg id="frascoPastillas" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 64 64">
        <rect x="20" y="8" width="24" height="48" rx="6" ry="6" fill="#2196F3" stroke="white" stroke-width="2"/>
        <rect x="18" y="4" width="28" height="8" rx="2" ry="2" fill="#0D47A1"/>
        <circle class="vibrante" cx="32" cy="24" r="3" fill="white"/>
        <circle class="vibrante" cx="28" cy="32" r="3" fill="#FFC107"/>
        <circle class="vibrante" cx="36" cy="36" r="3" fill="#FF5252"/>
      </svg>
    `;
    }

    function mostrarOverlayCentral(mensaje, tipo = 'exito') {
      const colores = {
        exito: '#60A5FA',
        error: '#f44336',
        advertencia: '#ff9800'
      };
      const iconos = {
        exito: `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>`,
        error: `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 1010-4.48 10-10S17.52 2 12 2zm5 13l-1.41 1.41L1213.41l-3.59 3.59L7 15l3.59-3.59L7 7.83 8.41 6.4112 10l3.59-3.59L17 7.83l-3.59 3.58L17 15z"/></svg>`,
        advertencia: `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>`
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
  ${rol_id == 1 ? medicoSVG() : usuarioSVG()}
 `;

      const texto = document.createElement('div');
      texto.textContent = mensaje;

      overlay.innerHTML = '';
      box.appendChild(animado);
      box.appendChild(texto);
      overlay.appendChild(box);

      setTimeout(() => {
        box.style.opacity = '1';
        const frasco = document.getElementById('frascoPastillas');
        if (frasco) frasco.classList.add('shaky-bottle');
        if (sonido) {
          sonido.volume = 0.7;
          sonido.play().catch(() => {});
        }
      }, 100);

      setTimeout(() => {
        overlay.style.opacity = '0';
        setTimeout(() => {
          overlay.style.display = 'none';
          <?php
          if ($rol_id == 1) {
            echo "window.location.href = '../frontend/vista_medico.html';";
          } else {
            echo "window.location.href = '../frontend/vista_paciente.html';";
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