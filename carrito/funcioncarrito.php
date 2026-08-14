<?php

function construirRespuestaCarrito($pdo, $carrito) {
    if (empty($carrito)) {
        return ['exito' => true, 'items' => [], 'total_items' => 0, 'total_precio' => 0];
    }
 
    $ids = implode(',', array_map('intval', array_keys($carrito)));
    $productos = $pdo->query("SELECT * FROM productos WHERE id IN ($ids)")->fetchAll(PDO::FETCH_ASSOC);
 
    $items = [];
    $total_precio = 0;
    $total_items = 0;
 
    foreach ($productos as $p) {
        $cant = $carrito[$p['id']];
        $items[] = [
            'id' => $p['id'],
            'nombre' => $p['nombre'],
            'precio' => (float)$p['precio'],
            'cantidad' => $cant
        ];
        $total_precio += $p['precio'] * $cant;
        $total_items += $cant;
    }
 
    return [
        'exito' => true,
        'items' => $items,
        'total_items' => $total_items,
        'total_precio' => $total_precio
    ];
}