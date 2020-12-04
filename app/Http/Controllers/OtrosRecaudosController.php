<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Cuentas;
use App\Cargos;
use App\Valores;
use App\OtrosRecaudos;
use Auth;
use Redirect;
use App\Exports\Informe4Export;
use Maatwebsite\Excel\Facades\Excel;

class OtrosRecaudosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado_otros_recaudos($fecha=null){


      if($fecha==null){ $fecha=date('Y-m-d'); }

         $timestamp = strtotime($fecha);
         $aniosel=date("Y", $timestamp);
         $messel=date("m", $timestamp);
         $recaudos=OtrosRecaudos::whereMonth('created_at', '=',  $messel)
                                 ->whereYear('created_at', '=',  $aniosel)->get();
      
         return view('otrosrecaudos.listado_otros_recaudos')->with('messel',  $messel )
                                                            ->with('aniosel',  $aniosel )
                                                            ->with('recaudos',  $recaudos );
    }


     public function registrar_otros_recaudos(Request $request){

         $fecha=date('Y-m-d H:i:s');  
         $recaudos=new OtrosRecaudos;
         $recaudos->referencia=$request->input("referencia");
         $recaudos->proveedor=$request->input("proveedor");
         $recaudos->detalles=$request->input("detalles");
         $recaudos->valor=$request->input("valor");
         $recaudos->save();

         $timestamp = strtotime($fecha);
         $aniosel=date("Y", $timestamp);
         $messel=date("m", $timestamp);
         $recaudos=OtrosRecaudos::whereMonth('created_at', '=',  $messel)
                                 ->whereYear('created_at', '=',  $aniosel)->get();
      
         return view('otrosrecaudos.listado_otros_recaudos')->with('messel',  $messel )
                                                            ->with('aniosel',  $aniosel )
                                                            ->with('recaudos',  $recaudos );



     }
     public function borrar_otro_recaudo($idrecaudo=0){

         $recaudosel=OtrosRecaudos::find($idrecaudo);
         if(!$recaudosel){ return Redirect::back()->withErrors(['msg', 'error']); }   
         $fecha= $recaudosel->created_at;  
         $recaudosel->delete();

         $timestamp = strtotime($fecha);
	     $aniosel=date("Y", $timestamp);
	     $messel=date("m", $timestamp);
	     $recaudos=OtrosRecaudos::whereMonth('created_at', '=',  $messel)
	                              ->whereYear('created_at', '=',  $aniosel)->get();

	       
         return view('otrosrecaudos.listado_otros_recaudos')->with('messel',  $messel )
                                                            ->with('aniosel',  $aniosel )
                                                            ->with('recaudos',  $recaudos );





     }

     public function listado_otros_recaudos_excel($fecha=null){

      if($fecha==null){  $fecha=Date('Y-m-d'); } 
            
      return Excel::download(new Informe4Export($fecha), 'recaudos_AL_'.$fecha.'.xlsx');

     
      }

   

     

 
}