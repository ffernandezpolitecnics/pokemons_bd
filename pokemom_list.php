<?php 
    require('./librarys/bd.php');

    $pokedex = selectAllPokemons();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <link rel="stylesheet" href="./client/style/flatly-bootstrap.min.css">
    <link rel="stylesheet" href="./client/style/miCSS.css">
    <link rel="shortcut icon" href="./client/media/img/pokeball.png" type="image/x-icon">
    <link rel="stylesheet" href="./client/tercers/fontawesome-free-5.15.1-web/css/all.min.css">
</head>
<body>
    <?php include_once('./partials/menu.php') ?>

    <div class="container-fluid">
        <a id="insertar" href="./pokemon.php" class="position-fixed btn btn-success btn-lg rounded-circle" > <i class="fas fa-plus"></i></a>
        
        <div class="row row-cols-1 row-cols-md-5 mt-4">
            <!-- Mostrar los pokemons -->
            <?php
                foreach ($pokedex as $pokemon) 
                { ?>
                    <div class="col mb-4">
                        <div class="card h-100">
                            <!-- <img src="./client/media/img/001.png" class="card-img-top" alt="..."> -->
                            <img src="<?php echo $pokemon['imagen'] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <!-- <h6 class="font-weight-bold">001 - Bulbasur</h5> -->
                                <h6 class="font-weight-bold"><?php echo $pokemon['numero'] . ' - ' . $pokemon['nombre'] ?></h5>
                                <?php 

                                $tipos = tiposPokemon($pokemon['id']); 
                                
                                foreach ($tipos as $tipo) { ?>
                                    <span class="badge badge-info"><?php echo $tipo['nombre']; ?></span> 
                                <?php
                                }  ?>
                            </div>
                            <div class="card-footer">
                               <form action="./controllers/pokemonController.php" method="post" class="float-right ml-1">
                                    <button type="submit" name="delete" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
                                    <input type="hidden" name="id" value="<?php echo $pokemon['id']; ?>">
                                </form>
                                <form action="./controllers/pokemonController.php" method="post" class="float-right">
                                    <button type="submit" name="edit" class="btn btn-outline-primary"><i class="far fa-edit"></i></button>
                                    <input type="hidden" name="id" value="<?php echo $pokemon['id']; ?>">
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                } ?>
        </div>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</html>