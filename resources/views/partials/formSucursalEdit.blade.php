<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <strong class="modal-title" id="exampleModalLabel">Editar Sucursal</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
        <div>
            <form method="POST" action="{{ route('sucursales/edit') }}">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">ID</span>
                        </div>
                        <input type="text" class="form-control" name="id" require value="{{ old('id',$sucursal['id']) }}" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
                        </div>
                        <input type="text" class="form-control" name="nombre" require value="{{ old('name',$sucursal['name']) }}">
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitches" name="estatus" @if($sucursal['status'] == 1) checked @endif>
                        <label class="custom-control-label" for="customSwitches">Estatus</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
