<?php

session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_POST['id'])) {
    $id_producto = intval($_POST['id']);

    if ($id_producto > 0) {
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]++;
        } else {
            $_SESSION['carrito'][$id_producto] = 1;
        }

        echo json_encode(['success' => true]);
        exit;
    }
}

echo json_encode(['success' => false]);

exit;

?>
