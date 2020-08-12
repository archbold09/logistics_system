<!--Modal Agregar-->
<div class="modal fade" id="modalAgregar">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"> <b>Agregar</b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="formulario" class="container">
          <div class="row">

            <div class="col-md-4 mb-3">
              <label> <b>Código</b> </label>
              <input type="text" class="form-control codigo" id="codigo" name="codigo">
            </div>
            
            <div class="col-md-8 mb-3">
              <label> <b>Destino</b> </label>
              <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            
            <div class="col-md-6 mb-3">
              <label> <b>Vehículo</b> </label>
              <input type="text" class="form-control" id="vehiculo" name="vehiculo">
            </div>

            <div class="col-md-6 mb-3">
              <label> <b>Fecha encargo</b> </label>
              <input type="text" readonly class="form-control fecha" id="fechaCreado" name="fechaCreado">
            </div>
            
            <div class="col-md-6 mb-3">
              <label> <b>Auxiliar facturación</b> </label>
              <input type="text" readonly class="form-control" value="<?php echo $auxiliarFacturacion ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label> <b>Verificador</b> </label>
              <select class="custom-select" id="verificador" name="verificador">
                  <option selected>Seleccionar...</option>
                  <?php foreach( $listarVerificador as $item ): ?>
                  <option value="<?php echo $item['id'] ?>"><?php echo utf8_encode($item['content']) ?></option>
                  <?php endforeach; ?>
              </select>
            </div>

            <br>

            <div class="col-md-12 mb-3">
                <label> <b>Datos entrega</b> </label>
                <input type="file" id="datosEncargo" name="datosEncargo">
            </div>

            <!-- <div class="col-md-12 mb-3">
              <label> <b>Datos entrega</b> </label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="datosEncargo" name="datosEncargo">
                <label class="custom-file-label">Seleccionar archivo</label>
              </div>
            </div> -->

          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnAgregar">Agregar</button>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>
<!-- Modal Editar -->
<div class="modal fade" id="modalEditar">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> <i class="material-icons">edit</i> <b>Editar</b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formularioEditar" class="container">
          <div class="row">

            <div class="col-md-4 mb-3">
              <label> <b>Código</b> </label>
              <input type="text" class="form-control" id="codigoEdit" name="codigoEdit">
            </div>
            
            <div class="col-md-8 mb-3">
              <label> <b>Destino</b> </label>
              <input type="text" class="form-control" id="nombreEdit" name="nombreEdit">
            </div>
            
            <div class="col-md-6 mb-3">
              <label> <b>Vehículo</b> </label>
              <input type="text" class="form-control" id="vehiculoEdit" name="vehiculoEdit">
            </div>

            <div class="col-md-6 mb-3">
              <label> <b>Fecha encargo</b> </label>
              <input type="text" readonly class="form-control fecha" id="fechaCreadoEdit" name="fechaCreadoEdit">
            </div>
            
            <div class="col-md-6 mb-3">
              <label> <b>Verificador</b> </label>
              <select class="custom-select" id="verificadorEdit" name="verificadorEdit">
                  <option selected>Seleccionar...</option>
                  <?php foreach( $listarVerificador as $item ): ?>
                  <option value="<?php echo $item['id'] ?>"><?php echo utf8_encode($item['content']) ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            
            <div class="col-md-6 mb-3">
              <label> <b>Estado</b> </label>
              <select class="custom-select" id="estadoEdit" name="estadoEdit">
                <option selected>Seleccionar...</option>
                <option value="3">Activo</option>
                <option value="4">Inactivo</option>                  
                <option value="6">Terminada</option>                  
              </select>
            </div>
            
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnEditar">Guardar cambios</button>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>