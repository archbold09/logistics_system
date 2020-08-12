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
              <label> <b>Auxiliar facturación</b> </label>
              <input type="text" readonly class="form-control" value="<?php echo $auxiliarFacturacion ?>">
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

            <div class="pt-4 col-md-2 form-group">
              <div class="input-group-prepend">
                <label>Estado</label>
              </div>
              <select id="estadoVer" name="estadoVer" disabled="disabled" class="form-control">
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
                      <th>Cantidad</th>
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
          <button type="button" id="btnVerEntrega" class="btn btn-success">Ver entrega</button>
          <button type="button" data-dismiss="modal" class="btn btn-outline-danger">Cancelar</button>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- fin modal Ver -->

<!-- Modal Ver eentrega -->
<div class="modal fade" id="modalVerEntrega">
  <div class="modal-dialog" role="document" style="max-width:1300px">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"> <b> Datos de entrega </b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="container datosEncargo">
          <div class="row">
            <div class="pt-4 col-md-12">

              <div class="table-responsive">
                <table class="table table-sm text-center table-bordered" id="tablaProductoVer"> 
                  <thead>
                    <tr>
                      <th>Material</th>
                      <th>Descripción</th>
                      <th>Cantidad verificador</th>
                      <th>Número intentos</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody id="contenedorVerEntrega" class="text-center">

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
<!-- fin modal Ver eentrega -->