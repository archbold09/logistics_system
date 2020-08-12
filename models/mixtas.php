<?php 
include_once __DIR__."/../conf/conexion.php";

class ConsultasMixtas extends Conexion{
	
	private $listado;

	function __construct() {
		parent::__construct();
	}

	public function listarTD() {

		$sentencia = $this->ejecutar("SELECT * FROM subitem WHERE idItem = 1");
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );

		return $this->listado;
	}

	public function listarTU() {

		$sentencia = $this->ejecutar("SELECT * FROM subitem WHERE idItem = 2");
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );

		return $this->listado;
	}

	public function listarRol() {

		$sentencia = $this->ejecutar("SELECT * FROM roles");
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );

		return $this->listado;
    }

	public function listarTotalConsulta() {

		$sentencia = $this->ejecutar("SELECT * FROM consultas");
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );

		return $this->listado;
	}

	public function listarEstado() {

		$sentencia = $this->ejecutar("SELECT * FROM subitem WHERE idItem = 2");
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );

		return $this->listado;
	}

	public function listarVerificador() {

		$sentencia = $this->ejecutar("SELECT id, CONCAT(nombre, ' ', apellido) AS content FROM usuarios WHERE estado = 3 AND rolUsuario = 3");
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );

		return $this->listado;
	}

	public function listarAuxFacturacion() {

		$sentencia = $this->ejecutar("SELECT id, CONCAT(nombre, ' ', apellido) AS content FROM usuarios WHERE estado = 3 ");
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );

		return $this->listado;
	}
	

	public function listarVerificacion() {

		$sentencia = $this->ejecutar("SELECT * 
		FROM subitem 
		WHERE idItem = 2");
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );

		return $this->listado;
	}
	
	
}
?>