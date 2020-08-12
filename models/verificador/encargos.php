<?php

include_once __DIR__."./../../conf/conexion.php";

class encargo extends Conexion {

	private $listado;

	function __construct() {
		parent::__construct();
	}

//Listar
	public function listar($params) {

		$sentencia = $this->ejecutarConParametros("SELECT encargo.*, sub.nombre AS estado, CONCAT(usAuxFacturacion.nombre, '  ', usAuxFacturacion.apellido) AS auxiliarFacturacion, CONCAT(usVerif.nombre, '  ', usVerif.apellido) AS verificador
			FROM encargos AS encargo
			INNER JOIN subitem AS sub ON sub.id = encargo.estado
			INNER JOIN usuarios AS usAuxFacturacion ON usAuxFacturacion.id = encargo.idAuxiliarFacturacion
			INNER JOIN usuarios AS usVerif ON usVerif.id = encargo.idVerificador
			WHERE encargo.idVerificador = :idVerificador AND encargo.estado = 3 OR encargo.estado = 6 OR encargo.estado = 4
		",$params);
		
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

	public function consultarEstado( $params ) {
		$sentencia = $this->ejecutarConParametros("SELECT verificacion
		FROM encargos
		WHERE id = :id",$params);
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );
		return $this->listado;
	}

	public function consultarDatosEntrega( $params ) {
		$sentencia = $this->ejecutarConParametros("SELECT *
		FROM datosentrega
		WHERE idDatoEncargo = :id AND estado = 7 
		",$params);
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );
		return $this->listado;
	}

	public function consultarDatosEntregaCorrectos( $params ) {
		$sentencia = $this->ejecutarConParametros("	SELECT cantidad
		FROM datosentrega
		WHERE idDatoEncargo = :id AND estado = 7 
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

		$sentencia = $this->insertar("INSERT INTO encargos ( codigo, nombre, vehiculo, fechaCreado, idAuxiliarFacturacion, idVerificador, estado )
			VALUES ( :codigo, :nombre, :vehiculo, :fechaCreado, :idAuxiliarFacturacion, :idVerificador, :estado)",$params);
		return $sentencia;
	}

	public function agregarDatosEncargo( $sqlDatosEncargo ) {
		$sentencia = $this->ejecutar($sqlDatosEncargo);
		return $sentencia;
	}

	public function agregarDatosEntrega($sqlGuardarDatosEncargo){
		$sentencia = $this->ejecutar($sqlGuardarDatosEncargo);
		return $sentencia;
	}

	public function agregarNumeroIntento($params){
		$sentencia = $this->insertar("INSERT INTO numerointentos ( fecha, idEncargo, idVerificador )
			VALUES ( :fecha, :idEncargo, :idVerificador )",$params);
		return $sentencia;
	}

//fin agregar

//actualizar
	public function actualizar( $params ) {
		$sentencia = $this->ejecutarConParametros("UPDATE encargos SET  codigo = :codigo, nombre = :nombre, vehiculo = :vehiculo, fechaCreado = :fechaCreado, idVerificador = :idVerificador, estado = :estado
			WHERE id = :id",$params);
		return $sentencia;
	}

	public function actualizarEstado( $params ) {
		$sentencia = $this->ejecutarConParametros("UPDATE encargos SET estado = 6 ,verificacion = 9
			WHERE id = :id",$params);
		return $sentencia;
	}
//fin actualizar

//eliminar
	public function eliminar( $params ) {
		$sentencia = $this->ejecutarConParametros("UPDATE encargos SET estado = 11 WHERE id = :id",$params);
		return $sentencia;
	}

	public function desactivarEncargo( $params ) {
		$sentencia = $this->ejecutarConParametros("UPDATE encargos SET estado = 4, verificacion = 4 WHERE id = :id",$params);
		return $sentencia;
	}
	
//fin eliminar

}
?>