<?php
// php_controllers/cantanteController.php
require_once('../php_librarys/bd.php');

if (isset($_POST['insertCantante'])) {
    $nombre = $_POST['cantanteNombre'];
    $fecha_nacimiento = $_POST['cantanteFechaNacimiento'];
    $pais_id = $_POST['cantantePais'];
    $canciones = $_POST['cantanteCanciones'];

    // Manejo de la imagen
    $imagen = $_FILES['cantanteImagen']['name'];
    $target_dir = "../images/";
    $target_file = $target_dir . basename($imagen);

    if (move_uploaded_file($_FILES['cantanteImagen']['tmp_name'], $target_file)) {
        if (insertCantante($nombre, $fecha_nacimiento, $pais_id, $imagen, $canciones)) {
            header('Location: ../index.php');
        } else {
            echo "Error al insertar el cantante.";
        }
    } else {
        echo "Error al subir la imagen.";
    }
}

if (isset($_POST['eliminarCantante'])) {
    $id = $_POST['cantanteId'];
    
    try {
        $conn = openBD();
        $stmt = $conn->prepare('DELETE FROM cantantes WHERE id = ?');
        $stmt->execute([$id]);
        closeBD();
        header('Location: ../index.php');
    } catch (PDOException $ex) {
        echo errorMessage($ex);
    }
}
?>
