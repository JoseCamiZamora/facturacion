 <!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>factura 1</title>
  <meta name="description" content="pdf factura">
 <style>
 	body{ font-family: arial !important; }
 	
 	.p-subtitulo{   }
 	table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
      text-align: center;
    }
    .td-color-azul{
    	background-color: #7491ac;
    	color: white;
        border-right: 1px solid #c4d4e3;
        font-size: 12px;
        line-height: 0.3;
        font-weight: 700;
        padding: .75rem;
    }
  
 </style>
</head>

<body>
        <div style="text-align: center;">

	 	<table  style="width:70%;  display: inline-block;" >
                       <tbody>
                       	<tr class="text-center" >
                       		<td colspan="4" >
                       			<h5 style="margin-bottom: .05rem; font-size: 1.25rem; ">BARRIO LAS BRISAS</h5>
                       			<p class="p-subtitulo">JUNTA ADMINISTRADORA DEL ACUEDUCTO</p>
                       		</td>
                       		
                       	</tr>
                       	<tr class="text-center">
                       		<td colspan="4" class="td-color-blanco" >FACTURA DEL AGUA</td>
                       		
                       		
                       	</tr>

                       	<tr class="text-center">
                       		<td  class="td-color-blanco " >ESTRATO: {{$factura->estrato}} </td>
                       		<td  class="td-color-blanco"  colspan="3" >NIT.900.058.328 DV-5</td>
                       		
                       	</tr>

                        <tr class="text-center">
                       		<td class="td-color-blanco"  >FACTURA No:</td>
                       		<td class="td-gris-azul-claro" colspan="3" >{{$factura->id}} </td>
                       	</tr>

                       	<tr class="text-center">
                       		<td class="td-color-azul" style="width: 350px;">DIRECCIÓN </td>
                       		<td class="td-color-azul" >MZ</td>
                       		<td class="td-color-azul" >CASA</td>
                       		<td class="td-color-azul" >APTO</td>
                       		
                       	</tr>

                       	<tr class="text-center">
                       		<td class="td-color-blanco" >{{ $factura->direccion }}</td>
                       		<td class="td-color-blanco" >{{$factura->mz}}</td>
                       		<td class="td-color-blanco" >{{$factura->casa}}</td>
                       		<td class="td-color-blanco"  >{{$factura->apto}}</td>
                       		
                       	</tr>

                       	 	<tr class="text-center">
                       		<td class="td-color-blanco" >NOMBRE:</td>
                       	
                       		<td class="td-color-blanco" colspan="3" >{{$factura->propietario}}</td>
                       		
                       	</tr>


                       	<tr class="text-center">
                       		<td class="td-color-azul" >MES FACTURADO</td>
                       		<td colspan="2" class="td-color-azul"> MES</td>
                       		<td  class="td-color-azul" >AÑO</td>
                       		
                       		
                       	</tr>
                       	 <tr class="text-center">
                       		<td class="td-color-blanco" >--</td>
                       		<td colspan="2" class="td-color-blanco" ></td>
                       		<td class="td-color-blanco"  >{{ $factura->anio }}</td>
                       		
                       	</tr>
                       	<tr class="text-center">
                       		<td class="td-color-azul">FECHA DE PAGO</td>
                       	    <td class="td-color-azul" >DIA</td>
                       		<td class="td-color-azul" >MES</td>
                       		<td class="td-color-azul" >AÑO</td>
                       	</tr>
                        @if($factura->estado==1)

                       	<tr class="text-center">
                       		<td class="td-color-blanco" style="background-color: #38c138;color:white; "  > PAGADA</td>
                       	    <td class="td-color-blanco"  ></td>
                       		<td class="td-color-blanco"  ></td>
                       		<td class="td-color-blanco"  ></td>
                       	</tr>

                        @else

                          <tr class="text-center">
                            <td class="td-color-blanco" style="background-color: #e68b3c;color:white; "  >SIN PAGAR</td>
                            <td class="td-color-blanco"  >-</td>
                            <td class="td-color-blanco"  >-</td>
                            <td class="td-color-blanco"  >-</td>
                          </tr>

                        @endif

                       	<tr class="text-center">
                       		<td class="td-color-azul" >CONCEPTOS</td>
                       	    <td colspan="3" class="td-color-azul">VALOR</td>
                       	</tr>

                       	<tr class="text-center">
                       		<td class="td-color-blanco" >--</td>
                       	    <td class="td-color-blanco" >VALOR</td>
                       		<td class="td-color-blanco" >CANCELA</td>
                       		<td class="td-color-blanco"  >DEBE</td>
                       	</tr>

                        <tr >
                          <td class="text-left td-conceptos" >SALDO ANTERIOR</td>
                          <td class="text-center td-color-blanco">{{number_format($factura->saldo_anterior, 0)}}</td>
                          <td class="text-center td-color-blanco"></td>
                          <td class="text-center td-color-blanco" ></td>
                        </tr>
                        <tr >
                          <td class="text-left td-conceptos" >VALOR LECTURA MES</td>
                          <td class="text-center td-color-blanco">{{number_format($factura->valor_mes, 0)}}</td>
                          <td class="text-center td-color-blanco"></td>
                          <td class="text-center td-color-blanco" ></td>
                        </tr>

                        @foreach($facturacargos as $cargo)
                       	<tr >
                       		<td class="text-left td-conceptos" >{{$cargo->cargo}}</td>
                       	  <td class="text-center td-color-blanco">{{number_format($cargo->valor_default, 0)}}</td>
                       		<td class="text-center td-color-blanco"></td>
                       		<td class="text-center td-color-blanco" ></td>
                       	</tr>
                        @endforeach

                        


                        <tr >
                       		<td class="td-total text-center">VALOR TOTAL</td>
                       	  <td class="td-total-gris-claro" >${{  number_format($factura->valor_total, 0) }}</td>
                       		<td class="td-total"></td>
                       		<td class="td-total" ></td>
                       	</tr>

                       	<tr class="text-left">
                       		<td colspan="4">
                       			Firma y Sello de Tesorería
                       		</td>
                       	
                       	</tr>
                   

                       	<tr class="text-left">
                       		<td colspan="4">
                       			-
                       		</td>
                       	
                       	</tr>

                       	<tr class="text-left">
                       		<td colspan="4">
                       			<p>Esta factura presta merito ejecutivo, según articulo 77 de comercio
                       		    El mal uso del agua será sancionado según estatutos aprobados</p>
                       		</td>
                       	
                       	</tr>

                       	<tr class="text-left">
                       		<td colspan="4">
                       			<p>Observaciones:</p>

                            <p>{{ $factura->observaciones}}</p>
                       		</td>
                       	
                       	</tr>







                       </tbody>

            	</table>

            </div>

</body>

</html>  