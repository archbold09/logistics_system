<?php
session_start();
date_default_timezone_set('America/Bogota');
setLocale(LC_ALL, "es_CO");
require "../../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory as IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation as DataValidation;

require_once "../../models/auxiliarFacturacion/encargos.php";

class encargosControllers extends encargo {

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
  $ec = new encargosControllers();

  $respuesta = [
    "exito" => false,
    "msj" => "Hubo un error al procesar la petición"
  ];

  switch($peticion) {

  //agregar
    case 'agregar':

      $file = $_FILES['datosEncargo']['name'];
      $type = $_FILES['datosEncargo']['type'];
      $tmp = $_FILES['datosEncargo']['tmp_name'];

      //validar extension del archivo
      if ( isset( $file ) && ( $type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $type == 'application/vnd.ms-excel' ) ) {
        //verificar si al ruta existe  == la crea si no existe
        $rutaDoc = '../../documentoTemporal/';
          if( !is_dir( $rutaDoc ) ){
            mkdir( $rutaDoc, 0777 );
          }
          //mueve el archivo temporalmente
        if ($file && move_uploaded_file( $tmp, $rutaDoc.$file )) {

          $params = [
            ":codigo" => utf8_encode( $_POST['codigo'] ),
            ":nombre" => utf8_encode( strtoupper($_POST['nombre']) ),
            ":vehiculo" => utf8_encode( strtoupper($_POST['vehiculo']) ),
            ":fechaCreado" => utf8_encode( strtoupper($_POST['fechaCreado']) ),
            ":idAuxiliarFacturacion" => $_SESSION['usuario']['id'],
            ":idVerificador" => utf8_encode( $_POST['verificador'] )
          ];

          $sqlGuardar = $ec->agregar( $params );

          if ($sqlGuardar) {

            $ruta ='../../documentoTemporal/'.$file;
            //se guarda todo el archivo
            $libro = IOFactory::load($ruta);
            //indica que hoja usara
            $libro->setActiveSheetIndex(0);
            //activa la hoja de trabajo
            $hoja1 = $libro->getActiveSheet();
            //verifica hasta que fila hay datos 
            $columRow = $hoja1->getHighestDataRow('E');

            $sqlDatosEncargo = 'INSERT INTO datosencargos ( material,	descripcion,	tp,	ctdCantidad,	ctdUnidad,	peso,	volumen,	idEncargo)
             VALUES ';

              for ($i=2; $i <= $columRow ; $i++) { 
                $TP = $hoja1->getCell("E".$i)->getValue();
                if ( $TP == 200 ) {
                  $material = $hoja1->getCell("A".$i)->getValue();
                  $descripcion = $hoja1->getCell("C".$i)->getValue();
                  $ctdCantidad = $hoja1->getCell("H".$i)->getValue();
                  $ctdUnidad = $hoja1->getCell("J".$i)->getValue();
                  $peso = $hoja1->getCell("K".$i)->getValue();
                  $volumen = $hoja1->getCell("L".$i)->getValue();
                  $idEncargo = $sqlGuardar;
                }else{
                  $material = NULL;
                  $descripcion = NULL;
                  $ctdCantidad = NULL;
                  $ctdUnidad = NULL;
                  $peso = NULL;
                  $volumen = NULL; 
                  $idEncargo = NULL;
                }

                if ( $material !== NULL && $descripcion !== NULL && $ctdCantidad !== NULL && $ctdUnidad !== NULL && $peso !== NULL && $volumen !== NULL && $idEncargo !== NULL ) {
                  $sqlDatosEncargo .= "('".utf8_decode( $material )."', '".utf8_decode( $descripcion )."', '".utf8_decode( $TP )."', '".utf8_decode( $ctdCantidad )."',
                   '".utf8_decode( $ctdUnidad )."', '".utf8_decode( $peso )."', '".utf8_decode( $volumen )."', '".$idEncargo."'),";
                }
              }

              $sqlDatosEncargo = substr($sqlDatosEncargo,0, strlen($sqlDatosEncargo) - 1);

              $agregarDatosEncargo = $ec->agregarDatosEncargo($sqlDatosEncargo);

              if ($agregarDatosEncargo) {
                $respuesta = [
                  "exito" => true,
                  "msj" => "Encargo y datos agregados correctamente"
                ];
                unlink('../../documentoTemporal/'.$file);
              } else {
                unlink('../../documentoTemporal/'.$file);
                $respuesta = [
                  "exito" => false,
                  "msj" => "Error al crear el encargo"
                ];
              }         
          }
          else {
            unlink('../../documentoTemporal/'.$file);
            $respuesta = [
              "exito" => false,
              "msj" => "Error al crear el encargo"
            ];
          }
        } else {
          $respuesta = [
            "exito" => false,
            "msj" => "Error al mover plantilla, intente nuevamente."
          ];
        }
      }else {
        $respuesta = [
          "exito" => false,
          "msj" => "Tipo de archivo incorrecto, verifique si es EXCEL"
        ];
      }


      echo json_encode( $respuesta );
    break;
  //fin agregar

  //listar
    case 'listar':
      $datos = $ec->listar();

      $data = "";
      
      foreach ( $datos as $row ) {

        $opcion =
        '<button data-idT=\"'.$row['id'].'\" type=\"button\" class=\"editar btn btn-info btn-sm\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Editar\"><span class=\"mdi mdi-pencil\"></span></button>
        <button data-idT=\"'.$row['id'].'\" type=\"button\" class=\"eliminar btn btn-danger btn-sm\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Eliminar\"><span class=\"mdi mdi-delete\"></span></button>'; 

        $data.= '{
          "Código":"'.utf8_encode( strtoupper( $row['codigo'] ) ).'",
          "Nombre":"'.utf8_encode( strtoupper( $row['nombre'] ) ).'",
          "Vehículo":"'.utf8_encode( strtoupper( $row['vehiculo'] ) ).'",
          "Fecha creado":"'.utf8_encode( strtoupper( $row['fechaCreado'] ) ).'",
          "Auxiliar facturación":"'.utf8_encode( strtoupper( $row['auxiliarFacturacion'] ) ).'",
          "Verificador":"'.utf8_encode( strtoupper( $row['verificador'] ) ).'",
          "Estado":"'.utf8_encode( strtoupper( $row['estado'] ) ).'",
          "Opciones":"'.$ec->parse( $opcion ).'"
        },';
      }

      $data = substr($data,0, strlen($data) - 1);

      echo '{"data":['.$data.']}';
    break;
  //fin listar

  //consultas
    case 'consultar':
      $params = [
        ":id" => $_POST['id']
      ];

      $datos = $ec->consultar( $params );
        //Esta consulta primero muestra los datos en los campos-  NO PARA EDITAR
      if ( $datos ) {
        $encargoD = [
          "id" => $datos[0]['id'],      //Array para que recorra cada uno de los campos
          "codigo" => utf8_encode( $datos[0]['codigo'] ),
          "nombre" => utf8_encode( $datos[0]['nombre'] ),
          "vehiculo" => utf8_encode( $datos[0]['vehiculo'] ),
          "fechaCreado" => utf8_encode( $datos[0]['fechaCreado'] ),
          "idAuxiliarFacturacion" => utf8_encode( $datos[0]['idAuxiliarFacturacion'] ),
          "idVerificador" => utf8_encode( $datos[0]['idVerificador'] ),
          "estado" => utf8_encode( $datos[0]['estado'] ),
          "verificacion" => utf8_encode( $datos[0]['verificacion'] ),
        ];

        $respuesta = [
          "exito" => true,
          "msj" => $encargoD
        ];
      }

      echo json_encode( $respuesta );
    break;
  //fin consultas

  //actualizar
    case 'actualizar':

      $estado = $_POST['estadoEdit'];
      $verificacionEdit = '';

      if ($estado == 3) {
        $verificacionEdit = 10;
      }elseif ($estado == 6) {
        $verificacionEdit = 9;
      }else{
        $verificacionEdit = 10;
      }

      $params = [
        ":codigo" => utf8_encode( $_POST['codigoEdit'] ),
        ":nombre" => utf8_encode( strtoupper($_POST['nombreEdit']) ),
        ":vehiculo" => utf8_encode( strtoupper($_POST['vehiculoEdit']) ),
        ":fechaCreado" => utf8_encode( strtoupper($_POST['fechaCreadoEdit']) ),
        ":idVerificador" => utf8_encode( $_POST['verificadorEdit'] ),
        ":estado" => $estado,
        ":verificacion" => $verificacionEdit,
        ":id" => $_POST['id']
      ];

      $datos = $ec->actualizar( $params );

      if ( $datos ) {
        $respuesta = [
          "exito" => true,
          "msj" => "Datos encargo actualizados correctamente"
        ];
      } else {
        $respuesta = [
          "exito" => false,
          "msj" => "Error al actualizar"
        ];
      }

      echo json_encode( $respuesta );
    break;
  //fin actualizar

  //eliminar
    case 'eliminar':
      $params = [
        ":id" => $_POST['id']
      ];

      $datos = $ec->eliminar( $params );

      if ( $datos ) {
        $respuesta = [
          "exito" => true,
          "msj" => "Encargo eliminado"
        ];
      } else {
        $respuesta = [
          "exito" => false,
          "msj" => "Error al Eliminar"
        ];
      }

      echo json_encode( $respuesta );
    break;
  //fin eliminar
    
  }
}