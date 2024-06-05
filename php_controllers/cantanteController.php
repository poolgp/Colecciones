<?php

require_once('../php_librarys/bd.php');

if (isset($_POST['insertCantante'])) {
    insertCantante($_POST['cantanteNombre'], $_POST['cantanteFechaNacimiento'], $_POST['cantantePais'], $_FILES['cantanteImagen'], $_POST['cantanteCanciones']);
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['updateCantante'])) {
    updateCantante($_POST['cantanteId'], $_POST['cantanteNombre'], $_POST['cantanteFechaNacimiento'], $_POST['cantantePais'], $_FILES['cantanteImagen'], $_POST['cantanteCanciones']);
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['eliminarCantante'])) {
    $cantanteId = $_POST['cantanteId'];
    eliminarCantante($cantanteId);
    header('Location: ../index.php');
    exit();
}
