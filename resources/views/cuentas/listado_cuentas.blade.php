@extends('layouts.app')

@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class='container'>
  <div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo Cuentas </span>
  
        <h4 class="page-title" >Listado General de cuentas activas  <span style='font-size: 0.6em;'></span> </h4>
     
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

     <a href="javascript:void(0);" onclick="SU_form_crear_cuenta();" class="mb-2 btn btn-sm btn-outline-primary mr-1" ><i class="fa fa-user-plus margin-icon" aria-hidden="true" ></i>Crear Nueva Cuenta</a>
    </div>
  </div>

  <form  method="post"  action="{{ url('cuentas/buscar_cuenta') }}" id="f_buscar_cuenta"   >
        <input type="hidden" name="_token" id='_token_avatar' value="<?php echo csrf_token(); ?>">    
          <div class="input-group mb-3">
            <input type="text" id='dato_buscadoDBP' name='dato_buscado' required class="form-control" style='background-color: white !important;' placeholder="Buscar cuenta direccion  o datos aquí...." aria-label="Buscar insumo" aria-describedby="basic-addon2">
            <input type="hidden" id='busdbp_pagina' name='busdbp_pagina' value='1'  >
            <input type="hidden" id='busdbp_next' name='busdbp_next' value='0'  >
            <div class="input-group-append">
              <button class="btn btn-white" type="submit">Buscar</button>
              @if(isset($busqueda))
              <a href="{{ url('cuentas/listado_cuentas') }}" class="btn btn-white  btn-azul"   >
                  <i class="fas fa-undo icon-color_blanco" title="deshacer busqueda"></i>
              </a>
              @endif
            </div>
          </div>
    </form>

  <div class="row">
    <div class="col">
     
      <table    class='table table-generic table-strech' >

            <thead class="bg-light">
              <tr>
                <th scope="col" class="th-gris text-center" style="width: 20px;" >No.</th>
                <th scope="col" class="th-gris text-left" style="width: 50px;">Mz</th>
                <th scope="col" class="th-gris text-left" style="width: 50px;">Casa</th>
                <th scope="col" class="th-gris text-left" style="width: 200px;">Dirección</th>
                <th scope="col" class="th-gris text-left " style="width: : 200px;">Propietario</th>
                <th scope="col" class="th-gris text-left " style="width: : 80px;">Tipo vivienda</th>
                <th scope="col" class="th-gris text-left " style="width: : 80px;">Telefono</th>
                <th scope="col" class="th-gris text-center " style="width: 1px;">Vehiculos</th>
                <th scope="col" class="th-gris text-center " style="width: 1px;">motos</th>
                <th scope="col" class="th-gris text-center " style="width: 1px;">Editar</th>
                <th scope="col" class="th-gris text-center" style="width: 1px;">Congelar</th>
                <th scope="col" class="th-gris text-center" style="width: 1px;">Facturas</th>
              </tr>
            </thead>
            <tbody>
             @foreach($cuentas as $cuenta)
                <tr>
                  <td class='text-center' >{{ $cuenta->id }}</td>
                  <td class='td-titulo text-center'>{{ $cuenta->mz }}</td>
                  <td class='td-titulo text-center'  >{{ $cuenta->casa }}</td>
                  <td class='text-left'  >{{ $cuenta->direccion }}</td>
                  <td class='text-left'  >{{ $cuenta->propietario }}</td>
                  <td class='text-left'  >{{ $cuenta->tipo_vivienda }}</td>
                  <td class='text-left'  >{{ $cuenta->telefono }}</td>
                   <td>
                    <a class="nav-link nav-link-icon text-center"  href="javascript:void(0);" onclick="listadoVehiculos({{$cuenta->id}})" role="button" id="subirfile" >
                      <div class="nav-link-icon__wrapper">
                        <i class="fa fa-car" title="ver listado vehiculos"></i><br>
                      </div>
                    </a>
                  </td>
                   <td>
                    <a class="nav-link nav-link-icon text-center"  href="javascript:void(0);" onclick="listadoMotos({{$cuenta->id}})" role="button" id="subirfile" >
                      <div class="nav-link-icon__wrapper">
                        <i class="fa fa-motorcycle" title="ver listado motocicletas"></i><br>
                      </div>
                    </a>
                  </td>
                  <td>
                    <a class="nav-link nav-link-icon text-center"  href="javascript:void(0);" onclick="editarCuentas({{$cuenta->id}})" role="button" id="subirfile" >
                      <div class="nav-link-icon__wrapper">
                        <i class="fa fa-edit" title="Editar Cuenta"></i><br>
                      </div>
                    </a>
                  </td>
                   <td>
                    <!--<a class="nav-link nav-link-icon text-center"  href="javascript:void(0);" role="button" id="subirfile" onclick="inactivarCuentas({{$cuenta->id}})">
                      <div class="nav-link-icon__wrapper">
                        <i class="fa fa-times" title="Congelar cuenta"></i><br>
                        
                      </div>
                    </a> -->
                    <a class="nav-link nav-link-icon text-center"  href="javascript:void(0);" role="button" id="subirfile" onclick="congelarCuentas({{$cuenta->id}})">
                      <div class="nav-link-icon__wrapper">
                        <i class="fa fa-times" title="Congelar cuenta"></i><br>
                        
                      </div>
                    </a>
                    </td>
                    <td>
                   <a class="nav-link nav-link-icon text-center" role="button" id="subirfile"  href="{{ url('cuentas/lista_factura_cuenta/'.$cuenta->id ) }}">
                      <div class="nav-link-icon__wrapper">
                        <i class="fa fa-file-invoice" title="listado Facturas"></i><br>
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
          {{ $cuentas->links() }}
         </div> 
  </div>
</div>
  <!-- End Default Light Table -->
</div>

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_cuentas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Crear Nueva Cuenta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_cuentas" style='min-height: 400px;'>
      </div>
    </div>
  </div>
</div>
<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_list_vehiculos">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Listado Vehiculo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_list_modal_vehiculos" style='min-height: 400px;'>
      </div>
    </div>
  </div>
</div>
<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_list_motos">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Listado motocicletas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_list_modal_motos" style='min-height: 400px;'>
      </div>
    </div>
  </div>
</div>

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_editar_cuentas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Editar Cuenta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_editar_modal_cuentas" style='min-height: 400px;'>
      </div>
    </div>
  </div>
</div>

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_congelar_cuentas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Congelar Cuenta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_cuentas_c" style='min-height: 400px;'>
      </div>
    </div>
  </div>
</div>

@endsection