    <table    style="min-width: 400px;"  >
            <thead >
              <tr>
              <th colspan="9">Listado de Recaudos {{$aniosel."-".$messel}}
              </th>
             </tr>
              <tr>
                <th  style="width: 10px; background-color: #dee2ec;"  >No.</th>
                <th  style="width: 10px; background-color: #dee2ec;"  >Tipo</th>
                <th style="width: 60px; background-color: #dee2ec;"  >Propietario</th>
                <th   >Valor mes</th>
                <th   >Saldo anterior</th>
                <th  >Total Cargos</th>
                 <th >Abonos</th>
                <th  >Subtotal</th>
                <th >Mora</th>
                <th >Total Recaudo</th>
              
              </tr>
            </thead>
            <tbody>

             @foreach($facturas as $cuenta)
                <tr>
                  <td >{{ $cuenta->id }}</td>
                  <td  >@if($cuenta->estado==1) PAGO  @endif  @if($cuenta->estado==0 &&  $cuenta->abono==1) Abono  @endif</td>
                  <td >{{ $cuenta->propietario }}</td>
                  <td  >{{$cuenta->valor_mes}}</td>
                  <td  >{{$cuenta->saldo_anterior}}</td>
                  <td  >{{$cuenta->total_cargos}}</td>
                  <td  >{{$cuenta->valor_abono}}</td>
                  <td  >{{$cuenta->valor_total-$cuenta->valor_abono}}</td>
                  <td  >{{$cuenta->mora}}</td>
                   @if($cuenta->estado==1)
                  <td  >{{$cuenta->valor_mes+ + $cuenta->saldo_anterior+  $cuenta->total_cargos +  $cuenta->mora}}</td>
                   @endif

                   @if($cuenta->estado==0 &&  $cuenta->abono==1)

                   <td  >{{ $cuenta->valor_abono }} </td>

                   @endif
              
                 
                 
               
                </tr>

              @endforeach
            </tbody>
          
          </table>