@extends('layouts.app')



@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
	<div class='container'>

		  <div class="page-header row no-gutters py-4">
		    <div class="col">
		      <span class="page-subtitle">Modulo Facturas</span>
		  
		        <h4 class="page-title" >Detalle de la factura <b>{{ $factura->numero }}</b> <span style='font-size: 0.6em;'></span> </h4>

    @if(Auth::user()->rol==1)
              
		     
         @if($seccion==0)
		       <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
		        Atrás
		        <a href="{{ url('/facturas/listado_facturas/'.$aniosel.'/'.$messel.'') }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
		      </div>
         @endif

         @if($seccion==1)
           <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
            Atrás
            <a href="{{ url('cuentas/lista_factura_cuenta/'.$factura->id_cuenta) }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
          </div>
         @endif

          @if($seccion==2)
           <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
            Atrás
            <a href="{{ url('recaudo/listado_facturas') }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
          </div>
         @endif

          @if($seccion==3)
           <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
            Atrás
            <a href="{{ url('informes/listado_informes') }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
          </div>
          @endif


        @if($seccion==4)

          <?php  
                    $urlprevious = url()->previous(); 
                    $newurl='informes/listado_facturas_bancos';
                    if (strpos($urlprevious, 'listado_facturas_bancos') !== false) {
                      
                      $newurl=$urlprevious;     
                    }
            ?>

           <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
            Atrás
            <a href="{{ url($newurl) }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
          </div>
          @endif

      @endif

      @if(Auth::user()->rol==2)
          <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
            Atrás
            <a href="{{ url('/recaudo/listado_facturas') }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
          </div>


      @endif




		    </div>
		  </div>


    <?php $mesesarray=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]; ?>

    <div class="row justify-content-md-center" style="margin-left: 115px">
      <div class="col-md-9">
        @if($permiso==true )
          @if($factura->estado==1 )
              <a  onclick="facturaPagada()" class="mb-2 btn btn-sm btn-primary mr-1 " ><i class="fa fa-edit margin-icon" aria-hidden="true" ></i>Editar Factura</a>
              <a  onclick="facturaPagada()" class="mb-2 btn btn-sm btn-primary mr-1 " ><i class="fas fa-plus-circle margin-icon"></i>Agregar Cargos</a>
               <a  onclick="facturaPagada()"  class="mb-2 btn btn-sm btn-warning mr-1 "  style="color:white;" disabled>
              <i class="far fa-money-bill-alt margin-icon" ></i>Realizar ABONO</a>
              <a  onclick="facturaPagada()"  class="mb-2 btn btn-sm btn-success mr-1 "  style="color:white;">
              <i class="far fa-money-bill-alt margin-icon" ></i>Registrar PAGO</a>
            @else
             @if($factura->congelada==1 )
              <a  onclick="facturaCongelada()" class="mb-2 btn btn-sm btn-primary mr-1 " ><i class="fa fa-edit margin-icon" aria-hidden="true" ></i>Editar Factura</a>
              <a  onclick="facturaCongelada()" class="mb-2 btn btn-sm btn-primary mr-1 " ><i class="fas fa-plus-circle margin-icon"></i>Agregar Cargos</a>
               <a  onclick="facturaCongelada()"  class="mb-2 btn btn-sm btn-warning mr-1 "  style="color:white;" disabled>
              <i class="far fa-money-bill-alt margin-icon" ></i>Realizar ABONO</a>
              <a  onclick="facturaCongelada()"  class="mb-2 btn btn-sm btn-success mr-1 "  style="color:white;">
              <i class="far fa-money-bill-alt margin-icon" ></i>Registrar PAGO</a>
             @else
                <a  onclick="editarFactura({{$factura->id}})" class="mb-2 btn btn-sm btn-primary mr-1 " ><i class="fa fa-edit margin-icon" aria-hidden="true" ></i>Editar Factura</a>
                <a  onclick="agregarCargosFactura({{$factura->id}})" class="mb-2 btn btn-sm btn-primary mr-1 " ><i class="fas fa-plus-circle margin-icon"></i>Agregar Cargos</a>
                <a  onclick="registrarAbono({{$factura->id}},{{ ($factura->valor_total+$factura->mora) }},'{{$factura->propietario}}')"  class="mb-2 btn btn-sm btn-warning mr-1 "  style="color:white;" disabled>
                <i class="far fa-money-bill-alt margin-icon" ></i>Realizar ABONO</a>
                <a  onclick="pagarFactura({{$factura->id}},{{ ($factura->valor_total+$factura->mora) }},'{{$factura->propietario}}')"  class="mb-2 btn btn-sm btn-success mr-1 "  style="color:white;">
                <i class="far fa-money-bill-alt margin-icon" ></i>Registrar PAGO</a>
             @endif
          @endif
           <!--
          @if($factura->estado==4)
            <a  onclick="descongelarFactura({{$factura->id}})"  class="mb-2 btn btn-sm btn-danger mr-1 "  style="color:white;">
              <i class="far fa-money-bill-alt margin-icon" ></i>Descongelar Factura</a>

          @else
          <a  onclick="congelarFactura({{$factura->id}})"  class="mb-2 btn btn-sm btn-danger mr-1 "  style="color:white;">
              <i class="far fa-money-bill-alt margin-icon" ></i>Cogelar Factura</a>
          @endif
        -->
        @elseif($permiso==false  ) 
          <a  onclick="javascript:alert('Acción no permitida sobre esta factura');" class="mb-2 btn btn-sm btn-primary mr-1 " style="background-color:#dcddea !important;" ><i class="fa fa-edit margin-icon" aria-hidden="true" ></i>
             Editar Factura
          </a>
          <a  onclick="javascript:alert('Acción no permitida sobre esta factura');" class="mb-2 btn btn-sm btn-primary mr-1 " style="background-color:#dcddea !important;" ><i class="fas fa-plus-circle margin-icon"></i>
              Agregar Cargos
          </a>
           <a  onclick="javascript:alert('Acción no permitida sobre esta factura');"  class="mb-2 btn btn-sm btn-primary mr-1 "  style="background-color:#dcddea !important;" >
            <i class="far fa-money-bill-alt margin-icon" ></i>
              Registrar PAGO
          </a>
           <a  onclick="javascript:alert('Acción no permitida sobre esta factura');"  class="mb-2 btn btn-sm btn-primary mr-1 "  style="background-color:#dcddea !important;" >
            <i class="far fa-money-bill-alt margin-icon" ></i>
              Registrar ABONO
          </a>

       
        @endif 
       
          <a  href="{{ url('facturas/pdf_factura/'.$factura->id.'') }}"  class="mb-2 btn btn-sm btn-primary mr-1 "  style="color:white;">
            <i class="fas fa-print margin-icon"></i>Imprimir Factura</a>
      </div>
    </div>

    @if($factura->estado==2)


     @if($factura->saldada==1)
        <div class="row justify-content-md-center">
              <div class="col-md-9"  >
               <div class="col-md-12" style="background-color:#d4f7e6;color:#0c5b35; padding-top: 10px; padding-bottom: 10px;">
              <h5 style="color:#13ac62;"><i class="fas fa-info-circle margin-icon"></i>FACTURA SALDADA</h5>  
              <ul>
              <li>Esta factura ya fue saldada </li>
              <li>el valor fue saldado pagando la Factura de {{ $ultimafactura }} </li>
              <li>No fue pagada en el tiempo correcto pero fue pagada en una factura de meses siguientes</li>
             </ul> 
             </div>
           </div>
        </div>
      @endif

        @if($factura->saldada==0)

          @if($permiso==false)
              <div class="row justify-content-md-center">
                    <div class="col-md-7"  >
                     <div class="col-md-12" style="background-color:#fdddc1;color:#aa5103; padding-top: 10px; padding-bottom: 10px;">
                    <h5 style="color:#d76603;"><i class="fas fa-info-circle margin-icon"></i>FACTURA NO PAGADA Y CERRADA</h5>  
                    <ul>
                    <li>Esta factura esta cerrada y no es editable </li>
                    <li>Ya se ha generado una nueva Factura en {{ $ultimafactura }} </li>
                    <li>Pagar la nueva Factura generada</li>
                    <li>La nueva factura incluye todos los valores que no han sido saldados de facturas anteriores
                    </li>
                   </ul> 
                   </div>
                 </div>
              </div>
           @endif
  
        @endif

    @endif


      @if($factura->estado==0)


        @if($factura->saldada==1)
          <div class="row justify-content-md-center">
                <div class="col-md-7"  >
                 <div class="col-md-12" style="background-color:#d4f7e6;color:#0c5b35; padding-top: 10px; padding-bottom: 10px;">
                <h5 style="color:#13ac62;"><i class="fas fa-info-circle margin-icon"></i>FACTURA SALDADA</h5>  
                <ul>
                <li>Esta factura ya fue saldada </li>
                <li>el valor fue saldado pagando la Factura de {{ $ultimafactura }} </li>
                <li>No fue pagada en el tiempo correcto pero fue pagada en una factura de meses siguientes</li>
               </ul> 
               </div>
             </div>
          </div>
        @endif

        @if($factura->saldada==0)

          @if($permiso==false)
              <div class="row justify-content-md-center">
                    <div class="col-md-7"  >
                     <div class="col-md-12" style="background-color:#fdddc1;color:#aa5103; padding-top: 10px; padding-bottom: 10px;">
                    <h5 style="color:#d76603;"><i class="fas fa-info-circle margin-icon"></i>FACTURA NO PAGADA Y CERRADA</h5>  
                    <ul>
                    <li>Esta factura esta cerrada y no es editable </li>
                    <li>Ya se ha generado una nueva Factura en {{ $ultimafactura }} </li>
                    <li>Pagar la nueva Factura generada</li>
                    <li>La nueva factura incluye todos los valores que no han sido saldados de facturas anteriores
                    </li>
                   </ul> 
                   </div>
                 </div>
              </div>
           @endif
  
        @endif

    @endif

		<div class="row justify-content-md-center">
      <div class="col-md-7">
      	<table class='table table-generic text-center' >
         <tbody>
         	<tr class="text-center" >
        

         		<td colspan="4" >
              <table width="100%;" style="border:none;" >
                <tr>
                  <td><img  src="{{ asset('assets/img/logo2.png') }}" style="width:100px;"/></td>
                  <td> 
                    <h5 style="margin-bottom: .05rem;">TERRAZAS DEL NORTE ETAPA I</h5>
                    <p class="p-subtitulo">JUNTA DE ACCION COMUNAL</p> 
                 </td>
                    <td><img  src="{{ asset('assets/img/logo2.png') }}" style="width:100px;" /></td>
                </tr>
              </table>
               

         	
              
         		</td>

       


         	</tr>
         	<tr class="text-center">
         		<td colspan="4" class="td-color-blanco" >FACTURA DEL AGUA</td>
         	</tr>
         	<tr class="text-center">
         		<td  class="td-color-blanco " >ESTRATO: {{$factura->estrato}} </td>
         		<td  class="td-color-blanco"  colspan="3" >NIT.900.058.328 DV-5</td>
         	</tr>
          <tr class="text-center">
         		<td class="td-color-blanco"  >FACTURA No:</td>
         		<td class="td-gris-azul-claro" colspan="3" >{{$factura->id}} </td>
         	</tr>
         	<tr class="text-center">
         		<td class="td-color-azul" style="width: 350px;">DIRECCIÓN </td>
         		<td class="td-color-azul" colspan="1" >MZ</td>
         		<td class="td-color-azul" colspan="3" >CASA</td>
         	</tr>
         	<tr class="text-center">
         		<td class="td-color-blanco" >{{ $factura->direccion }}</td>
         		<td class="td-color-blanco" colspan="1" >{{$factura->mz}}</td>
         		<td class="td-color-blanco"  colspan="3">{{$factura->casa}}</td>
         	</tr>
         	 	<tr class="text-center">
         		<td class="td-color-blanco" >NOMBRE:</td>
         		<td class="td-color-blanco" colspan="3" >{{$factura->propietario}}</td>
         	</tr>
         	<tr class="text-center">
         		<td class="td-color-azul" >MES FACTURADO</td>
         		<td colspan="2" class="td-color-azul"> MES</td>
         		<td  class="td-color-azul" >AÑO</td>
         	</tr>
         	 <tr class="text-center">
         		<td class="td-color-blanco" >--</td>
         		<td colspan="2" class="td-color-blanco" >{{ $mesesarray[$factura->mes] }}</td>
         		<td class="td-color-blanco"  >{{ $factura->anio }}</td>
         	</tr>


          @if($factura->estado==0)
            <tr class="text-center">
              <td class="td-color-azul">FECHA DE PAGO</td>
              <td class="td-color-azul" colspan="3">FECHA LIMITE PAGO</td>
            </tr>
            <tr class="text-center">
              <td class="td-color-blanco" style="background-color: #3c8ee6;color:white; "  > FACTURA SIN PAGAR</td>
              <td class="td-color-blanco" colspan="3" >{{$factura->limite_at}}</td>
            </tr>
          @endif


          @if($factura->estado==1)
            <tr class="text-center">
              <td class="td-color-azul">FECHA DE PAGO</td>
              <td class="td-color-azul" colspan="3">FECHA LIMITE PAGO</td>
            </tr>
           	<tr class="text-center">
           		<td class="td-color-blanco" style="background-color: #48d92a;color:white; "  > FACTURA PAGADA</td>
           	  <td class="td-color-blanco" colspan="3" >{{$factura->limite_at}}</td>
           	</tr>
          @endif

          @if($factura->estado==2)
           <tr class="text-center">
            <td class="td-color-azul">ESTADO</td>
            <td class="td-color-azul" colspan="3">FECHA LIMITE PAGO</td>
           </tr>
            <tr class="text-center">
              <td class="td-color-blanco" style="background-color: #eea00c;color:white; "  >FACTURA VENCIDA</td>
              <td class="td-color-blanco" colspan="3" >{{$factura->limite_at}}</td>
            </tr>
          @endif

          @if($factura->estado==3)
           <tr class="text-center">
            <td class="td-color-azul">ESTADO</td>
            <td class="td-color-azul" colspan="3">FECHA LIMITE PAGO</td>
           </tr>
            <tr class="text-center">
              <td class="td-color-blanco" style="background-color: #ee0c0c;color:white; "  >FACTURA CON ORDEN DE SUSPENSIÓN</td>
              <td class="td-color-blanco" colspan="3" >{{$factura->limite_at}}</td>
            </tr>
          @endif

          @if($factura->estado==4)
           <tr class="text-center">
            <td class="td-color-azul">ESTADO</td>
            <td class="td-color-azul" colspan="3">FECHA LIMITE PAGO</td>
           </tr>
            <tr class="text-center">
              <td class="td-color-blanco" style="background-color: #2ad9c0;color:white; "  >FACTURA CONGELADA</td>
              <td class="td-color-blanco" colspan="3" >{{$factura->limite_at}}</td>
            </tr>
          @endif


         	<tr class="text-center">
         		<td class="td-color-azul" >CONCEPTOS</td>
         	    <td colspan="3" class="td-color-azul">VALOR</td>
         	</tr>
         	<tr class="text-center">
         		<td class="td-color-blanco" >--</td>
         	  <td class="td-color-blanco" colspan="3" >VALOR</td>
         
         	</tr>
          
          <tr >
            <td class="text-left td-conceptos" >SALDO ANTERIOR</td>
            @if($factura->saldo_anterior > 0)
             <td class="text-center td-color-blanco"><a href="javascript:void(0);" onclick="detallefactaurasAnteriores({{$factura->id}})">{{number_format($factura->saldo_anterior, 0)}}</a></td>
            @else
             <td class="text-center td-color-blanco" colspan="3">{{number_format($factura->saldo_anterior, 0)}}</td>
            @endif
           
           
          </tr>

          <tr >
            <td class="text-left td-conceptos" >MORA</td>
            <td class="text-center td-color-blanco" colspan="3">{{number_format($factura->mora, 0)}}</td>
          
          </tr>



          <tr >
            <td class="text-left td-conceptos" >VALOR VIGILANCIA MES</td>
            <td class="text-center td-color-blanco" colspan="3">{{number_format($factura->valor_mes, 0)}}</td>
          
          </tr>


           @foreach($facturacargos as $cargo)
            <tr >
              <td class="text-left td-conceptos" >{{$cargo->cargo}}</td>
              <td class="text-center td-color-blanco" colspan="3">{{number_format($cargo->valor_default, 0)}}</td>
            
            </tr>
          @endforeach
          @if($factura->valor_abono > 0)
          <tr >
            <td class="text-left td-conceptos" >Abonos Factura</td>
            <td class="text-center td-color-blanco" colspan="3" >-{{number_format($factura->valor_abono, 0)}}</td>
          
          </tr>
          @endif
          <tr >
         		<td class="td-total text-center">VALOR TOTAL</td>
         	  <td class="td-total-gris-claro" colspan="3" >${{  number_format(($factura->valor_total + $factura->mora), 0) }}</td>
         	
         	</tr>
         	<tr class="text-left">
         		<td colspan="4">
         			Firma y Sello de Tesorería
         		</td>
         	</tr>
         	<tr class="text-left">
         		<td colspan="4">
         			-
         		</td>
         	</tr>
         	<tr class="text-left">
         		<td colspan="4">
         			<p>Esta factura presta merito ejecutivo, según articulo 77 de comercio
         		    El mal uso del agua será sancionado según estatutos aprobados</p>
         		</td>
         	</tr>
         	<tr class="text-left">
         		<td colspan="4">
         			<p>Observaciones:</p>
              <p>{{ $factura->observaciones}}</p>
         		</td>
         	</tr>
          <tr class="text-left">
            <td colspan="4">
              <p>Comunicados:</p>
                 @foreach($comunicados as $comuni)
                  <p>- {{ $comuni->descripcion}}</p>
                 @endforeach
            </td>
          </tr>
         </tbody>
      	</table>
      </div> 	
    </div>  
    <div style="text-align: right;">
      <div class="col-md-7">
        @if($permiso==true)
           @if($factura->estado==1 )
             <button  onclick="facturaPagada()" class="btn btn-success btn-lg" ><i class="far fa-money-bill-alt margin-icon" ></i>Registrar PAGO</button> 
           @else
            <button  onclick="pagarFactura({{$factura->id}},{{$factura->valor_total}},'{{$factura->propietario}}')" class="btn btn-success btn-lg" ><i class="far fa-money-bill-alt margin-icon" ></i>Registrar PAGO</button> 
           @endif
        @endif 
      </div>
    </div>    	
	</div>
  <!-- End Page Header -->
  <!-- Default Light Table -->

</div> 

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_editar_factura">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Editar Factura</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_editar_modal_factura" style='min-height: 200px;'>
      </div>
    </div>
  </div>
</div> 


<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_cargos_factura">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Agregar Cargos a Factura</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <div class="modal-body" id="contenido_modal_cargos_factura" style='min-height: 200px;'>

      </div>
    </div>
  </div>
</div> 

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_pago_factura">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Detalle del pago de la factura</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_pago_modal_factura" style='min-height: 200px;'>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_abono_factura">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Detalle del abono de la factura</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_abono_modal_factura" style='min-height: 200px;'>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_factura_congelada">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Detalle de la factura congelada</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_factura_congelada" style='min-height: 200px;'>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_factura_descongelada">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Detalle de la factura descongelada</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_factura_descongelada" style='min-height: 200px;'>
      </div>
    </div>
  </div>
</div>
<div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_facturas_no_pagadas_1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="datohtml">
        <h4 class="modal-title" id="titul_modal_usuarios">Detalle saldo facturas anteriores sin pagar
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="contenido_modal_factura_no_pagadas_1" style='min-height: 200px;'>
      </div>
    </div>
  </div>
</div>  

@endsection