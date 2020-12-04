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

class informe2Export implements FromView
{


   protected $anio;
   protected $mes;

   function __construct($anio=null,$mes=null) {
        $this->anio = $anio;
        $this->mes = $mes;
   }

  public function view(): View
  {
         $aniosel=$this->anio;
         $messel=$this->mes;
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

      
        $facfinal=$items;

        $sumfacturasrecaudo +=$moras;

       return view('excel.informe2Export_template')->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                                ->with("total_recaudo",$sumfacturasrecaudo)
                                                ->with("facturas",$facfinal);
   
     
  }
}