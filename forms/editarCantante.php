<?php
require_once('../php_librarys/bd.php');

$id = $_GET['id'];
$cantante = getCantanteById($id);
$paises = selectPaises();
$canciones = selectCanciones();

$cantanteCanciones = explode(', ', $cantante['canciones']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cantante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Editar Cantante</h2>
        <form action="../php_controllers/cantanteController.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="cantanteId" value="<?php echo $cantante['id']; ?>">
            <div class="form-group">
                <label for="cantanteNombre">Nombre</label>
                <input type="text" class="form-control" id="cantanteNombre" name="cantanteNombre" value="<?php echo $cantante['nombre']; ?>" placeholder="Introduce el nombre del cantante">
            </div>
            <div class="form-group">
                <label for="cantanteFechaNacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="cantanteFechaNacimiento" name="cantanteFechaNacimiento" value="<?php echo $cantante['fecha_nacimiento']; ?>">
            </div>
            <div class="form-group">
                <label for="cantantePais">País</label>
                <select class="form-control" id="cantantePais" name="cantantePais">
                    <?php foreach ($paises as $pais) { ?>
                        <option value="<?php echo $pais['id']; ?>" <?php if ($pais['id'] == $cantante['pais_id']) echo 'selected'; ?>>
                            <?php echo $pais['nombre']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cantanteCanciones">Canciones</label>
                <select multiple class="form-control" id="cantanteCanciones" name="cantanteCanciones[]">
                    <?php foreach ($canciones as $cancion) { ?>
                        <option value="<?php echo $cancion['id']; ?>" <?php if (in_array($cancion['id'], $cantanteCanciones)) echo 'selected'; ?>>
                            <?php echo $cancion['nombre']; ?>
                        </option>
                    <?php } ?>
                </select>
                <small class="form-text text-muted">Mantén presionada la tecla Ctrl (Windows) o Cmd (Mac) para seleccionar múltiples opciones.</small>
            </div>
            <div class="form-group">
                <label for="cantanteImagen">Imagen</label>
                <input type="file" class="form-control-file" id="cantanteImagen" name="cantanteImagen">
                <img src="<?php echo $cantante['imagen']; ?>" alt="Imagen del Cantante" style="width: 100px; margin-top: 10px;">
            </div>
            <button type="submit" class="btn btn-primary" name="updateCantante">Actualizar Cantante</button>
            <a href="../index.php" class="btn btn-secondary ml-2">Cancelar</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>