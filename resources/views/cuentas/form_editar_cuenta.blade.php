

<form  method="post"  action="editar_cuenta" id="f_editar_cuenta"   >

  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
   <input type="hidden" id="id" name="id" value="{{$cuenta->id}}">
   <input type="hidden" id="estado" name="estado" value="{{$cuenta->estado}}"> 

    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="feLastName">Identificación</label>
        <input type="text" maxlength="12" class="form-control" id="identificacion" name="identificacion" value="{{$cuenta->identificacion}}" required >
      </div>
      <div class="form-group col-md-6">
        <label for="feLastName">Nombres y Apellidos</label>
        <input type="text" maxlength="100" class="form-control" id="propietario" name="propietario"  value="{{$cuenta->propietario}}" required>
      </div>
      
      <div class="form-group col-md-3">
        <label for="feLastName">Telefono</label>
        <input type="text" maxlength="12" class="form-control" id="telefono" name="telefono" value="{{$cuenta->telefono}}" required >
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-1">
        <label for="feLastName">Mz</label>
        <input type="text" maxlength="10" class="form-control" id="mz" name="mz" value="{{$cuenta->mz}}" >
      </div>
      <div class="form-group col-md-1">
        <label for="feLastName">Casa</label>
        <input type="text" maxlength="10" class="form-control" id="casa" name="casa" value="{{$cuenta->casa}}" >
      </div>
      <div class="col-md-3">
         <label for="feLastName">Tipo de vivienda</label>
          <select class="form-control" id="select_mes_val" id="tipo_vivienda" name="tipo_vivienda">
            <option value="{{$cuenta->tipo_vivienda}}" selected >{{$cuenta->tipo_vivienda}}</option>
           
               <option  value="PROPIA">PROPIA</option>
            <option  value="ARRENDAMINETO">ARRENDAMINETO</option>
              
          </select>
      </div>
      <div class="form-group col-md-4">
        <label for="feLastName">Correo</label>
        <input type="text" maxlength="100" class="form-control" id="email" name="email" value="{{$cuenta->email}}" >
      </div>
     
      <div class="form-group col-md-3">
        <label for="feLastName">Ciudad</label>
        <input type="text" maxlength="50" class="form-control" id="ciudad" name="ciudad" value="{{$cuenta->ciudad}}" >
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="exampleFormControlTextarea1">Observaciones</label>
        <textarea class="form-control" maxlength="1000"  id="observaciones" name="observaciones" value="{{$cuenta->observaciones}}" rows="2">{{$cuenta->observaciones}}</textarea>
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

          @foreach($vehiculosSEL as $insSEL)
          <?php  $rowcount=$loop->index+1; ?>

          <tr id="row_insumo_v{{$rowcount}}">
            <td>
             <input  id='nov_{{$rowcount}}'  class='i-readonly' readonly  name='nov[{{$rowcount}}]' value='{{$insSEL->id}}' style='width:100%; text-align: center;' />
            </td>
            <td>
              <input  type='text'  class='t-marca' id='marcav_{{$rowcount}}' name='marcav[{{$rowcount}}]' value='{{$insSEL->marca}}' style='width:100%' />
            </td>
            <td>
              <input  type='text'  class='t-linea' id='lineav_{{$rowcount}}' name='lineav[{{$rowcount}}]' value='{{$insSEL->linea}}' style='width:100%' />
            </td>
            <td>
             <input  type='text'  class='t-placa' id='placav_{{$rowcount}}' name='placav[{{$rowcount}}]' value='{{$insSEL->placa}}' style='width:100%' />
            </td>
            <td>
             <a href='javascript:void(0);'  style='display:block;' onclick='borrar_vehiculos({{$rowcount}});'><i class='fas fa-times'></i></a>
            </td>
          </tr>
          @endforeach
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
            <th style="width: 10px;">No.</th>
            <th style="width: 200px;">Marca</th>
            <th style="width: 150px;">Linea</th>
            <th style="width: 100px;">Placa</th>
            <th style="width: 20px;" >-</th>
        </thead>
        <tbody  id="t_body_motos">

          @foreach($motosSEL as $motoSEL)
          <?php  $rowcount=$loop->index+1; ?>

          <tr id="row_insumo_m{{$rowcount}}">
            <td>
             <input  id='nom_{{$rowcount}}'  class='i-readonly' readonly  name='nom[{{$rowcount}}]' value='{{$motoSEL->id}}' style='width:100%; text-align: center;' />
            </td>
            <td>
              <input  type='text'  class='t-marca' id='marcam_{{$rowcount}}' name='marcam[{{$rowcount}}]' value='{{$motoSEL->marca}}' style='width:100%' />
            </td>
            <td>
              <input  type='text'  class='t-linea' id='lineam_{{$rowcount}}' name='lineam[{{$rowcount}}]' value='{{$motoSEL->linea}}' style='width:100%' />
            </td>
            <td>
             <input  type='text'  class='t-placa' id='placam_{{$rowcount}}' name='placam[{{$rowcount}}]' value='{{$motoSEL->placa}}' style='width:100%' />
            </td>
            <td>
             <a href='javascript:void(0);'  style='display:block;' onclick='borrar_motos({{$rowcount}});'><i class='fas fa-times'></i></a>
            </td>
          </tr>
          @endforeach
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
    <button type="submit" class="btn btn-accent" >Actualizar Datos</button>
</form>


                    