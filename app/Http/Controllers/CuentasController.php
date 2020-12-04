<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Cuentas;
use App\Factura;
use App\Cargos;
use App\FacturasCargos;
use Auth;
use App\Valores;
use Carbon\Carbon;

class CuentasController extends Controller
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

	 public function listado_cuentas(Request $request){
	 	
      $usuario_actual= Auth::user();
      $dato = 'A';
      $cuentas=Cuentas::where("estado",$dato)->where("congelada","=",0)
                ->paginate(50)
                ->appends(request()->query());
   	  
   	  return view("cuentas.listado_cuentas")->with("usuario_actual",$usuario_actual)
                                                ->with("cuentas",$cuentas);

     }

      public function listado_cuentas_inactivas(Request $request){
	 	
      $usuario_actual= Auth::user();
      $dato = 'I';
      $cuentas=Cuentas::where("estado",$dato)
                ->paginate(100)
                ->appends(request()->query());
   	  return view("cuentas.listado_cuentas_inactivas")->with("usuario_actual",$usuario_actual)
                                                ->with("cuentas",$cuentas);

     }
    public function listado_cuentas_congeladas(Request $request){
    
      $usuario_actual= Auth::user();
      $dato = 1;
      $cuentas=Cuentas::where("congelada",$dato)
                ->paginate(100)
                ->appends(request()->query());
      return view("cuentas.listado_cuentas_congeladas")->with("usuario_actual",$usuario_actual)
                                                ->with("cuentas",$cuentas);

     }

     

     public function editar_cuenta($id_cuenta){
      //presenta los detalles e info del usuario
     	//return dd("ide", $id);
        $usuario_actual= Auth::user();


        if( $usuario_actual->rol!=1 ){  
          return view("mensajes.msj_no_autorizado")
                ->with("msj","no tiene autorizacion para acceder a esta seccion"); 
        }

        $cuenta=Cuentas::find($id_cuenta);

        $cuenta->programas=$cuenta->programas?$cuenta->programas:'[]';
        $vehiculosSEL=json_decode($cuenta->vehiculos_json);

        $cuenta->programas=$cuenta->programas?$cuenta->programas:'[]';
        $motosSEL=json_decode($cuenta->motos_json);
       
        
        return view("cuentas.form_editar_cuenta")->with('cuenta',$cuenta)
             										  ->with("motosSEL",$motosSEL)
             										  ->with('vehiculosSEL',$vehiculosSEL);
        


    }

     

      public function form_nueva_cuenta(){
        //carga el formulario para agregar un nuevo usuario

        $usuario_actual=Auth::user();
        $valores=Valores::all();
        if( $usuario_actual->rol!=1 ){  
            return view("mensajes.msj_no_autorizado")->with("msj","no tiene autorizacion para acceder a esta seccion"); 
        }	
     
        return view("cuentas.form_nueva_cuenta")
               ->with("usuario_actual",$usuario_actual)
               ->with("valores",$valores);
    }

    public function crear_cuenta(Request $request){
        //crea una cuenta en el sistema
        $usuario_actual=Auth::user();

      	$cuenta=new Cuentas;
      	$tel= $request->input('telefono')?$request->input('telefono'):''; 
      	$iden= $request->input('identificacion')?$request->input('identificacion'):0; 
      	$variable2=intval($iden);
      	$mz = strtoupper( $request->input("mz")?$request->input("mz"):'-' );
      	$casa = $request->input("casa")?$request->input("casa"):'-';
        $dir = "MZ".' '.$mz.' '."CASA".' '.$casa;
        $tipo_vivienda = $request->input("tipo_vivienda")?$request->input("tipo_vivienda"):'' ;
      	$cuenta->propietario=strtoupper( $request->input("propietario")?$request->input("propietario"):'' ) ;
      	$cuenta->identificacion=$variable2;
      	$cuenta->mz= $mz;
      	$cuenta->casa= $casa;
      	$cuenta->estrato= 1;
      	$cuenta->direccion=$dir;
        $cuenta->telefono=$tel;
        $cuenta->tipo_vivienda= $tipo_vivienda;
        $cuenta->ciudad=strtoupper($request->input("ciudad")?$request->input("ciudad"):'');
        $cuenta->email=$request->input("email")?$request->input("email"):'';
        $cuenta->observaciones=strtoupper( $request->input("observaciones")?$request->input("observaciones"):'') ;
        $cuenta->estado = 'A';
        $cuenta->congelada = 'NO';

        $arrayjsonvehiculos=array();

        $idvsarray = $request->input("nov", array() );
        $marcavarray = $request->input("marcav", array() );
        $lineavarray = $request->input("lineav", array() );
        $placavarray = $request->input("placav", array() );

        $arrayjsonmotos=array();

        $idmsarray = $request->input("nom", array() );
        $marcamarray = $request->input("marcam", array() );
        $lineamarray = $request->input("lineam", array() );
        $placamarray = $request->input("placam", array() );

        foreach ( $idvsarray as $key => $value){

            if( isset($idvsarray[$key] ) ){  

                $v_id=$value;
                $v_marca=0;
                $v_linea=0;
                $v_placa=0;

                if(isset( $marcavarray[$key] ) ){  $v_marca=$marcavarray[$key];  }
                if(isset( $lineavarray[$key] ) ){  $v_linea=$lineavarray[$key];  }
                if(isset( $placavarray[$key] ) ){  $v_placa=$placavarray[$key];  }

                $newarrayveh=array(

                    "id"=>  $v_id,
                    "marca"=>strtoupper($v_marca),
                    "linea" =>strtoupper( $v_linea),
                    "placa"=>strtoupper( $v_placa),
                );
                array_push( $arrayjsonvehiculos, $newarrayveh );
            }
        }

        foreach ( $idmsarray as $key => $value){

            if( isset($idmsarray[$key] ) ){  

                $m_id=$value;
                $m_marca=0;
                $m_linea=0;
                $m_placa=0;

                if(isset( $marcamarray[$key] ) ){  $m_marca=$marcamarray[$key];  }
                if(isset( $lineamarray[$key] ) ){  $m_linea=$lineamarray[$key];  }
                if(isset( $placamarray[$key] ) ){  $m_placa=$placamarray[$key];  }

                $newarraymotos=array(

                    "id"=>  $v_id,
                    "marca"=>strtoupper( $m_marca),
                    "linea" =>strtoupper( $m_linea),
                    "placa"=>strtoupper( $m_placa),
                );
                array_push( $arrayjsonmotos, $newarraymotos );
            }
        }
        $cuenta->vehiculos_json =   json_encode($arrayjsonvehiculos);
        $cuenta->motos_json =   json_encode($arrayjsonmotos);
        if($cuenta->save())
        {
            return view("cuentas.mensajes.msj_cuenta_creada")->with("msj","Cuenta creada correctamente");
        }else{
            return view("usuarios.mensajes.msj_error")->with("msj","...Hubo un error al agregar ;...") ;
        }

    }

    public function editar_cuenta_acu(Request $request){

    	 //actualizar los datos del usuario
      $usuario_actual= Auth::user();
      if( $usuario_actual->rol!=1 ){  return view("mensajes.msj_no_autorizado")->with("msj","no tiene autorizacion para acceder a esta seccion"); }
       $id_cuenta = $request->input('id');

        $cuenta = Cuentas::find($id_cuenta);
         //return dd("Que llega aquyi", $cuenta);

        $tel= $request->input('telefono')?$request->input('telefono'):'';
      	$iden= $request->input('identificacion')?$request->input('identificacion'):0; 
      	$variable2=(int)$iden;
      	$mz = strtoupper( $request->input("mz")?$request->input("mz"):'-' );
      	$casa = $request->input("casa")?$request->input("casa"):'';
        $dir = "MZ".' '.$mz.' '."CASA".' '.$casa;
        $tipo_vivienda = $request->input("tipo_vivienda")?$request->input("tipo_vivienda"):'' ;
      	$cuenta->propietario=strtoupper( $request->input("propietario")?$request->input("propietario"):'' ) ;
      	$cuenta->identificacion=$variable2;
      	$cuenta->mz=$mz;
      	$cuenta->casa= $casa;
      	$cuenta->estrato= 1 ;
      	$cuenta->direccion=$dir;
        $cuenta->telefono=$tel;
        $cuenta->tipo_vivienda=$tipo_vivienda;
        $cuenta->email=$request->input("email")?$request->input("email"):'';
        $cuenta->ciudad=strtoupper($request->input("ciudad")?$request->input("ciudad"):'');
        $cuenta->observaciones=strtoupper( $request->input("observaciones")?$request->input("observaciones"):'') ;
    	  $arrayjsonvehiculos=array();

        $idvsarray = $request->input("nov", array() );
        $marcavarray = $request->input("marcav", array() );
        $lineavarray = $request->input("lineav", array() );
        $placavarray = $request->input("placav", array() );

        $arrayjsonmotos=array();

        $idmsarray = $request->input("nom", array() );
        $marcamarray = $request->input("marcam", array() );
        $lineamarray = $request->input("lineam", array() );
        $placamarray = $request->input("placam", array() );

        foreach ( $idvsarray as $key => $value){

            if( isset($idvsarray[$key] ) ){  

                $v_id=$value;
                $v_marca=0;
                $v_linea=0;
                $v_placa=0;

                if(isset( $marcavarray[$key] ) ){  $v_marca=$marcavarray[$key];  }
                if(isset( $lineavarray[$key] ) ){  $v_linea=$lineavarray[$key];  }
                if(isset( $placavarray[$key] ) ){  $v_placa=$placavarray[$key];  }

                $newarrayveh=array(

                    "id"=>  $v_id,
                    "marca"=>strtoupper($v_marca),
                    "linea" =>strtoupper( $v_linea),
                    "placa"=>strtoupper( $v_placa),
                );
                array_push( $arrayjsonvehiculos, $newarrayveh );
            }
        }

        foreach ( $idmsarray as $key => $value){

            if( isset($idmsarray[$key] ) ){  

                $m_id=$value;
                $m_marca=0;
                $m_linea=0;
                $m_placa=0;

                if(isset( $marcamarray[$key] ) ){  $m_marca=$marcamarray[$key];  }
                if(isset( $lineamarray[$key] ) ){  $m_linea=$lineamarray[$key];  }
                if(isset( $placamarray[$key] ) ){  $m_placa=$placamarray[$key];  }

                $newarraymotos=array(

                    "id"=>  $v_id,
                    "marca"=>strtoupper( $m_marca),
                    "linea" =>strtoupper( $m_linea),
                    "placa"=>strtoupper( $m_placa),
                );
                array_push( $arrayjsonmotos, $newarraymotos );
            }
        }
        $cuenta->vehiculos_json =   json_encode($arrayjsonvehiculos);
        $cuenta->motos_json =   json_encode($arrayjsonmotos);
        if($cuenta->save())
        {
            return view("cuentas.mensajes.msj_cuenta_editada")->with("msj","Cuenta actualizada correctamente");
        }else{
            return view("usuarios.mensajes.msj_error")->with("msj","...Hubo un error al agregar ;...") ;
        }
       
    }

    public function inactivar_cuenta($id_cuenta){

    	 //actualizar los datos del usuario
    	//return dd("Que llega aquyi", $id_cuenta);
     $usuario_actual= Auth::user();
      if( $usuario_actual->rol!=1 ){  return view("mensajes.msj_no_autorizado")->with("msj","no tiene autorizacion para acceder a esta seccion"); }
      $estado = 'I';

        $cuenta = Cuentas::find($id_cuenta);
        $cuenta->estado = $estado;
         if( $cuenta->save())
        {
            return view("cuentas.mensajes.msj_cuenta_inactiva")->with("msj","Cuenta inactivada correctamente");
        }else{
            return view("usuarios.mensajes.msj_error")->with("msj","...Hubo un error al agregar ;...") ;
        }
        return dd("cuenta", $cuenta);
    }

    public function activar_cuenta($id_cuenta){

       //actualizar los datos del usuario
      //return dd("Que llega aquyi", $id_cuenta);
     $usuario_actual= Auth::user();
      if( $usuario_actual->rol!=1 ){  return view("mensajes.msj_no_autorizado")->with("msj","no tiene autorizacion para acceder a esta seccion"); }
     $estado = 'A';

        $cuenta = Cuentas::find($id_cuenta);
        $cuenta->estado = $estado;
         if( $cuenta->save())
        {
            return view("cuentas.mensajes.msj_cuenta_activa")->with("msj","Cuenta activada correctamente");
        }else{
            return view("usuarios.mensajes.msj_error")->with("msj","...Hubo un error al agregar ;...") ;
        }
        return dd("cuenta", $cuenta);
    }

    public function congelar_cuenta($id_cuenta){

       //actualizar los datos del usuario
      //return dd("Que llega aquyi", $id_cuenta);
     $usuario_actual= Auth::user();
      if( $usuario_actual->rol!=1 ){  return view("mensajes.msj_no_autorizado")->with("msj","no tiene autorizacion para acceder a esta seccion"); }
      $estado = 1;

        $cuenta = Cuentas::find($id_cuenta);
        $cuenta->congelada = $estado;
         if( $cuenta->save())
        {
            return view("cuentas.mensajes.msj_cuenta_congelada")->with("msj","Cuenta congelada correctamente");
        }else{
            return view("usuarios.mensajes.msj_error")->with("msj","...Hubo un error al agregar ;...") ;
        }
        return dd("cuenta", $cuenta);
    }

    public function descongelar_cuenta($id_cuenta){

       //actualizar los datos del usuario
      //return dd("Que llega aquyi", $id_cuenta);
     $usuario_actual= Auth::user();
      if( $usuario_actual->rol!=1 ){  return view("mensajes.msj_no_autorizado")->with("msj","no tiene autorizacion para acceder a esta seccion"); }
     $estado = 0;

        $cuenta = Cuentas::find($id_cuenta);
        $cuenta->congelada = $estado;
         if( $cuenta->save())
        {
            return view("cuentas.mensajes.msj_cuenta_descongelada")->with("msj","Cuenta descobgelada correctamente");
        }else{
            return view("usuarios.mensajes.msj_error")->with("msj","...Hubo un error al agregar ;...") ;
        }
        return dd("cuenta", $cuenta);
    }

    public function form_listado_vehiculos($id_cuenta=null,$estado=null){

       //actualizar los datos del usuario
      //return dd("Que llega aquyi", $id_cuenta);
       $cuenta = Cuentas::find($id_cuenta);
       $automotores = [];
      if($estado == 'V'){

        $cuenta->programas=$cuenta->programas?$cuenta->programas:'[]';
        $automotores=json_decode($cuenta->vehiculos_json);

      }else{

        $cuenta->programas=$cuenta->programas?$cuenta->programas:'[]';
        $automotores=json_decode($cuenta->motos_json);

      }

      return view("cuentas.listado_automotores")->with('cuenta',$cuenta)
                                  ->with("automotores",$automotores)
                                  ->with("estado",$estado);


     
    }

    

    

    

     public function buscar_cuenta(Request $request){


      $usuario_actual=Auth::user();
      $dato=$request->input("dato_buscado");

      $cuentas=Cuentas::where("propietario","like","%".$dato."%")
      			   ->orWhere("mz","like","%".$dato."%")
      			   ->orWhere("casa","like","%".$dato."%")
      			   ->orWhere("apto","like","%".$dato."%")
                ->paginate(100)
                ->appends(request()->query());
      return view('cuentas.listado_cuentas')->with("usuario_actual",$usuario_actual)
                                              ->with("busqueda",true)
                                              ->with("cuentas",$cuentas);

    }
    public function buscar_cuenta_inactivas(Request $request){


      $usuario_actual=Auth::user();
      $dato=$request->input("dato_buscado");
      $dato1 = 'I';

      $cuentas=Cuentas::where("propietario","like","%".$dato."%")
      			->orWhere("mz","like","%".$dato."%")
      			->orWhere("casa","like","%".$dato."%")
      			->orWhere("apto","like","%".$dato."%")
      			->where("estado",'=',$dato1)
                ->paginate(100)
                ->appends(request()->query());

        //return dd("ceuntas",$cuentas);
      return view('cuentas.listado_cuentas_inactivas')->with("usuario_actual",$usuario_actual)
                                              ->with("busqueda",true)
                                              ->with("cuentas",$cuentas);

    }

    public function buscar_cuenta_congeladas(Request $request){


      $usuario_actual=Auth::user();
      $dato=$request->input("dato_buscado");
      $dato1 = 1;
      $cuentas=Cuentas::where("propietario","like","%".$dato."%")
            ->orWhere("mz","like","%".$dato."%")
            ->orWhere("casa","like","%".$dato."%")
            ->orWhere("apto","like","%".$dato."%")
            ->where("congelada",'=',$dato1)
            ->paginate(100)
            ->appends(request()->query());

      return view('cuentas.listado_cuentas_congeladas')->with("usuario_actual",$usuario_actual)
                                              ->with("busqueda",true)
                                              ->with("cuentas",$cuentas);

    }

    

    

    public function lista_factura_cuenta($id_cuenta,$aniosel=null,$messel=null){
       
    	//return dd("ceuntas",$id_cuenta);
        $usuario_actual=Auth::user();
        $now = Carbon::now();
        if($aniosel==null){ 
          $aniosel=$now->year;
          $messel=$now->month;
        }

        $facturas=Factura::where("id_cuenta","=",$id_cuenta)
						  ->orderBy('mes')
        				  ->paginate(100);
        
        return view("cuentas.listado_facturas")->with("usuario_actual",$usuario_actual)
                                                ->with("aniosel",$aniosel)
                                                ->with("messel", $messel)
                                                ->with("facturas",$facturas);

    }



public function detalle_factura_cuenta($id_factura){

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

      // return dd("Aqui vamos",  $facturasel);
       

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
       return view("cuentas.detalle_factura")->with("usuario_actual",$usuario_actual)
                                              ->with("facturacargos",$facturacargos)
                                              ->with("saldoanterior",$saldoanterior)
                                              ->with("totalmes", $totalmes)
                                              ->with("totalFactura",$totalFactura)
                                              ->with('anio_p',$anio_p )
                                              ->with('mes_p',$mes_p )
                                              ->with('day_p',$day_p )
                                              ->with("factura",$facturasel);

    }

     public function buscar_factura(Request $request,$aniosel=null,$messel=null){


       $usuario_actual=Auth::user();
       $dato=$request->input("dato_buscado");
       $now = Carbon::now();
        if($aniosel==null){ 
          $aniosel=$now->year;
          $messel=$now->month;
        }

      $facturas=Factura::where("id","like","%".$dato."%")
      			->orWhere("propietario","like","%".$dato."%")
                ->paginate(100)
                ->appends(request()->query());
      return view('cuentas.listado_facturas')->with("usuario_actual",$usuario_actual)
                                              ->with("busqueda",true)
                                              ->with("aniosel",$aniosel)
                                              ->with("messel", $messel)
                                              ->with("facturas",$facturas);

    }
    

    

}