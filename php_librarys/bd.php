<?php

session_start();

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

    $sentenciaText = "select * from musica.canciones order by nombre";
    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    $conn = closeBD();
    return $resultado;
}

function insertCantante($nombre, $fecha_nacimiento, $pais_id, $cancion_ids, $imagen)
{
    $conn = openBD();

    try {
        // Subir imagen
        if (isset($imagen)) {
            $rutaImg = "./imagenes/";
            $nombreArchivo = $imagen['name'];
            $imgSubida = $rutaImg . $nombreArchivo;
            move_uploaded_file($imagen['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $imgSubida);
        } else {
            $imgSubida = null;
        }

        // Insertar el cantante
        $sentenciaText1 = "INSERT INTO cantantes (imagen, nombre, fecha_nacimiento, pais_id) VALUES (:imagen, :nombre, :fecha_nacimiento, :pais_id)";
        $sentencia1 = $conn->prepare($sentenciaText1);
        $sentencia1->bindParam(':imagen', $imgSubida);
        $sentencia1->bindParam(':nombre', $nombre);
        $sentencia1->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $sentencia1->bindParam(':pais_id', $pais_id);
        $sentencia1->execute();

        $cantante_id = $conn->lastInsertId();

        // Insertar las canciones del cantante
        $sentenciaText2 = "INSERT INTO cantantes_canciones (cantante_id, cancion_id) VALUES (:cantante_id, :cancion_id)";
        $sentencia2 = $conn->prepare($sentenciaText2);

        foreach ($cancion_ids as $cancion_id) {
            $sentencia2->bindParam(':cantante_id', $cantante_id);
            $sentencia2->bindParam(':cancion_id', $cancion_id);
            $sentencia2->execute();
        }

        $_SESSION['mensaje'] = "Registro insertado correctamente.";
    } catch (PDOException $ex) {
        $_SESSION['error'] = errorMessage($ex);

        $cantante['nombre'] = $nombre;
        $cantante['fecha_nacimiento'] = $fecha_nacimiento;
        $cantante['pais_id'] = $pais_id;
        $cantante['cancion_ids'] = $cancion_ids;
        $cantante['imagen'] = $imagen;

        $_SESSION['cantante'] = $cantante;
    }

    $conn = closeBD();
}

function selectCantantes()
{
    $conn = openBD();

    $sentenciaText = "SELECT cantantes.id, cantantes.imagen, cantantes.nombre, cantantes.fecha_nacimiento, paises.nombre AS nombre_pais
                      FROM cantantes
                      LEFT JOIN paises ON cantantes.pais_id = paises.id";
    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    $conn = closeBD();
    return $resultado;
}

function selectCancionesPorCantante($cantante_id)
{
    $conn = openBD();

    $sentenciaText = "SELECT canciones.nombre 
                      FROM cantantes_canciones 
                      JOIN canciones ON cantantes_canciones.cancion_id = canciones.id 
                      WHERE cantantes_canciones.cantante_id = :cantante_id";
    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->bindParam(':cantante_id', $cantante_id);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    $conn = closeBD();
    return $resultado;
}

function deleteCantante($cantante_id)
{
    $conn = openBD();

    try {
        $sentenciaText1 = "DELETE FROM cantantes_canciones WHERE cantante_id = :cantante_id";
        $sentencia1 = $conn->prepare($sentenciaText1);
        $sentencia1->bindParam(':cantante_id', $cantante_id);
        $sentencia1->execute();

        $sentenciaText2 = "DELETE FROM cantantes WHERE id = :cantante_id";
        $sentencia2 = $conn->prepare($sentenciaText2);
        $sentencia2->bindParam(':cantante_id', $cantante_id);
        $sentencia2->execute();

        $_SESSION['mensaje'] = "Registro eliminado correctamente.";
    } catch (PDOException $ex) {
        $_SESSION['error'] = errorMessage($ex);
    }

    $conn = closeBD();
}

function selectCantantePorID($cantante_id)
{
    $conn = openBD();

    $sentenciaText = "SELECT cantantes.id, cantantes.imagen, cantantes.nombre, cantantes.fecha_nacimiento, paises.nombre AS nombre_pais
                      FROM cantantes
                      LEFT JOIN paises ON cantantes.pais_id = paises.id
                      WHERE cantantes.id = :cantante_id";
    $sentencia = $conn->prepare($sentenciaText);
    $sentencia->bindParam(':cantante_id', $cantante_id);
    $sentencia->execute();

    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Obtener las canciones del cantante
    $sentenciaText2 = "SELECT cancion_id FROM cantantes_canciones WHERE cantante_id = :cantante_id";
    $sentencia2 = $conn->prepare($sentenciaText2);
    $sentencia2->bindParam(':cantante_id', $cantante_id);
    $sentencia2->execute();
    $canciones = $sentencia2->fetchAll();

    // Agregar las canciones al resultado
    $resultado['canciones'] = $canciones;

    $conn = closeBD();
    return $resultado;
}

function editarCantante($cantante_id, $nombre, $fecha_nacimiento, $pais_id, $cancion_ids, $imagen)
{
    $conn = openBD();

    try {
        // Subir imagen
        if (isset($imagen)) {
            $rutaImg = "./imagenes/";
            $nombreArchivo = $imagen['name'];
            $imgSubida = $rutaImg . $nombreArchivo;
            move_uploaded_file($imagen['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $imgSubida);
        } else {
            $imgSubida = null;
        }

        // Actualizar el cantante
        $sentenciaText = "UPDATE cantantes 
                  SET nombre = :nombre, fecha_nacimiento = :fecha_nacimiento, pais_id = :pais_id, imagen = :imagen
                  WHERE id = :cantante_id";
        $sentencia = $conn->prepare($sentenciaText);
        $sentencia->bindParam(':cantante_id', $cantante_id);
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $sentencia->bindParam(':pais_id', $pais_id);
        $sentencia->bindParam(':imagen', $imgSubida);
        $sentencia->execute();

        // Eliminar las canciones actuales del cantante
        $sentenciaText2 = "DELETE FROM cantantes_canciones WHERE cantante_id = :cantante_id";
        $sentencia2 = $conn->prepare($sentenciaText2);
        $sentencia2->bindParam(':cantante_id', $cantante_id);
        $sentencia2->execute();

        // Insertar las nuevas canciones del cantante
        $sentenciaText3 = "INSERT INTO cantantes_canciones (cantante_id, cancion_id) VALUES (:cantante_id, :cancion_id)";
        $sentencia3 = $conn->prepare($sentenciaText3);
        foreach ($cancion_ids as $cancion_id) {
            $sentencia3->bindParam(':cantante_id', $cantante_id);
            $sentencia3->bindParam(':cancion_id', $cancion_id);
            $sentencia3->execute();
        }

        $_SESSION['mensaje'] = "Registro actualizado correctamente.";
    } catch (PDOException $ex) {
        $_SESSION['error'] = errorMessage($ex);

        $cantante['nombre'] = $nombre;
        $cantante['fecha_nacimiento'] = $fecha_nacimiento;
        $cantante['pais_id'] = $pais_id;
        $cantante['cancion_ids'] = $cancion_ids;
        $cantante['imagen'] = $imagen;

        $_SESSION['cantante'] = $cantante;
    }

    $conn = closeBD();
}
