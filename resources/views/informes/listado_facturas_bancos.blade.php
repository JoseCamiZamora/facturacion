@extends('layouts.app')



@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class='container'>


  <div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo Tnformes </span>
  
        <h4 class="page-title" >Listado de facturas referenciadas en Bancos<span style='font-size: 0.6em;'></span> </h4>
     
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

     <a href="{{ url('informes/listado_informes') }}" class="mb-2 btn btn-sm btn-default mr-1 " style="border:1px solid #dee2e6;"  ><i class="fas fa-file-invoice-dollar" aria-hidden="true" style="margin-right: 5px"></i>Listado Morosos
     </a>

      <a  href="{{ url('informes/listado_recaudos') }}" class="mb-2 btn btn-sm btn-default mr-1 " ><i class="fas fa-hand-holding-usd" style="margin-right: 5px"></i>Recaudos
      </a>

           <a href="{{ url('informes/listado_recaudos_concepto') }}" class="mb-2 btn btn-sm default mr-1 " style="border:1px solid #dee2e6;"  ><i class="fas fa-hand-holding-usd" style="margin-right: 5px"></i>Recaudos por Concepto
         </a>

        <a  href="{{ url('informes/listado_facturas_bancos') }}" class="mb-2 btn btn-sm btn-primary mr-1 " ><i class="fas fa-hand-holding-usd" style="margin-right: 5px"></i>Bancos
      </a>             
    </div>
  </div>

  <div class="row">
    <div class="col">



     <?php $mesesarray=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]; ?>

      <div class="row " style="margin-bottom: 20px; text-align: center">
       <div class="col-md-6" style="margin-bottom: 20px;">
        <select class="form-control" id="select_mes_val" onchange="FA_cambiar_fecha_bancos();">
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
      <div class="col-md-6">
        <select class="form-control"  id="select_anio_val"  onchange="FA_cambiar_fecha_bancos();" >
          <?php  $aniocurren=date("Y");?>
          @for($i = 2019; $i <=$aniocurren  ; $i++)
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

         <a class="btn btn-sm btn-default"  style="float:right;" href="{{ url('/informes/excel_informe3/'.$aniosel.''.$messel.'') }}" > <i class="fa fa-download" aria-hidden="true"></i> EXCEL
      </a>



      @if($facturas->count() > 0)
     
      <table    class='table table-generic table-strech' >



            <thead class="bg-light">
              <tr>
                <th scope="col" class="th-gris text-center" style="width: 100px;" >No. Factura</th>
                <th scope="col" class="th-gris text-center " style="width: 100px;"  >Mes Facturado</th>
                <th scope="col" class="th-gris" style="width: 30px;"  >Mz</th>
                <th scope="col" class="th-gris" style="width: 30px;">Casa</th>
                <th scope="col" class="th-gris" style="width: 30px;" >Apto</th>
                <th scope="col" class="th-gris">Propietario</th>
                <th scope="col" class="th-gris">valor</th>
                <th scope="col" class="th-gris" style="width: 60px;" >Estado</th>
                <th scope="col" class="th-gris text-center " style="width: 80px;">Ver</th>
            
              </tr>
            </thead>
            <tbody>

              @foreach($facturas as $factura)

                <tr>
                  <td class='text-center' style="background-color: #dee2ec; font-weight: 700;border:1px solid white !important;" >{{ $factura->id }}</td>
                  <td  class="   text-center">
                    {{ $factura->mes."/".$factura->anio }}
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
                   {{ $factura->propietario }}
                  </td>
                     <td class='text-left'>
                   {{ number_format($factura->valor_total,0) }}
                  </td>
                  <td class='text-left'>

                  @if($factura->estado==1)
                   <span class="badge badge-pill badge-success" style='font-size: 0.6em;  margin-top:0px;'>Pagada</span> 
                  @endif
                  @if($factura->estado== 0)
                     <span class="badge badge-pill badge-primary" style='font-size: 0.6em;  margin-top:0px; font-weight: 700;'>Sin pagar</span> 
                  @endif
                   @if($factura->estado== 2)
                     <span class="badge badge-pill badge-warning" style='font-size: 0.6em;  margin-top:0px; font-weight: 700;'>Vencida</span> 
                  @endif
                  @if($factura->estado== 3)
                     <span class="badge badge-pill badge-danger" style='font-size: 0.6em;  margin-top:0px; font-weight: 700;'>Orden Suspensión</span> 
                  @endif
                  </td>
                  <td style="background-color: #dee2ec; font-weight: 500;border:1px solid white !important; " >
                   <a href="{{ url('facturas/detalle_factura/'.$factura->id."/4" ) }}" ><span ><i class="fa fa-eye" aria-hidden="true" style="margin-right: 10px;"></i>Ver</span></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
               <tfoot>
              <tr>
                <td colspan='8'><span style='font-size:0.9em'><b>Total:</b> {{ $facturas->count() }} Facturas</span>     @if( isset($busqueda) ) encontradas la busqueda actual  <a href="{{ url('facturas/listado_facturas') }}" style="margin-left: 10px;">  <i class="fas fa-undo " title="deshacer busqueda"></i> deshacer</a>  @endif </td>
              </tr>
              </tfoot>
          </table>
          {{ $facturas->links() }}
          @endif
          @if( $facturas->count() == 0 and !isset($busqueda) )
           <div class="row justify-content-md-center">
             <div class="col-md-8 text-center">
              <br>
              <h5> No existen facturas registradas con pago en bancos en el mes y el año seleccionado... ...</h5>
              <b></b> 
            </div>
          </div>
          @endif

 <!-- 
          @if( $facturas->count() == 0 and !isset($busqueda) )

             @if(!isset($permiso) )
             <div class="row justify-content-md-center">

             <div class="col-md-8 text-center">Aún no se han generado facturas para el mes <b>{{$mesesarray[$messel] }} - {{ $aniosel}} </b> </div>
             <div class="col-md-8 text-center " style="margin-top: 10px;" >
                <a href="{{ url('facturas/generar_facturas/'.$aniosel.'/'.$messel ) }}" class="mb-2 btn btn-md btn-success mr-1 ">

        <i class="fas fa-file-invoice-dollar" style='margin-right: 5px'></i>
                Generar Facturas de este mes</a>
             </div>

            <div>
            @endif

            @if( isset($permiso) )
              @if( $mensaje==1)
                <div class="row justify-content-md-center">
                   <div class="col-md-8 text-center">
                    No se pueden generar facturas mayor a dos meses en adelante teniedo en cuenta el mes seleccionado por lo cual no se permite generar las facturas de este mes... Verifica la informacion e intenta nuevamente!
                    <b></b> 
                  </div>
                </div>
              @endif
              @if( $mensaje==2)
                <div class="row justify-content-md-center">
                   <div class="col-md-8 text-center">
                    Ya existen facturas generadas en meses posteriores al mes seleccionado por lo cual no se permite generar las facturas de este mes... Verifica la informacion e intenta nuevamente!
                    <b></b> 
                  </div>
                </div>
              @endif


            @endif


            
          @endif

-->
         </div> 



  </div>
</div>
  <!-- End Default Light Table -->
</div>




@endsection
