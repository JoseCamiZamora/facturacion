

<form  method="post"  action="pagar_factura" id="f_pagar_factura"   >

  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
   <input type="hidden" id="id_factura" name="id_factura" value="{{$factura->id}}">
   <input type="hidden" id="valor" name="valor" value="{{$valor}}">
   <input type="hidden" id="fecha_pago" name="fecha_pago" value="{{$fecha}}">

    <div class="form-row">
      <div class="form-group col-md-5">
        <label for="feLastName">Forma de pago</label>
       <select class="form-control" id="tipo_pago" name="tipo_pago" required>
            <option value="" selected >Selccione...</option>
            <option value="1" >En efectivo</option>
            <option value="2" >En entidad bancaria</option>
          </select>
      </div>
      <div class="form-group col-md-7">
        <label for="feLastName">Referencia de pago</label>
        <input type="text" maxlength="30" class="form-control" id="ref_pago" name="ref_pago" value="" >
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="feLastName">No. Factura</label>
        <input type="text" maxlength="100" class="form-control" id="id_factura" name="id_factura"  value="{{$factura->id}}" disabled>
      </div>
      <div class="form-group col-md-6">
        <label for="feLastName">Propietario</label>
        <input type="text" maxlength="10" class="form-control" id="propietario" name="propietario" value="{{$factura->propietario}}" disabled>
      </div>
      <div class="form-group col-md-2">
        <label for="feLastName">Valor</label>
        <input type="text" maxlength="10" class="form-control" id="valor" name="valor" value="{{$factura->valor_total}}" disabled>
      </div>
      <div class="form-group col-md-2">
        <label for="feLastName">Fecha de pago</label>
        <input type="text" maxlength="5" class="form-control" id="fecha_pago" name="fecha_pago" value="{{$fecha}}" disabled >
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
    <button type="submit" class="btn btn-success" >Ok Registrar Pago Factura</button>
</form>