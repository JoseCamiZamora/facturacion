function FA_cambiar_fecha_facturas(){

   var messel=$('#select_mes_val').val();
   var aniosel=$('#select_anio_val').val();

    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/facturas/listado_facturas/'+aniosel+'/'+messel+'';

   window.location.href= miurl;

}



function FA_filtro_estado(){

   var messel=$('#select_mes_val').val();
   var aniosel=$('#select_anio_val').val();
   var estadosel=$('#select_mes_filtro').val();

   console.log("estado",estadosel);

    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/facturas/listado_facturas_estado/'+aniosel+'/'+messel+'/'+estadosel+'';

   window.location.href= miurl;

}

function FA_modal_generar_facturas(){

   $('#modal_generar_facturas').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/configuracion/listado_cargos_a_generar";

    $.ajax({
    url: miurl
    }).done( function(resul){
    
      $('.preloader').fadeOut();
      $("#modal_listado_cargos").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;



}

function facturasNoPagada(id_factura) {

  console.log("llego ",id_factura);
  $('#modal_facturas_no_pagadas').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/informes/listado_facturas_no_pagadas/'+id_factura+'';

    $.ajax({
    url: miurl
    }).done( function(resul){
    
      $('.preloader').fadeOut();
      $("#contenido_modal_factura_no_pagadas").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;
}

function detallefactaurasAnteriores(id_factura) {

  console.log("llego xxxxxx",id_factura);
  $('#modal_facturas_no_pagadas_1').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/facturas/detalle_facturas_anteriores/'+id_factura+'';

    $.ajax({
    url: miurl
    }).done( function(resul){
    
      $('.preloader').fadeOut();
      $("#contenido_modal_factura_no_pagadas_1").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;


}

function editarFactura (id_factura) {


    $('#modal_editar_factura').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/facturas/editar_factura/"+id_factura+"";

    $.ajax({
    url: miurl
    }).done( function(resul){
    
      $('.preloader').fadeOut();
      $("#contenido_editar_modal_factura").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;
  // body...
}

function fac_nav_generar_facturas(){

   var messel=$('#mod_select_mes_val').val();
   var aniosel=$('#mod_select_anio_val').val();
   
   
 
 if(aniosel>0 && messel>0 ){ 
 $('.preloader').show(); 

   var urlraiz=$("#url_raiz_proyecto").val();
   var miurl='';
   miurl=urlraiz+'/facturas/generar_facturas/'+aniosel+'/'+messel+'';

   window.location.href= miurl;
   
 }
 else
 {
   alert('Seleccione el mes y el año a generar');
   $('.preloader').fadeOut();
 }
}


$(document).on("submit","#f_editar_factura",function(e){
  //funcion para actualizar los datos del usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/facturas/editar_factura_detalle";

    $.ajax({
      url : varurl,
      data : formu.serialize(),
      method: 'POST',
      dataType : 'html',
    })
    .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_editar_modal_factura").html(resul);
    })
    .fail(function(err){
        SU_revise_conexion();
        $(".preloader").hide();
    });
});


function agregarCargosFactura(id_factura) {

    
    $('#modal_cargos_factura').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/facturas/form_cargos_factura/"+id_factura+"";

    $.ajax({
    url: miurl
    }).done( function(resul){
    
      $('.preloader').fadeOut();
      $("#contenido_modal_cargos_factura").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;
  // body...
}

function registrarAbonoFactura(id_factura,fecha, id_cuenta){
  console.log(id_factura,fecha, id_cuenta);
}


$(document).on("submit","#f_cargos_factura",function(e){
  //funcion para actualizar los datos del usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/facturas/agregar_cargos_factura";

    $.ajax({
      url : varurl,
      data : formu.serialize(),
      method: 'POST',
      dataType : 'html',
    })
    .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_modal_cargos_factura").html(resul);
    })
    .fail(function(err){
        SU_revise_conexion();
        $(".preloader").hide();
    });
});


$(document).on("submit","#f_pagar_factura",function(e){
  //funcion para actualizar 
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/facturas/pagar_factura";

  
  $.ajax({
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html',
    })
    .done(function(resul) {
     $('.preloader').fadeOut();
     $("#contenido_pago_modal_factura").html(resul);

    })
    .fail(function(err){
        SU_revise_conexion();
        $(".preloader").hide();
         
    });
  

});

function realizarAbonoFactura(valor_total) {

  $('.preloader').fadeIn();
  var valorTotal = valor_total;
  var valorAbono = $("#valor_abonar").val();
  var valorAbonar = $("#valor_abono").val();
  var estado = $("#estado_abono").val();
  var propietario = $("#propietarios").val();
  var fecha = $("#fecha_pago").val();
  var id_factura=$('#id_factura').val();


  var formData = new FormData();
  formData.append("id_factura", id_factura);
  formData.append("propietario", propietario );
  formData.append("fecha", fecha );
  formData.append("valor_abono", valorAbonar );

  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/facturas/abonar_factura";

  var valAbonar = parseInt(valorAbonar);
  var valTotal = parseInt(valorTotal);
  var valAbono = parseInt(valorAbono);
 
   if(estado == 0){

     if(valAbonar > valTotal){
      swal({
        title: "Advertencia!",
        type: "warning",
        text: "El valor del abono no puede ser mayor al valor total de la facturta.. Valida la información e intenta nuevamente"
      });
      $(".preloader").hide();
     }else{
          formData.append("pagada", 'NO' );
          formData.append("primerAbono", 'SI' );
          $.ajax({
            // la URL para la petición
            url : varurl,
            method : 'POST',
            cache: false,
            processData: false,
            contentType : false,
            data: formData ,
            headers: {
              'X-CSRF-Token': $('input[id="_token_maestro"]').val()
            },
        }).done(function(resul){
          console.log("resultado",resul);
           $('.preloader').fadeOut();
           $("#contenido_abono_modal_factura").html(resul);
        })
          .fail( function (jqXHR, status, error) {
          $('.preloader').fadeOut();
          swal("Error", "Ocurrio un error con la conexion contactese con el administrador del sistema", "warning");
        });
    }  
  }else{
    if(valAbonar > valTotal){
      swal({
        title: "Advertencia!",
        type: "warning",
        text: "El valor del abono no puede ser mayor al valor total de la facturta.. Valida la información e intenta nuevamente"
      });
      $(".preloader").hide();
     }else{
       
          if(valAbonar == valTotal){
            formData.append("pagada", 'SI' );
          }else{
            formData.append("pagada", 'NO' );
          }
          formData.append("primerAbono", 'NO' );

          $.ajax({
            // la URL para la petición
            url : varurl,
            method : 'POST',
            cache: false,
            processData: false,
            contentType : false,
            data: formData ,
            headers: {
              'X-CSRF-Token': $('input[id="_token_maestro"]').val()
            },
        }).done(function(resul){
          console.log("resultado",resul);
           $('.preloader').fadeOut();
           $("#contenido_abono_modal_factura").html(resul);
        })
          .fail( function (jqXHR, status, error) {
          $('.preloader').fadeOut();
          swal("Error", "Ocurrio un error con la conexion contactese con el administrador del sistema", "success");
        });
     }
  }
}


function FA_cambiar_fecha_informes(){

   var messel=$('#select_mes_val').val();
   var aniosel=$('#select_anio_val').val();

    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/informes/listado_informes/'+aniosel+'/'+messel+'';

   window.location.href= miurl;

}

function FA_cambiar_fecha_recaudo(){

   var messel=$('#select_mes_val').val();
   var aniosel=$('#select_anio_val').val();

    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/informes/listado_recaudos/'+aniosel+'/'+messel+'';

   window.location.href= miurl;

}

function FA_cambiar_fecha_recaudo_concepto(){

   var messel=$('#select_mes_val').val();
   var aniosel=$('#select_anio_val').val();

    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/informes/listado_recaudos_concepto/'+aniosel+'/'+messel+'';

   window.location.href= miurl;

}


function FA_cambiar_fecha_bancos(){

   var messel=$('#select_mes_val').val();
   var aniosel=$('#select_anio_val').val();

    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/informes/listado_facturas_bancos/'+aniosel+'/'+messel+'';

   window.location.href= miurl;

}

function FA_cambiar_fecha_otrosrec(){

   var messel=$('#select_mes_val').val();
   var aniosel=$('#select_anio_val').val();
   var mesr="01";
   if(messel<9){ mesr="0"+messel; }

   var fecha= aniosel +"-" +mesr +"-01";

    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/recaudo/listado_otros_recaudos/'+fecha;

   window.location.href= miurl;

}











/*
ejemplod e una funcion con encabezados para laravel

$(document).on("submit","#form_asignar_solicitud",function(e){
  e.preventDefault();
  $('.preloader').fadeIn();
  var quien=$(this).attr("id");
  var formu=$(this);
  var varurl="";
  
  varurl=$(this).attr("action");   
  var formData = new FormData();
 formData.append("id_usuario", 1 );
formData.append("type", 2 );
  
  $.ajax({
    // la URL para la petición
    url : varurl,
    method : 'POST',
    cache: false,
    processData: false,
    contentType : false,
    data: formData ,
    headers: {
      'X-CSRF-Token': $('input[id="_token_maestro"]').val()
    },
  

  }).done(function(resul){
    
    $('.preloader').fadeOut();
    
    if(resul.estado=="asignada"){
      $('#modal_info_usuarios').modal('hide');
      swal("Actualizado", "Datos Actualizados", "success");
      window.location.href="listado_solicitudes_asignadas";
     
    }


  })
  .fail( function (jqXHR, status, error) {
    $('.preloader').fadeOut();
    swal("Error", "no actualizado", "warning");
  });


});*/