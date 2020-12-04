

  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
   <input type="hidden" id="id_factura" name="id_factura" value="{{$factura->id}}">
   <input type="hidden" id="valor" name="valor" value="{{$valor}}">
   <input type="hidden" id="valor_pagar" name="valor_pagar" value="{{$factura->valor_total}}">
   <input type="hidden" id="estado_abono" name="estado_abono" value="{{$factura->abono}}">
   <input type="hidden" id="valor_abonar" name="valor_abonar" value="{{$valorAbono}}">
   <input type="hidden" id="fecha_pago" name="fecha_pago" value="{{$fecha}}">
   <input type="hidden" id="propietarios" name="propietarios" value="{{$factura->propietario}}">

    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="feLastName">No. Factura</label>
        <input type="text" maxlength="100" class="form-control" id="id_factura" name="id_factura"  value="{{$factura->id}}" disabled>
      </div>
      <div class="form-group col-md-4">
        <label for="feLastName">Propietario</label>
        <input type="text" maxlength="10" class="form-control" id="propietario" name="propietario" value="{{$factura->propietario}}" disabled>
      </div>
      <div class="form-group col-md-2">
        <label for="feLastName">Valor Factura</label>
        <input type="text" maxlength="10" class="form-control" id="valor_total" name="valor_total" value="${{  number_format(($factura->valor_total + $factura->mora) , 0) }}" disabled>
      </div>
       <div class="form-group col-md-2">
        <label for="feLastName">Valor Abono</label>
        <input type="text" maxlength="10" class="form-control" id="valor_abono" name="valor_abono" value="0">
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
    <button onclick="realizarAbonoFactura({{ ($factura->valor_total + $factura->mora) }})" class="btn btn-success" >Ok Registrar Abono Factura</button>
