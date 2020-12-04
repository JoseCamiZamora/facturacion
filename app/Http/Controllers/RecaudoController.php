<?php


namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Factura;
use App\Cargos;
use App\Recaudo;
use App\Valores;
use App\FacturasCargos;
use App\Cuentas;
use Carbon\Carbon;


use Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class RecaudoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado_facturas($aniosel=null,$messel=null){
        //presenta un listado general de facturas 
        $usuario_actual=Auth::user();
        $now = Carbon::now();
        if($aniosel==null){ 
          $aniosel=$now->year;
          $messel=$now->month;
        }

        $facturas=Factura::where("anio","=",$aniosel )
                          ->where("mes","=",$messel )
                          ->where("estado","=",100 )
                          ->paginate(100);

        
        return view("recaudo.listado_facturas")->with("usuario_actual",$usuario_actual)
                                                ->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                                ->with("facturas",$facturas);
    }

     public function buscar_factura(Request $request){


       $usuario_actual=Auth::user();
       $dato=$request->input("dato_buscado");
       $aniosel = $request->input("aniosel");
       $messel = $request->input("messel");
       $now = Carbon::now();

      $facturas=Factura::where("id","like","%".$dato."%")
                ->orWhere("propietario","like","%".$dato."%")
                ->paginate(100)
                ->appends(request()->query());
     
      return view('recaudo.listado_facturas')->with("usuario_actual",$usuario_actual)
                                              ->with("busqueda",true)
                                              ->with("aniosel",$aniosel)
                                              ->with("messel", $messel)
                                              ->with("facturas",$facturas);

    }

     public function detalle_factura($id_factura){
       $usuario_actual=Auth::user();
       $facturasel=Factura::find($id_factura);

       if(!$facturasel){ 
        return view('facturas.mensajes.msj_factura_no_existe')
              ->with("msj","No existe factura con el id seleccionado");  
       }
     
       $anio_p ="";
       $mes_p= "";
       $day_p="";
       $saldoanterior=0;
       $totalmes=0;
       $totalFactura=0;

       $valores= Valores::where("tipo_cuenta","=",$facturasel->tipo_factura)->first();
       if($valores){   $totalmes=$valores->valor_default;  }
       $totalFactura+=$totalmes;
       

       if($facturasel->estado==1){
         $fechapagada=Carbon::createFromFormat('Y-m-d H:i:s', $facturasel->pagada_at);
         $anio_p =$fechapagada->year;
         $mes_p= $fechapagada->month;
         $day_p=$fechapagada->day;

       }

       $facturacargos = array();
       if($facturasel->cargos != null){

           $facturacargos = json_decode($facturasel->cargos);
           
           foreach($facturacargos as $cargo){

               $totalFactura+=$cargo->valor_default;
           }
       }
       

       return view("recaudo.detalle_factura")->with("usuario_actual",$usuario_actual)
                                              ->with("facturacargos",$facturacargos)
                                              ->with("saldoanterior",$saldoanterior)
                                              ->with("totalmes", $totalmes)
                                              ->with("totalFactura",$totalFactura)
                                              ->with('anio_p',$anio_p )
                                              ->with('mes_p',$mes_p )
                                              ->with('day_p',$day_p )
                                              ->with("factura",$facturasel);


    }

    


     public function info_pago_factura($id_factura, $valor){

     
       $usuario_actual=Auth::user();
       $facturasel=Factura::find($id_factura);
       $fecha = date("Y-m-d");
       $valoTmp = 0;
       if($facturasel->abono == 1){
          
          $valoTmp = (int)$facturasel->valor_total+(int)$facturasel->mora -(int)$facturasel->valor_abono;
          $facturasel->valor_total = $valoTmp;

        }
       return view("recaudo.detalle_pago_factura")->with("usuario_actual",$usuario_actual)
                                              ->with("fecha",$fecha)
                                              ->with("valor",$valor)
                                              ->with("factura",$facturasel);


     }

     public function info_abono_factura($id_factura, $valor){

     
       $usuario_actual=Auth::user();
       $facturasel=Factura::find($id_factura);
       $fecha = date("Y-m-d");
        //return dd("valor",$facturasel->valor_total);
       if($facturasel->abono == 1){
          
          $valoTmp = (int)$facturasel->valor_total  -(int)$facturasel->valor_abono;
          $facturasel->valor_total = $valoTmp ;

       }

       $valorAbono = (int)$facturasel->valor_total * 0.5;
       //return dd("valorAbono",$valorAbono);
       return view("recaudo.detalle_abono_factura")->with("usuario_actual",$usuario_actual)
                                              ->with("fecha",$fecha)
                                              ->with("valor",$valor)
                                              ->with("valorAbono",$valorAbono)
                                              ->with("factura",$facturasel);


     }
     

     

  }