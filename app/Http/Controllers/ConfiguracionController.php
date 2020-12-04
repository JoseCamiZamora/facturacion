<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Cuentas;
use App\Cargos;
use App\CargosMora;
use App\Avisos_sistema;
use App\Valores;
use Auth;

class ConfiguracionController extends Controller
{

      public function __construct()
    {
        $this->middleware('auth');
    }

     public function listado_cargos_mora(){

       $cargosmora=CargosMora::all();
       $valores=Valores::all();
       return view('configuracion.listado_cargos_mora')->with('cargos',  $cargosmora )->with('valores',  $valores );
    }

    public function listado_cargos(){

       $cargos=Cargos::all();
       return view('configuracion.listado_cargos')->with('cargos',  $cargos );
    }

    public function listado_valores(){

       $valores=Valores::all();
       return view('configuracion.listado_valores')->with('valores',  $valores );
    }

    public function listado_comunicados(){

       $comunicados=Avisos_sistema::all();
       //return dd("que llego",$comunicados);
       return view('configuracion.listado_comunicados')->with('comunicados',  $comunicados );
    }

    

    public function form_nuevo_valor(){

       $valores=Valores::all();
       return view('configuracion.form_nuevo_valor');
    }

    public function form_nuevo_comunicado(){

        $comunicados=Avisos_sistema::all();
       return view('configuracion.form_nuevo_comunicado');
    }

    

    public function nuevo_valor(Request $request){
       $maxval= Valores::max('id');
       $maxval=$maxval+1;
       $valorsel= new Valores;
       $valorsel->tipo_cuenta=$maxval;
       $valorsel->nombre= strtoupper( $request->input("detalle") ) ;
       $valorsel->valor_default= $request->input("valor") ?$request->input("valor"):0;

       if( $valorsel->save()){

             return view("configuracion.mensajes.msj_valor_creado")->with('msj','el valor de facturas se ha creado correctamente');
        }
        else{
             return view("configuracion.mensajes.msj_error")->with('msj','no se ha podido registrar el valor');
        }
    }

    public function nuevo_comunicado(Request $request){
       $maxval= Avisos_sistema::max('id');
       $valorsel= new Avisos_sistema;
       $valorsel->descripcion= strtoupper( $request->input("observaciones") ) ;
       $valorsel->estado= $request->input("estado") ;

       //return dd("Que llega", $valorsel);

       if( $valorsel->save()){
            return view("configuracion.mensajes.msj_comunicado_creado")->with('msj','El comunicado de facturas se ha creado correctamente');
        }
        else{
            return view("configuracion.mensajes.msj_error")->with('msj','no se ha podido registrar el valor');
        }
    }

    

     public function form_editar_valor($idvalor){
       $idval=$idvalor ?$idvalor:0;
       $valorsel=Valores::find($idval);
       return view('configuracion.form_editar_valor')
               ->with('valor',$valorsel);
     }

      public function form_borrar_valor($idvalor){
       $idval=$idvalor ?$idvalor:0;
       $valorsel=Avisos_sistema::find($idval);

       if( $valorsel->delete()){

             return view("configuracion.mensajes.msj_comunicado_borrado")->with('msj','El comunicado de facturas se ha borrado correctamente');
      }
        else{
             return view("configuracion.mensajes.msj_error")->with('msj','no se ha podido registrar el valor');
      }

       return view('configuracion.form_editar_valor')
               ->with('valor',$valorsel);
     }

     

     public function form_editar_comunicado($idvalor){
       $idval=$idvalor ?$idvalor:0;
       $valorsel=Avisos_sistema::find($idval);
       if( $valorsel->estado == 'I'){
          $estado = 'INACTIVO';
       }else{
          $estado = 'ACTIVO';
       }

       //return dd("llego",$valorsel);
       
       return view('configuracion.form_editar_comunicado')
               ->with('valor',$valorsel)
               ->with('estado',$estado);
     }

     

     public function editar_valor(Request $request){
      $idval=$request->input("id_valor") ?$request->input("id_valor"):0;
      $valorsel=Valores::find( $idval);
      $valorsel->nombre= $request->input("detalle") ?$request->input("detalle"):"sin definir";
      $valorsel->valor_default=$request->input("valor") ?$request->input("valor"):0;
      if( $valorsel->save()){

             return view("configuracion.mensajes.msj_valor_editado")->with('msj','el valor de facturas se ha actualizado correctamente');
      }
        else{
             return view("configuracion.mensajes.msj_error")->with('msj','no se ha podido registrar el valor');
      }


     }

     public function editar_comunicado(Request $request){

      $idval=$request->input("id_comunicado") ?$request->input("id_comunicado"):0;
      $valorsel=Avisos_sistema::find( $idval);

      $valorsel->descripcion= strtoupper( $request->input("observaciones") ?$request->input("observaciones"):"sin definir");
      //strtoupper( $request->input("observaciones")
      $valorsel->estado=$request->input("estado");
      
      if( $valorsel->save()){

             return view("configuracion.mensajes.msj_comunicado_editado")->with('msj','El comunicado de facturas se ha actualizado correctamente');
      }
        else{
             return view("configuracion.mensajes.msj_error")->with('msj','no se ha podido registrar el valor');
      }


     }

     

    public function form_nuevo_cargo(){

       $valores=Valores::all();
       return view('configuracion.form_nuevo_cargo');
    }

    public function nuevo_cargo(Request $request){
     
       $cargosel= new Cargos;
     
        $cargosel->cargo= strtoupper( $request->input("detalle") ) ;
        $cargosel->valor_default= $request->input("valor") ?$request->input("valor"):0;

       if(  $cargosel->save()){

             return view("configuracion.mensajes.msj_cargo_creado")->with('msj','el cargo de facturas se ha creado correctamente');
        }
        else{
             return view("configuracion.mensajes.msj_error")->with('msj','no se ha podido registrar el valor');
        }
    }


    public function form_nuevo_cargo_mora(){

       $valores=Valores::all();
       return view('configuracion.form_nuevo_cargo_mora')->with("valores",$valores);
    }


    public function nuevo_cargo_mora(Request $request){
     
        $cargosel= new CargosMora;
     
        $cargosel->cargo= strtoupper( $request->input("detalle") ) ;
        $cargosel->tipo_factura= strtoupper( $request->input("tipo_factura") ) ;
        $cargosel->valor_default= $request->input("valor") ?$request->input("valor"):0;

       if(  $cargosel->save()){

             return view("configuracion.mensajes.msj_cargo_mora_creado")->with('msj','el cargo de facturas se ha creado correctamente');
        }
        else{
             return view("configuracion.mensajes.msj_error")->with('msj','no se ha podido registrar el valor');
        }
    }


    public function form_editar_cargo($idvalor){
       $idval=$idvalor ?$idvalor:0;
       $cargosel=Cargos::find($idval);
       return view('configuracion.form_editar_cargo')
               ->with('cargo',$cargosel);
    }

     public function form_editar_cargo_mora($idvalor){
       $idval=$idvalor ?$idvalor:0;
       $cargosel=CargosMora::find($idval);
        $valores=Valores::all();

       return view('configuracion.form_editar_cargo_mora')
              ->with("valores",$valores)
               ->with('cargo',$cargosel);
    }

    

    public function editar_cargo(Request $request){
      $idval=$request->input("id_cargo") ?$request->input("id_cargo"):0;
      $cargosel=Cargos::find( $idval);
      $cargosel->cargo= $request->input("detalle") ?$request->input("detalle"):"sin definir";
      $cargosel->valor_default=$request->input("valor") ?$request->input("valor"):0;
      if( $cargosel->save()){

             return view("configuracion.mensajes.msj_cargo_editado")->with('msj','el valor de Cargos se ha actualizado correctamente');
      }
        else{
             return view("configuracion.mensajes.msj_error")->with('msj','no se ha podido registrar el valor');
      }


    }

    public function editar_cargo_mora(Request $request){
      $idval=$request->input("id_cargo") ?$request->input("id_cargo"):0;
      $cargosel=CargosMora::find( $idval);
      $cargosel->cargo= $request->input("detalle") ?$request->input("detalle"):"sin definir";
      $cargosel->tipo_factura= $request->input("tipo_factura") ?$request->input("tipo_factura"):0;
      $cargosel->valor_default=$request->input("valor") ?$request->input("valor"):0;
      if( $cargosel->save()){

             return view("configuracion.mensajes.msj_cargo_mora_editado")->with('msj','el valor de Cargos Mora se ha actualizado correctamente');
      }
        else{
             return view("configuracion.mensajes.msj_error")->with('msj','no se ha podido registrar el valor');
      }


    }


     public function listado_cargos_a_generar(){
       $valores=Valores::all();
       $cargos=Cargos::all();
       return view('facturas.listado_cargos_a_generar')->with('cargos',  $cargos )->with('valores',  $valores );
     }

    

}