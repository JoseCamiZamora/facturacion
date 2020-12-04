  <div class="main-navbar  bg-white"  id="menu_principal">
              <div class="container p-0">
                <!-- Main Navbar -->
                <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
                  <a class="navbar-brand" href="{{ url('/') }}" style="line-height: 25px;">
                    <div class="d-table m-auto">
                      <img id="main-logo" class="d-inline-block align-top mr-1 ml-3" style="max-width: 10em;" src="{{ asset('/assets/img/logo_horizontal_blancoo.svg') }}" alt="logo Urbnizacion">
                      <span class="d-none d-md-inline ml-1 " >
                    
                        <b style='line-height: 46px !important;'>SISTEMA DE FACTURACION URBANIZACION TERRAZAS DEL NORTE I ETAPA</b>
                    
                      </span>
                    </div>
                  </a>
                 
                  <ul class="navbar-nav  flex-row  ml-auto">
  
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
  
                        
                 
                        <img class="user-avatar rounded-circle mr-2" src="{{ asset('/assets/img/usuario.svg') }}"   onerror="this.src='{{ asset('/assets/img/usuario.svg') }}">
                        <span class="d-none d-md-inline-block"  id="US_nombre_usuario_actual" >
                        </span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-small">
     
                         
                        <a class="dropdown-item" href="{{url('/perfil_usuario')}}"><i class="material-icons">&#xE7FD;</i> Perfil</a>
      
                      
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{ url('/logout') }}" >
                          <i class="material-icons text-danger">&#xE879;</i> Cerrar Sesión </a>
                      </div>
                    </li>
                  </ul>
                  <nav class="nav">
                    <a href="#" class="nav-link nav-link-icon toggle-sidebar  d-inline d-lg-none text-center " data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                      <i class="material-icons">&#xE5D2;</i>
                    </a>
                  </nav>
                </nav>
              </div> <!-- / .container -->


            </div> 
