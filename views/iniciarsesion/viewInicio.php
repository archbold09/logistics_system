<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/favicon.png">
  <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../vendors/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="//cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="../../node_modules/toastr/build/toastr.min.css">
  <title> INICIAR SESIÓN </title>
</head>
<body>

  <div id="app">
    <v-app>
      <v-content>
        <v-container class="fill-height" fluid>
          <v-row align="center" justify="center" >
            <v-col md="7" sm="12">
              <v-card class="mt-6 mb-6">
                <v-row justify="center" align="center">
                  <img width="300" class="img-responsive" src="../../assets/img/logo.png" alt="">
                </v-row>
                <v-row justify="center" align="center">
                  <v-card-title style="padding-bottom:0px;" class="font-weight-bold">Iniciar sesión</v-card-title>
                </v-row>

                <form id="formLogin" class="form-signin" autocomplete="off">
                  <v-card-text>
                    <v-col cols="12">
                      <v-text-field v-model="numeroDocumento" :rules="reglasnumeroDocumento" :counter="30" outlined label="Documento" name="numeroDocumento" id="numeroDocumento" prepend-icon="mdi-account" type="text" required></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field v-model="contrasenia" :rules="reglascontrasenia" :counter="30" outlined label="Contraseña" name="contrasena" id="contrasena" prepend-icon="mdi-lock" type="password" required></v-text-field>                     
                    </v-col>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary btn-lg btn-block" id="btnLog">Ingresar</button>
                      <div id="text-error"></div>
                    </div>
                  </v-card-text>
                </form>
                
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-content>
    </v-app>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
  <script src="../../vendors/jquery/jquery-3.2.1.min.js"></script>
  <script src="../../vendors/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="../../node_modules/toastr/build/toastr.min.js"></script>

  <script>
    new Vue({
      el:'#app',
      vuetify: new Vuetify(),
      data: () => ({
        icons:[
        {icon:'mdi-facebook'},
        {icon:'mdi-instagram'},
        {icon:'mdi-youtube'}    
        ],
        drawer: false,

        numeroDocumento:'',
        contrasenia: '',

        reglasnumeroDocumento:[
        v => !!v || '¡Campo obligatorio!',
        v => v.length >= 3 || 'Minimo 3 caracteres',
        ],

        reglascontrasenia: [
        v => !!v || '¡La contraseña es obligatoria!',
        v => v.length >= 6 || 'Minimo 6 caracteres',
        ],
        

        dialog: false,
        colors: [
        'primary',
        'secondary',
        'yellow darken-2',
        'red',
        'orange',
        ]
      })
    })
  </script>
  <!--Ajax Login-->
  <script>
    $(document).ready(function(){
      $.getScript( "../../assets/js/validaciones.js" );

      let frm_login = $("#formLogin");

      frm_login.on("submit", function(e){

        e.preventDefault();
        
        //Button
        $('#btnLog').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Cargando...').attr('disabled', true);  
        $.ajax({
          type : 'post',
          url : './inicio_session.php',
          data : $("#formLogin").serialize(),
          dataType : 'json',
        }).done(function(data){
          if ( data.exito ) {
            toastr.clear();
            alert_success(data.msj);
            setTimeout(() => {
              window.location.href = data.href;
            }, 1000);
          } else {
            $('#btnLog').html('<button type="submit" id="btnLog" class="btn btn-primary btn-lg btn-block">Ingresar</button>').removeAttr('disabled',true);
            $('#text-error').html('<p class="lead red--text pt-5" id="text-error"> <span class="mdi mdi-alert-circle"></span> Usuario o contraseña incorrecta.</p>').removeAttr('disabled',true);
            alert_error(data.msj);
          }
        });
      });
    });
  </script>

</body>
</html>
