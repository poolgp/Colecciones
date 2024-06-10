<?php
//session_start();

require_once('../php_librarys/bd.php');

if (isset($_POST['insertCantante'])) {
    // Insertar nuevo cantante
    $carpetaDestino=$_SERVER["DOCUMENT_ROOT"]."/colecciones/imagenes/";
    move_uploaded_file($_FILES["imagenCantante"]["tmp_name"],$carpetaDestino.$_FILES["imagenCantante"]["name"]);

    insertCantante($_POST['cantanteNombre'], $_POST['fechaNacimiento'], $_POST['selectPais'], $_POST['chxCancion'],$_FILES['imagenCantante']['name']);

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

    if (isset($_SESSION['error'])) {
        header('Location: ../index.php');
        exit();
    } else {
        header('Location: ../index.php');
        exit();
    }
} elseif (isset($_POST['editarCantante'])) {
    // Editar cantante
    $carpetaDestino=$_SERVER["DOCUMENT_ROOT"]."/colecciones/imagenes/";
    move_uploaded_file($_FILES["imagenCantante"]["tmp_name"],$carpetaDestino.$_FILES["imagenCantante"]["name"]);

    editarCantante($_POST['cantante_id'], $_POST['cantanteNombre'], $_POST['fechaNacimiento'], $_POST['selectPais'], $_POST['chxCancion'], $_FILES['imagenCantante']["name"]);

    if (isset($_SESSION['error'])) {
        header('Location: ../forms/editarCantante.php');
        exit();
    } else {
        header('Location: ../index.php');
        exit();
    }
}
