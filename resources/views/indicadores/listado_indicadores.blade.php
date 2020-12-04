@extends('layouts.app')



@section('content')

<div class="main-content-container container-fluid px-4 pb-4">
     <!-- Page Header -->
  <div class='container'>


  	<div class="page-header row no-gutters py-4">
    <div class="col">
      <span class="page-subtitle">Modulo indicadores  </span>
  
        <h4 class="page-title" >Indicadores Graficos   <span style='font-size: 0.6em;'></span> </h4>
     
       <div  class=" ml-auto" style="text-align: right; margin-top: -35px;">
        Atrás
        <a href="{{ url('home') }}" class="mb-2 btn btn-sm  mr-1 btn-redondo-suave text-primary" title="salir a menu" ><i class="fa fa-chevron-left" aria-hidden="true"></i> </a>
      </div>
    </div>
  </div>
   <?php $mesesarray=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]; ?>

   <div class="stats-small card card-small">
      <div class="card-body">
       <h4 class="page-title" style="text-align:center;" >Fitros de busqueda  <span style='font-size:1.6em;'></span> </h4>
       <div class="row justify-content-md-center" style="margin-bottom: 20px;">
         <div class="col-md-4">
          <select class="form-control" id="select_mes_val" onchange="IN_cambiar_fecha_indicadores();">
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
          <select class="form-control"  id="select_anio_val"  onchange="IN_cambiar_fecha_indicadores();" >
             @for($i = 2018; $i <=$aniosel  ; $i++)
             @if($i==$aniosel )
               <option value="{{ $i }}" selected >{{ $i }}</option>
               @else
               <option value="{{ $i }}" >{{ $i }}</option>
             @endif
            @endfor
          </select>
        </div>
      </div>
    </div>
  </div>
  <br><br>
  <table style="width: 100%;  font-size: 0.9em; padding: 10 10 10 10; margin-bottom: 20px; border-top: 2px solid #0f62ab;" >
    <h3 class=" page-title">Cantidad de facturas pagadas y total recuado</h3>
      <tr><td style='width:20%' style="background-color: white; vertical-align: middle;" ><strong>
  </table>
  <div class="row" style="margin-top:20px;">
    <div  class="col-md-7"  style="background-color: white;margin-left: 10px; margin-right:  10px;">
       <br><br>
        <div  id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
         <table class="file-manager file-manager-list d-none table-responsive dataTable no-footer dtr-inline" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 1076px;">
            <thead class="bg-light">
              <tr>
                <th class="text-center sorting th-azul" >N°</th>
                <th class="text-center sorting th-azul" >Facturas</th>
                <th class="text-center sorting th-azul" >Cantidad Facturas</th>
                <th class="text-center sorting th-azul" >Total</th>
                <th class="text-center sorting th-azul" >Porcentaje</th>
              </tr>
            </thead>
            <tbody>
               <tr>
                <th scope="row" style="text-align: center">1</th>
                <td>Pagadas</td>
                <td>{{$facpagadas}}</td>
                <td style="text-align: left;">${{number_format($sumfacturasPagadas, 0)}}</td>
                <td>{{$prpagadas}}%</td>
              </tr>
              <tr>
                <th scope="row" style="text-align: center">2</th>
                <td>Abonos</td>
                <td>{{$facabonos}}</td>
                <td style="text-align: left;">${{number_format($sumfacturasAbonos, 0)}}</td>
                <td>{{$prabonos}}%</td>
              </tr>
               <tr>
                <th scope="row" style="text-align: center">3</th>
                <td>No Pagadas</td>
                <td>{{$facnopagadas}}</td>
                <td style="text-align: left;">${{number_format($sumfacturasNoPagadas, 0)}}</td>
                <td>{{$prnopagadas}}%</td>
              </tr>
            </tbody>
          </table>
        </div>
     </div>
     <div  class="col-md-4"  style="background-color: white; margin-left: 10px; margin-right: : 10px; padding-top: 30px;" >
        <div id="canvas-holder" >
            <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class=""></div>
            </div>
            </div>
            <canvas id="chart-area" style="display: block; width: 540px; height: 270px;margin-top:23px;" width="540" height="270" class="chartjs-render-monitor"></canvas>
        </div>
    </div>
  </div>
  <br><br>
  <table style="width: 100%;  font-size: 0.9em; padding: 10 10 10 10; margin-bottom: 20px; border-top: 2px solid #0f62ab;" >
    <h3 class=" page-title">Indicador de Cargos</h3>
      <tr><td style='width:20%' style="background-color: white; vertical-align: middle;" ><strong>
  </table>

  <div class="row" style="margin-top:20px;">
       <div  class="col-md-12"  style="background-color: white;margin-left: 10px; margin-right:  10px;">
        <br>
        <div  id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
         <table class="file-manager file-manager-list d-none table-responsive dataTable no-footer dtr-inline" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 1076px;">
            <thead class="bg-light">
              <tr>
                <th class="text-center sorting th-azul" >N°</th>
                <th class="text-center sorting th-azul" >Tipo</th>
                <th class="text-center sorting th-azul" >Cantidad cargos pagados</th>
                <th class="text-right sorting th-azul" >Valor cargos Pagados</th>
                <th class="text-center sorting th-azul"  >Cantidad cargos no pagadas</th>
                <th class="text-right sorting th-azul"  >Total deuda caergos</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" style="text-align: center">1</th>
                <td style="text-align: left;">Multas</td>
                <td>{{$cargos['cant_multasP']}}</td>
                <td style="text-align: right;">${{number_format($cargos['multas'], 0)}}</td>
                <td>{{$cargosNoPagadas['cant_multasPno']}}</td>
                <td style="text-align: right;">${{number_format($cargosNoPagadas['multasno'], 0)}}</td>
              </tr>
               <tr>
                <th scope="row" style="text-align: center">2</th>
                <td style="text-align: left;">Temdemcia M</td>
                 <td>{{$cargos['cant_tendenciaP']}}</td>
                <td style="text-align: right;">${{number_format($cargos['tendencia'], 0)}}</td>
                <td>{{$cargosNoPagadas['cant_tendenciaPno']}}</td>
                <td style="text-align: right;">${{number_format($cargosNoPagadas['tendenciano'], 0)}}</td>
              </tr>
               <tr>
                <th scope="row" style="text-align: center">3</th>
                <td style="text-align: left;" >LLaves y Accesorios</td>
                 <td>{{$cargos['cant_llavesP']}}</td>
                <td style="text-align: right;">${{number_format($cargos['llavesaccesorios'], 0)}}</td>
                <td>{{$cargosNoPagadas['cant_llavesPno']}}</td>
                <td style="text-align: right;">${{number_format($cargosNoPagadas['llavesaccesoriosno'], 0)}}</td>
              </tr>
               <tr>
                <th scope="row" style="text-align: center">4</th>
                <td style="text-align: left;" >Tanques</td>
                 <td>{{$cargos['cant_tanqueP']}}</td>
                <td style="text-align: right;">${{number_format($cargos['tanque'], 0)}}</td>
                <td>{{$cargosNoPagadas['cant_tanquePno']}}</td>
                <td style="text-align: right;">${{number_format($cargosNoPagadas['tanqueno'], 0)}}</td>
              </tr>
               <tr>
                <th scope="row" style="text-align: center">5</th>
                <td style="text-align: left;">Recargos</td>
                 <td>{{$cargos['cant_recargosP']}}</td>
                <td style="text-align: right;">${{number_format($cargos['recargos'], 0)}}</td>
                <td>{{$cargosNoPagadas['cant_recargosPno']}}</td>
                <td style="text-align: right;">${{number_format($cargosNoPagadas['recargosno'], 0)}}</td>
              </tr>
               <tr>
                <th scope="row" style="text-align: center">6</th>
                <td style="text-align: left;">Otros</td>
                 <td>{{$cargos['cant_otrosP']}}</td>
                <td style="text-align: right;">${{number_format($cargos['otros'], 0)}}</td>
                <td>{{$cargosNoPagadas['cant_otrosPno']}}</td>
                <td style="text-align: right;">${{number_format($cargosNoPagadas['otrosno'], 0)}}</td>
              </tr>
            </tbody>
          </table>
        </div>
     </div>
  </div>
  <br><br>
  <div class="row" style="margin-top:10px; text-align: center;">
    
     <div  class="col-md-3"  style="background-color: white; margin-left: 180px; margin-right: : 10px; padding-top: 20px;" >
      <h4 class="page-title" >Multas <span style='font-size: 0.6em;'></span> </h4>
          <div id="canvas-holder" >
              <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
              </div>
              <canvas id="chart-area-multas" style="display: block; width: 340px; height: 270px;margin-top:10px;" width="540" height="270" class="chartjs-render-monitor"></canvas>
          </div>
      </div>
       <div  class="col-md-3"  style="background-color: white; margin-left: 10px; margin-right: : 10px; padding-top: 20px;" >
         <h4 class="page-title" >Tendencia M <span style='font-size: 0.6em;'></span> </h4>
          <div id="canvas-holder" >
              <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
              </div>
              <canvas id="chart-area-tendencia" style="display: block; width: 540px; height: 270px;margin-top:10px;" width="540" height="270" class="chartjs-render-monitor"></canvas>
          </div>
      </div>
       <div  class="col-md-3"  style="background-color: white; margin-left: 10px; margin-right: : 10px; padding-top: 20px;" >
        <h4 class="page-title" >Llaves y Accesorios<span style='font-size: 0.6em;'></span> </h4>
          <div id="canvas-holder" >
              <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
              </div>
              <canvas id="chart-area-llaves" style="display: block; width: 540px; height: 270px;margin-top:10px;" width="540" height="270" class="chartjs-render-monitor"></canvas>
          </div>
      </div>
  </div>
  <div class="row" style="margin-top:20px; text-align: center;">
    <div  class="col-md-3"  style="background-color: white; margin-left: 180px; margin-right: : 10px; padding-top: 20px;" >
      <h4 class="page-title" >Tanques<span style='font-size: 0.6em;'></span> </h4>
        <div id="canvas-holder" >
            <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class=""></div>
            </div>
            </div>
            <canvas id="chart-area-tanque" style="display: block; width: 540px; height: 270px;margin-top:10px;" width="540" height="270" class="chartjs-render-monitor"></canvas>
        </div>
    </div>
     <div  class="col-md-3"  style="background-color: white; margin-left: 10px; margin-right: : 10px; padding-top: 20px;" >
      <h4 class="page-title" >Recargos<span style='font-size: 0.6em;'></span> </h4>
        <div id="canvas-holder" >
            <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class=""></div>
            </div>
            </div>
            <canvas id="chart-area-recargos" style="display: block; width: 540px; height: 270px;margin-top:10px;" width="540" height="270" class="chartjs-render-monitor"></canvas>
        </div>
    </div>
    <div  class="col-md-3"  style="background-color: white; margin-left: 10px; margin-right: : 10px; padding-top: 20px;" >
      <h4 class="page-title" >Otros<span style='font-size: 0.6em;'></span> </h4>
        <div id="canvas-holder" >
            <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class=""></div>
            </div>
            </div>
            <canvas id="chart-area-otros" style="display: block; width: 540px; height: 270px;margin-top:10px;" width="540" height="270" class="chartjs-render-monitor"></canvas>
        </div>
    </div>
  </div>

</div>
<script type="text/javascript">
  console.log("llego aqui");
  document.addEventListener("DOMContentLoaded", function(event) { 
    IND_renderizar_indicador1({{$facpagadas}},{{$facnopagadas}},{{$facabonos}});
    IND_renderizar_cargo_multa({{$cargos['cant_multasP']}},{{$cargosNoPagadas['cant_multasPno']}});
    IND_renderizar_cargo_tendencia({{$cargos['cant_tendenciaP']}},{{$cargosNoPagadas['cant_tendenciaPno']}});
    IND_renderizar_cargo_llavesaccesorios({{$cargos['cant_llavesP']}},{{$cargosNoPagadas['cant_llavesPno']}});
    IND_renderizar_cargo_tanque({{$cargos['cant_tanqueP']}},{{$cargosNoPagadas['tanqueno']}});
    IND_renderizar_cargo_recargos({{$cargos['cant_recargosP']}},{{$cargosNoPagadas['recargosno']}});
    IND_renderizar_cargo_otros({{$cargos['cant_otrosP']}},{{$cargosNoPagadas['cant_otrosPno']}});
    //do work
  });

  
</script>
@endsection

