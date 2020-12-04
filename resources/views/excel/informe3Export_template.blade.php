      <table    class='table table-generic table-strech' >



            <thead class="bg-light">
              <tr>
                <th scope="col" class="th-gris text-center" style="width: 100px;" >No. Factura</th>
                <th scope="col" class="th-gris text-center " style="width: 100px;"  >Mes Facturado</th>
                <th scope="col" class="th-gris" style="width: 30px;"  >Mz</th>
                <th scope="col" class="th-gris" style="width: 30px;">Casa</th>
                <th scope="col" class="th-gris" style="width: 30px;" >Apto</th>
                <th scope="col" class="th-gris">Propietario</th>
                <th scope="col" class="th-gris">valor</th>
                <th scope="col" class="th-gris" style="width: 60px;" >Estado</th>
               
            
              </tr>
            </thead>
            <tbody>

              @foreach($facturas as $factura)

                <tr>
                  <td class='text-center' style="background-color: #dee2ec; font-weight: 700;border:1px solid white !important;" >{{ $factura->id }}</td>
                  <td  class="   text-center">
                    {{ $factura->mes."/".$factura->anio }}
                  </td>
                  <td  class="   text-center">
                    {{ $factura->mz }}
                  </td>
                  <td  class="   text-center">
                    {{ $factura->casa }}
                  </td>
                  <td  class="   text-center">
                    {{ $factura->apto }}
                  </td>
                  <td class='text-left'>
                   {{ $factura->propietario }}
                  </td>
                     <td class='text-left'>
                   {{ number_format($factura->valor_total,0) }}
                  </td>
                  <td class='text-left'>

                  @if($factura->estado==1)
                   <span class="badge badge-pill badge-success" style='font-size: 0.6em;  margin-top:0px;'>Pagada</span> 
                  @endif
                  @if($factura->estado== 0)
                     <span class="badge badge-pill badge-primary" style='font-size: 0.6em;  margin-top:0px; font-weight: 700;'>Sin pagar</span> 
                  @endif
                   @if($factura->estado== 2)
                     <span class="badge badge-pill badge-warning" style='font-size: 0.6em;  margin-top:0px; font-weight: 700;'>Vencida</span> 
                  @endif
                  @if($factura->estado== 3)
                     <span class="badge badge-pill badge-danger" style='font-size: 0.6em;  margin-top:0px; font-weight: 700;'>Orden Suspensión</span> 
                  @endif
               
                </tr>
              @endforeach
            </tbody>
           
          </table>