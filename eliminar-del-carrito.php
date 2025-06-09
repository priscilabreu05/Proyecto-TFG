<?php

session_start();

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    unset($_SESSION['carrito'][$id]);
}

header('Location: carrito.php');
exit;

?>