<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;


use Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        
        $usuarioactual=Auth::user();

        if($usuarioactual->rol==1){  return view('home')->with('usuario_actual', $usuarioactual);  }
        if($usuarioactual->rol==2){  return view('home_recaudador')->with('usuario_actual', $usuarioactual);  }
     
        

    }



 







}