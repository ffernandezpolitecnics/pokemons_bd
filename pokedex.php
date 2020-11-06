<?php

function displayPokemon($pokemon)
{
    echo 'N.º ' . $pokemon['numero'];
    echo '<br/>';
    echo $pokemon['nombre'];
    echo '<br/>';
    for ($i=0; $i < count($pokemon['tipos']); $i++) { 
        echo $pokemon['tipos'][$i] . ' ';
    }
    echo '<br/>';
    echo 'Altura - ' . $pokemon['altura'] . ' m';
    echo '<br/>';
    echo 'Peso - ' . $pokemon['peso'] . ' kg';
    echo '<br/>';
}

function displayPokedex($pokedex)
{
    foreach ($pokedex as $pokemon) {
        displayPokemon($pokemon);
        echo '<hr />';
    }
}

function createPokemon($numero, $nombre, $tipos, $altura, $peso)
{
    $pokemon = [
        'numero'    => $numero,
        'nombre'    => $nombre,
        'tipos'     => $tipos,
        'altura'    => $altura,
        'peso'      => $peso
    ];

    return $pokemon;
}

function addPokemon(&$pokedex, $pokemon)
{
    array_push($pokedex, $pokemon);
}

function deletePokemon(&$pokedex, $nombre)
{
    $position = searchPokemon($pokedex, $nombre);

    if ($position != -1) {
        // unset($pokedex[$position]);
        // $pokedex = array_values($pokedex);
        array_splice($pokedex, $position, 1);
    }
}

function searchPokemon($pokedex, $nombre)
{
    $i = 0;
    $found = false;

    while ($i < count($pokedex) && !$found) {
        if ($pokedex[$i]['nombre'] == $nombre) {
            $found = true;
        }
        else {
            $i++;
        }
    }

    if ($found) {
        $position = $i;
    } else {
        $position = -1;
    }

    return $position;
}

