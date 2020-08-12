$(document).ready(function() {
  //Script de validaciones
  $.getScript( "../../assets/js/validaciones.js" );
  //Variables globales
  var tabla;

  //BOTON AGREGAR
  $("#btnAgregar").click(function() {
      //Variables recibidas

      var txt = txtVal("formAgregar");
      var number = numberVal("formAgregar");
      var select = selectVal("formAgregar");
      var formData = new FormData( $("#formAgregar")[0] );
      formData.append("peticion","agregar");

      if (txt && number && select) {
        $.ajax({
          type: "POST",
          url: "../../controllers/usuariosControllers.php",
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'JSON'
        }).done(function(data) {
          if (data['exito']) {
            //Envia los datos por ajax para que se carguen
            $("#formAgregar")[0].reset();
            $("#modalAgregar").modal("hide")
            tabla.ajax.reload();
            alert_success(data['msj']);
          } else {
            alert_error(data['msj']);
          }
        });
      } else {
        alert_warning("Por favor llene todos los campos");
      }
    });

  //LISTAR
  function tabla_usuarios() {
    tabla = $('#tabla').DataTable({
      "select": true,
      "searching": true,
      "bDeferRender": true,
      "sPaginationType": "full_numbers",
      "ajax": {
        "url": "../../controllers/usuariosControllers.php",
        "type": "POST",
        "data": {
          peticion: "listar"
        },
        "dataSrc": function(json) {
          let datos = json.data;
          if (datos.length > 0) {
            return json.data;
          } else {
            alert_warning("No hay datos");
          }
        }
      },
        //Aqui se agregan las columnas de la tabla Para el TBODY
        "columns": [
        { "data": "Nombre" },
        { "data": "Apellido" },
        { "data": "Tipo de documento" },
        { "data": "Número documento" },
        { "data": "Tipo de usuario" },
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
        //Aqui llamo las funciones para que se ejecuten
        delete_usuario();
        consultar();
      });
  }

  // FUNCION ANONIMA
  $(function() {
      //Aqui se configura el URL
      let archivo = "viewUsuario.php";
      let pathname = window.location.pathname;
      let array = pathname.split("/");
      let archivo2 = array.pop();

      if (archivo == archivo2) {
        $("li.usuarios").addClass('active');
        if ($.fn.dataTable.isDataTable('#tabla')) {
          tabla.destroy();
          tabla_usuarios();
        } else {
          tabla_usuarios();
        }
      }
    });
  
  //CONSULTAR
  function consultar() {

    $("#tabla").find("button.editar").each(function() {
      $(this).unbind("click");
      $(this).click(function() {
        let idT = $(this).attr("data-idT");

        $.ajax({
          type: "POST",
          url: "../../controllers/usuariosControllers.php",
          data: {
            id: idT,
            peticion: 'consultar'
          },
          dataType: 'JSON'
        }).done(function(data) {
          if (data['exito']) {
            $("#btnEditar").data("idTi", data['msj']['id']);
            $("#nombreEdit").val(data['msj']['nombre']);
            $("#apellidoEdit").val(data['msj']['apellido']);
            $("#tipoDocumentoEdit").val(data['msj']['tipoDocumento']);
            $("#numeroDocumentoEdit").val(data['msj']['numeroDocumento']);
            $("#contrasenaEdit").val(data['msj']['contrasena']);
            $("#rolUsuarioEdit").val(data['msj']['rolUsuario']);

              //Esto es para mostrar el modal
              $("#modalEditar").modal("show");

              editar();
            } else {
              alert(data['msj']);
            }
          });
      });
    });
  }
  
  //EDITAR
  function editar() {

    $("#btnEditar").unbind("click");
    $("#btnEditar").click(function() {
        //Variables creadas para editar mejor poner siempre "New" variable
        let newnombre = $("#nombreEdit").val();
        let newapellido = $("#apellidoEdit").val();
        let newtipoDocumento = $("#tipoDocumentoEdit").val();
        let newnumeroDocumento = $("#numeroDocumentoEdit").val();
        let newrolUsuario = $("#rolUsuarioEdit").val();
        let idT = $("#btnEditar").data("idTi");
        //Aqui poner que hayan letras en los campos
        if (newnombre.length > 0 && newapellido.length > 0 && newtipoDocumento.length > 0 && newnumeroDocumento.length > 0 && newrolUsuario.length > 0 ) {
          $.ajax({
            type: "POST",
            url: "../../controllers/usuariosControllers.php",
            data: {
              newnombre:newnombre,
              newapellido:newapellido ,
              newtipoDocumento:newtipoDocumento ,
              newnumeroDocumento:newnumeroDocumento ,
              newrolUsuario: newrolUsuario,
              id: idT,
              peticion: 'actualizar'
            },
            dataType: 'JSON'
          }).done(function(data) {
            if (data['exito']) {
              tabla.ajax.reload();
              $("#modalEditar").modal("hide");
              alert_success(data['msj']);
            } else {
              alert_error(data['msj']);
            }
          });
        } else {
          alert_error("Por favor llene todos los campos");
        }
      });
  }
  
  //Eliminar 
  var eliminarSi = {
    "funcion" : function(){
      $.ajax({
        type: 'POST',
        url: '../../controllers/usuariosControllers.php',
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
  //funcion eliminar Programa
  function delete_usuario(){
    $("#tabla").find("button.eliminar").each(function(){
      $(this).unbind("click");
      $(this).click(function(){
        eliminarSi['params'] = $(this).attr("data-idT");
        deleteds( "<h3>Eliminar usuario</h3>", "<h4><i class='fas fa-check-double'></i> ¿Seguro que desea eliminar el usuario?</h4><h4><i class='fas fa-check-double'></i> Si elimina no podrá recuperar los datos</h4>", eliminarSi['funcion'] , null );
      });
    });
  };
});