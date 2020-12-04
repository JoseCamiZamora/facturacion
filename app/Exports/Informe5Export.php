<?php

namespace App\Exports;

use App\User;
use App\Factura;
use App\Valores;
use App\Cargos;
use App\FacturasCargos;
use App\Cuentas;
use Carbon\Carbon;
use App\Generacion;

use Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class informe5Export implements FromView
{


   protected $aniosel;
   protected $messel;

   function __construct($anio=null,$mes=null) {
        $this->aniosel = $anio;
        $this->messel = $mes;
   }

   public function view(): View
   {
        
         $aniosel=$this->aniosel ;
         $messel=$this->messel;
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




       return view('excel.informe5Export_template')->with("usuario_actual",$usuario_actual)
                                                ->with("moras",$moras)
                                                ->with("cargos",$newcargos)
                                                ->with("valores_abono",$valores_abono)
                                                 ->with("saldos_anteriores", $saldos_anteriores)
                                                 ->with("valores_mes", $valores_mes)
                                                ->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                          
                                                ->with("facturas",$facturas);
   
     
  }
}