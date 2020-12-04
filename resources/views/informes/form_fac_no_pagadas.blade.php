<div class="row">
	<div class="col">
	  	<table    class='table table-generic table-strech' >
		    <thead class="bg-light">
		      <tr>
		        <th scope="col" class="th-gris text-left" >No Factura.</th>
		        <th scope="col" class="th-gris text-left" >Mes</th>
		        <th scope="col" class="th-gris text-left" >Anio</th>
		        <th scope="col" class="th-gris text-left" >Valor Mes</th>
		        <th scope="col" class="th-gris text-left" >Saldo Anterior</th>
		        <th scope="col" class="th-gris text-left" >Cargos</th>
		         <th scope="col" class="th-gris text-left" >Abono</th>
		  
		        <th scope="col" class="th-gris text-left " >Total</th>
		      </tr>
		    </thead>
		    <tbody>

		     @foreach($facturas as $cuenta)
		        <tr>
		          <td class='text-left' >{{ $cuenta->id }}</td>
		          <td class='td-titulo text-left'>
		          	@if($cuenta->mes==1){{ "Enero" }} @endif
                    @if($cuenta->mes==2){{ "Febrero" }} @endif
                    @if($cuenta->mes==3){{ "Marzo" }} @endif
                    @if($cuenta->mes==4){{ "Abril" }} @endif
                    @if($cuenta->mes==5){{ "Mayo" }} @endif
                    @if($cuenta->mes==6){{ "Junio" }} @endif
                    @if($cuenta->mes==7){{ "Julio" }} @endif
                    @if($cuenta->mes==8){{ "Agosto" }} @endif
                    @if($cuenta->mes==9){{ "Septiembre" }} @endif
                    @if($cuenta->mes==10){{ "Octubre" }} @endif
                    @if($cuenta->mes==11){{ "Noveimbre" }} @endif
                    @if($cuenta->mes==12){{ "Diciembre" }} @endif

		          	</td>
		          <td class='td-titulo text-left'  >{{ $cuenta->anio ?? 0}}</td>
		          <td class='td-titulo text-left'  >{{ $cuenta->valor_mes ?? 0 }}</td>
		               <td class='td-titulo text-left'  >{{ $cuenta->saldo_anterior ?? 0 }}</td>
		          <td class='td-titulo text-left'  >{{ $cuenta->total_cargos ?? 0 }}</td>
		          <td class='td-titulo text-left'  >-{{ $cuenta->valor_abono ?? 0 }}</td>
		       
		          <td class='text-left'  >${{number_format($cuenta->valor_mes + $cuenta->saldo_anterior +  $cuenta->total_cargos-$cuenta->valor_abono, 0)}}</td>
		        </tr>

		     
		      @endforeach
		    </tbody>

		     <tfooter>

		    	<tr>
		    	<th>
		    		-
		    	</th>
		    	<th>
		    		 -
		    	</th>
		       </tr>

		       <tr>
		    	<th>
		    		Total recargo por MORA
		    	</th>
		    		<th>
		    		 -
		    	</th>
		  
		    		<th>
		    		 -
		    	</th>
		    		<th>
		    		 -
		    	</th>
		    	<th>
		    		 -
		    	</th>
		    		<th>
		    		 -
		    	</th>
		    		<th>
		    		 -
		    	</th>
		    	<th>
		    		     ${{ number_format($totalmora, 0) ?? 0 }}
		    	</th>
		       </tr>
		    </tfooter>
		</table>
	</div> 
</div>