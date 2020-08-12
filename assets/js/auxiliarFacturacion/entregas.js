$(document).ready(function() {
  //Script de validaciones
  $.getScript( "../../assets/js/validaciones.js" );

  //plugins
  $(".fecha").flatpickr( { "locale": "es"  } );
  $('.codigo').mask('000.000.000-00', {reverse: true});
  //Funcion anonima -- verificar archivo
  $(function() {
    let archivo = "viewEntregas.php";
    let pathname = window.location.pathname;
    let array = pathname.split("/");
    let archivo2 = array.pop();

    if (archivo == archivo2) {       

      $("li.entrega").addClass('active');

      if ($.fn.dataTable.isDataTable('#tabla')) {
        tabla.destroy();
        listar_tabla();
      } else {
        listar_tabla();
      }
      
    }
  });

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
        url: "../../controllers/auxiliarFacturacion/entregasControllers.php",
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
        "url": "../../controllers/auxiliarFacturacion/entregasControllers.php",
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
        { "data": "Destino" },
        { "data": "Vehículo" },
        { "data": "Fecha creado" },
        { "data": "Auxiliar facturación" },
        { "data": "Verificador" },
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
      eliminar();
      consultar();
      ver();
    });
  }
  //fin listar
  
  //consultar
  function consultar() {

    $("#tabla").find("button.editar").each(function() {
      $(this).unbind("click");
      $(this).click(function() {
        let idT = $(this).attr("data-idT");

        $.ajax({
          type: "POST",
          url: "../../controllers/auxiliarFacturacion/entregasControllers.php",
          data: {
            id: idT,
            peticion: 'consultar'
          },
          dataType: 'JSON'
        }).done(function(data) {
          if (data['exito']) {
            $("#btnEditar").data("idTi", data['msj']['id']);
            $("#codigoEdit").val(data['msj']['codigo']);
            $("#nombreEdit").val(data['msj']['nombre']);
            $("#vehiculoEdit").val(data['msj']['vehiculo']);
            $("#fechaCreadoEdit").val(data['msj']['fechaCreado']);
            $("#auxiliarFacturacionEdit").val(data['msj']['idauxiliarFacturacion']).trigger('change');
            $("#verificadorEdit").val(data['msj']['idVerificador']).trigger('change');
            $("#estadoEdit").val(data['msj']['estado']).trigger('change');
            $("#verificacionEdit").val(data['msj']['verificacion']).trigger('change');
            $("#modalEditar").modal("show");
            editar();
          } else {
            alert(data['msj']);
          }
        });
      });
    });
  }
  //fin consultar
  
  //ver
  function ver() {
    $("#tabla").find("button.ver").each(function() {
      $(this).unbind("click");
      $(this).click(function() {
        
        let idT = $(this).attr("data-idT");
        
        $.ajax({
          type: "POST",
          url: "../../controllers/auxiliarFacturacion/entregasControllers.php",
          data: {
            id: idT,
            peticion: 'ver'
          },
          dataType: 'JSON'
        }).done(function(data) {
              // console.log(data.datosEncargo)
              $("#btnVerEntrega").attr("data-idEncargo", data['encargo']['id']);
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

              p = 0;
              $("#contenedorVer").find('.cantidadVer').each(function(){
                $(this).val(data['datosEncargo']['cantidad'][p]);
                p++;
              });
              
              $("#modalVer").modal("show");
            });
      });
    });
  }
  //fin ver

  //verEntrega
  $('#btnVerEntrega').click(function() {
    
    let idEncargo = $(this).attr("data-idEncargo");

    $.ajax({
      type: "POST",
      url: "../../controllers/auxiliarFacturacion/entregasControllers.php",
      data: {
        id: idEncargo,
        peticion: 'verEntrega'
      },
      dataType: 'JSON'
    }).done(function(data) {
          // console.log(data.datosEncargo)

          $("#contenedorVerEntrega").empty();
          $("#contenedorVerEntrega").html(data.tabla);

          var p = 0;
          $("#contenedorVerEntrega").find('.materialVerEntrega').each(function(){
            $(this).val(data['datosEntrega']['material'][p]);
            p++;
          });

          p = 0;
          $("#contenedorVerEntrega").find('.descripcionVerEntrega').each(function(){
            $(this).val(data['datosEntrega']['descripcion'][p]);
            p++;
          });

          p = 0;
          $("#contenedorVerEntrega").find('.cantidadVerEntrega').each(function(){
            $(this).val(data['datosEntrega']['cantidad'][p]);
            p++;
          });

          p = 0;
          $("#contenedorVerEntrega").find('.verNumeroEdiciones').each(function(){
            $(this).val(data['datosEntrega']['numeroEdiciones'][p]);
            p++;
          });

          $("#modalVerEntrega").modal("show");
        });
  });
  //fin verEntrega

  //editar
  function editar() {

    $("#btnEditar").unbind("click");
    $("#btnEditar").click(function() {

        //Variables creadas para editar mejor poner siempre "New" variable

        let txtEdit = txtVal('formularioEditar');
        let idT = $("#btnEditar").data("idTi");
        let formDataEdit = new FormData ( $('#formularioEditar')[0] );
        formDataEdit.append ('peticion', 'actualizar');
        formDataEdit.append ('id', idT);
        //Aqui poner que hayan letras en los campos
        if (txtEdit) {
          $('#btnEditar').addClass( "btn disabled btn-info btn-progress" ).html('Cargando').attr('disabled','disabled');
          $.ajax({
            type: "POST",
            url: "../../controllers/auxiliarFacturacion/entregasControllers.php",
            data: formDataEdit,
            cache:false,
            contentType:false,
            processData:false,
            dataType: 'JSON'
          }).done(function(data) {
            if (data['exito']) {
              tabla.ajax.reload();
              $('#formularioEditar')[0].reset();  
              $("#modalEditar").modal("hide");
              alert_success(data['msj']);
              $('#btnEditar').removeClass( "disabled btn-progress" ).html('Guardar cambios').removeAttr('disabled','disabled');
            } else {
              $('#btnEditar').removeClass( "disabled btn-progress" ).html('Guardar cambios').removeAttr('disabled','disabled');
              alert_error(data['msj']);
            }
          });
        } else {
          alert_error("Por favor llene todos los campos");
        }
      });
  }
  //fin editar

  //eliminar 
  var eliminarSi = {
    "funcion" : function(){
      $.ajax({
        type: 'POST',
        url: '../../controllers/auxiliarFacturacion/entregasControllers.php',
        data: {
          peticion : 'eliminar',
          id : eliminarSi['params']
        },
        dataType: 'JSON'
      }).done(function( data ){
        if ( data['exito'] ) {
          alert_success( data['msj'] );
          tabla.ajax.reload();
        }else{
          alert_error( data['msj'] );
        }
      });
    },
    "params" : ""
  }

  function eliminar(){
    $("#tabla").find("button.eliminar").each(function(){
      $(this).unbind("click");
      $(this).click(function(){
        eliminarSi['params'] = $(this).attr("data-idT");
        deleteds( "<h3>Desactivar encargo</h3>", "<h4><i class='fas fa-check-double'></i> ¿Seguro que desea desactivar el encargo ?</h4>", eliminarSi['funcion'] , null );
      });
    });
  };
  //fin eliminar 


});