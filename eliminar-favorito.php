<?php
session_start();

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if (!isset($_SESSION['favoritos'])) {
    $_SESSION['favoritos'] = [];
}

$_SESSION['favoritos'] = array_values(array_diff($_SESSION['favoritos'], [$id]));

// Si es petición fetch, devolver JSON
if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'idEliminado' => $id]);
    exit;
}

// Si no, redirige (para uso desde formulario)
header('Location: favoritos.php');
exit;
?>