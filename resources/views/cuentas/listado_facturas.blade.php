@extends('layouts.app')

@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class='container'>
  <div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo Facturas </span>
  
        <h4 class="page-title" >Listado de Facturas  <span style='font-size: 0.6em;'></span> </h4>
     
       <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
        Atrás
        <a href="{{ url('cuentas/listado_cuentas') }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="Regresar al listado de cuentas" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
      </div>
    </div>
  </div>
  <!-- End Page Header -->
  <!-- Default Light Table -->
  <div class="row">
    <div class="col">
    <form  method="post"  action="{{ url('cuentas/buscar_factura') }}" id="f_buscar_factura"   >
        <input type="hidden" name="_token" id='_token_avatar' value="<?php echo csrf_token(); ?>">    
          <div class="input-group mb-3">
              <input type="text" id='dato_buscadoDBP' name='dato_buscado' required class="form-control" style='background-color: white !important;' placeholder="Buscar factura por numero  o datos aquí...." aria-label="Buscar insumo" aria-describedby="basic-addon2">
              <input type="hidden" id='busdbp_pagina' name='busdbp_pagina' value='1'  >
              <input type="hidden" id='busdbp_next' name='busdbp_next' value='0'  >
              <div class="input-group-append">
                <button class="btn btn-white" type="submit">Buscar</button>
                @if(isset($busqueda))
                <a href="{{ url('cuentas/lista_factura_cuenta/'.$factura->id_cuenta ) }}" class="btn btn-white  btn-azul"   >
                    <i class="fas fa-undo icon-color_blanco" title="deshacer busqueda"></i>
                </a>
                @endif
              </div>
          </div>
      </form>

      @if($facturas->count() > 0)
     
      <table class='table table-generic' >
            <thead class="bg-light">
              <tr>
                <th scope="col" class="th-gris text-center" style="width: 100px;" >No. Factura</th>
                <th scope="col" class="th-gris text-center " style="width: 150px;"  >Mes Facturado</th>
                <th scope="col" class="th-gris" style="width: 30px;"  >Mz</th>
                <th scope="col" class="th-gris" style="width: 30px;">Casa</th>
                <th scope="col" class="th-gris" style="width: 30px;" >Apto</th>
                <th scope="col" class="th-gris">Propietario</th>
                <th scope="col" class="th-gris" style="width: 60px;" >Estado</th>
                <th scope="col" class="th-gris text-center " style="width: 80px;">Ver</th>
              </tr>
            </thead>
            <tbody>

              @foreach($facturas as $factura)

                <tr>
                  <td class='text-center' style="background-color: #dee2ec; font-weight: 700;border:1px solid white !important;" >{{ $factura->id }}</td>
                  <td  class="   text-center">
                    @if($factura->mes==1){{ "Enero/".$factura->anio }} @endif
                    @if($factura->mes==2){{ "Febrero/".$factura->anio }} @endif
                    @if($factura->mes==3){{ "Marzo/".$factura->anio }} @endif
                    @if($factura->mes==4){{ "Abril/".$factura->anio }} @endif
                    @if($factura->mes==5){{ "Mayo/".$factura->anio }} @endif
                    @if($factura->mes==6){{ "Junio/".$factura->anio }} @endif
                    @if($factura->mes==7){{ "Julio/".$factura->anio }} @endif
                    @if($factura->mes==8){{ "Agosto/".$factura->anio }} @endif
                    @if($factura->mes==9){{ "Septiembre/".$factura->anio }} @endif
                    @if($factura->mes==10){{ "Octubre/".$factura->anio }} @endif
                    @if($factura->mes==11){{ "Noveimbre/".$factura->anio }} @endif
                    @if($factura->mes==12){{ "Diciembre/".$factura->anio }} @endif
                  </td>
                  <td  class="   text-center">
                    {{ $factura->mz }}
                  </td>
                  <td  class="   text-center">
                    {{ $factura->casa }}
                  </td>
                  <td  class="   text-center">
                    {{ $factura->apto }}
                  </td>
                  <td class='text-left'>
                   <h6 class="td-titulo">{{ $factura->propietario }}</h6>
                  </td>
                  <td class='text-left'>
                  @if($factura->estado==1)
                   <span class="badge badge-pill badge-success" style='font-size: 0.6em;  margin-top:0px;'>Pagada</span> 
                  @else
                     <span class="badge badge-pill badge-warning" style='font-size: 0.6em;  margin-top:0px; font-weight: 700;'>Sin pagar</span> 
                  @endif
                  </td>
                  <td style="background-color: #dee2ec; font-weight: 500;border:1px solid white !important; " >
                   <a href="{{ url('facturas/detalle_factura/'.$factura->id .'/1') }}" ><span ><i class="fa fa-eye" aria-hidden="true" style="margin-right: 10px;"></i>Ver</span></a>
                             
                  </td>
                </tr>

              @endforeach
            </tbody>
               <tfoot>
              <tr>
                 
                  <td colspan='8'><span style='font-size:0.9em'><b>Total:</b> {{ $facturas->count() }} Facturas</span>     @if( isset($busqueda) ) encontradas la busqueda actual  <a href="{{ url('cuentas/lista_factura_cuenta/'.$factura->id_cuenta ) }}" style="margin-left: 10px;">  <i class="fas fa-undo " title="deshacer busqueda"></i> deshacer</a>  @endif </td>
                 
              </tr>
              </tfoot>
          </table>

          {{ $facturas->links() }}

          @endif

         </div> 



  </div>
</div>
  <!-- End Default Light Table -->
</div>


<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_generar_facturas">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_fac">Generar Facturas del MES</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_GF" style='min-height: 300px;'>

      <div class="row justify-content-md-center" style="margin-bottom: 20px;">
 <div class="col-md-12" style="margin-bottom: 20px;">
         <h6 >Seleccione el mes y el año que desea generar</h6>
</div>
         <div class="col-md-6">

          <select class="form-control" id="mod_select_mes_val" >
           <option value=""  disabled selected >Seleccione..</option>
            <option value="1" >Enero</option>
            <option value="2" >Febrero</option>
            <option value="3" >Marzo</option>
            <option value="4" >Abril</option>
            <option value="5" >Mayo</option>
            <option value="6" >Junio</option>
            <option value="7" >Julio</option>
            <option value="8" >Agosto</option>
            <option value="9" >Septiembre</option>
            <option value="10" >Octubre</option>
            <option value="11" >Noviembre</option>
            <option value="12" >Diciembre</option>
          
          </select>


        </div>
        <div class="col-md-6">

          <select class="form-control"  id="mod_select_anio_val"   >
              <option value=""   disabled selected >Seleccione..</option>
            @for($i = 2019; $i <=$aniosel  ; $i++)
               <option value="{{ $i }}" >{{ $i }}</option>
            @endfor

          </select>

        </div>


          <div class="col-md-8 text-center " style="margin-top: 30px;" >
                <a href="javascript:void(0);" onclick="fac_nav_generar_facturas();" class="mb-2 btn btn-md btn-success mr-1 ">

       <i class="fas fa-check"></i>
                OK generar </a>
          </div>


      </div>


      </div>
    </div>
  </div>
</div>




@endsection