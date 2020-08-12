<!--Modal Agregar-->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> <i class="material-icons">add_box</i> <b>Agregar</b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAgregar">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tipo de documento</label>
                    <select class="custom-select" id="tipoDocumento" name="tipoDocumento">
                        <option selected>Seleccionar...</option>
                        <?php foreach( $listarDocumento as $item ): ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo utf8_encode($item['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Número de documento</label>
                    <input type="number" class="form-control" id="numeroDocumento" name="numeroDocumento">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tipo de usuario</label>
                    <select class="custom-select" id="rolUsuario" name="rolUsuario">
                        <option selected>Seleccionar...</option>
                    <?php foreach( $listarRolUsuario as $item ): ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo utf8_encode($item['nombre']) ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena">
                </div>
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


<!--Modal Editar-->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> <i class="material-icons">edit</i> <b>Editar</b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formEditar">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nombre</label>
                    <input type="text" class="form-control" id="nombreEdit" name="nombreEdit">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Apellido</label>
                    <input type="text" class="form-control" id="apellidoEdit" name="apellidoEdit">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tipo de documento</label>
                    <select class="custom-select" id="tipoDocumentoEdit" name="tipoDocumentoEdit">
                        <option selected>Seleccionar...</option>
                        <?php foreach( $listarDocumento as $item ): ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo utf8_encode($item['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Número de documento</label>
                    <input type="number" class="form-control" id="numeroDocumentoEdit" name="numeroDocumentoEdit">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tipo de usuario</label>
                    <select class="custom-select" id="rolUsuarioEdit" name="rolUsuarioEdit">
                        <option selected>Seleccionar...</option>
                    <?php foreach( $listarRolUsuario as $item ): ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo utf8_encode($item['nombre']) ?></option>
                    <?php endforeach; ?>
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