
<form  method="post"  action="{{ url("nuevo_comunicado") }}" id="f_nuevo_comunicado"   >
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
    <div class="form-row">
    	<div class="form-group col-md-6">
         <label for="feLastName">Estado del comunicado</label>
          <select class="form-control" id="estado" name="estado" required>
            <option value="" selected >Seleccione......</option>
            <option  value="A">ACTIVO</option>
            <option  value="I">INCATIVO</option>
          </select>
      </div>
      <div class="form-group col-md-12">
        <label for="feLastName">Detalle Comunicados</label>
         <textarea class="form-control" maxlength="1000"  name="observaciones" value="" rows="4" required></textarea>
      </div>
      
    </div>
    <button type="submit" class="btn btn-accent" >Guardar Datos</button>
</form>
