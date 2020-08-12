<?php
require "../conf/conexion.php";
/**
 * Modelo de tiempo
 */
class usuario extends Conexion {

	private $listado;

	function __construct() {
		parent::__construct();
	}

//Listar
	public function listaUsuario() {
		$sentencia = $this->ejecutar("SELECT us.*, sub.nombre AS tipoDocumento, rol.nombre AS rolUsuario
		FROM usuarios AS us
		INNER JOIN subitem AS sub ON sub.id = us.tipoDocumento
		INNER JOIN roles AS rol ON rol.id = us.rolUsuario
		WHERE us.estado = 3
		");
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );

		return $this->listado;
	}

//Consulta
	public function consultarUsuario( $params ) {
		$sentencia = $this->ejecutarConParametros("SELECT * FROM usuarios WHERE id = :id",$params);
		$this->listado = $sentencia->fetchAll( PDO::FETCH_ASSOC );
		return $this->listado;
	}

//Agregar
	public function agregarUsuario( $params ) {
		$sentencia = $this->ejecutarConParametros("INSERT INTO usuarios ( nombre, apellido, tipoDocumento, numeroDocumento, contrasena, rolUsuario, estado )
		 VALUES ( :nombre, :apellido, :tipoDocumento, :numeroDocumento, :contrasena, :rolUsuario, 3  )",$params);
		return $sentencia;
	}

//Actualizar
	public function actualizarUsuario( $params ) {
		$sentencia = $this->ejecutarConParametros("UPDATE usuarios SET nombre = :nombre, apellido = :apellido, tipoDocumento = :tipoDocumento, numeroDocumento = :numeroDocumento, rolUsuario = :rolUsuario
		WHERE id = :id",$params);
		return $sentencia;
	}

//Eliminar
	public function eliminarUsuario( $params ) {
		$sentencia = $this->ejecutarConParametros("UPDATE usuarios SET estado = 11 WHERE id = :id",$params);
		return $sentencia;
	}
}
?>