<?php
session_start();
include ('components/includes/verificarRol.php');
require "../../models/mixtas.php";
$mixta = new ConsultasMixtas();
$listarEstado = $mixta->listarEstado();
$listarVerificador = $mixta->listarVerificador();
$listarVerificacion = $mixta -> listarVerificacion();
$auxiliarFacturacion = $_SESSION['usuario']['nombre'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <!-- CSS styles -->  
  <?php include('../../assets/css/css.php') ?>
  <link rel="stylesheet" href="../../node_modules/fileInput/input-file.css">
  <title>
    ENCARGOS
  </title>
</head>

<body>
  <div class="wrapper">

    <?php include('components/includes/sidebar.php') ?>

    <div class="main-panel">

    <?php include('components/includes/navbar.php') ?>

    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregar">
              Agregar
            </button>
          </div>
          <div class="card">
            <div class="card-header">
              <h5 class="card-title"> <b>Encargos del sistema</b> </h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped" id="tabla"">
                  <thead class="text-primary">
                    <th>Código</th>
                    <th>Destino</th>
                    <th>Vehículo</th>
                    <th>Fecha creado</th>
                    <th>Auxiliar facturación</th>
                    <th>Verificador</th>
                    <th>Estado</th>                    
                    <th>Opciones</th>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

      <?php include('components/modals/modalEncargo.php') ?>
      <?php include('../components/modals/cerrarsesion.php') ?>
      <?php include('components/includes/footer.php') ?>

    </div>
  </div>

  <!-- JS scripts -->
  <?php include('../../assets/js/js.php') ?>

  <script src="../../assets/js/auxiliarFacturacion/encargos.js"></script>
  <script src="../../node_modules/jqueryMask/jquery.mask.min.js"></script>
  <script src="../../node_modules/fileInput/input-file.min.js"></script>

</body>

</html>
