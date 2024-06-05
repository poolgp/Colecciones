<?php

require_once('../php_librarys/bd.php');

if (isset($_POST['insertCantante'])) {
    insertCantante($_POST['cantanteNombre'], $_POST['cantanteFechaNacimiento'], $_POST['cantantePais'], $_POST['cantanteCanciones'], $_FILES['cantanteImagen']);

    header('Location: ../index.php');
    exit();
    // if (isset($_SESSION['error'])) {
    //     header('Location: ../forms/añadirCantante.php');
    //     exit();
    // } else {
    //     header('Location: ../index.php');
    //     exit();
    // }
}