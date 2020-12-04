@extends('layouts.app')

@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class='container'>
  <div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo Cuentas </span>
  
        <h4 class="page-title" >Listado General de cuentas inactivas  <span style='font-size: 0.6em;'></span> </h4>
     
       <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
        Atrás
        <a href="{{ url('home') }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
      </div>
    </div>
  </div>
  <!-- End Page Header -->

  <!-- Default Light Table -->

  <div class="row">
    <div class="col">

      <a  href="{{ url('cuentas/listado_cuentas') }}" class="mb-2 btn btn-sm btn-primary mr-1 " ><i class="fa fa-users margin-icon" aria-hidden="true" ></i>Cuentas Activas</a>
      <!-- <a  href="{{ url('cuentas/listado_cuentas_inactivas') }}" class="mb-2 btn btn-sm btn-primary mr-1 " ><i class="fa fa-users margin-icon" aria-hidden="true" ></i>Cuentas Inactivas</a> -->
      <a  href="{{ url('cuentas/listado_cuentas_congeladas') }}" class="mb-2 btn btn-sm btn-primary mr-1 " ><i class="fa fa-users margin-icon" aria-hidden="true" ></i>Cuentas Congeladas</a>

    </div>
  </div>
 <form  method="post"  action="{{ url('cuentas/buscar_cuenta_inactivas') }}" id="f_buscar_cuenta"   >
        <input type="hidden" name="_token" id='_token_avatar' value="<?php echo csrf_token(); ?>">    
          <div class="input-group mb-3">
            <input type="text" id='dato_buscadoDBP' name='dato_buscado' required class="form-control" style='background-color: white !important;' placeholder="Buscar cuenta direccion  o datos aquí...." aria-label="Buscar insumo" aria-describedby="basic-addon2">
            <input type="hidden" id='busdbp_pagina' name='busdbp_pagina' value='1'  >
            <input type="hidden" id='busdbp_next' name='busdbp_next' value='0'  >
            <div class="input-group-append">
              <button class="btn btn-white" type="submit">Buscar</button>
              @if(isset($busqueda))
              <a href="{{ url('cuentas/listado_cuentas_inactivas') }}" class="btn btn-white  btn-azul"   >
                  <i class="fas fa-undo icon-color_blanco" title="deshacer busqueda"></i>
              </a>
              @endif
            </div>
          </div>
    </form>

  <div class="row">
    <div class="col">
     
      <table    class='table table-generic' >

            <thead class="bg-light">
              <tr>

                <th scope="col" class="th-gris text-center" style="width: 20px;">No.</th>
                <th scope="col" class="th-gris text-left" style="width: 10px;">Mz</th>
                <th scope="col" class="th-gris text-left" style="width: 10px;">Casa</th>
                <th scope="col" class="th-gris text-left" style="width: 10px;">Apto</th>
                <th scope="col" class="th-gris text-left " style="width: 150px;"  >Propietario</th>
                <th scope="col" class="th-gris text-left " style="width: 80px;">Observaciones</th>
                <th scope="col" class="th-gris text-center" style="width: 1px;">Activar</th>
            
              </tr>
            </thead>
            <tbody>

             @foreach($cuentas as $cuenta)
                <tr>
                  <td class='text-center' >{{ $cuenta->id}}</td>
                  <td class='td-titulo'>{{ $cuenta->mz }}</td>
                  <td class='td-titulo'  >{{ $cuenta->casa }}</td>
                  <td class='td-titulo'  >{{ $cuenta->apto }}</td>
                  <td class='text-left'  >{{ $cuenta->propietario }}</td>
                   <td class='text-left'  >{{ $cuenta->observaciones }}</td>
                   <td>
                   <a class="nav-link nav-link-icon text-center"  role="button" id="subirfile" onclick="activarCuentas({{$cuenta->id}})" >
                      <div class="nav-link-icon__wrapper">
                        <i class="fa fa-check" title="Editar"></i><br>
                        
                      </div>
                    </a>
                    </td>
                </tr>

              @endforeach
            </tbody>
               <tfoot>
              <tr>
                 
                   <td colspan='4'><span style='font-size:0.9em'><b>Total:</b> {{ $cuentas->count() }} Cuentas</span></td>
                 
              </tr>
              </tfoot>
          </table>
         </div> 

  </div>
</div>
  <!-- End Default Light Table -->
</div>

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_activar_cuentas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Inactivar Cuenta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_cuentas_a" style='min-height: 400px;'>
      </div>
    </div>
  </div>
</div>

@endsection