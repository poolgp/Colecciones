<?php
require_once('../php_librarys/bd.php');
$paises = selectPaises();
$canciones = selectCanciones();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicaApp</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-4">

        <?php include_once("../php_partials/mensajes.php") ?>

        <?php if (isset($_SESSION['cantante'])) {
            $cantante = $_SESSION['cantante'];
            unset($_SESSION['cantante']);
        } else {
            $cantante = [
                'nombre' => '',
                'fecha_nacimiento' => '',
                'pais_id' => '',
                'cancion_ids' => '',
                'imagen' => ''
            ];
        }

        ?>

        <form action="../php_controllers/cantanteController.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="cantanteNombre">Nombre Cantante: </label>
                <input type="text" class="form-control" id="cantanteNombre" name="cantanteNombre" placeholder="Nombre del cantante" value="<?php echo $cantante['nombre'] ?>">
            </div>
            <div class="form-group">
                <label for="fechaNacimiento">Fecha Nacimiento: </label>
                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $cantante['fecha_nacimiento'] ?>">
            </div>
            <div class="form-group">
                <label for="selectPais">Select Pais:</label>
                <select class="form-control" id="selectPais" name="selectPais">
                    <?php foreach ($paises as $pais) { ?>
                        <option value="<?php echo $pais['id'] ?>" <?php echo ($pais['id'] == $cantante['pais_id']) ? 'selected' : '' ?>>
                            <?php echo $pais['nombre'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="chxCancion">Canciones:</label>
                <?php foreach ($canciones as $cancion) { ?>
                    <div class="form-check form-check-inline" value="<?php echo $cantante['cancion_ids'] ?>">
                        <input class="form-check-input" type="checkbox" name="chxCancion[]" id="chxCancion" value="<?php echo $cancion['id'] ?>">
                        <label class="form-check-label" for="inlineCheckbox1"><?php echo $cancion['nombre'] ?></label>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="imagenCantante">Imagen del Cantante</label>
                <input type="file" class="form-control-file" id="imagenCantante" name="imagenCantante" value="<?php echo $cantante['imagen'] ?>">
            </div>
            <button type="submit" class="btn btn-success" name="insertCantante">Guardar</button>
            <a href="../index.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>