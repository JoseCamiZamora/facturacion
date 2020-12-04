@extends('layouts.app')



@section('content')

<style>
#loadImg{position:absolute;z-index:999;}
#loadImg div{display:table-cell;width:200px;height:200px;background:#fff;text-align:center;vertical-align:middle;}
</style>


<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
	<div class='container'>

		  <div class="page-header row no-gutters py-4">
		    <div class="col">
		      <span class="page-subtitle">Modulo Facturas </span>
		  
		        <h4 class="page-title" >Impresión de la factura <b>{{ $factura->id }}</b> <span style='font-size: 0.6em;'></span> 
            </h4>

           <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
                 Atrás
              <a href="{{ url('facturas/detalle_factura/'.$factura->id ) }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> 
              </a>
            </div>
		
		    </div>
		  </div>


  

    <div class="row justify-content-md-center">
   


    </div>
		<div class="row justify-content-md-center">
            <div class="col-md-12"  id="panel_pdf_impresion">
            

            	<iframe src="{{ url('facturas/imprimir_factura/'.$factura->id.'') }}" style="width:100%; height:1024px; background-color: white;" >
            		
            	</iframe>

            	
            </div> 	

        </div>  

      	

	</div>
  <!-- End Page Header -->
  <!-- Default Light Table -->

</div> 



@endsection