@extends('layouts.auth')

@section('content')

  <div class="container-fluid icon-sidebar-nav h-100" >
      <div class="row ">
      

        <div class='col-md-12' >
        
        <main class="main-content col" style="padding: 0 0 0 0rem;" >
          <div class="main-content-container container-fluid px-4 my-auto h-100">
            <div class="row no-gutters h-100">
              <div class="col-lg-6 col-md-6 auth-form mx-auto my-auto">

                <div class="card" style="margin-top:50px;">
                  <div class="card-body">
                    <img class="auth-form__logo d-table mx-auto mb-3" src="{{ asset("assets/img/logo_inicial.svg")}}" alt="logo_cedenar" style="max-width: 10.5rem !important;">
                   
                    <form id="form_login" method="post" autocomplete="off" action="{{ url('/login_externo') }}" >
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input autocomplete="off" type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Ingresar email" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input autocomplete="off" type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required >
                      </div>
                      <button type="submit" class="btn btn-pill btn-accent d-table mx-auto">Ingresar</button>
                        @if ($errors->count() > 0)
                          <ul class='red-text'>
                              @foreach ($errors->all() as $error)
                                <li class='red-text'><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ $error }}</li>
                              @endforeach
                          </ul>
                        @endif
                    </form>
                  </div>
                  <div class="card-footer border-top">
                  
                  </div>
                </div>
                <div class="auth-form__meta d-flex mt-4">
                 -
                </div>
              </div>
              
            </div>
          </div>
        </main>
       
      </div>


      </div>

    </div>



@endsection




