<?php

function errorMessage($ex)
{
    if (!empty($ex->errorInfo[1])) {
        switch ($ex->errorInfo[1]) {
            case 1062:
                $mensaje = 'Registro ducplicado';
                break;
            case 1451:
                $mensaje = 'Registro con elementos relacionados';
                break;
            default:
                $mensaje = $ex->errorInfo[1] . ' - ' . $ex->errorInfo[2];
                break;
        }
    } else {
        switch ($ex->getCode()) {
            case 1044:
                $mensaje = "Usuario y/o password incorrectos";
                break;
            case 1049:
                $mensaje = "Base de datos deconocida";
                break;
            case 2002:
                $mensaje = "No se encuentra el servidor";
                break;
            default:
                $mensaje = $ex->getCode() . ' - ' . $ex->getMessage();
                break;
        }
    }
    return $mensaje;
}

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

    $sentenciaText = "SELECT * FROM canciones ORDER BY nombre";
    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    $conn = closeBD();
    return $resultado;
}

function insertCantante($nombre, $fechaNacimiento, $pais, $canciones, $imagen)
{
    $conn = openBD();

    $rutaImg = "/colecciones/imagenes/";
    $nombreArchivo = $imagen['name'];
    $imgSubida = $rutaImg . $nombreArchivo;
    move_uploaded_file($imagen['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $imgSubida);

    $sentenciaText = "INSERT INTO cantantes (nombre, fecha_nacimiento, pais_id, imagen) VALUES (:nombre, :fechaNacimiento, :pais, :imagen)";
    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':fechaNacimiento', $fechaNacimiento);
    $sentencia->bindParam(':pais', $pais);
    $sentencia->bindParam(':imagen', $imgSubida);
    $sentencia->execute();

    $cantanteId = $conn->lastInsertId();

    foreach ($canciones as $cancion) {
        $sentenciaText = "INSERT INTO cantantes_canciones (cantante_id, cancion_id) VALUES (:cantanteId, :cancionId)";
        $sentencia = $conn->prepare($sentenciaText);
        $sentencia->bindParam(':cantanteId', $cantanteId);
        $sentencia->bindParam(':cancionId', $cancion);
        $sentencia->execute();
    }

    closeBD();
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

function jointPais()
{
    $conn = openBD();

    $sentenciaText = "SELECT cantantes.id, cantantes.nombre AS nombre_cantante, cantantes.fecha_nacimiento, paises.nombre AS nombre_pais
        FROM cantantes
        INNER JOIN paises ON cantantes.pais_id = paises.id";

    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conn = closeBD();

    return $resultado;
}