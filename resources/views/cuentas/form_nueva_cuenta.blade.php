<form  method="post"  action="crear_cuenta" id="f_crear_cuenta"   >
  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="feLastName">Identificación</label>
        <input type="text" maxlength="12" class="form-control" id="identificacion" name="identificacion" value="" >
      </div>
      <div class="form-group col-md-6">
        <label for="feLastName">Nombres y Apellidos</label>
        <input type="text" maxlength="100" class="form-control" id="propietario" name="propietario"  value="" required>
      </div>
      <div class="form-group col-md-3">
        <label for="feLastName">Telefono</label>
        <input type="text" maxlength="12" class="form-control" id="telefono" name="telefono" value="" >
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-1">
        <label for="feLastName">Mz</label>
        <input type="text" maxlength="10" class="form-control" id="mz" name="mz" value="" >
      </div>
      <div class="form-group col-md-1">
        <label for="feLastName">Casa</label>
        <input type="text" maxlength="10" class="form-control" id="casa" name="casa" value="" >
      </div>
      <div class="col-md-3">
         <label for="feLastName">Tipo vivenda</label>
          <select class="form-control" id="select_mes_val" id="tipo_vivienda" name="tipo_vivienda" required>
            <option value="" selected >Seleccione......</option>
            <option  value="PROPIA">PROPIA</option>
            <option  value="ARRENDAMINETO">ARRENDAMINETO</option>
           
          </select>
      </div>
      <div class="form-group col-md-4">
        <label for="feLastName">Correo</label>
        <input type="text" maxlength="100" class="form-control" id="email" name="email" value="" >
      </div>
      
      <div class="form-group col-md-3">
        <label for="feLastName">Ciudad</label>
        <input type="text" maxlength="50" class="form-control" id="ciudad" name="ciudad" value="" >
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="exampleFormControlTextarea1">Observaciones</label>
        <textarea class="form-control" maxlength="1000"  name="observaciones" value="" rows="2"></textarea>
      </div>
    </div>
    <div class="form-row">
      <label for="feLastName">Agregar vehiculos al propietario o arrendatario <label style="font-size: 18px;color: red">*</label></label>
      <table class='table table-generic table-strech'>
        <thead class="bg-light">
          <th scope="col" colspan="13" class="th-gris text-right"   >  
            <a href="javascript:void(0);" onclick="agregar_vehiculos();" class="mb-2 btn btn-sm btn-primary mr-1" >
            <i class="fas fa-plus margin-icon" aria-hidden="true">
            </i>Adicionar Vehiculos</a> 
          </th>
        </thead>
         <thead class="bg-light">
            <th style="width: 10px;">No.</th>
            <th style="width: 200px;">Marca</th>
            <th style="width: 150px;">Linea</th>
            <th style="width: 100px;">Placa</th>
            <th style="width: 20px;" >-</th>
         </thead>
        <tbody  id="t_body_vehiculos">

        </tbody>
      </table>
     </div>
     <div class="form-row">
      <label for="feLastName">Agregar motos al propietario o arrendatario<label style="font-size: 18px;color: red;">*</label></label>
      <table class='table table-generic table-strech'>
          <thead class="bg-light">
          <th scope="col" colspan="13" class="th-gris text-right"   >  
            <a href="javascript:void(0);" onclick="agregar_motos();" class="mb-2 btn btn-sm btn-primary mr-1" >
            <i class="fas fa-plus margin-icon" aria-hidden="true">
            </i>Adicionar Motocicletas</a> 
          </th>
        </thead>
         <thead class="bg-light">
            <th style="width: 5px;">No.</th>
            <th style="width: 200px;">Marca</th>
            <th style="width: 150px;">Linea</th>
            <th style="width: 100px;" >Placa</th>
            <th style="width: 20px;" >-</th>
         </thead>
        <tbody  id="t_body_motos">

        </tbody>
         
      </table>
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
    <button type="submit" class="btn btn-accent" >Guardar Datos</button>
</form>


                    