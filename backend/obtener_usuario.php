<?php
session_start();
header('Content-Type: application/json');

$nombre = $_SESSION['primer_nombre'] ?? '';
$apellido = $_SESSION['primer_apellido'] ?? '';
echo json_encode(['nombre' => $nombre, 'apellido' => $apellido]);