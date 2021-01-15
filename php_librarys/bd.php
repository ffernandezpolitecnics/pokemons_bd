<?php 
	
	//Abrir la sesión de usuario
	session_start();

	function errorMessage($e)
	{
		if (!empty($e->errorInfo[1]))
		{
			switch ($e->errorInfo[1]) 
			{
				case 1062:
					$mensaje = 'Registro duplicado';
					break;
				case 1451:
					$mensaje = 'Registro con elementos relacionados';
					break;
				default:
					$mensaje = $e->errorInfo[1] . ' - ' . $e->errorInfo[2];
					break;
			}
		}
		else 
		{
			switch ($e->getCode()) 
			{
				case 1044:
					$mensaje = "Usuario y/o password incorrecto";
					break;
				case 1049:
					$mensaje = "Base de datos desconocida";
					break;
				case 2002:
					$mensaje = 'No se encuentra el servidor';
					break;
				default:
					$mensaje = $e->getCode() . ' - ' .  $e->getMessage();
					break;
			}
		
		}

		return $mensaje;
	}

	/**
	 * Abrir la conexión
	 */

	function abrirConexion ()
	{			
		//Creamos la conexión
	    //Bd::$conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));

	    //$db = ['host' => 'localhost', 'database' => 'capraboacasa', 'username' => 'root', 'password' => ''];

		//$conexion = new PDO("mysql:host=localhost;dbname=hoteles_dwes", 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));

        // set the PDO error mode to exception
        $conexion = new PDO("mysql:host=localhost;dbname=pokedex", 'root', '');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->exec("set names utf8");
        


		return $conexion;
	}

	/**
	 * Cerrar la conexión
	 */

	function cerrarConexion ()
	{
		return null;
	}

	function selectAllRegiones()
	{
		//Recuperamos todas las secciones
		try {
			$conexion = abrirConexion();
			
			$texto = "select * from regiones";

			$sentencia = $conexion->prepare($texto);
		  	$sentencia->execute();
		} catch (PDOException $e) {
			$_SESSION['error'] =  errorMessage($e);
		}

		// Convertimos el resultado en un array asociativo
        //$resultado = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
		// $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $sentencia->fetchAll();
		  
		$conexion = cerrarConexion();
	  	return $resultado;
	}

	function selectAllTipos()
	{
		//Recuperamos todas las secciones
		try {
			$conexion = abrirConexion();
			
			$texto = "select * from tipos";

			$sentencia = $conexion->prepare($texto);
		  	$sentencia->execute();
		} catch (PDOException $e) {
			$_SESSION['error'] =  errorMessage($e);
		}

		// Convertimos el resultado en un array asociativo
        //$resultado = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
		// $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $sentencia->fetchAll();
		  
		$conexion = cerrarConexion();
	  	return $resultado;
	}

	function selectAllPokemons()
	{
		//Recuperamos todas las secciones
		try {
			$conexion = abrirConexion();
			
			$texto = "select * from pokemons";

			$sentencia = $conexion->prepare($texto);
		  	$sentencia->execute();
		} catch (PDOException $e) {
			$_SESSION['error'] =  errorMessage($e);
		}

		// Convertimos el resultado en un array asociativo
        //$resultado = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
		// $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $sentencia->fetchAll();
		  
		$conexion = cerrarConexion();
	  	return $resultado;
	}

	function selectPokemon($id)
	{
		//Recuperamos todas las secciones
		try {
			$conexion = abrirConexion();
			
			$texto = "select * from pokemons where id = :id";

			$sentencia = $conexion->prepare($texto);
			$sentencia->bindParam(':id', $id);

		  	$sentencia->execute();
		} catch (PDOException $e) {
			$_SESSION['error'] =  errorMessage($e);
		}

		// Convertimos el resultado en un array asociativo
        //$resultado = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
		// $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $sentencia->fetchAll();
		  
		$conexion = cerrarConexion();
	  	return $resultado[0];
	}

	//Devuelve los tipos de un pokemon.
	function tiposPokemon($idPokemon)
	{
		//Recuperamos todas las secciones
		try {
			$conexion = abrirConexion();
			
			$texto = "select ti.* from tipos_has_pokemons tp inner join tipos ti on  ti.id = tp.tipos_id inner join pokemons po on tp.pokemons_id = po.id where po.id = :pokemon_id;" ;
			$sentencia = $conexion->prepare($texto);
			$sentencia->bindParam(':pokemon_id', $idPokemon);
			
		  	$sentencia->execute();
		} catch (PDOException $e) {
			$_SESSION['error'] =  errorMessage($e);
		}

		// $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $sentencia->fetchAll();
		$conexion = cerrarConexion();
	  	
	  	return $resultado;
	}

	function insertPokemon($numero, $nombre, $altura, $peso, $evolucion, $imagen, $region, $tipos)
	{
		try
		{
			// Abrimos la conexión
			$conexion = abrirConexion();

			$conexion->beginTransaction();
			//Preparamos la sentencia a ejecutar
			$sentencia = $conexion->prepare("insert into pokemons (numero, nombre, altura, peso, evolucion, imagen, regiones_id) values (:numero, :nombre, :altura, :peso, :evolucion, :imagen, :regiones_id)");
			$sentencia->bindParam(':numero', $numero);
			$sentencia->bindParam(':nombre', $nombre);
			$sentencia->bindParam(':altura', $altura);
			$sentencia->bindParam(':peso', $peso);
			$sentencia->bindParam(':evolucion', $evolucion);
			$sentencia->bindParam(':imagen', $imagen);
			$sentencia->bindParam(':regiones_id', $region);

			//Ejecutamos la sentencia
			$sentencia->execute();

			$pokemon_id = $conexion->lastInsertId();

			foreach ($tipos as $tipo) {
				$sentencia = $conexion->prepare("insert into tipos_has_pokemons (tipos_id, pokemons_id) values (:tipos_id, :pokemons_id)");
				$sentencia->bindParam(':tipos_id', $tipo);
				$sentencia->bindParam(':pokemons_id', $pokemon_id);

				$sentencia->execute();
			}

			$conexion->commit();

			$_SESSION['mensaje'] = 'Registro insertado correctamente';
		}
		catch (PDOException $e)
		{
			$_SESSION['error'] = errorMessage($e);
			$pokemon['numero'] = $numero;
			$pokemon['nombre'] = $nombre;
			$pokemon['altura'] = $altura;
			$pokemon['peso'] = $peso;
			$pokemon['evolucion'] = $evolucion;
			$pokemon['imagen'] = $imagen;
			$pokemon['regiones_id'] = $region;
			$pokemon['tipos'] = $tipos;

			$_SESSION['pokemon'] = $pokemon;
		}

		//Cerramos la conexión
		$conexion = cerrarConexion();
	}


	function deletePokemon($id)
	{
		try
		{
			// Abrimos la conexión
			$conexion = abrirConexion();

			//Preparamos la sentencia a ejecutar
			$sentencia = $conexion->prepare("delete from pokemons where id = :id");
			$sentencia->bindParam(':id', $id);

			//Ejecutamos la sentencia
			$sentencia->execute();

			$_SESSION['mensaje'] = 'Registro borrado correctamente';
		}
		catch (PDOException $e)
		{
			$_SESSION['error'] = errorMessage($e);
		}

		//Cerramos la conexión
		$conexion = cerrarConexion();
	}

	function updatePokemon($id, $numero, $nombre, $altura, $peso, $evolucion, $imagen, $region, $tipos)
	{
		try
		{
			// Abrimos la conexión
			$conexion = abrirConexion();

			$conexion->beginTransaction();
			//Preparamos la sentencia a ejecutar
			if ($imagen == "")
			{
				$sentencia = $conexion->prepare("update pokemons set numero = :numero, nombre = :nombre, altura = :altura, peso = :peso, evolucion = :evolucion, regiones_id = :regiones_id where id = :id");
			}
			else 
			{
				$sentencia = $conexion->prepare("update pokemons set numero = :numero, nombre = :nombre, altura = :altura, peso = :peso, evolucion = :evolucion, imagen = :imagen, regiones_id = :regiones_id where id = :id");
				$sentencia->bindParam(':imagen', $imagen);
			}
			
			$sentencia->bindParam(':numero', $numero);
			$sentencia->bindParam(':nombre', $nombre);
			$sentencia->bindParam(':altura', $altura);
			$sentencia->bindParam(':peso', $peso);
			$sentencia->bindParam(':evolucion', $evolucion);
			
			$sentencia->bindParam(':regiones_id', $region);
			$sentencia->bindParam(':id', $id);
			
			//Ejecutamos la sentencia
			$sentencia->execute();

			//Borrar los tipos que tenía anteriormente el pokémon
			$sentencia = $conexion->prepare("delete from tipos_has_pokemons where pokemons_id = :id");
			$sentencia->bindParam(':id', $id);

			$sentencia->execute();

			foreach ($tipos as $tipo) {
				$sentencia = $conexion->prepare("insert into tipos_has_pokemons (tipos_id, pokemons_id) values (:tipos_id, :pokemons_id)");
				$sentencia->bindParam(':tipos_id', $tipo);
				$sentencia->bindParam(':pokemons_id', $id);

				$sentencia->execute();
			}

			$conexion->commit();

			$_SESSION['mensaje'] = 'Registro modificado correctamente';
		}
		catch (PDOException $e)
		{
			$_SESSION['error'] = errorMessage($e);
			$ciudad['id_ciudad'] = $id_ciudad;
			$ciudad['nombre'] = $nombre;
			$_SESSION['ciudad'] = $ciudad;
		}

		//Cerramos la conexión
		$conexion = cerrarConexion();
	}
 ?>