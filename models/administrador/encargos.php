<?php

include_once __DIR__."./../../conf/conexion.php";

class encargo extends Conexion {

	private $listado;

	function __construct() {
		parent::__construct();
	}

//Listar
	public function listar() {

		$sentencia = $this->ejecutar("SELECT encargo.*, sub.nombre AS estado, CONCAT(usAuxFacturacion.nombre, '  ', usAuxFacturacion.apellido) AS auxiliarFacturacion, CONCAT(usVerif.nombre, '  ', usVerif.apellido) AS verificador
		FROM encargos AS encargo
		INNER JOIN subitem AS sub ON sub.id = encargo.estado
		INNER JOIN usuarios AS usAuxFacturacion ON usAuxFacturacion.id = encargo.idAuxiliarFacturacion
		INNER JOIN usuarios AS usVerif ON usVerif.id = encargo.idVerificador
		WHERE encargo.estado = 3 OR encargo.estado = 6 OR encargo.estado = 4	
		");
		
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );

		return $this->listado;
	}
//fin Listar

//consulta
	public function consultar( $params ) {
		$sentencia = $this->ejecutarConParametros("SELECT *
		FROM encargos
		WHERE id = :id",$params);
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );
		return $this->listado;
	}

	public function consultarDatosEncargo( $params ) {
		$sentencia = $this->ejecutarConParametros("SELECT *
			FROM datosencargos
			WHERE idEncargo = :id",$params);
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );
		return $this->listado;
	}

	public function consultarDatosEntrega( $params ) {
		$sentencia = $this->ejecutarConParametros("SELECT de.*, sub.nombre AS estado
		FROM datosentrega  AS de
		INNER JOIN subitem AS sub ON sub.id = de.estado
		WHERE de.idDatoEncargo = :id AND de.estado = 7 
		",$params);
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );
		return $this->listado;
	}

	public function consultarDatosEntregaCorrectos( $params ) {
		$sentencia = $this->ejecutarConParametros("SELECT cantidad
		FROM datosentrega
		WHERE idDatoEncargo = :id AND estado = 7 
        limit 1
		",$params);
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );
		return $this->listado;
	}

	public function consultarDatosEntregaIncorrectos( $params ) {
		$sentencia = $this->ejecutarConParametros("SELECT cantidad
		FROM datosentrega
		WHERE idDatoEncargo = :id AND estado = 8 
        ORDER BY id DESC
        limit 1
		",$params);
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );
		return $this->listado;
	}

	public function consultarNumeroIntento( $params ) {
		$sentencia = $this->ejecutarConParametros("	SELECT  COUNT(idDatoEncargo) AS numeroIntentos
		FROM datosentrega
		WHERE idDatoEncargo = :id AND estado = 8
		",$params);
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );
		return $this->listado;
	}
	

//fin consulta
	
//agregar

	public function agregar( $params ) {

		$sentencia = $this->insertar("INSERT INTO encargos ( codigo, nombre, vehiculo, fechaCreado, idAuxiliarFacturacion, idVerificador, estado, verificacion )
		 VALUES ( :codigo, :nombre, :vehiculo, :fechaCreado, :idAuxiliarFacturacion, :idVerificador, :estado, 10)",$params);
		return $sentencia;
	}

	public function agregarDatosEncargo( $sqlDatosEncargo ) {
		$sentencia = $this->ejecutar($sqlDatosEncargo);
		return $sentencia;
	}
//fin agregar

//actualizar
	public function actualizar( $params ) {
		$sentencia = $this->ejecutarConParametros("UPDATE encargos SET  codigo = :codigo, nombre = :nombre, vehiculo = :vehiculo, fechaCreado = :fechaCreado, idVerificador = :idVerificador, estado = :estado, verificacion = :verificacion
		WHERE id = :id",$params);
		return $sentencia;
	}
//fin actualizar

//eliminar
	public function eliminar( $params ) {
		$sentencia = $this->ejecutarConParametros("UPDATE encargos SET estado = 11 WHERE id = :id",$params);
		return $sentencia;
	}


//fin eliminar

}
?>