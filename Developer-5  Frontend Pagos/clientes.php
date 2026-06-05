<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "conexion.php";

$mes_actual = isset($_GET['mes']) ? $_GET['mes'] : date("Y-m");


$sql = "SELECT
    c.id_cliente,
    CONCAT(c.nombre, ' ', c.apellido) AS nombre_completo,
    c.telefono,
    col.nombre AS colonia,
    col.tarifa_mensual AS monto,
    IFNULL((SELECT 'pagado' FROM pagos p WHERE p.id_cliente = c.id_cliente AND p.mes_pagado = ? LIMIT 1), 'pendiente') AS estado
FROM clientes c
INNER JOIN colonias col ON c.id_colonia = col.id_colonia
WHERE c.activo = 1
ORDER BY c.nombre ASC";


$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $mes_actual);
$stmt->execute();
$result = $stmt->get_result();
$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = [
        'id_cliente'      => $row['id_cliente'],
        'nombre_completo' => $row['nombre_completo'],
        'colonia'         => $row['colonia'],
        'monto'           => $row['monto'],
        'estado'          => $row['estado'],
        'telefono'        => $row['telefono']
    ];
}

echo json_encode($clientes);
?>