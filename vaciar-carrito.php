<?php

session_start();
$_SESSION['carrito'] = [];
header('Location: carrito.php?vacio=1');
exit;

?>
