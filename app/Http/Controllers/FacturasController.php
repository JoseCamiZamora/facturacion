<?php


namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Factura;
use App\Valores;
use App\Cargos;
use App\CargosMora;
use App\FacturasCargos;
use App\Cuentas;
use App\Abonos;
use App\Generacion;
use App\Factura_congelada;
use App\Avisos_sistema;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use PDF;
use DateTime;

use Auth;
use Illuminate\Support\Facades\View;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class FacturasController extends Controller
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
        $fechaActual = date('Y-m-d');
        $now = Carbon::now();

        if($aniosel==null){ 
          $aniosel=$now->year;
          $messel=$now->month;
        }

        $genActual= Generacion::where("id", ">", 0)->orderBy("fecha", "DESC")->first();

        if($genActual){ 
          $lasatdate=$genActual->fecha; 
          $proximafecha = date('Y-m-d', strtotime("+1 months", strtotime( $lasatdate)));
          $pf=DateTime::createFromFormat("Y-m-d",  $proximafecha);
          $nwanio=intval( $pf->format("Y") );
          $nwmes=intval( $pf->format("m") );

        }
        else{
          $ld=date("Y-m-d");
          $proximafecha = date('Y-m-d', strtotime("-1 months", strtotime( $ld )));
          $pf=DateTime::createFromFormat("Y-m-d",  $proximafecha);
          $nwanio=intval($pf->format("Y") );
          $nwmes=intval($pf->format("m") );

        }


      
        $facturas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )->paginate(100);
        
        foreach ($facturas as $key => $value) {
          $fac_anteriores = json_decode($value->facturas_anteriores);
          $cant_facturas_ant = count($fac_anteriores);
          
          if($value->estado == 0){$value->estado = 0;}// factura sin pagar
          if($fechaActual > $value->limite_at && $value->estado == 0){$value->estado = 2;}//Factura Vencida
          if($cant_facturas_ant >= 3 && $value->estado == 0 ){$value->estado = 3;}//Orden suspencion
          if($cant_facturas_ant >= 1 && $value->estado == 0 ){$value->estado = 2;}
          if($value->estado == 1){$value->estado = 1;} //Factura pagada
          if($value->congelada == 1){$value->estado = 4;} //Factura Congelada
        }

          

       // return dd("anio",$aniosel);
        return view("facturas.listado_facturas")->with("usuario_actual",$usuario_actual)
                                                ->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                                ->with("facturas",$facturas)
                                                ->with("nwmes",$nwmes)
                                                ->with("nwanio", $nwanio);
    }

        public function buscar_factura(Request $request){

      $usuario_actual=Auth::user();
      $usuario_actual=Auth::user();
      $fechaActual = date('Y-m-d');
      $dato=$request->input("dato_buscado");
      $facturas=Factura::where("id","like","%".$dato."%")
                ->orwhere("propietario","like","%".$dato."%")
                ->paginate(100)
                ->appends(request()->query());
      $now = Carbon::now();
      $aniosel=$now->year;
      $messel=$now->month;

       $genActual= Generacion::where("id", ">", 0)->orderBy("fecha", "DESC")->first();

        if($genActual){ 
          $lasatdate=$genActual->fecha; 
          $proximafecha = date('Y-m-d', strtotime("+1 months", strtotime( $lasatdate)));
          $pf=DateTime::createFromFormat("Y-m-d",  $proximafecha);
          $nwanio=intval( $pf->format("Y") );
          $nwmes=intval( $pf->format("m") );

        }
        else{

          $proximafecha = date('Y-m-d');
          $pf=DateTime::createFromFormat("Y-m-d",  $proximafecha);
          $nwanio=intval($pf->format("Y") );
          $nwmes=intval($pf->format("m") );

        }

           foreach ($facturas as $key => $value) {
          $fac_anteriores = json_decode($value->facturas_anteriores);
          $cant_facturas_ant = count($fac_anteriores);
          
          if($value->estado == 0){$value->estado = 0;}// factura sin pagar
          if($fechaActual > $value->limite_at && $value->estado == 0){$value->estado = 2;}//Factura Vencida
          if($cant_facturas_ant >= 3 && $value->estado == 0 ){$value->estado = 3;}//Orden suspencion
          if($cant_facturas_ant >= 1 && $value->estado == 0 ){$value->estado = 2;}
          if($value->estado == 1){$value->estado = 1;} //Factura pagada
          if($value->congelada == 1){$value->estado = 4;} //Factura Congelada
        }
      

     
      //return dd("llego aquixxxxxx",$cant_mese_generar_fac);
  
      return view('facturas.listado_facturas')->with("usuario_actual",$usuario_actual)
                                              ->with("busqueda",true)
                                              ->with("aniosel",$aniosel)
                                              ->with("messel", $messel)
                                              ->with("facturas",$facturas)
                                                ->with("nwmes",$nwmes)
                                                ->with("nwanio", $nwanio);

    }


    public function listado_facturas_estado($aniosel=null,$messel=null,$estadosel){
        //presenta un listado general de facturas 

        $usuario_actual=Auth::user();
        $fechaActual = date('Y-m-d');
        $now = Carbon::now();
        //$collection = $paginator->getCollection();

        if($aniosel==null){ 
          $aniosel=$now->year;
          $messel=$now->month;
        }

         $genActual= Generacion::where("id", ">", 0)->orderBy("fecha", "DESC")->first();

        if($genActual){ 
          $lasatdate=$genActual->fecha; 
          $proximafecha = date('Y-m-d', strtotime("+1 months", strtotime( $lasatdate)));
          $pf=DateTime::createFromFormat("Y-m-d",  $proximafecha);
          $nwanio=intval( $pf->format("Y") );
          $nwmes=intval( $pf->format("m") );

        }
        else{

          $proximafecha = date('Y-m-d');
          $pf=DateTime::createFromFormat("Y-m-d",  $proximafecha);
          $nwanio=intval($pf->format("Y") );
          $nwmes=intval($pf->format("m") );

        }


        
        $facturas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )->get();

       // return dd("estado",$estadosel)
        
        foreach ($facturas as $key => $value) {
          $fac_anteriores = json_decode($value->facturas_anteriores);
          $cant_facturas_ant = count($fac_anteriores);
          
          if($value->estado == 0){$value->estado = 0;}// factura sin pagar
          if($fechaActual > $value->limite_at && $value->estado == 0){$value->estado = 2;}//Factura Vencida
          if($cant_facturas_ant >= 3 && $value->estado == 0 ){$value->estado = 3;}//Orden suspencion
          if($cant_facturas_ant >= 1 && $value->estado == 0 ){$value->estado = 2;}
          if($value->estado == 1){$value->estado = 1;} //Factura pagada
          if($value->congelada == 1){$value->estado = 4;} //Factura Congelada
        }

    

        $facturasant  =  $facturas->filter(function($item) use ( $estadosel) {
              return $item->estado == $estadosel;
        });

        //$collectionU = collect([]); 
        //$collectionU = $collectionU->merge($facturasant);  
     
        /*paginacion  100 */ 
        //$finalcollection = new Paginator($collectionU, $collectionU->count(), 100, 1);

        $facturasant1 = FacturasController::custom_paginate($facturasant, 100);

        //return dd("paginatio",$facturasant1);
       

        return view("facturas.listado_facturas")->with("usuario_actual",$usuario_actual)
                                                ->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                                ->with("facturas",$facturasant1)
                                                 ->with("nwmes",$nwmes)
                                                ->with("nwanio", $nwanio);
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

    


     public function detalle_facturas_anteriores($id_factura){

     $facturareal=Factura::find($id_factura);


      $facturasel=Factura::find($id_factura);
      $list_fac = array();

      if($facturasel->congelada == 1){
        $fact_congelada=Factura_congelada::where("id_cuenta","=",$facturasel->id_cuenta)->first();
        //return dd("facturasel",$fact_congelada);
        $facturasel=Factura::find($fact_congelada->id_factura);
        $fac_anteriores = json_decode($facturasel->facturas_anteriores);
        $cont_fac = count($fac_anteriores);
        if($cont_fac > 0){
          foreach ($fac_anteriores as $value) {
            $facturasel=Factura::find($value);
            array_push($list_fac, $facturasel);
            # code...
          }
          foreach($list_fac as $factura){
            $facturacargos = json_decode($factura->cargos);
            $totalcargos = 0;
            foreach($facturacargos as $cargo){
              $totalcargos+=$cargo->valor_default;
            }
            $factura->total_cargos= $totalcargos;
          }
        }else{
          array_push($list_fac, $facturasel);
          foreach($list_fac as $factura){
            $facturacargos = json_decode($factura->cargos);
            $totalcargos = 0;
            foreach($facturacargos as $cargo){
              $totalcargos+=$cargo->valor_default;
            }
            $factura->total_cargos= $totalcargos;
          }
          
        }
        //return dd("facturasel",$cont_fac);
      }else{
        $fac_anteriores = json_decode($facturasel->facturas_anteriores);
       
        foreach ($fac_anteriores as $value) {
          $facturasel=Factura::find($value);
          array_push($list_fac, $facturasel);
          # code...
        }
        foreach($list_fac as $factura){
          $facturacargos = json_decode($factura->cargos);
          $totalcargos = 0;
          foreach($facturacargos as $cargo){
            $totalcargos+=$cargo->valor_default;
          }
          $factura->total_cargos= $totalcargos;
        }
      }


      
    
      //return dd("factura sel", $list_fac);
      return view("facturas.form_detalle_facturas_anteriores")->with('facturas',$list_fac)->with("facturasel",      $facturareal);



    }

    public function detalle_factura($id_factura,$seccion=0){
       
       $usuario_actual=Auth::user();
       $facturasel=Factura::find($id_factura);
       $estado = 'A';
       $comunicados=Avisos_sistema::where("estado","=",$estado)->get();
       $fechaActual = date('Y-m-d');

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
       $nmes=$facturasel->mes;
      if(intval($facturasel->mes)<10 ){  $nmes='0'.$facturasel->mes;   }
       
       $generadoactual=Generacion::where('anio','>', 1)->orderBy('fecha', 'desc')->first();
       $fechames=$facturasel->anio.'-'.$nmes.'-01';
       $fechageneracion=$fechames;
       if($generadoactual){    
           $fechageneracion=$generadoactual->fecha;
       }

       $fecha_mesactual = strtotime($fechames);
       $fecha_genactual = strtotime($fechageneracion);
       $permiso=true;
       if( $fecha_mesactual >= $fecha_genactual)
       {$permiso=true;}else{$permiso=false;}

       // Estado de la factura

      $fac_anteriores = json_decode($facturasel->facturas_anteriores);
      $cant_facturas_ant = count($fac_anteriores);
      if($facturasel->estado == 0 ){$facturasel->estado = 0;}// factura sin pagar
      if($fechaActual > $facturasel->limite_at && $facturasel->estado == 0 ){$facturasel->estado = 2;}//Factura Vencida
      if($cant_facturas_ant >= 3 && $facturasel->estado == 0 ){$facturasel->estado = 3;}//Orden suspencion
      //if($facturasel->estado == 0 && $facturasel->saldada == 1){$facturasel->estado = 4;} //Factura saLdada
      if($cant_facturas_ant >= 1 && $facturasel->estado == 0 ){$facturasel->estado = 2;}
      if($facturasel->estado == 1){$facturasel->estado = 1;} //Factura pagada
      if($facturasel->congelada == 1){$facturasel->estado = 4;} //Factura pagada
      $valoTmp = 0;

      if($facturasel->abono == 1){ 
        $valoTmp = (int)$facturasel->valor_total-(int)$facturasel->valor_abono;
        $facturasel->valor_total = $valoTmp;

      }

       return view("facturas.detalle_factura")->with("usuario_actual",$usuario_actual)
                                              ->with("facturacargos",$facturacargos)
                                              ->with("saldoanterior",$saldoanterior)
                                              ->with("totalmes", $totalmes)
                                              ->with("totalFactura",$totalFactura)
                                              ->with('anio_p',$anio_p )
                                              ->with('mes_p',$mes_p )
                                              ->with('day_p',$day_p )
                                              ->with('messel',$facturasel->mes )
                                              ->with('aniosel',$facturasel->anio )
                                              ->with('seccion',$seccion )
                                              ->with('permiso',$permiso )
                                              ->with('ultimafactura', $fechageneracion)
                                              ->with("factura",$facturasel)
                                              ->with("comunicados", $comunicados);


    }



    public function generar_facturas($aniosel,$messel){
        /* genera todas las facturas de los registrados */

       /* genera todas las facturas de los registrados */

       $usuario_actual= Auth::user();
     
       $generadoactual=Generacion::where('anio','=', $aniosel)->where('mes','=', $messel)->first();
       $generadomenor=Generacion::orderBy("fecha","DESC")->first();


      
       if($generadoactual){
      
        return "Ya se ha generado Facturación para el año y mes seleccionados"; 
       }

       if($generadomenor){
     
         $msr=$messel;
        if($messel<10){ $msr="0".$messel;}
        $fechapro=$aniosel."-".$messel."-01";
        $fechax=$generadomenor->fecha;
        $fecha_inicio = new DateTime($fechapro);
        $fecha_fin    = new DateTime( $fechax);

        if($fecha_inicio<$fecha_fin ){  
          return "Ya se ha generado Facturacion en fechas posteriores a la seleccionada";   
        }
      }




       $mes_fecha_limite = (int)$messel + 1; 
       $anio_fecha_limite=$aniosel;
       if($mes_fecha_limite >12){    $mes_fecha_limite=1;  $anio_fecha_limite=$aniosel+1;  }
  

      $fecha_limite = FacturasController::optener_fecha_limite(   $anio_fecha_limite,$mes_fecha_limite);
     

      
      $facturas=Factura::where("anio","=",$aniosel )->where("mes","=",$messel )->get();
      $arraydata=array();
      $totalFactura=0;
      $cargos=Cargos::where("estado","=", 1 )->get();
      $cargosMora=CargosMora::where("estado","=", 1)->get();
      $valores= Valores::all();
      $arrayvalores=array();
      $valMes = 0;
     
      if($valores){
         foreach($valores as $valor){
              $idval=$valor->id;
              $valMes+=$valor->valor_default;
              $arrayvalores[$idval]=$valor->valor_default;
         }
      }
       $totalcargos=0;
      if($cargos){
         foreach($cargos as $cargo){
               $cargo->valor_default=$cargo->valor_default?$cargo->valor_default:0;
               $totalcargos= $totalcargos+$cargo->valor_default;
         }
      }

     // return dd($valMes);


      $estado = 0; 
      $facanteriores= Factura::where("estado","=",0)->whereDate("fecha_facturado","<", Carbon::createFromFormat('Y-m-d',$aniosel.'-'.$messel.'-01') )->where("saldada","=",0)->get();

      if($facturas->count()==0){

          $cuentas=Cuentas::where("estado","=", "A")->where("congelada","=",0)->get();
          foreach ( $cuentas as  $cuenta) {
            $totalFactura=0;
            $saldoanterior=0;
            $abono=0;
            $valormes=$valMes?$valMes:0;
            $id_cuenta=$cuenta->id?$cuenta->id:0;
            $estrato=$cuenta->estrato?$cuenta->estrato:'sin definir';
            $mz=$cuenta->mz?$cuenta->mz:'-';
            $casa=$cuenta->casa?$cuenta->casa:'-';
            $direccion=$cuenta->direccion?$cuenta->direccion:'-';
            $propietario=$cuenta->propietario?$cuenta->propietario:'-';
            $anio=$aniosel;
            $mes=$messel;
            
              $idcuenta=$cuenta->id;
              $idesfacturas=array();
              $valormora=0;
              $totalmora=0;
              $CM=array();
              $facturasant  =  $facanteriores->filter(function($item) use ( $idcuenta)  {
                    return $item->id_cuenta == $idcuenta;
              });
              
              if($facturasant){
                $subtotal=0;      

                foreach($cargosMora as $cargom){
                    if($cargom->tipo_factura==$cuenta->tipo_factura){  
                        $valormora=$cargom->valor_default?$cargom->valor_default:0;
                      
                     }
                }   

                foreach($facturasant as $facant){
                  if($facant->saldada == 0){
                    $saldoanterior=$saldoanterior+$this->saldo_anterior($facant);
                    $ctmop=array("id"=>$facant->id, "mora"=>$valormora);
                    array_push($CM,$ctmop);
                    array_push($idesfacturas,$facant->id);
                  }
                }


              }

      
              $cantmora=count($idesfacturas);
              $totalmora=$valormora*$cantmora;


              $saldoanterior=$saldoanterior;

              $totalFactura=$saldoanterior+$valormes+$totalcargos;


              $recordarray=array('id_cuenta'=>$id_cuenta, 
              'estrato'=>$estrato, 
              'mz'=>$mz,
              'casa'=>$casa,
              'direccion'=>$direccion,
              'propietario'=>$propietario,
              'fecha_facturado'=>$anio.'-'.$messel."-01",
              'anio'=>$anio,
              'mes'=>$messel,
              'estado'=>$estado,
              'valor_mes'=>$valormes,
              'facturas_anteriores'=> json_encode($idesfacturas),
              'saldo_anterior'=>$saldoanterior,
              'cargos'=>json_encode($cargos),
              'cargosmora'=>json_encode($CM),
              'mora'=>$totalmora,
              'valor_total'=>$totalFactura,
              'limite_at'=>$fecha_limite

             );
            array_push($arraydata,$recordarray);

          }

          Factura::insert($arraydata);

          $generado=new Generacion;
          $generado->mes=$messel;
          $generado->anio=$aniosel;
          $nmessel=$messel;
          if( intval($messel)<10 ){ $nmessel='0'.$messel;  }
          $generado->fecha=$aniosel.'-'.$nmessel.'-01';
          $generado->save();

          return  redirect('facturas/listado_facturas/'.$aniosel.'/'.$messel.'');
      }
      else
      {
          return   view('facturas.mensajes.msj_factura_no_existe')->with('msj','factura no existe');
      }
    }

    public function optener_fecha_limite($aniosel,$messel){



      $fecha_limete = "";
      $ultimo_dia = date("d",mktime(0,0,0,$messel+1,0,$aniosel));
      $starDate = new DateTime( $aniosel.'-'.$messel.'-01');
      $endDate = new DateTime($aniosel.'-'.$messel.'-'.$ultimo_dia);
      $contadomingo=0;

       while( $starDate <= $endDate){
         if($starDate->format('l')== 'Sunday'){
          $contadomingo++;
          if( $contadomingo==2){  $fecha_limete=$starDate->format('Y-m-d');  }
                      
         }
       $starDate->modify("+1 days");

       }
       if($fecha_limete==""){   $fecha_limete=  $endDate; }
  

 
      return $fecha_limete;

    }

    
    public function editar_factura($id_factura){
      //presenta los detalles e info del usuario
      //return dd("ide", $id);
        $usuario_actual= Auth::user();
        $factura=Factura::find($id_factura);
       
        if($factura){
             return view("facturas.form_editar_factura")->with('factura',$factura);
        }
        else{
             return redirect('usuarios');
        }


    }

    
    public function editar_factura_detalle(Request $request){

       //actualizar los datos del usuario
        $usuario_actual= Auth::user();
        $id_factura = $request->input('id');
        $factura = Factura::find($id_factura);
         //return dd("Que llega aquyi", $cuenta);
        $factura->mz=strtoupper( $request->input("mz")?$request->input("mz"):'' );
        $factura->casa=$request->input("casa")?$request->input("casa"):'';
        $factura->apto=$request->input("apto")?$request->input("apto"):'' ;
        $factura->observaciones=strtoupper( $request->input("observaciones")?$request->input("observaciones"):'') ;
        $factura->propietario=strtoupper( $request->input("propietario")?$request->input("propietario"):'' ) ;
      
      
        if( $factura->save())
        {
            return view("facturas.mensajes.msj_factura_editada")
                                          ->with("msj","Factura actualizada correctamente")
                                          ->with("factura",$factura);
        }else{
            return view("usuarios.mensajes.msj_error")->with("msj","...Hubo un error al agregar ;...") ;
        }
       
    }



    public function form_cargos_factura($id_factura){
      //presenta los detalles e info del usuario
      //return dd("ide", $id);
        $usuario_actual= Auth::user();
        $factura=Factura::find($id_factura);
        $cargos=Cargos::all();
       
        if($factura){
             return view("facturas.form_cargos_factura")
                    ->with('cargos',$cargos)
                    ->with('factura',$factura);
        }
        else{
             return redirect('/');
        }
    }

    public function agregar_cargos_factura(Request $request){

      $id_factura = $request->input('id');
      $id_cargo = $request->input('id_cargo');
      $valorsel= $request->input('valor')?$request->input('valor'):0;
      $factura = Factura::find($id_factura);
      $cargos=Cargos::all();

      $newcargos=array();
      $factura->cargos=$factura->cargos?$factura->cargos:null;
      $totalcargos=0;
      if( $factura->estado==1){  return view("facturas.mensajes.msj_error")->with("msj","...factura ya registrada como pagada;...") ; }

      if( $factura->cargos!=null){
        
        $currentcargos=json_decode($factura->cargos); 
        $existe=0;

      

        
        foreach($currentcargos as $cargo){
           if($cargo->id==$id_cargo){
              $cargo->valor_default=  $valorsel;
              $existe=1;
           }
           $totalcargos=$totalcargos+ $cargo->valor_default;
           array_push(  $newcargos, $cargo);
        }


        if( $existe==0){
            foreach($cargos as $cargom){
               if($cargom->id==$id_cargo){
                  $cargom->valor_default=  $valorsel;
                  $totalcargos=$totalcargos+ $cargom->valor_default;
                   array_push(  $newcargos, $cargom);
                    
               }
            }

         }

      }
      
      $factura->cargos=json_encode($newcargos);

      $factura->valor_total=$factura->saldo_anterior + $factura->valor_mes +  $totalcargos;
      
      if( $factura->save())
      {
            return view("facturas.mensajes.msj_cargos_agregados")
                                          ->with("msj","Cargos actualizado correctamente")
                                          ->with("factura",$factura);
      }else{
            return view("facturas.mensajes.msj_error")->with("msj","...Hubo un error al agregar ;...") ;
      }



    }


    public function pdf_facturas($aniosel,$messel){

       return view("facturas.impresion_facturas")->with("aniosel",  $aniosel )->with("messel",  $messel );

    }

    public function pdf_factura($id_factura){
       
       $factura = Factura::find($id_factura);
       return view("facturas.impresion_factura_individual")->with("factura",  $factura );
    }


    public function impresion_factura($id_factura){

      $factura = Factura::find($id_factura);
         
      $codehtml='
       <!doctype html>
        <html lang="en">
        <head>
          <meta charset="utf-8">
          <title>factura 1</title>
          <meta name="description" content="pdf factura">
         <style>
          body{ font-family: arial !important; }
          
          .p-subtitulo{   }
          table, th, td {
              border: 1px solid #3d5170;
              border-collapse: collapse;
              text-align: center;
            }
           .td-color-azul{
                background-color: #7491ac;
                color: white;
                
                font-size: 12px;
                line-height: 0.3;
                font-weight: 500;
                padding: .75rem;
            }
            .td-conceptos{
              padding-left:10px;
               text-align: left;
            }
         </style>
        </head>

    <body>';
    
      
    
    $codeone= $this->code_factura_regular($factura);
    $codehtml.=$codeone;
    
    $codehtml.="</body></html>";
   
      $inventory_pdf = PDF::loadHTML($codehtml);


      return $inventory_pdf->stream();
    
    }


    public function impresion_facturas($aniosel,$messel){
      
      $facturas=Factura::where("mes","=",$messel)->where("anio","=",$aniosel)->get();
      $codehtml='
       <!doctype html>
        <html lang="en">
        <head>
          <meta charset="utf-8">
          <title>factura 1</title>
          <meta name="description" content="pdf factura">
         <style>
          body{ font-family: arial !important; }
          
          .p-subtitulo{   }
          table, th, td {
              border: 1px solid #3d5170;
              border-collapse: collapse;
              text-align: center;
            }
           .td-color-azul{
                background-color: #7491ac;
                color: white;
                
                font-size: 12px;
                line-height: 0.3;
                font-weight: 500;
                padding: .75rem;
            }
            .td-conceptos{
              padding-left:10px;
               text-align: left;
            }
         </style>
        </head>

    <body>';
    
      
      foreach($facturas as $fac){
          $codeone= $this->code_factura_regular($fac);
          $codehtml.=$codeone;
      }
    $codehtml.="</body></html>";


       $inventory_pdf = PDF::loadHTML($codehtml);
  
        
       return $inventory_pdf->stream();
    }


    public function pagar_factura(Request $request){

        $id_factura = $request->input("id_factura");
        $fecha_pago = $request->input("fecha_pago");
        $valor = $request->input("valor");
        $tipo_pago = $request->input("tipo_pago");
        $ref_pago = $request->input("ref_pago");

        if($tipo_pago == 1){
          $ref_pago = 'N/A';
        }else{
          $ref_pago = $ref_pago;
        }

        $facturasel= Factura::find($id_factura);

        if($facturasel->estado==0  ){  
           $facturasel->estado=1;
           $facturasel->pagada_at= $fecha_pago;
           $facturasel->saldada=1;
           $facturasel->tipo_pago=$tipo_pago;
           $facturasel->ref_pago=$ref_pago;
           $facturasel->saldada_at=$fecha_pago;

           $facturaant = array();
           if($facturasel->facturas_anteriores != null){

               $facarray = json_decode($facturasel->facturas_anteriores);
               $facturaant = Factura::find( $facarray);
               foreach($facturaant as $factu){
                   $factu->saldada=1;
                   $factu->saldada_at=$fecha_pago;
                   $factu->tipo_pago=$tipo_pago;
                   $factu->ref_pago=$ref_pago;
                   $factu->save();
                }
           }
          if($facturasel->save()){
              return view("facturas.mensajes.msj_factura_pagada")
                                                  ->with("msj","Registro de Pago correcto")
                                                  ->with("factura",$facturasel);
          }else{
              return view("facturas.mensajes.msj_error")
                               ->with("msj","...Hubo un error al registrar ;...") ;
          }
        }
        else
        {
                  return view("facturas.mensajes.msj_error")->with("msj","...factura ya pagada ;...") ;
        }
     }

     public function abonar_factura(Request $request){

  
        $id_factura = $request->input("id_factura");
        $valor = $request->input("valor_abono");
        $fecha = $request->input("fecha");
        $pagada = $request->input("pagada");
        $primerAbono = $request->input("primerAbono");

        $arraydata=array();

        $now = Carbon::now();
        $aniosel=$now->year;
        $messel=$now->month;

        $facturasel= Factura::find($id_factura);
        $propietario =  $facturasel->propietario;

        if($facturasel->estado==0  ){

        $valortotalf= $facturasel->valor_total+ $facturasel->mora;
        if($valor>=$valortotalf){ 
          $pagada='SI';
              $facturasel->abono = 1;
              $facturasel->valor_abono += $valor;
              $facturasel->estado=1;
              $facturasel->pagada_at= $fecha;
              $facturasel->saldada=1;
              $facturasel->saldada_at=$fecha;
              
      

              $facturaant = array();
              if($facturasel->facturas_anteriores != null){

                   $facarray = json_decode($facturasel->facturas_anteriores);
                   $facturaant = Factura::find( $facarray);
                   foreach($facturaant as $factu){
                       $factu->saldada=1;
                       $factu->saldada_at=$fecha;
                       $factu->save();
                    }
              }  

        }
        else
        {
             $facturasel->abono = 1;
             $facturasel->valor_abono += $valor;
        }
        
       

           if($facturasel->save()){
             $recordarray=array('id_factura'=>$id_factura,
              'id_cuenta'=>$facturasel->id_cuenta,
              'propietario'=>$propietario,
              'anio'=>$aniosel,
              'mes'=>$messel,
              'fecha_abono'=>$fecha,
              'valor_abono'=>$valor

             );
            array_push($arraydata,$recordarray);

            Abonos::insert($arraydata);
            return view("facturas.mensajes.msj_factura_abonada")
                                                  ->with("msj","Registro de Abono correcto")
                                                  ->with("factura",$facturasel);
           }else{
              return view("facturas.mensajes.msj_error")
                               ->with("msj","...Hubo un error al registrar ;...") ;
           }
        }else{
           return view("facturas.mensajes.msj_error")->with("msj","...factura ya pagada ;...");
        }
     }

  public function congelar_factura(Request $request){

  
    $id_factura = $request->input("id_factura");
    $observaciones = $request->input("observaciones");
    $congelada = $request->input("congelada");
    $factura=Factura::find($id_factura);
    $cuenta=Cuentas::find($factura->id_cuenta);

    $factura->observaciones = $observaciones;
    $factura->congelada = $congelada;
    $cuenta->congelada = $congelada;
    if($factura->save()){
      $cuenta->save();
      $arraydata = array();
      $fac_ante = array();
      $val_mes = 0;
      if($factura->estado == 1){
        $val_mes = 0;
        $fac_ante = "[]";
      }else{
        $val_mes = $factura->valor_total-$factura->valor_abono;
        $fac_ante = $factura->facturas_anteriores;
      }

      $recordarray=array('id_factura'=>$id_factura,
        'id_cuenta'=>$factura->id_cuenta,
        'estado_factura'=>$factura->estado,
        'saldo_factura'=>$val_mes,
        'pagada_at'=>$factura->pagada_at,
        'facturas_anteriores'=>$fac_ante
      );
      array_push($arraydata,$recordarray);
      Factura_congelada::insert($arraydata);

       return view("facturas.mensajes.msj_factura_congelada")
                                                  ->with("msj","La factura se congeló exitosamente")
                                                  ->with("factura",$factura);
    }else{
      return view("facturas.mensajes.msj_error")
             ->with("msj","...Hubo un error al registrar ;...") ;
    }
       return dd("Llego a aqui",$factura,$cuenta);

  }

  public function descongelar_factura(Request $request){

    $id_factura = $request->input("id_factura");
    $factura=Factura::find($id_factura);
    $cuenta=Cuentas::find($factura->id_cuenta);
    $fac_congeladas = Factura_congelada::where("id_cuenta","=",$factura->id_cuenta)->first();

    $cuenta->congelada = 0;
    $factura->congelada = 0;
    
    if($fac_congeladas){

      if((int)$fac_congeladas->estado_factura == 1){
        $factura->saldada = 1;
        $factura->pagada_at = $fac_congeladas->pagada_at;
      }else{
        $factura->saldada = 0;
      }
      
      $factura->estado = $fac_congeladas->estado_factura;
      $factura->saldo_anterior = $fac_congeladas->saldo_factura;
      $factura->facturas_anteriores = $fac_congeladas->facturas_anteriores;

      $factura->save();
      $cuenta->save();
      $fac_congeladas->delete();

      return view("facturas.mensajes.msj_factura_descongelada")
                                                  ->with("msj","La factura se descongelo exitosamente")
                                                  ->with("factura",$factura);
    }else{

      $factura->save();
      $cuenta->save();
      return view("facturas.mensajes.msj_factura_descongelada")
                                                  ->with("msj","La factura se descongelo exitosamente")
                                                  ->with("factura",$factura);
    }
  }
     
  public function bucar_factura_abono($id_factura){
      //presenta los detalles e info del usuario
     
        $usuario_actual= Auth::user();
        $factura=Factura::find($id_factura);
         //$facarray = json_decode($factura);
        //return dd("ide", $facarray);
        if($factura){
             return response()->json([ 'factura' => $factura ],200);  
        }
        else{
             return response()->json([ 'factura' => [] ],200);  
        }
    }
   


    function code_factura_regular($factura){ 

      $mesesarray=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
      $factura->saldo_anterior=number_format($factura->saldo_anterior, 0);
      $factura->valor_mes=number_format($factura->valor_mes, 0);
      $factura->mora=$factura->mora?$factura->mora:0;
      if($factura->abono == 1){ 
        $valoTmp = (int)$factura->valor_total-(int)$factura->valor_abono;
        $factura->valor_total = $valoTmp;

      }
      $factura->valor_total=$factura->valor_total + $factura->mora;
      
      $estado = 'A';
      $comunicados=Avisos_sistema::where("estado","=",$estado)->get();
      $comunicado = "";
      $codeestado="";
      $codecargos="";

      if($factura->estado==1){
           if( !isset($factura->pagada_at) ){  $factura->pagada_at="0000-00-00 00:00:00"; }
           $formatopagada=  DateTime::createFromFormat('Y-m-d H:i:s', $factura->pagada_at)->format('Y-m-d') ;

           $codeestado= '<tr class="text-center">
                          <td class="td-color-azul">ESTADO</td>
                          <td class="td-color-azul" colspan="3" >FECHA PAGADA</td>
                          </tr> 
                          <tr class="text-center">
                          <td class="td-color-blanco" style="background-color: #38c138;color:white; "  > PAGADA</td>
                            <td class="td-color-blanco" colspan="3" >'.$formatopagada.'</td> 
                        </tr>';
      }
      else
      {
          $lbestado="SIN PAGAR";
         
          $fecha_actual = strtotime(date("Y-m-d H:i:00",time()));
          $fecha_limite = strtotime($factura->limite_at." 23:00:00");
          if(intval($factura->saldo_anterior)>0) { $lbestado="VENCIDA - PAGO INMEDIATO";  }
          if( $fecha_actual > $fecha_limite ){   $lbestado="VENCIDA - PAGO INMEDIATO";  }

           if($factura->facturas_anteriores!=null){
                  $arfa=json_decode($factura->facturas_anteriores); 
                  if(count($arfa)>2) { $lbestado="ORDEN SUSPENSIÓN";  }      
          }

          if($factura->congelada==1){
                  $lbestado="CONGELADA";
          }          

        

          $codeestado='<tr class="text-center">
                          <td class="td-color-azul">ESTADO</td>
                            <td class="td-color-azul" colspan="3" >FECHA  LIMITE  PAGO</td>
                        
                        </tr><tr class="text-center">
                            <td class="td-color-blanco" style="background-color: #e68b3c;color:white; "  >'.$lbestado.'</td>
                            <td class="td-color-blanco" colspan="3" >'.$factura->limite_at.'</td>
                          </tr>';

          if($lbestado=='ORDEN SUSPENSIÓN'){
             $codeestado='<tr class="text-center">
                          <td class="td-color-azul">ESTADO</td>
                            <td class="td-color-azul" colspan="3" >FECHA  LIMITE  PAGO</td>
                        
                        </tr><tr class="text-center">
                            <td class="td-color-blanco" style="background-color: #ee0c0c;color:white; "  >'.$lbestado.'</td>
                            <td class="td-color-blanco" colspan="3" >'.$factura->limite_at.'</td>
                          </tr>';
            
          }                
      }



      $factura->cargos=isset($factura->cargos)?$factura->cargos:'[]';
      $facturacargos=json_decode($factura->cargos);

      foreach($facturacargos as $cargo){
             $cargo->valor_default=number_format($cargo->valor_default, 0);
             $codecargos.='<tr >
                          <td class="text-left td-conceptos" >'.$cargo->cargo.'</td>
                          <td class="text-center td-color-blanco" colspan="3">'.$cargo->valor_default.'</td>
                        
                          </tr>';
      }; 

      foreach ($comunicados as $value) {
        $comunicado.='<p>- '.$value->descripcion.'</p>'; 
      } 

       $codeabono="";


       if($factura->valor_abono > 0) {

        $factura->valor_abono=number_format($factura->valor_abono, 0);
        $codeabono='<tr >
                          <td class="text-left td-conceptos" >ABONOS FACTURA</td>
                          <td class="text-center td-color-blanco" colspan="3">-'.$factura->valor_abono.'</td>
                    
                          </tr>';

       }                
         


        $hlogo1=asset('assets/img/logo1.png');
        $hlogo2=asset('assets/img/logo2.png');

        $codehtml ='<div style="text-align: center; page-break-inside: avoid;">
        <h5 style="color:white;">Factura No. '.$factura->id.' '. $factura->propietario.'  </h5>

        <table  style="width:90%;  display: inline-block;" >
                       <tbody>
                        <tr class="text-center" >

                          <td colspan="4" >
                           <table width="100%;" style="border:none;" >
                            <tr>
                              <td><img  src="'.$hlogo1.'" style="width:80px;"/></td>
                              <td> 
                                <h5 style="margin-bottom: .05rem; font-size:16px;">BARRIO LAS BRISAS</h5>
                                <p class="p-subtitulo">JUNTA ADMINISTRADORA DEL ACUEDUCTO</p> 
                             </td>
                                <td><img  src="'.$hlogo2.'" style="width:80px;" /></td>
                            </tr>
                          </table>

                          </td>
                          
                        </tr>
                        <tr class="text-center">
                          <td colspan="4" class="td-color-blanco" >FACTURA DEL AGUA</td>
                          
                          
                        </tr>

                        <tr class="text-center">
                          <td  class="td-color-blanco " >ESTRATO: '.$factura->estrato .' </td>
                          <td  class="td-color-blanco"  colspan="3" >NIT.900.058.328 DV-5</td>
                          
                        </tr>

                        <tr class="text-center">
                          <td class="td-color-blanco"  >FACTURA No:</td>
                          <td class="td-gris-azul-claro" colspan="3" >'.$factura->id .' </td>
                        </tr>

                        <tr class="text-center">
                          <td class="td-color-azul" style="width: 350px;">DIRECCIÓN </td>
                          <td class="td-color-azul" >MZ</td>
                          <td class="td-color-azul" >CASA</td>
                          <td class="td-color-azul" >APTO</td>
                          
                        </tr>

                        <tr class="text-center">
                          <td class="td-color-blanco" >'.$factura->direccion .'</td>
                          <td class="td-color-blanco" >'.$factura->mz .'</td>
                          <td class="td-color-blanco" >'.$factura->casa .'</td>
                          <td class="td-color-blanco"  >'.$factura->apto .'</td>
                          
                        </tr>

                          <tr class="text-center">
                          <td class="td-color-blanco" >NOMBRE:</td>
                        
                          <td class="td-color-blanco" colspan="3" >'.$factura->propietario .'</td>
                          
                        </tr>


                        <tr class="text-center">
                          <td class="td-color-azul" >MES FACTURADO</td>
                          <td colspan="2" class="td-color-azul"> MES</td>
                          <td  class="td-color-azul" >AÑO</td>
                          
                          
                        </tr>
                         <tr class="text-center">
                          <td class="td-color-blanco" >--</td>
                          <td colspan="2" class="td-color-blanco" >'. $mesesarray[$factura->mes].'</td>
                          <td class="td-color-blanco"  >'.$factura->anio.'</td>
                          
                        </tr>

                    

                       '. $codeestado.'
                     

                        <tr class="text-center">
                          <td class="td-color-azul" >CONCEPTOS</td>
                            <td colspan="3" class="td-color-azul">VALOR</td>
                        </tr>

                        <tr class="text-center">
                          <td class="td-color-blanco" >--</td>
                          <td class="td-color-blanco" colspan="3" >VALOR</td>
                         
                        </tr>

                        <tr >
                          <td class="text-left td-conceptos" >SALDO ANTERIOR</td>
                          <td class="text-center td-color-blanco" colspan="3" >'.$factura->saldo_anterior.'</td>
                       
                        </tr>

                        <tr >
                          <td class="text-left td-conceptos" >MORA</td>
                          <td class="text-center td-color-blanco" colspan="3">'.number_format($factura->mora,0) .'</td>
                      
                        </tr>
                        

                        <tr >
                          <td class="text-left td-conceptos" >VALOR LECTURA MES</td>
                          <td class="text-center td-color-blanco" colspan="3">'.$factura->valor_mes.'</td>
                    
                        </tr>

                        '.$codecargos.' 
                        '.$codeabono.'

                        <tr >
                          <td class="td-total text-center">VALOR TOTAL</td>
                          <td class="td-total-gris-claro"  colspan="3">$ '.number_format($factura->valor_total,0).' </td>
                 
                        </tr>

                        <tr class="text-left">
                          <td colspan="4">
                            Firma y Sello de Tesorería
                          </td>
                        
                        </tr>
                   

                        <tr class="text-left">
                          <td colspan="4">
                            -
                          </td>
                        
                        </tr>

                        <tr class="text-left">
                          <td colspan="4">
                            <p>Esta factura presta merito ejecutivo, según articulo 77 de comercio
                              El mal uso del agua será sancionado según estatutos aprobados</p>
                          </td>
                        
                        </tr>

                        <tr class="text-left">
                          <td colspan="4">
                            <p>Observaciones:</p>

                            <p>'.$factura->observaciones.'-</p>
                          </td>
                        
                        </tr>

                        <tr class="text-left">
                          <td colspan="4">
                            <p>Comunicados:</p>

                            <p>'.$comunicado.'</p>
                          </td>
                        
                        </tr>
                       </tbody>

              </table></div>';


              return $codehtml;
    }



    function saldo_anterior($facant){

      $valor_mes=$facant->valor_mes?$facant->valor_mes:0;
      $arrcargos=$facant->cargos?json_decode($facant->cargos):array();
   
      $valor_cargos=0;
       $abono=0;
      foreach ($arrcargos as $cargo)
      {
           $valor_cargos=$valor_cargos+$cargo->valor_default;
      }

  
      if($facant->abono == 1){
          $abono = (float)$facant->valor_abono;
                      
      }

      $subtotal= $valor_mes+$valor_cargos - $abono ;
  
      return $subtotal;

    }


   

    





}
