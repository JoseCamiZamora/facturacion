@extends('layouts.app')



@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class=''>


  	<div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo Tnformes </span>
  
        <h4 class="page-title" >Listado de Facturas No pagadas<span style='font-size: 0.6em;'></span> </h4>
     
       <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
        Atrás
        <a href="{{ url('home') }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">

     <a href="{{ url('informes/listado_informes') }}" class="mb-2 btn btn-sm btn-primary mr-1 " style="border:1px solid #dee2e6;"  ><i class="fas fa-file-invoice-dollar" aria-hidden="true" style="margin-right: 5px"></i>Listado Morosos
     </a>

      <a  href="{{ url('informes/listado_recaudos') }}" class="mb-2 btn btn-sm btn-default mr-1 " ><i class="fas fa-hand-holding-usd" style="margin-right: 5px"></i>Recaudos
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
    <div class="row " style="margin-bottom: 15px; text-align: center">

     
      <div class="col-md-3">
        <h4 class="page-title" >Facturas No pagadas Hasta :<span style='font-size: 0.6em;'></span> </h4>
      </div>
       <div class="col-md-" >
        <input style="text-align: right; font-size: 1em" type="text" maxlength="12" class="form-control" id="mora" name="mora" value="{{ $fecha}}" >
      </div>


      <div class="col-md-1">
        <h4 class="page-title" >Mora:<span style='font-size: 0.6em;'></span> </h4>
      </div>
      
       <div class="col-md-2">
        <input style="text-align: right; font-size: 1em" type="text" maxlength="12" class="form-control" id="mora" name="mora" value="${{number_format($generalmora, 0)}}" >
      </div>


      <div class="col-md-1">
        <h4 class="page-title" >Saldo:<span style='font-size: 0.6em;'></span> </h4>
      </div>

       <div class="col-md-2">
        <input style="text-align: right; font-size: 1em" type="text" maxlength="12" class="form-control" id="mora" name="mora" value="${{number_format($generalsaldo, 0)}}" >
      </div>

      <div>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col">

          <a class="btn btn-sm btn-default"  style="float:right;" href="{{ url('/informes/excel_informe1') }}" > <i class="fa fa-download" aria-hidden="true"></i> EXCEL
      </a>
      <table    class='table table-generic table-strech' >
            <thead class="bg-light">
              <tr>
                <th  class="th-gris text-center"  >No.</th>
                <th  class="th-gris text-left" >Dirección</th>
                <th  class="th-gris text-left " >Propietario</th>
                <th  class="th-gris text-center " >Estado Factura</th>
                <th  class="th-gris text-center" >Facturas Sin pagar</th>
                <th  class="th-gris text-center" >Facturas en mora</th>
                <th  class="th-gris text-center" >Mora</th>
                <th  class="th-gris text-left " >Saldo</th>
                <th   scope="col" class="th-gris text-center " style="width: 80px;" >Facturas</th>
              </tr>
            </thead>
            <tbody>

             @foreach($cuentas as $cuenta)
                <tr>
                  <td class='text-center'>{{ $loop->index+1 }}</td>
                  <td class='text-left' >{{ $cuenta->direccion }}</td>
                  <td class='text-left' >{{ $cuenta->propietario }}</td>

                  
                  <td class='text-center' >
                    @if($cuenta->congelada==1)
                     <span class="badge badge-pill badge-primary" style='font-size: 0.6em;  margin-top:0px;'>Congelada</span> 
                    @else
                       <span class="badge badge-pill badge-success" style='font-size: 0.6em;  margin-top:0px; font-weight: 700;'>Activa</span> 
                    @endif
                  </td>
                  <td class='text-center' >{{$cuenta->cantidad_facturas??0}}</td>
                    <td class='text-center' >{{$cuenta->cantmora?? 0}}</td>
                    <td class='text-center' >{{$cuenta->mora?? 0}}</td>
                  <td class='text-left' >${{number_format($cuenta->valor_total, 0)}}</td>
                 
                   <td style="background-color: #dee2ec; font-weight: 500;border:1px solid white !important; " >
                  
                   <a href="javascript:void(0);" onclick="facturasNoPagada({{$cuenta->id}})" ><span ><i class="fa fa-eye" aria-hidden="true" style="margin-right: 10px;"></i>Detalle</span></a>
                             
                  </td>
                </tr>

              @endforeach
            </tbody>
               <tfoot>
              <tr>
                 
                   <td colspan='4'><span style='font-size:0.9em'><b>página:</b> {{ $cuentas->count() }} Cuentas</span></td>
                 
              </tr>
              </tfoot>
          </table>
          {{ $cuentas->links() }}
         </div> 

  </div>

  	


  </div>


</div>
<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_facturas_no_pagadas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Detalle de facturas no pagadas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_factura_no_pagadas" style='min-height: 200px;'>
      </div>
    </div>
  </div>
</div> 

@endsection