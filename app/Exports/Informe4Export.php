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
use App\OtrosRecaudos;

use Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class informe4Export implements FromView
{


   protected $fecha;


   function __construct($fecha=null) {
        $this->fecha = $fecha;
   }

  public function view(): View
  {
         
         $fecha= $this->fecha;
         $timestamp = strtotime($fecha);
         $aniosel=date("Y", $timestamp);
         $messel=date("m", $timestamp);
         $recaudos=OtrosRecaudos::whereMonth('created_at', '=',  $messel)
                                 ->whereYear('created_at', '=',  $aniosel)->get();
      
         return view('excel.informe4Export_template')->with('messel',  $messel )
                                                            ->with('aniosel',  $aniosel )
                                                            ->with('recaudos',  $recaudos );
   
     
  }



}