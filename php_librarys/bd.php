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
        # code...
    }

    //comprovacion si se ha seleccionado cancion


}
