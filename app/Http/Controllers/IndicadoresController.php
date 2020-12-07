<?php


namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\User;
use App\Factura;
use App\Valores;
use App\Cargos;
use App\FacturasCargos;
use App\Cuentas;
use Carbon\Carbon;
use Response;
use Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class IndicadoresController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado_indicadores($aniosel=null,$messel=null){

        $now = Carbon::now();
        if($aniosel==null){ 
          $aniosel=$now->year;
          $messel=$now->month;
        }

        $sumValores = IndicadoresController::sum_recuado($aniosel,$messel);
        $sumfacturasPagadas = $sumValores["sumfacturasPagadas"];
        $sumfacturasNoPagadas = $sumValores["sumfacturasNoPagadas"];
        $sumfacturasAbonos = $sumValores["sumfacturasAbonos"];

        $countValores = IndicadoresController::cant_recuado($aniosel,$messel);
        $facpagadas = $countValores['facturasPagadas'];
        $facnopagadas = $countValores['facturasNoPagadas'];
        $facabonos = $countValores['facturasAbonos'];
        $prpagadas = $countValores['promedioPagadas'];
        $prnopagadas = $countValores['promedioNoPagadas'];
        $prabonos = $countValores['promedioAbonos'];


        $cargosFactura = IndicadoresController::cargosFactura($aniosel,$messel);
        $cargosFacturaNoPagadas = IndicadoresController::cargosFacturaNoPagadas($aniosel,$messel);
        
        

        //return dd("datos", $promedioPagadas,$promedioNoPagadas);

       return view('indicadores.listado_indicadores')->with("aniosel",$aniosel)
              ->with("messel", $messel)->with("facpagadas", $facpagadas)->with("facabonos", $facabonos)
              ->with("facnopagadas", $facnopagadas)->with("prpagadas", $prpagadas)
              ->with("prnopagadas", $prnopagadas)->with("sumfacturasPagadas", $sumfacturasPagadas)
              ->with("sumfacturasNoPagadas", $sumfacturasNoPagadas)->with("prabonos", $prabonos)
              ->with("cargos", $cargosFactura)->with("sumfacturasAbonos", $sumfacturasAbonos)
              ->with("cargosNoPagadas",$cargosFacturaNoPagadas);
             
    }

    public function sum_recuado($aniosel=null,$messel=null){

   
       $sumfacturasPagadas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )
                                                             ->where("estado","=",1 )
                                                             ->sum("valor_total");
     
      $sumfacturasNoPagadas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )->where("estado","=",0 )->get()->sum("valor_total");

      $sumfacturasAbonos=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )->where("estado","=",0 )->where("abono","=",1 )->get()->sum("valor_abono");

        $recordarray=array(
          'sumfacturasPagadas'=>$sumfacturasPagadas,
          'sumfacturasNoPagadas'=>$sumfacturasNoPagadas,
          'sumfacturasAbonos'=>$sumfacturasAbonos
        );
     //return  $sumfacturasPagadas, $sumfacturasNoPagadas;
      
      return  $recordarray;
      
    }

    public function cant_recuado($aniosel=null,$messel=null){

        $facturasPagadas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel)
                        ->where("estado","=",1 )->get()->count();
        $facturasNoPagadas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel)->where("estado","=",0 )->get()->count();

        $facturasAbonos = Factura::where("anio","=",$aniosel )->where("mes","=",$messel)->where("estado","=",0 )->where("abono","=",1 )->get()->count();

        //return dd("llego aqui",$facturasAbonos);
       
        if($facturasPagadas > 0){
          $totalFacturas = $facturasPagadas +  $facturasNoPagadas;
          $promedioPagadas = round($facturasPagadas*100/$totalFacturas,2);
          $promedioNoPagadas = round($facturasNoPagadas*100/$totalFacturas,2);
          $promedioAbonos = round($facturasAbonos*100/$totalFacturas,2);
        }else{
          $totalFacturas = $facturasPagadas +  $facturasNoPagadas;
          $promedioPagadas = 0;
          $promedioNoPagadas = 100;
          $promedioAbonos = 0;
        }
        $recordarray=array(
          'facturasPagadas'=>$facturasPagadas,
          'facturasNoPagadas'=>$facturasNoPagadas,
          'facturasAbonos'=>$facturasAbonos,
          'promedioPagadas'=>$promedioPagadas,
          'promedioNoPagadas'=>$promedioNoPagadas,
          'promedioAbonos' =>  $promedioAbonos
        );
      return  $recordarray;
    }
    public function cargosFactura($aniosel=null,$messel=null){


      $facturas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel)
                                                    ->where("estado","=",1 )
                                                    ->get();                                                       
       $valorMultas = 0;
       $otros = 0;

       $cant_multasP = 0;
       $cant_otrosP = 0;

       foreach($facturas as $fac){

        $id_factura = $fac->id;

        $facturacargo = array();
        
          $facturacargo = json_decode($fac->cargos);
          foreach($facturacargo as $cargo){
            if($cargo->id ==1){
               $valorMultas += $cargo->valor_default;
               if($cargo->valor_default > 0){
                  $cant_multasP ++;
               }
            } 
             if($cargo->id ==6){
               $otros += $cargo->valor_default;
               if($cargo->valor_default > 0){
                  $cant_otrosP ++;
               }
            }
          }
       }

        $recordarray=array(
          'multas'=>$valorMultas,
          'otros'=>$otros,
          'cant_multasP'=> $cant_multasP,
          'cant_otrosP'=> $cant_otrosP
        );

       return $recordarray;
    }

     public function cargosFacturaNoPagadas($aniosel=null,$messel=null){

       $facturas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )->where("estado","=",0 )
                                      ->get();
       $valorMultas = 0;
       $otros = 0;

       $cant_multasP = 0;
       $cant_otrosP = 0;

       foreach($facturas as $fac){

        $id_factura = $fac->id;

        $facturacargo = array();
        
          $facturacargo = json_decode($fac->cargos);
          foreach($facturacargo as $cargo){
            if($cargo->id ==1){
               $valorMultas += $cargo->valor_default;
               if($cargo->valor_default > 0){
                  $cant_multasP ++;
               }
            }
             if($cargo->id ==6){
               $otros += $cargo->valor_default;
               if($cargo->valor_default > 0){
                  $cant_otrosP ++;
               }
            }
          }
       }
        $recordarray=array(
          'multasno'=>$valorMultas,
          'otrosno'=>$otros,
          'cant_multasPno'=> $cant_multasP,
          'cant_otrosPno'=> $cant_otrosP
        );
       return $recordarray;
     }
}