<?php
session_start();

require_once('../php_librarys/bd.php');

if (isset($_POST['insertCantante'])) {
    // Insertar nuevo cantante
    insertCantante($_POST['cantanteNombre'], $_POST['fechaNacimiento'], $_POST['selectPais'], $_POST['chxCancion'], $_FILES['imagenCantante']);

    if (isset($_SESSION['error'])) {
        header('Location: ../forms/añadirCantante.php');
        exit();
    } else {
        header('Location: ../index.php');
        exit();
    }
} elseif (isset($_POST['deleteCantante'])) {
    // Eliminar cantante
    deleteCantante($_POST['cantante_id']);
    header('Location: ../index.php');
    exit();
} elseif (isset($_POST['editarCantante'])) {
    // Editar cantante
    editarCantante($_POST['cantante_id'], $_POST['cantanteNombre'], $_POST['fechaNacimiento'], $_POST['selectPais'], $_POST['chxCancion'], $_FILES['imagenCantante']);
    header('Location: ../index.php');
    exit();
}
