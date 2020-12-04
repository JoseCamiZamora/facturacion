<?php


namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Factura;
use App\Valores;
use App\Cargos;
use App\FacturasCargos;
use App\Cuentas;
use Carbon\Carbon;
use App\Generacion;
use App\Exports\Informe1Export;
use App\Exports\Informe2Export;
use App\Exports\Informe3Export;
use App\Exports\Informe5Export;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;


use Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class InformesController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado_informes($aniosel=null,$messel=null){

       $cargos=Cargos::all();
       $usuario_actual=Auth::user();
        $now = Carbon::now();
        $arraydata=array();
        
        $aniosel=$now->year;
        $messel=$now->month;
        $day=$now->day-1;
        if(intval($messel)<10 ){  $messel='0'.$messel;   }
         $mesGenerado=$messel;
         $anioGenerado =$aniosel;
        
        
        $generadoactual=Generacion::all()->last();
        if($generadoactual){  
          $mesGenerado =  $generadoactual->mes;
          $anioGenerado = $generadoactual->anio;
        }

        $fecha_mora = $anioGenerado.'-'.$mesGenerado;
     
  

        $facturasacotadas=Factura::whereDate("fecha_facturado","=", Carbon::createFromFormat('Y-m-d',$anioGenerado.'-'.$mesGenerado.'-01') )
                            ->where("estado","=",0 )->where("saldada","=",0 )
                            ->get();

        $arrayfacs=array();
        $arraycants=array(); 
        $arraycantmora=array(); 
        $arraymora=array();   

        $generalmora=0;
        foreach( $facturasacotadas as $fac){

           $arrayfacs[$fac->id_cuenta]=$fac->valor_total-$fac->valor_abono;
           $arraymora[$fac->id_cuenta]=$fac->mora;
           $generalmora+=$fac->mora;

           if(!isset($arraycants[$fac->id_cuenta]) ){ $arraycants[$fac->id_cuenta]=0; $arraycantmora[$fac->id_cuenta]=0; }
            $arraycants[$fac->id_cuenta]++;
            if($fac->facturas_anteriores!=null){  
             $facta=json_decode($fac->facturas_anteriores); 
             if(count($facta)>0 ){
                $arraycants[$fac->id_cuenta]+=count($facta);
                $arraycantmora[$fac->id_cuenta]+=count($facta);

             }

            }

        }
        
       
        $col=collect([]);
        $cuentas=Cuentas::where("estado","=","A")->where("congelada","=",0) ->get();   
        $cont = 0;
        $sumfacturasmorosos=0;
        foreach($cuentas as $fac){

    
           $fac->valor_total    =0;
           $fac->cantidad_facturas=0;
           if( isset($arrayfacs[$fac->id]) ){ 

              $fac->valor_total = $arrayfacs[$fac->id]; 
              $fac->cantidad_facturas = $arraycants[$fac->id];
              $fac->cantmora= $arraycantmora[$fac->id];
              $fac->mora=  $arraymora[$fac->id];

           }

            $sumfacturasmorosos= $sumfacturasmorosos+$fac->valor_total ;
         
           $col->push($fac);          
         
       
     
          
        }


      
      
       $cfinal=$this->custom_paginate($col, 100);


      


        

       return view('informes.listado_informes')->with("usuario_actual",$usuario_actual)
                                                ->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                                ->with("fecha", $fecha_mora)
                                                ->with("generalmora", $generalmora)
                                                ->with("generalsaldo",$sumfacturasmorosos)
                                                ->with("cuentas",   $cfinal);
    }

    function custom_paginate($items, $perPage){

        $pageStart           = request('page', 1);
        $offSet              = ($pageStart * $perPage) - $perPage;
        $itemsForCurrentPage = $items->slice($offSet, $perPage);

        return new Paginator(
            $itemsForCurrentPage, $items->count(), $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
     }

    
     public function listado_facturas_no_pagadas($id_cuenta){

    


      $generadoactual=Generacion::all()->last();
      $mesGenerado =  $generadoactual->mes;
      $anioGenerado = $generadoactual->anio;

      $cuentas_fac=Factura::where("id_cuenta","=", $id_cuenta)->where("saldada","=",0)->whereDate("fecha_facturado","<=", Carbon::createFromFormat('Y-m-d',$anioGenerado.'-'.$mesGenerado.'-01') ) ->get();
      $cat_fac = count($cuentas_fac);

      $facturaact=Factura::where("id_cuenta","=", $id_cuenta)->where("saldada","=",0)->whereDate("fecha_facturado","=", Carbon::createFromFormat('Y-m-d',$anioGenerado.'-'.$mesGenerado.'-01') ) ->first();
      
      $totalmora=0;
      if( $facturaact){
         $totalmora=$facturaact->mora;
      }
       
      $facturas = array();
      if($cat_fac >= 1 ){
        foreach ($cuentas_fac as $fac) {
          array_push($facturas,$fac);
        }
      }

     foreach($facturas as $factura){
        $facturacargos = json_decode($factura->cargos);
        $totalcargos = 0;
        foreach($facturacargos as $cargo){
          $totalcargos+=$cargo->valor_default;
        }
        $factura->total_cargos= $totalcargos;
     }



      return view("informes.form_fac_no_pagadas")->with('facturas',$facturas)->with('totalmora',$totalmora);

     }




    

    
    public function listado_recaudos($aniosel=null,$messel=null){

       $cargos=Cargos::all();
       $usuario_actual=Auth::user();
        $now = Carbon::now();
        $arraydata=array();
        if($aniosel==null){ 
          $aniosel=$now->year;
          $messel=$now->month;
        }

        $sumfacturasrecaudo=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )
        										->where("estado","=",1 )->sum("valor_total");

        $sumabonos=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )
                            ->where("estado","=",0 )->where("abono","=",1 )->sum("valor_abono");

        $sumfacturasrecaudo =  $sumfacturasrecaudo + $sumabonos;


        $facturas = Factura::where("anio","=",$aniosel )->where("mes","=",$messel )
                                                        ->where("estado","=",1)
                                                        ->get();

         $facturasAB = Factura::where("anio","=",$aniosel )->where("mes","=",$messel )
                                                        ->where("estado","=",0)
                                                        ->where("abono","=",1)
                                                        ->get();

        $newfacturas=collect([]);
        $facturacargos = array();
        $moras=0;
         $newfacturas=  $facturas->merge($facturasAB);


         $items=collect([]);
        
        foreach(  $newfacturas as $factura){
       
    
        	$facturacargos = json_decode($factura->cargos);
        	$totalcargos = 0;
        	foreach($facturacargos as $cargo){
        		$totalcargos+=$cargo->valor_default;
        	}
        	$factura->total_cargos= $totalcargos;
          if($factura->estado==1){
          $moras+=  $factura->mora;
          }
          
          $items->push($factura);


        }

      
        $facfinal=$this->custom_paginate($items, 100);

        $sumfacturasrecaudo +=$moras;

       return view('informes.listado_recaudos')->with("usuario_actual",$usuario_actual)
                                                ->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                                ->with("total_recaudo",$sumfacturasrecaudo)
                                                ->with("facturas",$facfinal);
    }


    
    public function listado_recaudos_concepto($aniosel=null,$messel=null){

       $cargos=Cargos::where("estado","=",1)->get();
       $usuario_actual=Auth::user();
        $now = Carbon::now();
        $arraydata=array();
        if($aniosel==null){ 
          $aniosel=$now->year;
          $messel=$now->month;
        }

        $facturas = Factura::where("anio","=",$aniosel )->where("mes","=",$messel )
                                                        ->where("estado","=",1)
                                                        ->get();
        
        $facturasAbono = Factura::where("anio","=",$aniosel )->where("mes","=",$messel )
                                                        ->where("estado","=",0)
                                                        ->where("abono","=",1)
                                                        ->get();

        $arraycargos=array();
        $moras=0;
        $saldos_anteriores=0;
        $valores_mes=0;
        $valores_abono=0;


        foreach($facturas as $factura){
               if($factura->cargos!=null){ 
                  $ncs=json_decode($factura->cargos);

                   foreach($ncs as $nc){
                         if(!isset($arraycargos[$nc->id]) ){ $arraycargos[$nc->id]=0;  } 
                         $nc->valor_default=$nc->valor_default?$nc->valor_default:0;
                         $arraycargos[$nc->id]+=$nc->valor_default;  
                      
                   }

                  $arracr=$factura->cargos;      
               }

               $saldos_anteriores+=$factura->saldo_anterior;

               $valores_mes+=$factura->valor_mes;
               $moras+=$factura->mora;  

        }

         foreach($facturasAbono as $facturaAB){

                 $valores_abono+=$facturaAB->valor_abono;

         }

         $newcargos=collect([]);

         foreach( $cargos as $cg){
            $cg->sum_cargo=0;
            if( !isset( $arraycargos[$cg->id] )  ){ $arraycargos[$cg->id]=0;      }
            $cg->sum_cargo=$arraycargos[$cg->id];
            $newcargos->push($cg);

         }










       return view('informes.listado_recaudos_concepto')->with("usuario_actual",$usuario_actual)
                                                ->with("moras",$moras)
                                                ->with("cargos",$newcargos)
                                                ->with("valores_abono",$valores_abono)
                                                 ->with("saldos_anteriores", $saldos_anteriores)
                                                 ->with("valores_mes", $valores_mes)
                                                ->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                          
                                                ->with("facturas",$facturas);
    }


    public function listado_facturas_bancos($aniosel=null,$messel=null){
        //presenta un listado general de facturas 

        $usuario_actual=Auth::user();
        $fechaActual = date('Y-m-d');
        $now = Carbon::now();

        if($aniosel==null){ 
          $aniosel=$now->year;
          $messel=$now->month;
        }
       
       

        $facturas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )->where("tipo_pago","=",2 )->paginate(400);
        
        foreach ($facturas as $key => $value) {
          $fac_anteriores = json_decode($value->facturas_anteriores);
          $cant_facturas_ant = count($fac_anteriores);
          
          if($value->estado == 0){$value->estado = 0;}// factura sin pagar
          if($fechaActual > $value->limite_at && $value->estado == 0){$value->estado = 2;}//Factura Vencida
          if($cant_facturas_ant >= 3 && $value->estado == 0 ){$value->estado = 3;}//Orden suspencion
          if($cant_facturas_ant >= 1 && $value->estado == 0 ){$value->estado = 2;}
          if($value->estado == 1){$value->estado = 1;} //Factura pagada
        }
        return view("informes.listado_facturas_bancos")->with("usuario_actual",$usuario_actual)
                                                ->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                                ->with("facturas",$facturas);
    }


        public function mes_factura_a_generar($aniosel,$messel){

      $arrayenc = array();
      $arraymesgenerar = array();
      $fechaActual = date('Y-m-d');
      $mes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
       $count = 0;
      foreach ($mes as $key => $value) {
         $count++;
         $arrayp=array("id"=> $count , "mes"=> $value);
         array_push( $arrayenc, $arrayp);
        # code...
      }

      $generadoactual=Generacion::all()->count();
    
      if($generadoactual > 0){

        $generadoactual=Generacion::where('anio','>', 1)->orderBy('fecha', 'desc')->first();
        $ultimo_mes_generado = (int)$generadoactual->mes + 1;
        $mes_fecha_sig_factura = (int)$generadoactual->mes + 2;
        $fecha_generacion = $generadoactual->anio ."-". (string)$mes_fecha_sig_factura ."-". "01";

         //if( $fechaActual > $fecha_generacion){
          foreach ($arrayenc as $key => $value) {
            if($value["id"] == $ultimo_mes_generado){
              $arrayp1=array("id"=> $value["id"] , "mes"=> $value["mes"]);
              array_push( $arraymesgenerar, $arrayp1);
            }
          }
        // }else{
         // $arraymesgenerar = array();
         //}
      }else{
        
        $now = Carbon::now();
        $aniosel=$now->year;
        $messel1=$now->month-1;
        
        foreach ($arrayenc as $key => $value) {
          if($value["id"] == $messel1){
            $arrayp1=array("id"=> $value["id"] , "mes"=> $value["mes"]);
            array_push( $arraymesgenerar, $arrayp1);
          }
        }
      }
        return $arraymesgenerar;
    }



    public function excel_informe1($aniosel=null,$messel=null){

        if($aniosel==null){ $datev=date('Y-m-d');  }else{ $datev=$aniosel."-".$messel; }
        return Excel::download(new Informe1Export($aniosel,$messel), 'MOROSOS_AL_'.$datev.'.xlsx');

    }


    public function excel_informe2($aniosel=null,$messel=null){

          if($aniosel==null){ $datev=date('Y-m-d');  }else{ $datev=$aniosel."-".$messel; }
        return Excel::download(new Informe2Export($aniosel,$messel), 'RECAUDOS_AL_'.$datev.'.xlsx');

    }


    public function excel_informe3($aniosel=null,$messel=null){
        if($aniosel==null){ $datev=date('Y-m-d');  }else{ $datev=$aniosel."-".$messel; }

        return Excel::download(new Informe3Export($aniosel,$messel), 'BANCOS_AL_'.$datev.'.xlsx');

    }

      public function excel_informe5($aniosel=null,$messel=null){
        if($aniosel==null){ $datev=date('Y-m-d');  }else{ $datev=$aniosel."-".$messel; }

        return Excel::download(new Informe5Export($aniosel,$messel), 'CONCEPTOS_AL_'.$datev.'.xlsx');

    }

    
}