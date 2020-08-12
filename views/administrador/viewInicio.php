<?php
session_start();
include ('components/includes/verificarRol.php');
require "../../models/mixtas.php";
$mixta = new ConsultasMixtas();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- CSS styles -->  
  <?php include('../../assets/css/css.php') ?>
  <title>
    ADMINISTRADOR
  </title>
</head>

<body>
  <div class="wrapper">

    <?php include('components/includes/sidebar.php') ?>

    <div class="main-panel">

      <?php include('components/includes/navbar.php') ?>

      <div class="content">
        <div class="row justify-content-center">

          <img src="../../assets/img/fondo-comarrico.png" alt="fondo" class="img-fluid" style="width: 70%">

        </div>

      </div>

      <?php include('components/includes/footer.php') ?>
      <?php include('../components/modals/cerrarsesion.php') ?>

    </div>
  </div>
  <!-- JS scripts -->
  <?php include('../../assets/js/js.php') ?>

<script>
  //Funcion anonima
  $(function() {
    //Aqui se configura el URL
    let archivo = "viewInicio.php";
    let pathname = window.location.pathname;
    let array = pathname.split("/");
    let archivo2 = array.pop();

    if (archivo == archivo2) {
      $("li.inicio").addClass('active');
    }
  });
</script>
</body>

</html>
