<?php
date_default_timezone_set('America/Bogota');
setLocale(LC_ALL, "es_CO");

require_once "../models/usuarios.php";

class usuarioControllers extends usuario {

  public function __construct() {
    parent::__construct();
  }

  public function parse( $text ){
    $parsedText = str_replace(chr(10), "", $text);
    return str_replace(chr(13), "", $parsedText);
  }
}

if( isset($_POST["peticion"]) ) {
  $peticion = $_POST["peticion"];
  $us = new usuarioControllers();

  $respuesta = [
    "exito" => false,
    "msj" => "Hubo un error al procesar la petición"
  ];

  switch($peticion) {
  //AGREGAR--------------
    case 'agregar':
      $params = [
        ":nombre" => strtoupper( utf8_decode( $_POST['nombre'] ) ),
        ":apellido" => strtoupper( utf8_decode( $_POST['apellido'] ) ),
        ":tipoDocumento" => utf8_decode( strtoupper($_POST['tipoDocumento']) ),
        ":numeroDocumento" => utf8_decode( $_POST['numeroDocumento'] ),
        ":contrasena" => hash("sha256",utf8_encode($_POST[ 'contrasena' ])),
        ":rolUsuario" => strtoupper( $_POST['rolUsuario'] ),
      ];

      $sqlGuardar = $us->agregarUsuario( $params );

      if ( $sqlGuardar ) {
        $respuesta = [
          "exito" => true,
          "msj" => "Usuario Agregado"
        ];
      } else {
        $respuesta = [
          "exito" => false,
          "msj" => "Falla al guardar"
        ];
      }

      echo json_encode( $respuesta );
    break;

  //LISTAR
    case 'listar':

    $datos = $us->listaUsuario();

    $data = "";
    foreach ( $datos as $row ) { 
      $opcion =
      '
      <button data-idT=\"'.$row['id'].'\" type=\"button\" class=\"editar btn btn-info btn-sm\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Editar\"><span class=\"mdi mdi-pencil\"></span></button>
      <button data-idT=\"'.$row['id'].'\" type=\"button\" class=\"eliminar btn btn-danger btn-sm\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Eliminar\"><span class=\"mdi mdi-delete\"></span></button>
      '
      ; 
      
      $data.= '{
        "Nombre":"'.utf8_encode( $row['nombre'] ).'",
        "Apellido":"'.utf8_encode( $row['apellido'] ).'",
        "Tipo de documento":"'.utf8_encode( $row['tipoDocumento'] ).'",
        "Número documento":"'.utf8_encode( $row['numeroDocumento'] ).'",
        "Tipo de usuario":"'.utf8_encode( $row['rolUsuario'] ).'",
        "Opciones":"'.$us->parse( $opcion ).'"
      },';
    }

    $data = substr($data,0, strlen($data) - 1);

    echo '{"data":['.$data.']}';
    break;

  //CONSULTAR
    case 'consultar':
      $params = [
        ":id" => $_POST['id']
      ];

      $datos = $us->consultarUsuario( $params );
        //Esta consulta primero muestra los datos en los campos-  NO PARA EDITAR
      if ( $datos ) {
        $usuariosD = [
          "id" => $datos[0]['id'],      //Array para que recorra cada uno de los campos
          "nombre" => utf8_encode( $datos[0]['nombre'] ),
          "apellido" => utf8_encode( $datos[0]['apellido'] ),
          "tipoDocumento" => utf8_encode( $datos[0]['tipoDocumento'] ),
          "numeroDocumento" => utf8_encode( $datos[0]['numeroDocumento'] ),
          "rolUsuario" => utf8_encode( $datos[0]['rolUsuario'] ),
        ];

        $respuesta = [
          "exito" => true,
          "msj" => $usuariosD
        ];
      }

      echo json_encode( $respuesta );
    break;

  //ACTUALIZAR
    case 'actualizar':
      $params = [
        ":nombre" => utf8_decode( $_POST['newnombre'] ),
        ":apellido" => utf8_decode( $_POST['newapellido'] ),
        ":tipoDocumento" => utf8_decode( $_POST['newtipoDocumento'] ),
        ":numeroDocumento" => utf8_decode( $_POST['newnumeroDocumento'] ),
        ":rolUsuario" => utf8_decode( $_POST['newrolUsuario'] ),
        
        ":id" => $_POST['id']
      ];

      $datos = $us->actualizarUsuario( $params );

      if ( $datos ) {
        $respuesta = [
          "exito" => true,
          "msj" => "Usuario Actualizado Correctamente"
        ];
      } else {
        $respuesta = [
          "exito" => false,
          "msj" => "Error al actualizar"
        ];
      }

      echo json_encode( $respuesta );
    break;

  //ELIMINAR
      case 'eliminar':
        $params = [
          ":id" => $_POST['id']
        ];

        $datos = $us->eliminarUsuario( $params );

        if ( $datos ) {
          $respuesta = [
            "exito" => true,
            "msj" => "Usuario Eliminado"
          ];
        } else {
          $respuesta = [
            "exito" => false,
            "msj" => "Error al Eliminar"
          ];
        }

        echo json_encode( $respuesta );
      break;

    default:
      # code...
    break;
  }
}