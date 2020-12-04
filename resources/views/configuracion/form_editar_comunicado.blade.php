
<form  method="post"  action="{{ url("configuracion/editar_comunicado") }}" id="f_editar_comunicado"   >
	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
	<input type="hidden" name="id_comunicado" value="{{$valor->id}}"> 
        <div class="form-row">

        <div class="form-group col-md-6">
         <label for="feLastName">Estado del comunicado</label>
          <select class="form-control" id="estado" name="estado" required>
            <option value="{{$valor->estado}}" selected >{{$estado}}</option>
            <option  value="A">ACTIVO</option>
            <option  value="I">INCATIVO</option>
          </select>
      </div>
      <div class="form-group col-md-12">
        <label for="feLastName">Detalle Comunicados</label>
         <textarea class="form-control" maxlength="1000"  name="observaciones" value="{{$valor->descripcion}}" rows="4" required>{{$valor->descripcion}}</textarea>
      </div>
         
        <button type="submit" class="btn btn-accent" >Guardar Datos</button>
</form>
