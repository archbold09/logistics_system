<?php
session_start();
include ('components/includes/verificarRol.php');
require "../../models/mixtas.php";
$mx = new ConsultasMixtas();
$listarDocumento = $mx->listarTD();
$listarRolUsuario = $mx->listarRol();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- CSS styles -->  
  <?php include('../../assets/css/css.php') ?>
  <title>
   USUARIOS
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
                Agregar usuario
              </button>
            </div>
            <div class="card">
              <div class="card-header">
                <h5 class="card-title"> <b>Usuarios del sistema</b> </h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered table-striped" id="tabla"">
                    <thead class="text-primary">
                      <th><i class="text-center" aria-hidden="true"></i>Nombre</th>
                      <th><i class="text-center" aria-hidden="true"></i>Apellido</th>
                      <th><i class="text-center" aria-hidden="true"></i>Tipo de documento</th>
                      <th><i class="text-center" aria-hidden="true"></i>Número documento</th>
                      <th><i class="text-center" aria-hidden="true"></i>Tipo de usuario</th>
                      <th><i class="text-center" aria-hidden="true"></i>Opciones</th>
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

      <?php include('components/includes/footer.php') ?>

    </div>
  </div>
  <?php include('components/modals/modalUsuario.php') ?>
  <?php include('../components/modals/cerrarsesion.php') ?>
  <!-- JS scripts -->
  <?php include('../../assets/js/js.php') ?>
  <script src="../../assets/js/administrador/usuarios.js"></script>
</body>

</html>
