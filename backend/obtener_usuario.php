<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
  'nombre' => $_SESSION['primer_nombre'] ?? '',
  'apellido' => $_SESSION['primer_apellido'] ?? ''
]);