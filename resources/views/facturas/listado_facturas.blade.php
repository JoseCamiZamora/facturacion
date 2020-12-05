@extends('layouts.app')



@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class='container'>
  <div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo Facturas </span>
  
        <h4 class="page-title" >Listado de facturas generadas  <span style='font-size: 0.6em;'></span> </h4>
     
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

      <a  href="{{ url('/facturas/listado_facturas') }}" class="mb-2 btn btn-sm btn-primary mr-1 " >
        <i class="fas fa-list-ol" style='margin-right: 5px' ></i> Listado Generado</a>

         <a  href="javascript:void(0);" class="mb-2 btn btn-sm btn-primary mr-1 "   onclick="FA_modal_generar_facturas();"  >
        <i class="fas fa-file-invoice-dollar" style='margin-right: 5px'></i> Generar Facturas Mes</a>
    

                       
    </div>
  </div>

  <div class="row">
    <div class="col">

    <form  method="post"  action="{{ url('facturas/buscar_factura') }}" id="f_buscar_factura"   >
        <input type="hidden" name="_token" id='_token_avatar' value="<?php echo csrf_token(); ?>">    

                  <div class="input-group mb-3">
                     
                      <input type="text" id='dato_buscadoDBP' name='dato_buscado' required class="form-control" style='background-color: white !important;' placeholder="Buscar factura por numero  o datos aquí...." aria-label="Buscar insumo" aria-describedby="basic-addon2">

                      <input type="hidden" id='busdbp_pagina' name='busdbp_pagina' value='1'  >
                      <input type="hidden" id='busdbp_next' name='busdbp_next' value='0'  >
                     
                      <div class="input-group-append">
                        <button class="btn btn-white" type="submit">Buscar</button>
                        @if(isset($busqueda))
                        <a href="{{ url('facturas/listado_facturas') }}" class="btn btn-white  btn-azul"   >
                           
                            <i class="fas fa-undo icon-color_blanco" title="deshacer busqueda"></i>
                        </a>
                        @endif
                      </div>

                    
                    </div>
      </form>

     <?php $mesesarray=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]; ?>


      @if(!isset($busqueda))
      <div class="row " style="margin-bottom: 20px;">
        <div class="col-md-2">

          <select class="form-control" id="select_mes_filtro" onchange="FA_filtro_estado({{$messel}});">
            <option value="" selected >Seleccionar estado</option>
            <option value="0" >Sin Pagar</option>
            <option value="1" >Pagado</option>
            <option value="2" >Vencida</option>
            <option value="3" >Orden Suspensión</option>
          
          </select>
        </div>
         <div class="col-md-4">
          <select class="form-control" id="select_mes_val" onchange="FA_cambiar_fecha_facturas();">
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
          <select class="form-control"  id="select_anio_val"  onchange="FA_cambiar_fecha_facturas();" >
               <?php  $aniocurren=date("Y");?>
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
          @if($facturas->count() > 0)

          <a  href="{{ url('facturas/pdf_facturas/'.$aniosel.'/'.$messel ) }}" id="button_imprimir_fac" type="button" class="mb-2 btn  btn-primary mr-1 "     >
             <i class="fas fa-print" style='margin-right: 5px'></i> Imprimir Facturas Mes
             </a>

          @else
            <button  id="button_imprimir_fac" type="button" class="mb-2 btn  btn-primary mr-1 " disabled  onclick="javascript:alert('se debe generar las facturas del mes antes de imprimir');"  >
             <i class="fas fa-print" style='margin-right: 5px'></i> Imprimir Facturas Mes
             </button>
          @endif
        </div>


      </div>

      @endif


      @if($facturas->count() > 0)
     
      <table    class='table table-generic table-strech' >

            <thead class="bg-light">
              <tr>
                <th scope="col" class="th-gris text-center" style="width: 100px;" >No. Factura</th>
                <th scope="col" class="th-gris text-center " style="width: 100px;"  >Mes Facturado</th>
                <th scope="col" class="th-gris" style="width: 50px;"  >Mz</th>
                <th scope="col" class="th-gris" style="width: 50px;">Casa</th>
                <th scope="col" class="th-gris" style="width: 100px;">Dirección</th>
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
                    {{ $factura->mes."/".$factura->anio }}
                  </td>
                  <td  class="   text-center">
                    {{ $factura->mz }}
                  </td>
                  <td  class="   text-center">
                    {{ $factura->casa }}
                  </td>
                   <td class='text-left'>
                   {{ $factura->direccion }}
                  </td>
                  <td class='text-left'>
                   {{ $factura->propietario }}
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
                  @if($factura->estado== 4)
                     <span class="badge badge-pill badge-info" style='font-size: 0.6em;  margin-top:0px; font-weight: 700;'>Cogelada</span> 
                  @endif
                  </td>
                  <td style="background-color: #dee2ec; font-weight: 500;border:1px solid white !important; " >
                   <a href="{{ url('facturas/detalle_factura/'.$factura->id ) }}" ><span ><i class="fa fa-eye" aria-hidden="true" style="margin-right: 10px;"></i>Ver</span></a>
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
              <h5> No existen facturas generadas en el mes y el año seleccionado... Verifica la información en la opción "Generar Factura Mes" e intenta nuevamente...</h5>
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
       
     
     

          <div class="col-md-12" style="margin-bottom: 10px;">
               <h6 >Seleccione el mes y el año que desea generar</h6>
          </div>
          <div class="col-md-6">
            <select class="form-control" id="mod_select_mes_val" >
             <option value=""  disabled selected >Seleccione el mes..</option>
            
              <option  value="{{$nwmes}}">{{$mesesarray[intval($nwmes)] }}</option>
          
            </select>
          </div>
          <div class="col-md-6">
             <input type="text" class="form-control" id="mod_select_anio_val" name="mod_select_anio_val" value="{{$nwanio}}" disabled >
          </div>



           <div class="col-md-12"  id="modal_listado_cargos">



           </div>


           <div class="col-md-8 text-center " style="margin-top: 5px;" >
                <a href="javascript:void(0);" onclick="fac_nav_generar_facturas();" class="mb-2 btn btn-md btn-success mr-1 "><i class="fas fa-check"></i>OK generar </a>
          </div>



       

      </div>
      </div>
    </div>
  </div>
</div>

@endsection
