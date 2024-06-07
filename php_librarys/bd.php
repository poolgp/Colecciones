<?php

function openBD()
{
    $servername = "localhost";
    $username = "root";
    $password = "mysql";

    $conn = new PDO("mysql:host=$servername;dbname=musica", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8");

    return $conn;
}

function closeBD()
{
    return null;
}

function selectPaises()
{
    $conn = openBD();

    $sentenciaText = "select * from musica.paises order by nombre";
    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    $conn = closeBD();
    return $resultado;
}

function selectCanciones()
{
    $conn = openBD();

    $sentenciaText = "select * from musica.canciones order by nombre";
    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    $conn = closeBD();
    return $resultado;
}

function insertCantante($imagen, $nombre, $fecha_nacimiento, $pais_id, $cancion_id)
{
    $conn = openBD();

    if (isset($_FILES['imagenCantante'])) {
        $rutaImg = "/colecciones/imagenes/";
        $nombreArchivo = $_FILES['imagen']['name'];
        $imgSubida = $rutaImg . $nombreArchivo;
        move_uploaded_file($_FILES['imatge']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $imgSubida);
    }

    $sentenciaText = ""
}

function selectCantantes()
{
    $conn = openBD();

    $sentenciaText = "SELECT cantantes.id, cantantes.imagen, cantantes.nombre, cantantes.fecha_nacimiento, paises.nombre AS nombre_pais, GROUP_CONCAT(canciones.nombre SEPARATOR ', ') AS canciones
                      FROM cantantes
                      LEFT JOIN paises ON cantantes.pais_id = paises.id
                      LEFT JOIN cantantes_canciones ON cantantes.id = cantantes_canciones.cantante_id
                      LEFT JOIN canciones ON cantantes_canciones.cancion_id = canciones.id
                      GROUP BY cantantes.id";
    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    $conn = closeBD();
    return $resultado;
}
