 <table    class='table table-generic table-strech' style="margin-top: 10px;" >
    <thead class="bg-light">
      <tr>
        <th scope="col" class="th-gris text-center" style="width: 100px;" >No.</th>
        <th scope="col" class="th-gris">Detalle del cargo</th>
        <th scope="col" class="th-gris text-center " style="width: 125px;">Valor Inicial </th>
      </tr>
    </thead>
    <tbody>
      @foreach($cargos as $car)
        <tr>
          <td class='text-center'>{{ $loop->index+1 }}</td>
          <td class='text-left' >
           <h6 class="td-titulo" style="font-size: 0.7em !important;">{{ $car->cargo }}</h6>
          </td>
          <td class="td-btn-azul-claro" >
            ${{number_format($car->valor_default, 0)}}
          </td>
        </tr>
      @endforeach
    </tbody>
       <tfoot>
      <tr>
          <td colspan='3'><span style='font-size:0.9em'><b>Total:</b> {{ $cargos->count() }} cargos</span></td>
      </tr>
      </tfoot>
  </table>
        <table    class='table table-generic table-strech' >
    <thead class="bg-light">
      <tr>
        <th scope="col" class="th-gris text-center" style="width: 100px;" >No.</th>
        <th scope="col" class="th-gris">Facturado</th>
        <th scope="col" class="th-gris text-center " style="width: 125px;">Valor Inicial </th>
      </tr>
    </thead>

    <tbody>
      @foreach($valores as $val)
        <tr>
          <td class='text-center'>{{ $loop->index+1 }}</td>
          <td class='text-left'>
          <h6 class="td-titulo" style="font-size: 0.7em !important;">{{ $val->nombre }}</h6>
          </td>
          <td class="td-btn-azul-claro" >
            ${{number_format($val->valor_default, 0)}}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <label style="font-size:0.9em; ">Todas las facturas llevaran estos valores iniciales </label>
  <label style="font-size:0.9em; ">Puede cambiar los valores iniciales en la sección de configuración </label>