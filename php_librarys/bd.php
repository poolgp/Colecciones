<?php

function errorMessage($ex)
{
    if (!empty($ex->errorInfo[1])) {
        switch ($ex->errorInfo[1]) {
            case 1062:
                $mensaje = 'Registro duplicado';
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
                $mensaje = "Base de datos desconocida";
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

function insertCantante($nombre, $fecha_nacimiento, $pais_id, $imagen, $canciones)
{
    try {
        $conn = openBD();
        $conn->beginTransaction();

        // Insert into cantantes
        $sentencia = $conn->prepare("INSERT INTO cantantes (nombre, fecha_nacimiento, pais_id, imagen) VALUES (?, ?, ?, ?)");
        $sentencia->execute([$nombre, $fecha_nacimiento, $pais_id, $imagen]);
        $cantante_id = $conn->lastInsertId();

        // Insert into cantantes_canciones
        foreach ($canciones as $cancion_id) {
            $sentencia = $conn->prepare("INSERT INTO cantantes_canciones (cantante_id, cancion_id) VALUES (?, ?)");
            $sentencia->execute([$cantante_id, $cancion_id]);
        }

        $conn->commit();
        $conn = closeBD();
        return true;
    } catch (PDOException $ex) {
        if ($conn) {
            $conn->rollBack();
        }
        echo errorMessage($ex);
        return false;
    }
}

function selectCantantes()
{
    $conn = openBD();

    $sentenciaText = "SELECT cantantes.*, GROUP_CONCAT(canciones.nombre SEPARATOR ', ') AS canciones FROM cantantes
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

    $sentenciaText = "SELECT cantantes.id, paises.nombre AS nombre_pais FROM cantantes JOIN paises ON cantantes.pais_id = paises.id";
    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    $conn = closeBD();
    return $resultado;
}
