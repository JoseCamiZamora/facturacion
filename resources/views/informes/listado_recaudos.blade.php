@extends('layouts.app')



@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div >


  	<div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo Tnformes </span>
  
        <h4 class="page-title" >Listado general de recaudos por mes   <span style='font-size: 0.6em;'></span> </h4>
     
       <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
        Atrás
        <a href="{{ url('home') }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">

     <a href="{{ url('informes/listado_informes') }}" class="mb-2 btn btn-sm btn-default mr-1 " ><i class="fas fa-file-invoice-dollar" aria-hidden="true" style="margin-right: 5px"></i>Listado Morosos
     </a>

     <a href="{{ url('informes/listado_recaudos') }}" class="mb-2 btn btn-sm btn-primary mr-1 " style="border:1px solid #dee2e6;"  ><i class="fas fa-hand-holding-usd" style="margin-right: 5px"></i>Recaudos
     </a>

         <a href="{{ url('informes/listado_recaudos_concepto') }}" class="mb-2 btn btn-sm default mr-1 " style="border:1px solid #dee2e6;"  ><i class="fas fa-hand-holding-usd" style="margin-right: 5px"></i>Recaudos por Concepto
     </a>

       <a  href="{{ url('informes/listado_facturas_bancos') }}" class="mb-2 btn btn-sm btn-default mr-1 " ><i class="fas fa-hand-holding-usd" style="margin-right: 5px"></i>Bancos
      </a>           
    </div>
  </div>

  <br>


  <?php $mesesarray=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]; ?>

  @if(!isset($busqueda))
    <div class="row " style="margin-bottom: 20px; text-align: center">
       <div class="col-md-4" style="margin-bottom: 20px;">
        <select class="form-control" id="select_mes_val" onchange="FA_cambiar_fecha_recaudo();">
          <option value="{{$messel}}" selected >{{$mesesarray[$messel] }}</option>
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
      <div class="col-md-4">
        <select class="form-control"  id="select_anio_val"  onchange="FA_cambiar_fecha_recaudo();" >
          @for($i = 2019; $i <=2030  ; $i++)
           @if($i==$aniosel )
             <option value="{{ $i }}" selected >{{ $i }}</option>
             @else
             <option value="{{ $i }}" >{{ $i }}</option>
           @endif
          @endfor
        </select>
      </div>
      <div class="col-md-2">
        <h4 class="page-title" >Total Recaudo:<span style='font-size: 0.6em;'></span> </h4>
      </div>
       <div class="col-md-2">
        <input style="text-align: right; font-size: 1em" type="text" maxlength="12" class="form-control" id="mora" name="mora" value="${{number_format($total_recaudo, 0)}}" >
      </div>
      <div>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col">

              <a class="btn btn-sm btn-default"  style="float:right;" href="{{ url('/informes/excel_informe2/'.$aniosel.'/'.$messel.'') }}" > <i class="fa fa-download" aria-hidden="true"></i> EXCEL
      </a>
      <table    class='table table-generic table-strech' >
            <thead class="bg-light">
              <tr>
                <th colspan="9" class="text-center"> {{$aniosel}} - {{$mesesarray[$messel] }}</th>
              </tr>
              <tr>
                <th  class="th-gris text-center"  >No.</th>
                <th  class="th-gris text-left" >tipo</th>
                <th  class="th-gris text-left " >Propietario</th>
                <th  class="th-gris text-left " >Valor mes</th>
                <th  class="th-gris text-left " >Saldo anterior</th>
                <th  class="th-gris text-left " >Total Cargos</th>
                 <th  class="th-gris text-left ">Abonos</th>
                <th  class="th-gris text-left " >Subtotal</th>
               
                 <th  class="th-gris text-left ">Moras</th>
                <th  class="th-gris text-left ">Total Recaudo</th>
                <th   scope="col" class="th-gris text-center " style="width: 80px;" >Factura</th>
              </tr>
            </thead>
            <tbody>

             @foreach($facturas as $cuenta)
                <tr>
                  <td class='text-center'>{{ $cuenta->id }}</td>
                  <td class='text-left' >@if($cuenta->estado==1) PAGO  @endif  @if($cuenta->estado==0 &&  $cuenta->abono==1) Abono  @endif</td>
                  <td class='text-left' >{{ $cuenta->propietario }}</td>
                  <td class='text-left' >${{number_format($cuenta->valor_mes, 0)}}</td>
                  <td class='text-left' >${{number_format($cuenta->saldo_anterior, 0)}}</td>
                  <td class='text-left' >${{number_format($cuenta->total_cargos, 0)}}</td>
                  <td class='text-left' >${{number_format($cuenta->valor_abono, 0)}}</td>
                  <td class='text-left' >${{number_format($cuenta->valor_total-$cuenta->valor_abono, 0)}}</td>
                   <td class='text-left' >${{number_format($cuenta->mora, 0)}}</td>
                    @if($cuenta->estado==1)
                  <td class='text-left' >${{number_format($cuenta->valor_mes+ + $cuenta->saldo_anterior+  $cuenta->total_cargos +  $cuenta->mora, 0)}}</td>
                   @endif

                   @if($cuenta->estado==0 &&  $cuenta->abono==1)

                   <td class='text-left' >${{number_format($cuenta->valor_abono , 0)}}</td>

                   @endif


                 
                   <td style="background-color: #dee2ec; font-weight: 500;border:1px solid white !important; " >
                  
                   <a href="{{ url('facturas/detalle_factura/'.$cuenta->id .'/3' ) }}" ><span ><i class="fa fa-eye" aria-hidden="true" style="margin-right: 10px;"></i>Ver</span></a>
                             
                  </td>
                </tr>

              @endforeach
            </tbody>
               <tfoot>
              <tr>
                 
                   <td colspan='4'><span style='font-size:0.9em'><b>Total:</b> {{ $facturas->count() }} Cuentas</span></td>
                 
              </tr>
              </tfoot>
          </table>
          {{ $facturas->links() }}
         </div> 

  </div>

  	


  </div>


</div>

@endsection