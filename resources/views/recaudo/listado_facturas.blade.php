@extends('layouts.app')



@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class='container'>
  <div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo de Pagos </span>
      <h4 class="page-title"> Pago de Facturas<span style='font-size: 0.6em;'></span> </h4>
  
       
     
       <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
        Atrás
        <a href="{{ url('home') }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
      </div>
    </div>
  </div>
  <!-- End Page Header -->
  <!-- Default Light Table -->

  <div class="card">
  <div class="card-header">
     <h4 class="page-title" style="text-align: center"> Formulario para realizar el pago de su factura <span style='font-size: 0.6em;'></span> </h4>
  </div>
  <div class="card-body" style="margin-top: -20px">
   <form  method="post"  action="{{ url('recaudo/buscar_factura') }}" id="r_buscar_factura"   >
    <input type="hidden" name="_token" id='_token_avatar' value="<?php echo csrf_token(); ?>">    
      <div class="input-group mb-3">
            <input type="text" id='dato_buscadoDBP' name='dato_buscado' required class="form-control" style='background-color: white !important;' placeholder="Buscar factura por numero  o propietario aquí...." aria-label="Buscar insumo" aria-describedby="basic-addon2">
            <input type="hidden" id='busdbp_pagina' name='busdbp_pagina' value='1'  >
            <input type="hidden" id='busdbp_next' name='busdbp_next' value='0'  >
            <input type="hidden" id='aniosel' name='aniosel' value='{{$aniosel}}'  >
            <input type="hidden" id='messel' name='messel' value='{{$messel}}'  >
           
            <div class="input-group-append">
              <button class="btn btn-white" type="submit">Buscar</button>
              @if(isset($busqueda))
              <a href="{{ url('recaudo/listado_facturas') }}" class="btn btn-white  btn-azul"   >
                 
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
                <th scope="col" class="th-gris text-center" style="width: 100px;" >No. Factura</th>
                <th scope="col" class="th-gris text-center " style="width: 150px;"  >Mes Facturado</th>
                <th scope="col" class="th-gris" style="width: 30px;"  >Mz</th>
                <th scope="col" class="th-gris" style="width: 30px;">Casa</th>
                <th scope="col" class="th-gris" style="width: 30px;" >Apto</th>
                <th scope="col" class="th-gris">Propietario</th>
                <th scope="col" class="th-gris" style="width: 60px;" >Estado</th>
                <th scope="col" class="th-gris text-center " style="width: 90px;">Pago</th>
            
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
                   @if($factura->estado==1)
                  <td style="background-color: #dee2ec; font-weight: 500;border:1px solid white !important; " >
                   <a href="{{ url('facturas/detalle_factura/'.$factura->id.'/2' ) }}"><span ><i class="fa fa-eye" aria-hidden="true" style="margin-right: 10px;"></i>Ver</span></a>
                  </td>
                  @else
                   <td style="background-color: #dee2ec; font-weight: 500;border:1px solid white !important; " >
                   <a href="{{ url('facturas/detalle_factura/'.$factura->id.'/2' ) }}" ><span ><i class="fa fa-dollar-sign" aria-hidden="true" style="margin-right: 10px;"></i>Pagar</span></a>
                  </td>
                  @endif
                </tr>

              @endforeach
            </tbody>
               <tfoot>
              <tr>
                  <td colspan='8'><span style='font-size:0.9em'><b>Total:</b> {{ $facturas->count() }} Facturas</span>     @if( isset($busqueda) ) encontradas la busqueda actual  <a href="{{ url('recaudo/listado_facturas') }}" style="margin-left: 10px;">  <i class="fas fa-undo " title="deshacer busqueda"></i> deshacer</a>  @endif </td>
              </tr>
              </tfoot>
          </table>
          {{ $facturas->links() }}
         </div> 
  </div>
  </div>
</div>

  

  
</div>
  <!-- End Default Light Table -->
</div>

@endsection