<?php
    require_once('../php_librarys/bd.php');


    if (isset($_POST['insert']))
    {
        // Hacer el tratamiento de la imagen

        $fileTmpPath = $_FILES['fileLangHTML']['tmp_name'];
        $fileName = $_FILES['fileLangHTML']['name'];
        $fileSize = $_FILES['fileLangHTML']['size'];
        $fileType = $_FILES['fileLangHTML']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $name = '../client/media/img/'.$_POST['inputNumero'].'.'.$fileExtension;
        move_uploaded_file($fileTmpPath, $name);

        $name_insert = '/pokemons_bd/client/media/img/'.$_POST['inputNumero'].'.'.$fileExtension;

        insertPokemon($_POST['inputNumero'], $_POST['inputNombre'], $_POST['inputAltura'], $_POST['inputPeso'], $_POST['radioEvolucion'], $name_insert, $_POST['selectRegion'], $_POST['checkTipo']);

        header('Location: ' . '../pokemon_list.php');
        exit();
    }
    elseif (isset($_POST['update'])) 
    {
        # code...
    }
    elseif (isset($_POST['delete'])) 
    {
        $pokemon = selectPokemon($_POST['id']);
        deletePokemon($_POST['id']);

        unlink($pokemon['imagen']);
        
        header('Location: ' . '../pokemon_list.php');
        exit();
    }
    elseif (isset($_POST['edit'])) 
    {
        $pokemon = selectPokemon($_POST['id']);

        $_SESSION['pokemon_edit'] = $pokemon;

        header('Location: ' . '../pokemon.php');
        exit();
        
    }








?>