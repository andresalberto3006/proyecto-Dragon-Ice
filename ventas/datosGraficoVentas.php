<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Content-Type: application/json"); echo json_encode([]); exit(); }
include("../conexion.php");
header("Content-Type: application/json");

$sql = "SELECT DATE(fecha) AS dia, SUM(total) AS total FROM ventas GROUP BY DATE(fecha) ORDER BY dia ASC LIMIT 30";
$r = $conexion->query($sql);
$labels = [];
$totales = [];
while ($f = $r->fetch_assoc()) {
    $labels[] = $f['dia'];
    $totales[] = (float)$f['total'];
}
echo json_encode(["labels" => $labels, "totales" => $totales]);