

<form  method="post"  action="{{ url('agregar_cargos_factura')}}" id="f_cargos_factura"   >

  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
   <input type="hidden" id="id" name="id" value="{{$factura->id}}">

    <div class="form-row">


      <div class="form-group col-md-8">
        <label for="feLastName">Cargos de Facturas</label>
          <select class="form-control" id="select_mes_val" name="id_cargo" required>
            <option value="" selected disabled >Seleccione......</option>
            @foreach($cargos as $cargo)
              <option  value="{{$cargo->id}}">{{$cargo->cargo}}</option>
            @endforeach
          </select>
    
      </div>


      <div class="form-group col-md-4">
        <label for="feLastName">Valor $</label>
        <input type="number" maxlength="10" class="form-control"  name="valor" value="0" required>
      </div>
   
    </div>
 


     @if ($errors->count() > 0)
    <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
    </div>
    @endif
    <button type="submit" class="btn btn-accent" >Guardar Datos del Cargo</button>
</form>