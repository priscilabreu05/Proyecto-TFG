<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "pam_accessories";

$conexion = new mysqli($host, $user, $pass, $db);
$conexion->set_charset("utf8mb4");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>
