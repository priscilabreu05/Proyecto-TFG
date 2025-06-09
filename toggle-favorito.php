<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = intval($_POST['id']);
if (!isset($_SESSION['favoritos'])) {
    $_SESSION['favoritos'] = [];
}

if (in_array($id, $_SESSION['favoritos'])) {
    $_SESSION['favoritos'] = array_diff($_SESSION['favoritos'], [$id]);
    echo json_encode(['favorito' => false]);
} else {
    $_SESSION['favoritos'][] = $id;
    echo json_encode(['favorito' => true]);
}
?>
