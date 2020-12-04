@extends('layouts.app')



@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class='container'>


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

     <a href="{{ url('informes/listado_recaudos') }}" class="mb-2 btn btn-sm btn-default mr-1 " style="border:1px solid #dee2e6;"  ><i class="fas fa-hand-holding-usd" style="margin-right: 5px"></i>Recaudos
     </a>

         <a href="{{ url('informes/listado_recaudos_concepto') }}" class="mb-2 btn btn-sm btn-primary mr-1 " style="border:1px solid #dee2e6;"  ><i class="fas fa-hand-holding-usd" style="margin-right: 5px"></i>Recaudos por Concepto
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
        <select class="form-control" id="select_mes_val" onchange="FA_cambiar_fecha_recaudo_concepto();">
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
        <select class="form-control"  id="select_anio_val"  onchange="FA_cambiar_fecha_recaudo_concepto();" >
          @for($i = 2019; $i <=2030  ; $i++)
           @if($i==$aniosel )
             <option value="{{ $i }}" selected >{{ $i }}</option>
             @else
             <option value="{{ $i }}" >{{ $i }}</option>
           @endif
          @endfor
        </select>
      </div>
  
      <div>
      </div>
    </div>
  @endif


 

  <div class="row">
    <div class="col-md-12">

       <a class="btn btn-sm btn-default"  style="float:right;" href="{{ url('/informes/excel_informe5/'.$aniosel.'/'.$messel.'') }}" > <i class="fa fa-download" aria-hidden="true"></i> EXCEL
     </a>

     <?php   $totalcargos=0;  ?>
 
      <table    class='table table-generic table-strech' >
            <thead class="bg-light">
              <tr>
                <th colspan="9" class="text-center"> {{$aniosel}} - {{$mesesarray[$messel] }}</th>
              </tr>
              <tr>
                <th  class="th-gris text-center"  >ID.</th>
                <th  class="th-gris text-left" >Cargo</th>
                <th  class="th-gris text-left ">Total Recaudo</th>
              
              </tr>
            </thead>
            <tbody>


               <tr>
                  <td class='text-center'>-</td>
                  <td class='text-left' >SALDOS ANTERIORES RECAUDADOS</td>
                  <td class='text-left' >${{number_format($saldos_anteriores, 0)}}</td>

               
                </tr>

               <tr>
                  <td class='text-center'>-</td>
                  <td class='text-left' >POR MORA</td>
                  <td class='text-left' >${{number_format($moras, 0)}}</td>

               
                </tr>

                 <tr>
                  <td class='text-center'>-</td>
                  <td class='text-left' >VALORES NORMALES MES</td>
                  <td class='text-left' >${{number_format($valores_mes, 0)}}</td>

               
                </tr>

                  <?php 
                       $totalcargos+=$saldos_anteriores+$moras+$valores_mes;
                 ?>
              

             @foreach($cargos as $cargo)
                <tr>
                  <td class='text-center'>-</td>
                  <td class='text-left' >{{ $cargo->cargo }}</td>
                  <td class='text-left' >${{number_format($cargo->sum_cargo, 0)}}</td>

               
                </tr>

                <?php 
                       $totalcargos+=$cargo->sum_cargo;
                 ?>

              @endforeach

             
                 <tr>
                  <td class='text-center'>-</td>
                  <td class='text-left' >ABONOS REALIZADOS</td>
                  <td class='text-left' >${{number_format($valores_abono, 0)}}</td>

               
                </tr>

                    <?php 
                       $totalcargos+=$valores_abono;
                 ?>

                <tr>
                  <td class='text-center'></td>
                  <td class='text-left' ><b style="font-weight:900;">Total Recaudado Mes</b></td>
                  <td class='text-left' style="background-color: #dde9f5;  " ><b style="font-weight:900;">${{number_format($totalcargos, 0)}}</b></td>

               
                </tr>


            </tbody>
              
          </table>

         </div> 





  </div>

  	


  </div>


</div>

@endsection