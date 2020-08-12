<?php
session_start();
date_default_timezone_set('America/Bogota');
setLocale(LC_ALL, "es_CO");
require "../../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory as IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation as DataValidation;

require_once "../../models/verificador/encargos.php";

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
		"msj" => utf8_encode("Hubo un error al procesar la petición")
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
					":idEstibador" => $_SESSION['usuario']['id'],
					":idVerificador" => utf8_encode( $_POST['verificador'] ),
					":estado" => utf8_encode( $_POST['estado'] )
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
			
		$params = [
			':idVerificador' => $_SESSION['usuario']['id'] 
		];

		$datos = $ec->listar($params);
			

		$data = "";

		foreach ( $datos as $row ) {
			$paramConsultar = [ ':id' => $row['id'] ];
			$consultarEstado = $ec->consultarEstado($paramConsultar);

			if ($consultarEstado[0]['verificacion'] == 9) {
				$opcion = '<button data-idT=\"'.$row['id'].'\" type=\"button\" class=\"ver btn btn-info\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Ver encargo\"><span class=\"mdi mdi-eye\"></span></button>'; 
			}else if ($consultarEstado[0]['verificacion'] == 4) {
				$opcion = '<button data-idT=\"'.$row['id'].'\" type=\"button\" class=\"btn btn-secondary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Encargo desactivado\"><span class=\"mdi mdi-message-bulleted \"></span></button>'; 
			}
			else {
				$opcion = '<button data-idT=\"'.$row['id'].'\" type=\"button\" class=\"responder btn btn-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responder encargo\"><span class=\"mdi mdi-message-bulleted \"></span></button>'; 
			}

			$data.= '{
				"Código":"'.utf8_encode( strtoupper( $row['codigo'] ) ).'",
				"Nombre":"'.utf8_encode( strtoupper( $row['nombre'] ) ).'",
				"Vehículo":"'.utf8_encode( strtoupper( $row['vehiculo'] ) ).'",
				"Fecha creado":"'.utf8_encode( strtoupper( $row['fechaCreado'] ) ).'",
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
          "idEstibador" => utf8_encode( $datos[0]['idEstibador'] ),
          "idVerificador" => utf8_encode( $datos[0]['idVerificador'] ),
          "estado" => utf8_encode( $datos[0]['estado'] ),
       ];

       $respuesta = [
       	"exito" => true,
       	"msj" => $encargoD
       ];
    }

    echo json_encode( $respuesta );
    break;
  //fin consultas

  // ver
    case 'ver':
    require_once("../../models/mixtas.php");
    $mixta = new ConsultasMixtas();

    $listarEstado = $mixta -> listarEstado();

    $params = [ ":id" => $_POST['id'] ];

    $datos = $ec -> consultar( $params );

    if ( $datos ) {

    	$datoEncargo = [
    		"id" =>  $datos[0]['id'],
    		"codigo" =>  $datos[0]['codigo'],
    		"nombre" => strtoupper( $datos[0]['nombre'] ),
    		"vehiculo" => strtoupper( $datos[0]['vehiculo'] ),
    		"fechaCreado" => strtoupper( $datos[0]['fechaCreado'] ),
    		"estado" => strtoupper( $datos[0]['estado'] ),
    	];

    	$html = '';

    	if ( $datoEncargo ) {

    		$paramsD = [ ":id" => $_POST['id'] ];

    		$datosEncargos = $ec -> consultarDatosEncargo( $paramsD );

    		$t = 0;
    		for ($i = 1; $i <= sizeof($datosEncargos); $i++) { 
    			$html .= '
    			<tr class="defaultFilasVer">
    			<td style="text-align:center;">
    			<input disabled="disabled" type="text" class="form-control my-1 mr-sm-2 materialVer" data-num="'.$i.'" style="width:100%;text-align:center;">
    			</td>
    			<td style="text-align:center;">
    			<input disabled="disabled" type="text" class="form-control my-1 mr-sm-2 descripcionVer" data-num="'.$i.'" style="width:100%;text-align:center;">
    			</td>
    			</tr>';
    		}
    	}

    	$materiales = [];
    	$descripciones = [];

    	foreach ($datosEncargos as $row) {
    		array_push($materiales, $row['material']);
    		array_push($descripciones, $row['descripcion']);
    	}

    	$datoEnc = [
    		"material" => $materiales,
    		"descripcion" => $descripciones
    	];

    	$respuesta = [
    		"encargo" => $datoEncargo,
    		"tabla" => $html,
    		"datosEncargo" => $datoEnc
    	];
    }
    echo json_encode( $respuesta );
    break;
  //fin ver

  // responder
    case 'responder':

		$params = [ ":id" => $_POST['id'] ];

		$html = '';

		$datosEncargos = $ec -> consultarDatosEncargo( $params );
		$cantidades = [];
		$t = 0;
		foreach ($datosEncargos as $item) {
			$paramDatoCorrecto = [':id' => $item['id']];
			$datosEntregaCorrectos = $ec -> consultarDatosEntregaCorrectos( $paramDatoCorrecto );

			$html .= '
			<tr class="filasRespuesta">
				<td style="text-align:center;">
				<input disabled="disabled" type="text" class="form-control my-1 mr-sm-2 materialRespuesta" data-resp="'.$item['id'].'" style="width:100%;text-align:center;">
				</td>
				<td style="text-align:center;">
				<input disabled="disabled" type="text" class="form-control my-1 mr-sm-2 descripcionRespuesta" data-resp="'.$item['id'].'" style="width:100%;text-align:center;">
				</td>';
				
				if ( sizeof($datosEntregaCorrectos) > 0 ) {
					$html	.='
					<td style="text-align:center;">
						<input value="'.$datosEntregaCorrectos[0]['cantidad'].'" disabled="disabled" type="number" class="form-control my-1 mr-sm-2 cantidadRespuesta" data-resp="'.$item['id'].'" style="width:100%;text-align:center;">
					</td>';
					array_push($cantidades, $datosEntregaCorrectos[0]['cantidad']);
				} else {
					$html	.='
					<td style="text-align:center;">
						<input value="Ingrese la cantidad" type="number" class="form-control my-1 mr-sm-2 cantidadRespuesta" data-resp="'.$item['id'].'" style="width:100%;text-align:center;">
					</td>';
				}

				$html .='</tr>';

			// if ($consultarNumeroIntento)
		}

		$materiales = [];
		$descripciones = [];

		foreach ($datosEncargos as $row) {
			array_push($materiales, $row['material']);
			array_push($descripciones, $row['descripcion']);
		}

		$datoEncargo = [
			"id" => $_POST['id'],
			"material" => $materiales,
			"descripcion" => $descripciones,
			"cantidad" => $cantidades
		];

		// echo '<pre>';
		// print_r($datoEncargo);
		// echo '</pre>';

		$respuesta = [
			"tabla" => $html,
			"datosEncargo" => $datoEncargo
		];

		echo json_encode( $respuesta );
    break;
  //fin responder

  //respuesta
    case 'respuesta':
    $errores = [];
    $cantidades = json_decode($_POST['cantidad']);
    $idDatoEncargo = json_decode($_POST['idDatoEncargo']);
      // $idEncargo = $_POST['idEncargo'];
    $paramsConsulta = [ 'id' => $_POST['idEncargo'] ];
    $consultarDatosEncargo = $ec->consultarDatosEncargo($paramsConsulta);


    $params = [':fecha' => date('y'."-".'m'."-".'d'), ':idEncargo' => $_POST['idEncargo'], ':idVerificador' => $_SESSION['usuario']['id'] ];

    $agregarNumeroIntento = $ec->agregarNumeroIntento($params);

    if ($agregarNumeroIntento > 0 ) {

    	$sqlGuardarDatosEncargo = 'INSERT INTO datosentrega ( idDatoEncargo, cantidad, idNumeroIntento, estado)
    	VALUES ';

    	$conteoVerificacion = 0;
		$desactivar = false;
		$aviso = false;
    	foreach ($consultarDatosEncargo as $item) {
    		$sqlValues = array_search( $item['id'], $idDatoEncargo );
			//
			$paramDatoEntrega = [ ':id' => $item['id']];
			$datoEntrega = $ec -> consultarDatosEntrega($paramDatoEntrega);
			$consultarNumeroIntento = $ec -> consultarNumeroIntento($paramDatoEntrega);
			if ($consultarNumeroIntento[0]['numeroIntentos'] == 2) {
				$aviso = true;
			}
			if ($consultarNumeroIntento[0]['numeroIntentos'] == 3) {
				$desactivar = true;
				$sqlGuardarDatosEncargo.=" ('".$item['id']."', '".$cantidades[$sqlValues]."', '".$agregarNumeroIntento."', '8'),";
			}else{
				if ($cantidades[$sqlValues] == $item['ctdCantidad']) {
					$sqlGuardarDatosEncargo.=" ('".$item['id']."', '".$cantidades[$sqlValues]."', '".$agregarNumeroIntento."', '7'),";
				}else{				
					$sqlGuardarDatosEncargo.=" ('".$item['id']."', '".$cantidades[$sqlValues]."', '".$agregarNumeroIntento."', '8'),";
					$conteoVerificacion++;
					array_push($errores, $item['id']);
				}
			}
    	}

    	$sqlGuardarDatosEncargo = substr($sqlGuardarDatosEncargo,0, strlen($sqlGuardarDatosEncargo) - 1);	
    	$agregarDatosEntrega = $ec->agregarDatosEntrega($sqlGuardarDatosEncargo);

    	if ( $agregarDatosEntrega ) {
			if ($desactivar) {
				$paramDesactivar = [':id' => $_POST['idEncargo'] ];
				$desactivarEncargo = $ec -> desactivarEncargo($paramDesactivar);
				if ($desactivarEncargo) {
					$respuesta = [
						"desactivar" => true,
						"msj" => "El encargo se a desactivado. Por favor verifique el item",
					];
				}
			} else {
				if ( $conteoVerificacion == 0 ) {

					$paramIdEncargo = [':id' => $_POST['idEncargo'] ];
					$actualizarEstado = $ec->actualizarEstado($paramIdEncargo);
					$respuesta = [
						"exito" => true,
						"msj" => "Encargo guardado correctamente."
					];
	
				} else {
					if ($aviso) {
						$respuesta = [
							"mensajeIntentos" => true,
							"msj" => "1 Error más y el encargo sera desactivado.",
							"errores" => $errores
						];
					}else{
						$respuesta = [
							"exito" => false,
							"msj" => "Por favor verifique.",
							"errores" => $errores
						];
					}
				}
			}
    	}else{
    		$respuesta = [
    			"exito" => false,
    			"msj" => "Invonvenientes al guardar."
    		];
		}

    }else{
    	$respuesta = [
    		"exito" => false,
    		"msj" => "Inconvenientes al guardar."
    	];
    }
    echo json_encode( $respuesta );
    break;
  //fin respuesta

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