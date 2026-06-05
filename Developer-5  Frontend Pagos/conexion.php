<?php
// Conexión local para el módulo de pagos que reutiliza el archivo de Dev 2.
$db_path = '../Developer-2  Backend API/recolectora-api/config/database.php';
if (!file_exists($db_path)) {
    header('Content-Type: application/json');
    echo json_encode(["error" => "No se encontró el archivo de conexión de la base de datos."]);
    exit;
}
require_once $db_path;

// El archivo database.php define $conn
$conexion = $conn;
?>