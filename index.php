<?php
require_once('./php_librarys/bd.php');
$cantantes = selectCantantes();
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
    <?php include_once("./php_partials/navBar.php") ?>

    <div class="container">
        <div class="row row-cols-1 row-cols-md-3">
            <?php foreach ($cantantes as $cantante) { ?>
                <div class="col mb-4">
                    <div class="card m-3">
                        <img src="<?php echo $cantante['imagen']; ?>" class="card-img-top" alt="imagenCantante">
                        <div class="card-body">
                            <h4 class="card-title" style="margin: 0px;">
                                <?php echo $cantante['nombre']; ?>
                            </h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <?php echo $cantante['fecha_nacimiento']; ?>
                            </li>
                            <li class="list-group-item">
                                <?php echo $cantante['nombre_pais']; ?>
                            </li>
                            <li class="list-group-item">
                                cancion1
                            </li>
                        </ul>
                        <div class="card-body">
                            <button type="button" class="btn btn-success">Success</button>
                            <button type="button" class="btn btn-danger">Danger</button>
                        </div>
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