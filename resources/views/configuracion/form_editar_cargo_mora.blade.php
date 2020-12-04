

<form  method="post"  action="{{ url("configuracion/editar_cargo_mora") }}" id="f_editar_cargo_mora"   >

      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
      <input type="hidden" name="id_cargo" value="{{$cargo->id}}"> 
                       
                            <div class="form-row">
                             
                              <div class="form-group col-md-12">
                                <label for="feLastName">Detalle del Cargo</label>
                                <input type="text" maxlength="100" class="form-control" id="detalle" name="detalle"  value="{{$cargo->cargo}}" required>
                              </div>

                                 <div class="col-md-5">
                                    <label for="feLastName">Tipo de Factura</label>
									 <select class="form-control" id="select_mes_val" id="tipo_factura" name="tipo_factura" required>
									            <option value="" selected  disabled >Seleccione......</option>
									            @foreach($valores as $valore)

                                @if( $valore->tipo_cuenta == $cargo->tipo_factura )
                                  <option value="{{$valore->tipo_cuenta}}" selected="selected" >{{$valore->nombre}}</option>
                                @endif
									                <option  value="{{$valore->tipo_cuenta}}">{{$valore->nombre}}</option>

									            @endforeach
									 </select>
                                </div>

                              <div class="form-group col-md-12">
                                <label for="feLastName">Valor</label>
                                <input type="number" maxlength="15" class="form-control" id="valor" name="valor" value="{{$cargo->valor_default}}" required >
                              </div>

                            </div>

                
                         
                            <button type="submit" class="btn btn-accent" >Guardar Datos</button>
</form>
