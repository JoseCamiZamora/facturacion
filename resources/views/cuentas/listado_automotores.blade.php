<div class="row">
    <div class="col">
      <table    class='table table-generic table-strech' >
            <thead class="bg-light">
              <tr>
                <th scope="col" class="th-gris text-center" style="width: 20px;">No.</th>
                <th scope="col" class="th-gris text-left" style="width: 10px;">Marca</th>
                <th scope="col" class="th-gris text-left" style="width: 10px;">Linea</th>
                <th scope="col" class="th-gris text-left" style="width: 10px;">Placa</th>
              </tr>
            </thead>
            <tbody>
             @foreach($automotores as $auto)
                <tr>
                  <td class='text-center' >{{ $auto->id}}</td>
                  <td class='td-titulo'>{{ $auto->marca }}</td>
                  <td class='td-titulo'  >{{ $auto->linea }}</td>
                  <td class='td-titulo'  >{{ $auto->placa }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
         </div> 

  </div>
</div>