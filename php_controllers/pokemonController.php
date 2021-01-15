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
        $name = '../media/img/'.$_POST['inputNumero'].'.'.$fileExtension;
        move_uploaded_file($fileTmpPath, $name);

        $name_insert = '/pokemons_bd/media/img/'.$_POST['inputNumero'].'.'.$fileExtension;

        insertPokemon($_POST['inputNumero'], $_POST['inputNombre'], $_POST['inputAltura'], $_POST['inputPeso'], $_POST['radioEvolucion'], $name_insert, $_POST['selectRegion'], $_POST['checkTipo']);

        if (isset($_SESSION['error']))
        {
            header('Location: ' . '../php_views/pokemon.php');
            exit();
        }
        else 
        {
            move_uploaded_file($fileTmpPath, $name);
            header('Location: ' . '../php_views/pokemon_list.php');
            exit();
        }
    }
    elseif (isset($_POST['update'])) 
    {
        $fileTmpPath = $_FILES['fileLangHTML']['tmp_name'];
        $fileName = $_FILES['fileLangHTML']['name'];
        $fileSize = $_FILES['fileLangHTML']['size'];
        $fileType = $_FILES['fileLangHTML']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $name = '../media/img/'.$_POST['inputNumero'].'.'.$fileExtension;

        if ($fileSize != 0)
        {
            move_uploaded_file($fileTmpPath, $name);
            $name_update = '/pokemons_bd/media/img/'.$_POST['inputNumero'].'.'.$fileExtension;
        }
        else 
        {
            $name_update = "";
        }

        updatePokemon($_POST["id"],$_POST['inputNumero'], $_POST['inputNombre'], $_POST['inputAltura'], $_POST['inputPeso'], $_POST['radioEvolucion'], $name_update, $_POST['selectRegion'], $_POST['checkTipo']);

        if (isset($_SESSION['error']))
        {
            header('Location: ' . '../php_views/pokemon.php');
            exit();
        }
        else 
        {
            header('Location: ' . '../php_views/pokemon_list.php');
            exit();
        }
    }
    elseif (isset($_POST['delete'])) 
    {
        $pokemon = selectPokemon($_POST['id']);
        deletePokemon($_POST['id']);

        $ruta = $_SERVER['DOCUMENT_ROOT'] . $pokemon['imagen'];

        // if (unlink($pokemon['imagen']))
        if (unlink($ruta))
        {
            $borrar = true;
        }
        else {
            $borrar = $_SERVER['DOCUMENT_ROOT'];
        }
        
        header('Location: ' . '../php_views/pokemon_list.php');
        exit();
    }
    elseif (isset($_POST['edit'])) 
    {
        $pokemon = selectPokemon($_POST['id']);

        $_SESSION['pokemon_edit'] = $pokemon;

        header('Location: ' . '../php_views/pokemon.php');
        exit();
        
    }
?>