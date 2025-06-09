<?php
session_start();

if (!isset($_POST['id'], $_POST['accion'])) {
    header("Location: carrito.php");
    exit;
}

$id = intval($_POST['id']);
$accion = $_POST['accion'];

if (isset($_SESSION['carrito'][$id])) {
    if ($accion === 'sumar') {
        $_SESSION['carrito'][$id]++;
    } elseif ($accion === 'restar') {
        $_SESSION['carrito'][$id]--;
        if ($_SESSION['carrito'][$id] <= 0) {
            unset($_SESSION['carrito'][$id]);
        }
    }
}

header("Location: carrito.php");
exit;

?>