

<form  method="post"  action="editar_factura" id="f_editar_factura"   >

  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
   <input type="hidden" id="id" name="id" value="{{$factura->id}}">

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="feLastName">Nombres y Apellidos</label>
        <input type="text" maxlength="100" class="form-control" id="propietario" name="propietario"  value="{{$factura->propietario}}" required>
      </div>
      <div class="form-group col-md-2">
        <label for="feLastName">Mz</label>
        <input type="text" maxlength="10" class="form-control" id="mz" name="mz" value="{{$factura->mz}}" >
      </div>
      <div class="form-group col-md-2">
        <label for="feLastName">Casa</label>
        <input type="text" maxlength="10" class="form-control" id="casa" name="casa" value="{{$factura->casa}}" >
      </div>
      <div class="form-group col-md-2">
        <label for="feLastName">Apto</label>
        <input type="text" maxlength="10" class="form-control" id="apto" name="apto" value="{{$factura->apto}}" >
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="exampleFormControlTextarea1">Observaciones</label>
        <textarea class="form-control" maxlength="1000"  id="observaciones" name="observaciones" value="{{$factura->observaciones}}" rows="4">{{$factura->observaciones}}</textarea>
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
    <button type="submit" class="btn btn-accent" >Actualizar Datos</button>
</form>


                    