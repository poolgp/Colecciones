<?php

session_start();

require_once('../php_librarys/bd.php');

if (isset($_POST['insertCantante'])) {
    insertCantante($_POST['cantanteNombre'], $_POST['fechaNacimiento'], $_POST['selectPais'], $_POST['chxCancion'], $$_FILES['imagenCantante'],);

    header('Location: ../index.php');
    exit();
}
