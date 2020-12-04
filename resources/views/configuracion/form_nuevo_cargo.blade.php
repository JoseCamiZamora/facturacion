

<form  method="post"  action="{{ url("configuracion/nuevo_cargo") }}" id="f_nuevo_cargo"   >

      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
                       
                            <div class="form-row">
                             
                              <div class="form-group col-md-12">
                                <label for="feLastName">Detalle del Cargo</label>
                                <input type="text" maxlength="100" class="form-control" id="detalle" name="detalle"  value="" required>
                              </div>

                               <div class="form-group col-md-12">
                                <label for="feLastName">Valor</label>
                                <input type="number" maxlength="15" class="form-control" id="valor" name="valor" value="" required >
                              </div>

                            </div>

                
                         
                            <button type="submit" class="btn btn-accent" >Guardar Datos</button>
</form>
