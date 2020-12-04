
<form  method="post"  action="{{ url("configuracion/editar_cargo") }}" id="f_editar_cargo"   >

      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
      <input type="hidden" name="id_cargo" value="{{$cargo->id}}"> 
                       
                            <div class="form-row">
                             
                              <div class="form-group col-md-12">
                                <label for="feLastName">Detalle del Cargo</label>
                                <input type="text" maxlength="100" class="form-control" id="detalle" name="detalle"  value="{{$cargo->cargo}}" required>
                              </div>

                               <div class="form-group col-md-12">
                                <label for="feLastName">Valor</label>
                                <input type="number" maxlength="15" class="form-control" id="valor" name="valor" value="{{$cargo->valor_default}}" required >
                              </div>

                            </div>

                
                         
                            <button type="submit" class="btn btn-accent" >Guardar Datos</button>
</form>
