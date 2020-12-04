@extends('layouts.app')



@section('content')

<div class="container">
    <div class="page-header row no-gutters py-4">
      <div class="col-12 col-sm-10 text-center text-sm-left mb-4 mb-sm-0">
         <h4 class="page-title">RECAUDADOR</h4>
        <h4 class="page-title">Bienvenido : {{ $usuario_actual->nombres }} </h4>
      </div>
    </div>
    <div class="row">


 

    

      <div class="col-12 col-md-6 col-lg-3 mb-4">
        <div class="stats-small card card-small">
          <div class="card-body px-0 pb-0" >
           <div class="d-flex px-3 text-center">
           
                 <a href="{{ url('recaudo/listado_facturas') }}" style='width: 100%'>
            
                <img src="{{ asset('/assets/img/recaudo.svg') }}" style='max-height: 40px;' onerror="this.onerror=null; this.src='image.png'">
              
                <h4 style='margin-bottom: 1px;' >Pagos</h4>
                <span  class="text-primary" style="font-size:0.9em;margin-top:1px;" >Pagar Facturas </span>
                </a>
             
            </div>
          </div>
        </div>
      </div>



      <div class="col-12 col-md-6 col-lg-3 mb-4">
        <div class="stats-small card card-small">
          <div class="card-body px-0 pb-0" >
           <div class="d-flex px-3 text-center">
           
                 <a href="{{ url('recaudo/listado_otros_recaudos') }}" style='width: 100%'>
            
                <img src="{{ asset('/assets/img/recaudo.svg') }}" style='max-height: 40px;' onerror="this.onerror=null; this.src='image.png'">
              
                <h4 style='margin-bottom: 1px;' >Otros Recaudos</h4>
                <span  class="text-primary" style="font-size:0.9em;margin-top:1px;" >Otros Recaudos </span>
                </a>
             
            </div>
          </div>
        </div>
      </div>

    

 










    





 


      <div class="col-md-12 ">
                  <div class="card-header border-bottom">
                  
                    <div class="block-handle"></div>
                  </div>
                
                 <div class="card-body p-0" id="bloque_actividad_reciente" >  
                    

                 </div>
                   
      </div>






  


              


  </div>
</div>




@endsection
