$(document).ready(function() {
  //Script de validaciones
  $.getScript( "../../assets/js/validaciones.js" );

  //plugins
  $(".fecha").flatpickr( { "locale": "es"  } );
  $('.codigo').mask('000.000.000-00', {reverse: true});
  //Funcion anonima -- verificar archivo
  $(function() {
    //Aqui se configura el URL
    let archivo = "viewEncargo.php";
    let pathname = window.location.pathname;
    let array = pathname.split("/");
    let archivo2 = array.pop();

    if (archivo == archivo2) {       

      $("li.encargo").addClass('active');

      if ($.fn.dataTable.isDataTable('#tabla')) {
        tabla.destroy();
        listar_tabla();
      } else {
        listar_tabla();
      }
      
    }
  });

  var tabla;

  //agregar
  $("#btnAgregar").click(function() {

    let txt = txtVal('formulario');
    let select = selectVal('formulario');
    let formData = new FormData( $('#formulario')[0] );
    formData.append ('peticion','agregar');

    if (txt && select) {
      $('#btnAgregar').addClass( "btn disabled btn-success btn-progress" ).html('Cargando').attr('disabled','disabled');
      $.ajax({
        type: "POST",
        url: "../../controllers/verificador/encargosControllers.php",
        data: formData,
        cache:false,
        contentType:false,
        processData:false,
        dataType: 'JSON'
      }).done(function(data) {
        if (data['exito']) {
          $('#formulario')[0].reset();  
          $("#modalAgregar").modal("hide")
          alert_success(data['msj']);
          tabla.ajax.reload();
          $('#btnAgregar').removeClass( "disabled btn-progress" ).html('Agregar').removeAttr('disabled','disabled');
        } else {
          alert_error(data['msj']);
          $('#btnAgregar').removeClass( "disabled btn-progress" ).html('Agregar').removeAttr('disabled','disabled');
        }
      });
    }
    else {
      alert_warning("Por favor llene todos los campos");
    }

  });
  //fin agregar

  //listar
  function listar_tabla() {
    tabla = $('#tabla').DataTable({
      "select": true,
      "searching": true,
      "bDeferRender": true,
      "sPaginationType": "full_numbers",
      "ajax": {
        "url": "../../controllers/verificador/encargosControllers.php",
        "type": "POST",
        "data": {
          peticion: "listar"
        },
        "dataSrc": function(json) {
          let datos = json.data;
          if (datos.length > 0) {
            return json.data;
          } else {
            return json.data;
          }
        }
      },
        //Aqui se agregan las columnas de la tabla Para el TBODY
        "columns": [
        { "data": "Código" },
        { "data": "Nombre" },
        { "data": "Vehículo" },
        { "data": "Fecha creado" },
        { "data": "Estado" },
        { "data": "Opciones" }
        ],
        "oLanguage": {
          "sProcessing": "Procesando...",
          "sLengthMenu": 'Mostrar <select>' +
          '<option value="10">10</option>' +
          '<option value="20">20</option>' +
          '<option value="30">30</option>' +
          '<option value="40">40</option>' +
          '<option value="50">50</option>' +
          '<option value="-1">All</option>' +
          '</select> registros',
          "sZeroRecords": "No se encontraron resultados",
          "sEmptyTable": "Ningún dato disponible en esta tabla",
          "sInfo": "Mostrando del (_START_ al _END_) de un total de _TOTAL_ registros",
          "sInfoEmpty": "Mostrando del 0 al 0 de un total de 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix": "",
          "sSearch": "Buscar:",
          "sUrl": "",
          "sInfoThousands": ",",
          "sLoadingRecords": "Por favor espere - cargando...",
          "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
        }
      });
    tabla.on('draw', function(e, settings, details) {
      $(function() {
          //Tooltip
          $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
          });
        });
      responder();
      ver();
    });
  }
  //fin listar

  //responder
  function responder() {
    $("#tabla").find("button.responder").each(function() {
      $(this).unbind("click");
      $(this).click( function() {

        let idT = $(this).attr("data-idT");

        $.ajax({
          type: "POST",
          url: "../../controllers/verificador/encargosControllers.php",
          data: {
            id: idT,
            peticion: 'responder'
          },
          dataType: 'JSON'
        }).done( function (data)  {
            // console.log(data.datosEncargo)
            $("#btnGuardarRespuesta").attr("data-idEncargo", data['datosEncargo']['id']);
            $("#contenedorRespuesta").empty();
            $("#contenedorRespuesta").html(data.tabla);

            var i = 0;
            $("#contenedorRespuesta").find('.materialRespuesta').each(function(){
              $(this).val(data['datosEncargo']['material'][i]);
              i++;
            });

            i = 0;
            $("#contenedorRespuesta").find('.descripcionRespuesta').each(function(){
              $(this).val(data['datosEncargo']['descripcion'][i]);
              i++;
            });

            respuesta();
            $("#modalRespuesta").modal("show");
          });
      });
    });
  }
  //fin responder

  //respuesta
  function respuesta (){
    $('#btnGuardarRespuesta').unbind('click');
    $('#btnGuardarRespuesta').on('click', function(){

      let cantidades = [];
      let idDatosEncargos = [];

      $('#contenedorRespuesta').find('input.cantidadRespuesta').each( function() {
        cantidades.push( $(this).val() );
      });

      $('#contenedorRespuesta').find('input.cantidadRespuesta').each( function() {
        idDatosEncargos.push( $(this).attr('data-resp') );
      });

        //contador que cuente si cada campo esta mayor a 0 

        $.ajax({
          type: "POST",
          url: "../../controllers/verificador/encargosControllers.php",
          data: {
            idEncargo: $(this).attr('data-idEncargo'),
            cantidad: JSON.stringify(cantidades),
            idDatoEncargo: JSON.stringify(idDatosEncargos),
            peticion: 'respuesta'
          },
          dataType: 'JSON'
        }).done(function(data) {
          if (data['exito']) {
            alert_success(data['msj']);
            tabla.ajax.reload();
            $("#modalRespuesta").modal("hide")
          }else if (data['desactivar']){
            alert_error(data['msj']);
            $('#modalRespuesta').modal('hide');
            tabla.ajax.reload();
          }
          else if (data['mensajeIntentos']) {
            alert_warning(data['msj']);
          }
          else {
            $('#contenedorRespuesta').find('input.cantidadRespuesta').each( function() {
              let verificar = jQuery.inArray(  $(this).attr('data-resp'), data['errores'] );

              if (verificar >= 0 ) {
                $(this).css( 'border-style', 'solid' );
                $(this).css( 'border-color', 'red' );
              }else{
                $(this).removeAttr( 'style' );
                $(this).css( 'width', '100%' );
                $(this).css( 'text-align', 'center' );
              }

            });
            alert_error(data['msj']);
          }
        });

      })
  }
  //fin respuesta

  //ver
  function ver() {
    $("#tabla").find("button.ver").each(function() {
      $(this).unbind("click");
      $(this).click(function() {

        let idT = $(this).attr("data-idT");

        $.ajax({
          type: "POST",
          url: "../../controllers/verificador/encargosControllers.php",
          data: {
            id: idT,
            peticion: 'ver'
          },
          dataType: 'JSON'
        }).done(function(data) {
            // console.log(data.datosEncargo)
            $("#btnVer").attr("data-idEncargo", data['encargo']['id']);
            $("#idEncargo").val(data['encargo']['id']);
            $("#codigoVer").val(data['encargo']['codigo']);
            $("#nombreVer").val(data['encargo']['nombre']);
            $("#vehiculoVer").val(data['encargo']['vehiculo']);
            $("#fechaCreadoVer").val(data['encargo']['fechaCreado']);
            $("#estadoVer").val(data['encargo']['estado']).trigger('change');

            $("#contenedorVer").empty();
            $("#contenedorVer").html(data.tabla);

            var p = 0;
            $("#contenedorVer").find('.materialVer').each(function(){
              $(this).val(data['datosEncargo']['material'][p]);
              p++;
            });

            p = 0;
            $("#contenedorVer").find('.descripcionVer').each(function(){
              $(this).val(data['datosEncargo']['descripcion'][p]);
              p++;
            });

            $("#modalVer").modal("show");
          });
      });
    });
  }
  //fin ver

});