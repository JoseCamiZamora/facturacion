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

class informe1Export implements FromView
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


      
      
       $cfinal=$col;
      
       

         return view('excel.informe1Export_template')->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                                ->with("fecha", $fecha_mora)
                                                ->with("generalmora", $generalmora)
                                                ->with("generalsaldo",$sumfacturasmorosos)
                                                ->with("cuentas",   $cfinal);
   
     
  }
}