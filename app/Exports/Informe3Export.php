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

class informe3Export implements FromView
{


   protected $anio;
   protected $mes;

   function __construct($anio=null,$mes=null) {
        $this->anio = $mes;
   }

  public function view(): View
  {
         $aniosel=$this->anio;
         $messel=$this->mes;
        
        $fechaActual = date('Y-m-d');
        $now = Carbon::now();

        if($aniosel==null){ 
          $aniosel=$now->year;
          $messel=$now->month;
        }


        $facturas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )->where("tipo_pago","=",2 )->paginate(1000);
        
        foreach ($facturas as $key => $value) {
          $fac_anteriores = json_decode($value->facturas_anteriores);
          $cant_facturas_ant = count($fac_anteriores);
          
          if($value->estado == 0){$value->estado = 0;}// factura sin pagar
          if($fechaActual > $value->limite_at && $value->estado == 0){$value->estado = 2;}//Factura Vencida
          if($cant_facturas_ant >= 3 && $value->estado == 0 ){$value->estado = 3;}//Orden suspencion
          if($cant_facturas_ant >= 1 && $value->estado == 0 ){$value->estado = 2;}
          if($value->estado == 1){$value->estado = 1;} //Factura pagada
        }
        return view("excel.informe3Export_template")
                                                ->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                                ->with("facturas",$facturas);
   
     
  }
}