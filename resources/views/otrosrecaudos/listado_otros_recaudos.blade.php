@extends('layouts.app')



@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class='container'>

  <div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo de Otros Recaudos </span>
      <h4 class="page-title"> Registro de Recaudos<span style='font-size: 0.6em;'></span> </h4>
  
       
     
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
     <h4 class="page-title" style="text-align: center"> Formulario para otros Recaudos <span style='font-size: 0.6em;'></span> </h4>
  </div>
  <div class="card-body" style="margin-top: -20px">
  
   <form  method="post"  action="{{ url('recaudo/registrar_otros_recaudos') }}" id="f_recaudos"   >
    
    <input type="hidden" name="_token" id='_token_avatar' value="<?php echo csrf_token(); ?>"> 

        <table style="width: 100%;">
        <tr>
        	<td style="width:10%;" >Referencia:</td>
            <td> <input class="form-control" type="text" size="140" style="height: 28px;" value="" required name="referencia">   </td>
        </tr>
         <tr>
        	<td>Proveedor:</td>
            <td> <input class="form-control"  type="text" size="140"   value=""  style="height: 28px;" required name="proveedor">   </td>
        </tr>
        <tr>
             <td>Detalles:</td>
            <td> <input class="form-control"  type="text"  size="255"  value="" style="height: 28px;" required name="detalles">   </td>
        </tr>

            <td>Valor:</td>
            <td> <input class="form-control" type="number"  size="40"  value="" style="height: 28px;" required name="valor">   </td>
        </tr>

        </tr>

            <td>-</td>
            <td> <button class="btn-primary btn-sm" type="submit">Registrar</button>  </td>
        </tr>

        </table>   


  </form>


  </div>
</div>


  <div class="row" style="margin-top:20px;">
    <div class="col">

           <?php $mesesarray=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]; ?>

      <div class="row " style="margin-bottom: 20px; text-align: center">
       <div class="col-md-6" style="margin-bottom: 20px;">
        <select class="form-control" id="select_mes_val" onchange="FA_cambiar_fecha_otrosrec();">
          <option value="{{intval($messel)}}" selected >{{$mesesarray[intval($messel)] }}</option>
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
        <select class="form-control"  id="select_anio_val"  onchange="FA_cambiar_fecha_otrosrec();" >
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

         <a class="btn btn-sm btn-default"  style="float:right;" href="{{ url('/recaudo/listado_otros_recaudos_excel/'.$aniosel.'-'.$messel.'-01' ) }}" > <i class="fa fa-download" aria-hidden="true"></i> EXCEL
      </a>




      <table    class='table table-generic' style="width: 100%;" >

            <thead class="bg-light">
              <tr>
                <th scope="col" class="th-gris text-center" style="width: 50px;" >No</th>
                <th scope="col" class="th-gris text-center " style="width: 100px;"  >fecha</th>
                <th scope="col" class="th-gris text-left" style="width: 150px;"  >referencia</th>
                <th scope="col" class="th-gris text-left" style="width: 330px;">proveedor</th>
                <th scope="col" class="th-gris text-left" style="width: 330px;" >detalles</th>
                <th scope="col" class="th-gris text-left" style="width: 100px;">valor</th>
             
            
              </tr>
            </thead>
            <tbody>
               <?php  $total=0; ?>
              @foreach($recaudos as $recaudo)

                <tr>
                  <td class='text-center' style="background-color: #dee2ec; font-weight: 700;border:1px solid white !important;" >
                  	{{ $loop->index+1 }}
                  </td>
                    <td  class="   text-center" style="font-size: 0.8em;">
                     {{ $recaudo->created_at->format('Y-m-d') ?? ""  }}
                  </td>
                  <td  class="   text-left">
                     {{ $recaudo->referencia ?? ""  }}
                  </td>
                  <td  class="   text-left">
                     {{ $recaudo->proveedor ?? "" }}
                  </td>
                  <td  class="   text-left">
                    {{ $recaudo->detalles ?? "" }}
                  </td>
                  <td  class="   text-left">
                     {{ number_format( $recaudo->valor,2) ?? "" }}
                  </td>
                  <td>
                  	 <a class="text-center" role="button" id="subirfile"  href="{{ url('recaudo/borrar_otro_recaudo/'. $recaudo->id ) }}">
                     
                         <i class="fa fa-times" title="Inactivar"></i>
                    </a>
                  </td>
                 <?php  $total+=$recaudo->valor; ?>
              
               
                </tr>

              @endforeach
            </tbody>
               <tfoot>
              <tr>
              	<td></td>
              	<td></td>
              	<td></td>
              	<td></td>
              	<td></td>
              	<td style="background-color: #dee2ec; font-weight: 700;border:1px solid white !important;" >
              		{{ number_format($total,2)  }}</td>
              		<td></td>
              
              </tr>
              </tfoot>
          </table>
      
         </div> 
  </div>

  

  
</div>
  <!-- End Default Light Table -->
</div>

@endsection