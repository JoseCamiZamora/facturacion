<table    style="min-width: 400px;"  >
            <thead >
              <tr>
              <th colspan="6">Listado de propietarios que a la fecha estan en mora
              </th>
             </tr>
              <tr>
                <th  style="width: 10px; background-color: #dee2ec;"  >No.</th>
                <th  style="width: 50px; background-color: #dee2ec;" >Dirección</th>
                <th  style="width: 30px; background-color: #dee2ec;" >Propietario</th>
                <th  style="width: 20px; background-color: #dee2ec;" >Estado Factura</th>
                <th  style="width: 10px; background-color: #dee2ec;">Facturas Sin pagar</th>
                 <th  style="width: 10px; background-color: #dee2ec;">Facturas en mora</th>
                  <th  style="width: 10px; background-color: #dee2ec;">Mora</th>
                <th  style="width: 20px; background-color: #dee2ec;" >Saldo</th>
               
              </tr>
            </thead>
            <tbody>

             @foreach($cuentas as $cuenta)
                <tr>
                  <td  >{{ $loop->index+1 }}</td>
                  <td  >{{ $cuenta->direccion }}</td>
                  <td  >{{ $cuenta->propietario }}</td>

                  
                  <td  >
                    @if($cuenta->congelada==1)
                     Congelada
                    @else
                       Activa
                    @endif
                  </td>
                  <td  >{{$cuenta->cantidad_facturas}}</td>
                    <td  >{{$cuenta->cantmora?? 0}}</td>
                    <td  >{{$cuenta->mora?? 0}}</td>
                  <td style="text-align: right;">{{$cuenta->valor_total}} </td>
                 
                 
                </tr>

              @endforeach
            </tbody>
            
          </table>