
$(document).ready(function() {
  $.getScript( "../../assets/js/validaciones.js" );

  //BOTON AGREGAR
    $("#btnRespuesta").click(function() {

      var txt = txtVal("formRespuesta");
      var txtArea = textareaVal("formRespuesta");
      var formData = new FormData( $("#formRespuesta")[0] );
      formData.append("peticion","responder");

      if (txt && txtArea) {
        $('#btnRespuesta').html('<button type="button" class="btn btn-success" disabled style="font-size: 12px"><i class="fa fa-spinner fa-spin"></i> Enviando respuesta</button>').attr('disabled', true); 
        $.ajax({
          type: "POST",
          url: "../../controllers/respuestasControllers.php",
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'JSON'
        }).done(function(data) {
          if (data['exito']) {
            setTimeout(() => {
              $('#btnRespuesta').html('<button id="btnRespuesta" type="button" class="btn btn-success">Enviar respuesta</button>').removeAttr('disabled',true);
              location.href = 'viewConsulta.php';
            }, 2000);
            $("#formRespuesta")[0].reset();
            alert_success(data['msj']);
          } else {
            $('#btnRespuesta').html('<button id="btnRespuesta" type="button" class="btn btn-success">Enviar respuesta</button>').removeAttr('disabled',true);
            alert_error(data['msj']);
          }
        });
      } else {
        alert_warning("Por favor escriba la respuesta");
      }
    });


  // FUNCION ANONIMA
    $(function() {
      //Aqui se configura el URL
      let archivo = "viewConsulta.php";
      let pathname = window.location.pathname;
      let array = pathname.split("/");
      let archivo2 = array.pop();

      if (archivo == archivo2) {
        $("li.consultas").addClass('active');
        if ($.fn.dataTable.isDataTable('#tabla')) {
          tabla.destroy();
          tabla_usuarios();
        } else {
          tabla_usuarios();
        }
      }
    });

});