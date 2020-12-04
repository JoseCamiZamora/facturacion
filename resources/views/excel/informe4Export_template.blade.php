      <table    class='table table-generic table-strech'  >

            <thead class="bg-light">
              <tr>
                <th scope="col" class="th-gris text-center" colspan="6" >OTROS RECAUDOS {{$aniosel}} - {{$messel}}  </th>
         
             
            
              </tr>
              <tr>
                <th scope="col" class="th-gris text-center" style="width: 10px;" >No</th>
                <th scope="col" class="th-gris text-center " style="width: 30px;"  >fecha</th>
                <th scope="col" class="th-gris text-left" style="width: 50px;"  >referencia</th>
                <th scope="col" class="th-gris text-left" style="width: 50px;">proveedor</th>
                <th scope="col" class="th-gris text-left" style="width: 50px;" >detalles</th>
                <th scope="col" class="th-gris text-left" style="width: 50px;">valor</th>
             
            
              </tr>
            </thead>
            <tbody>
              <?php  $total=0; ?>
              @foreach($recaudos as $recaudo)

                <tr>
                  <td class='text-center' style="background-color: #dee2ec; font-weight: 700;border:1px solid white !important;" >
                    {{ $loop->index+1 }}
                  </td>
                    <td  class="text-center" >
                     {{ $recaudo->created_at ?? ""  }}
                  </td>
                  <td  class="text-left">
                     {{ $recaudo->referencia ?? ""  }}
                  </td>
                  <td  class="text-left">
                     {{ $recaudo->proveedor ?? "" }}
                  </td>
                  <td  class="text-left">
                    {{ $recaudo->detalles ?? "" }}
                  </td>
                  <td  class="text-left">
                     {{  $recaudo->valor ?? 0 }}
                  </td>
                
                 <?php  $total+=$recaudo->valor; ?>
              
               
                </tr>

              @endforeach
            </tbody>
               <tfoot>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="background-color: #dee2ec; font-weight: 700;border:1px solid white !important;" >
                  {{ $total ?? 0  }}</td>
               
              
              </tr>
              </tfoot>
          </table>