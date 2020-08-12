<!-- Modal respuesta -->
<div class="modal fade" id="modalRespuesta">
  <div class="modal-dialog" role="document" style="max-width:1300px">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"> <b> Respuesta del encargo </b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="container datosEncargo">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table text-center table-bordered" id="tablaProductoRespuesta"> 
                  <thead>
                    <tr>
                      <th>Material</th>
                      <th>Descripción</th>
                      <th>Cantidad</th>
                    </tr>
                  </thead>
                  <tbody id="contenedorRespuesta" class="text-center">

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" id="btnGuardarRespuesta" class="btn btn-info">Guardar</button>
          <button type="button" data-dismiss="modal" class="btn btn-outline-danger">Cancelar</button>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- fin modal respuesta -->

<!-- Modal Ver -->
<div class="modal fade" id="modalVer">
  <div class="modal-dialog" role="document" style="max-width:1300px">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"> <b> Datos del encargo </b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
          <div class="container datosEncargo">
            <div class="row">

              <div class="pt-4 col-md-2">
                <label>Código</label>
                <input type="text" class="form-control" disabled="disabled" name="codigoVer" id="codigoVer">
              </div>

              <div class="pt-4 col-md-3">
                <label>Descripción encargo</label>
                <input type="text" class="form-control" disabled="disabled" name="nombreVer" id="nombreVer">
              </div>

              <div class="pt-4 col-md-3">
                <label>Vehículo</label>
                <input type="text" class="form-control" disabled="disabled" name="vehiculoVer" id="vehiculoVer">
              </div>

              <div class="pt-4 col-md-2">
                <label>Fecha creado</label>
                <input type="text" class="form-control" disabled="disabled" name="fechaCreadoVer" id="fechaCreadoVer">
              </div>

              <div class="pt-4 col-md-2">
                <div class="input-group-prepend">
                  <label>Estado</label>
                </div>
                <select id="estadoVer" name="estadoVer" disabled="disabled" class="custom-select">
                  <option value="0">Seleccionar..</option>
                  <?php foreach( $listarEstado as $item ): ?>
                    <option value="<?php echo $item['id'] ?>"><?php echo utf8_encode($item['nombre'])?> </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="pt-4 col-md-12">

                <div class="table-responsive">
                  <table class="table  text-center table-bordered" id="tablaProductoVer"> 
                    <thead>
                      <tr>
                        <th>Material</th>
                        <th>Descripción</th>
                      </tr>
                    </thead>
                    <tbody id="contenedorVer" class="text-center">

                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-outline-danger">Cancelar</button>
          </div>
      </div>

    </div>
  </div>
</div>
<!-- fin modal Ver -->