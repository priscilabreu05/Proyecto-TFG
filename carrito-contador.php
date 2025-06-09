<?php

session_start();
$total = 0;

if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $cantidad) {
        $total += $cantidad;
    }
}

echo json_encode(['total' => $total]);

?>