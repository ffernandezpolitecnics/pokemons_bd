<?php
    require_once('../php_librarys/bd.php');

    $regiones = selectAllRegiones();
    $tipos = selectAllTipos();

    if (isset($_SESSION['pokemon_edit']))
    {
        $pokemon = $_SESSION['pokemon_edit'];
        unset($_SESSION['pokemon_edit']);
    }
    elseif (isset($_SESSION['pokemon']))
    {
        $pokemon = $_SESSION['pokemon'];
        unset($_SESSION['pokemon']);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémons</title>
    <?php require_once('../php_partials/styles.php') ?>
</head>
<body>
    <?php require_once('../php_partials/menu.php'); ?>

    <div class="container">´

        <?php require_once('../php_partials/mensajes.php') ?>

        <div class="card mt-2">
            <div class="card-header bg-secondary text-white">
                <img src="../media/img/pikachu.png" alt="" height="50" width="50">
                &nbsp;&nbsp;Pokémon
            </div>
            <div class="card-body">
                <form action="../php_controllers/pokemonController.php" method="post" enctype="multipart/form-data">
                    <!-- id del pokemon --> 
                    <?php if (isset($pokemon['id'])) { ?>
                        <input type="hidden" name="id" value="<?php echo $pokemon['id']; ?>">
                    <?php } ?>
                    
                    <!-- Número de pokémon -->
                    <div class="form-group row">
                        <label for="inputNumero" class="col-sm-2 col-form-label">Número</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputNumero" name="inputNumero" 
                                    placeholder="Número del pokémon" maxlength="3" autofocus 
                                    value="<?php if (isset($pokemon)) { echo $pokemon['numero'];} ?>">
                        </div>
                    </div>
                    <!-- Nombre del pokémon -->
                    <div class="form-group row">
                        <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre del pokémon" value="<?php if (isset($pokemon)) { echo $pokemon['nombre'];} ?>">
                        </div>
                    </div>
                    <!-- Región del pokémon -->
                    <div class="form-group row">
                        <label for="selectRegion" class="col-sm-2 col-form-label">Región</label>
                        <div class="col-sm-10">
                            <select name="selectRegion" id="selectRegion" class="custom-select" >
                                <?php foreach ($regiones as $region) { 
                                    if ($region['id'] == $pokemon['regiones_id']) {?>
                                        <option selected value="<?php echo $region['id'] ?>"><?php echo $region['nombre'] ?></option>
                                    <?php 
                                    } 
                                    else {?>
                                        <option value="<?php echo $region['id'] ?>"><?php echo $region['nombre'] ?></option>
                                    <?php } ?>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <!-- Tipo de pokémon -->
                    <div class="form-group row">
                        <label for="checkTipo" class="col-sm-2 col-form-label">Tipo</label>
                        <div class="col-sm-10 pt-2">
                            <?php  
                                if (isset($pokemon['id']))
                                {
                                    $tiposPokemon = tiposPokemon($pokemon['id']);
                                }
                                elseif (isset($pokemon)) 
                                {
                                    $tiposPokemon = $pokemon['tipos'];
                                }
                                else
                                {
                                    $tiposPokemon = [];
                                }
                                
                                foreach ($tipos as $tipo) { ?>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <?php if (in_array($tipo, $tiposPokemon)) { ?>
                                            <input checked type="checkbox" class="custom-control-input" id="<?php echo $tipo['nombre'] ?>" name="checkTipo[]" value="<?php echo $tipo['id'] ?>">
                                        <?php }
                                        else { ?>
                                            <input type="checkbox" class="custom-control-input" id="<?php echo $tipo['nombre'] ?>" name="checkTipo[]" value="<?php echo $tipo['id'] ?>">
                                        <?php } ?>
                                        <label class="custom-control-label" for="<?php echo $tipo['nombre'] ?>"><?php echo $tipo['nombre'] ?></label>
                                    </div>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- Altura del pokémon -->
                    <div class="form-group row">
                        <label for="inputAltura" class="col-sm-2 col-form-label">Altura</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="number" class="form-control" id="inputAltura" name="inputAltura" aria-describedby="addon-cm" value="<?php if (isset($pokemon)) { echo $pokemon['altura'];}?>">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="addon-cm">cm</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Peso del pokémon -->
                    <div class="form-group row">
                        <label for="inputPeso" class="col-sm-2 col-form-label">Peso</label>
                        <div class="col-sm-10">
                           
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" id="inputPeso" name="inputPeso" aria-describedby="addon-kg" value="<?php if (isset($pokemon)) { echo $pokemon['peso'];}?>">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="addon-kg">Kg</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Evolución del pokémon -->
                    <div class="form-group row">
                        <label for="radioEvolucion" class="col-sm-2 col-form-label">Evolución</label>
                        <div class="col-sm-10 pt-2">
                            <div class="custom-control custom-radio custom-control-inline">
                                <?php if (!isset($pokemon)) {?>
                                    <input type="radio" id="radioSin" name="radioEvolucion" class="custom-control-input" value="Sin evolucionar" checked>
                                <?php } ?>
                                <?php if (isset($pokemon) && $pokemon['evolucion'] == "Sin evolucionar") { ?>
                                    <input type="radio" id="radioSin" name="radioEvolucion" class="custom-control-input" value="Sin evolucionar" checked>
                                <?php } 
                                    else {?>
                                    <input type="radio" id="radioSin" name="radioEvolucion" class="custom-control-input" value="Sin evolucionar">
                                <?php } ?>
                                <label class="custom-control-label" for="radioSin">Sin evolucionar</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <?php if (isset($pokemon) && $pokemon['evolucion'] == "Primera evolución") { ?>
                                    <input type="radio" id="radioPrimera" name="radioEvolucion" class="custom-control-input" value="Primera evolución" checked>
                                <?php } 
                                    else {?>
                                    <input type="radio" id="radioPrimera" name="radioEvolucion" class="custom-control-input" value="Primera evolución">
                                <?php } ?>
                                <label class="custom-control-label" for="radioPrimera">Primera evolución</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <?php if (isset($pokemon) && $pokemon['evolucion'] == "Segunda evolución") { ?>
                                    <input type="radio" id="radioSegunda" name="radioEvolucion" class="custom-control-input" value="Segunda evolución" checked> 
                                <?php } 
                                    else {?>
                                    <input type="radio" id="radioSegunda" name="radioEvolucion" class="custom-control-input" value="Segunda evolución">
                                <?php } ?>
                                <label class="custom-control-label" for="radioSegunda">Otras evoluciones</label>
                            </div>
                        </div>
                    </div>
                    <!-- Imagen del pokémon -->
                    <div class="form-group row">
                        <label for="selectRegion" class="col-sm-2 col-form-label">Imagen</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileLangHTML" name="fileLangHTML">
                                <label class="custom-file-label" for="fileLangHTML" data-browse="Elegir"></label>
                            </div>
                        </div>
                    </div>
                    <!-- Botones del formulario -->
                    <div class="float-right">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-primary" name="<?php if (isset($pokemon['id'])) { echo "update"; } else { echo "insert"; } ?>">Aceptar</button>
                            <a href="./pokemon_list.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>           
        </div>
    </div>

</body>

<?php require_once('../php_partials/scripts.php') ?>

</html>