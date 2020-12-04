@extends('layouts.app')



@section('content')
<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class='container'>
  <div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo Configuración </span>
        <h4 class="page-title" >Listado de comunicados  <span style='font-size: 0.6em;'></span> </h4>
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
     <a  href="{{ url('configuracion/listado_valores') }}" class="mb-2 btn btn-sm btn-default mr-1 " ><i class="fas fa-file-invoice-dollar"  style="margin-right: 5px"></i>Valores Facturas</a>
      <a  href="{{ url('configuracion/listado_cargos') }}" class="mb-2 btn btn-sm btn-default mr-1 "   ><i class="fas fa-hand-holding-usd" style="margin-right: 5px;" ></i>Cargos</a>
      <a  href="{{ url('configuracion/listado_cargos_mora') }}" class="mb-2 btn btn-sm btn-default mr-1 " ><i class="fas fa-hand-holding-usd" style="margin-right: 5px"></i>Cargos por Mora</a>
      <a  href="{{ url('configuracion/listado_comunicados') }}" class="mb-2 btn btn-sm btn-primary mr-1 " style="border:1px solid #dee2e6;"><i class="fas fa-file-invoice" style="margin-right: 5px" aria-hidden="true" ></i>Comunicados</a>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <table    class='table table-generic table-strech' >
       <thead class="bg-light">
          <tr>
            <th colspan="5" class="th-gris text-right"  >
               <a href="javascript:void(0);" onclick="config_form_crear_comunicado();" class="mb-2 btn btn-sm btn-primary mr-1" ><i class="far fa-plus-square" style="margin-right:10px;"></i>Nuevo Comunicado </a>
            </th>
          </tr>
        </thead>
        <thead class="bg-light">
          <tr>
            <th scope="col" class="th-gris text-center" style="width: 100px;" >No.</th>
            <th scope="col" class="th-gris">Detalle Comunicado</th>
            <th scope="col" class="th-gris text-center " style="width: 125px;">Estado </th>
              <th scope="col" class="th-gris text-center " style="width: 50px;">Editar </th>
              <th scope="col" class="th-gris text-center " style="width: 50px;">Borrar </th>
          </tr>
        </thead>
        <tbody>
          @foreach($comunicados as $val)
            <tr>
              <td class='text-center'>{{ $loop->index+1 }}</td>
              <td class='text-left'>
              <h6 class="td-titulo">{{ $val->descripcion }}</h6>
              </td>
              <td class="td-btn-azul-claro" >
               @if($val->estado=='I')
                 <h6 class="td-titulo text-center">INACTIVO</h6>
               @else
                 <h6 class="td-titulo text-center">ACTIVO</h6>
               @endif
              </td>
              <td>
                <a href="javascript:void(0);" class="nav-link nav-link-icon text-center" onclick="config_form_editar_comunicado({{ $val->id }});" role="button" id="subirfile">
                  <div class="nav-link-icon__wrapper">
                    <i class="fa fa-edit" title="Editar"></i><br>
                  </div>
                </a>
              </td>
              <td>
                <a href="javascript:void(0);" class="nav-link nav-link-icon text-center" onclick="config_form_borrar_comunicado({{ $val->id }});" role="button" id="subirfile">
                  <div class="nav-link-icon__wrapper">
                    <i class="fa fa-trash" title="Borrar"></i><br>
                  </div>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
           <tfoot>
          <tr>
              <td colspan='4'><span style='font-size:0.9em'><b>Total:</b> {{ $comunicados->count() }} cargos</span></td>
          </tr>
          </tfoot>
      </table>
     </div> 
  </div>
</div>
  <!-- End Default Light Table -->
</div>

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_comunicados">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Crear nuevo comunicado</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_comunicados" style='min-height: 400px;'>
      </div>
    </div>
  </div>
</div>

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_comunicados_editar">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Editar comunicado</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_comunicados_editar" style='min-height: 400px;'>
      </div>
    </div>
  </div>
</div>

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_comunicados_borrar">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Borrar comunicado</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_comunicados_borrar" style='min-height: 400px;'>
      </div>
    </div>
  </div>
</div>

@endsection