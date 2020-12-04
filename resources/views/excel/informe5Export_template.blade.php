    <?php   $totalcargos=0;  ?>
 
      <table    class='table table-generic table-strech' >
            <thead class="bg-light">
              <tr>
                <th colspan="3" class="text-center"> Recaudos de  {{$aniosel}} - {{ $messel }}</th>
              </tr>
              <tr>
                <th  class="th-gris text-center" style="width: 10px;"   >ID.</th>
                <th  class="th-gris text-left"  style="width: 50px;"  >Cargo</th>
                <th  class="th-gris text-left " style="width: 60px;" >Total Recaudo</th>
              
              </tr>
            </thead>
            <tbody>


               <tr>
                  <td class='text-center'>-</td>
                  <td class='text-left' >SALDOS ANTERIORES RECAUDADOS</td>
                  <td class='text-left' >{{$saldos_anteriores}}</td>

               
                </tr>

               <tr>
                  <td class='text-center'>-</td>
                  <td class='text-left' >POR MORA</td>
                  <td class='text-left' >{{$moras}}</td>

               
                </tr>

                 <tr>
                  <td class='text-center'>-</td>
                  <td class='text-left' >VALORES NORMALES MES</td>
                  <td class='text-left' >{{$valores_mes}}</td>

               
                </tr>

                  <?php 
                       $totalcargos+=$saldos_anteriores+$moras+$valores_mes;
                 ?>
              

             @foreach($cargos as $cargo)
                <tr>
                  <td class='text-center'>-</td>
                  <td class='text-left' >{{ $cargo->cargo }}</td>
                  <td class='text-left' >{{$cargo->sum_cargo}}</td>

               
                </tr>

                <?php 
                       $totalcargos+=$cargo->sum_cargo;
                 ?>

              @endforeach

                

                 <tr>
                  <td class='text-center'>-</td>
                  <td class='text-left' >ABONOS REALIZADOS</td>
                  <td class='text-left' >{{$valores_abono}}</td>

               
                </tr>

                    <?php 
                       $totalcargos+=$valores_abono;
                 ?>

                <tr>
                  <td class='text-center'></td>
                  <td class='text-left' >Total Recaudado Mes</td>
                  <td class='text-left'  >{{$totalcargos}}</td>

               
                </tr>


            </tbody>
              
          </table>