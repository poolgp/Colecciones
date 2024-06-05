<?php
require_once('php_librarys/bd.php');
$cantantes = selectCantantes();
$paises = jointPais();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicaApp</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <?php include_once("./php_partials/navBar.php") ?>

    <div class="container mx-auto">
        <h2>Lista de Cantantes</h2>
        <div class="row">
            <?php foreach ($cantantes as $cantante) { ?>
                <div class="card m-2" style="max-width: 18rem;">
                    <img src="<?php echo $cantante['imagen']; ?>" class="card-img-top" alt="imgCantante">
                    <div class="card-body">
                        <h4 class="card-title">
                            <?php echo $cantante['nombre']; ?>
                        </h4>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <?php echo $cantante['fecha_nacimiento']; ?>
                        </li>
                        <li class="list-group-item">
                            <?php foreach ($paises as $pais) {
                                if ($pais['id'] == $cantante['id']) {
                                    echo $pais['nombre_pais'];
                                    break;
                                }
                            } ?>
                        </li>
                        <li class="list-group-item">
                            <?php $canciones = explode(', ', $cantante['canciones']);
                            foreach ($canciones as $cancion) { ?>
                                <?php echo $cancion; ?>
                            <?php } ?>
                        </li>
                    </ul>
                    <div class="card-body d-flex">
                        <a href="./forms/editarCantante.php?id=<?php echo $cantante['id']; ?>" class="btn btn-primary">Editar</a>
                        <form action="./php_controllers/cantanteController.php" method="POST">
                            <input type="hidden" name="cantanteId" value="<?php echo $cantante['id']; ?>">
                            <button type="submit" class="btn btn-danger" name="eliminarCantante">Eliminar</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>