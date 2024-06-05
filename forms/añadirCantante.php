<?php
require_once('../php_librarys/bd.php');
$paises = selectPaises();
$canciones = selectCanciones(); // Agregamos esta línea para obtener las canciones
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Añadir Cantante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Añadir Cantante</h2>
        <form action="../php_controllers/cantanteController.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="cantanteNombre">Nombre</label>
                <input type="text" class="form-control" id="cantanteNombre" name="cantanteNombre" placeholder="Introduce el nombre del cantante">
            </div>
            <div class="form-group">
                <label for="cantanteFechaNacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="cantanteFechaNacimiento" name="cantanteFechaNacimiento">
            </div>
            <div class="form-group">
                <label for="cantantePais">País</label>
                <select class="form-control" id="cantantePais" name="cantantePais">
                    <?php foreach ($paises as $pais) { ?>
                        <option value="<?php echo $pais['id'] ?>"><?php echo $pais['nombre'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cantanteCanciones">Canciones</label>
                <select multiple class="form-control" id="cantanteCanciones" name="cantanteCanciones[]">
                    <?php foreach ($canciones as $cancion) { ?>
                        <option value="<?php echo $cancion['id'] ?>"><?php echo $cancion['nombre'] ?></option>
                    <?php } ?>
                </select>
                <small class="form-text text-muted">Mantén presionada la tecla Ctrl (Windows) o Cmd (Mac) para seleccionar múltiples opciones.</small>
            </div>
            <div class="form-group">
                <label for="cantanteImagen">Imagen</label>
                <input type="file" class="form-control-file" id="cantanteImagen" name="cantanteImagen">
            </div>
            <button type="submit" class="btn btn-primary" name="insertCantante">Añadir Cantante</button>
            <a href="../index.php" class="btn btn-secondary ml-2">Cancelar</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>