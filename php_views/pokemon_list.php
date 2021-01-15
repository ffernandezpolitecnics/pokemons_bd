<?php 
    require('../php_librarys/bd.php');

    $pokedex = selectAllPokemons();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <?php require_once('../php_partials/styles.php') ?>
</head>
<body>
    <?php include_once('../php_partials/menu.php') ?>

    <div class="container-fluid">

        <?php require_once('../php_partials/mensajes.php') ?>
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
                               <form action="../php_controllers/pokemonController.php" method="post" class="float-right ml-1">
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $pokemon['id']; ?>" data-nombre="<?php echo $pokemon['nombre']; ?>"><i class="far fa-trash-alt"></i></button>
                                </form>
                                <form action="../php_controllers/pokemonController.php" method="post" class="float-right">
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
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Esborrar Pokémon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="missatge"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tancar</button>
        <form action="../php_controllers/pokemonController.php" method="post" class="float-right ml-1">
            <button type="submit" name="delete" class="btn btn-danger"><i class="far fa-trash-alt"></i> Esborrar</button>
            <input type="hidden" name="id" id="id">
        </form>
      </div>
    </div>
  </div>
</div>




</body>

<?php require_once('../php_partials/scripts.php') ?>
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var nombre = button.data('nombre') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#missatge').text('Estas segur que vols esborrar el pokémon ' + nombre + '?');
        modal.find('.modal-footer #id').val(id);
    });

</script>







</html>