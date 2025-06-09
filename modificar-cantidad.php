<?php

session_start();

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$cambio = isset($_POST['cambio']) ? intval($_POST['cambio']) : 0;

if ($id > 0 && $cambio != 0 && isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id] += $cambio;

    if ($_SESSION['carrito'][$id] <= 0) {
        unset($_SESSION['carrito'][$id]);
    }

    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['success' => false]);

?>