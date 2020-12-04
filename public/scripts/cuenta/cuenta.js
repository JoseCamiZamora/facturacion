

function SU_form_crear_cuenta(){

  console.log('LLego aquiii');
    $('#modal_cuentas').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/cuentas/form_nueva_cuenta";

    $.ajax({
    url: miurl
    }).done( function(resul){
      //console.log("Resultado", resul);
      $('.preloader').fadeOut();
      $("#contenido_modal_cuentas").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;
}

function editarCuentas (id_cuenta) {

    $('#modal_editar_cuentas').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/cuentas/editar_cuenta/"+id_cuenta+"";

    $.ajax({
    url: miurl
    }).done( function(resul){
    
      $('.preloader').fadeOut();
      $("#contenido_editar_modal_cuentas").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;
  // body...
}

function inactivarCuentas(id_cuenta){


  swal({
      title: "Advertencia!!",
      text:"Esta seguro que desea inactivar la cuenta",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      cancelButtonText:"Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: true
    },
  function(){
    
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/cuentas/inactivar_cuenta/"+id_cuenta+"";

    $.ajax({
    // la URL para la petición
      url : miurl,
    })
     .done(function(resul) {
       $('#modal_inactivar_cuentas').modal();
        $('.preloader').fadeOut();
        $("#contenido_modal_cuentas_i").html(resul);
     }).fail(function(err){
        $('.preloader').fadeOut();
        SU_revise_conexion();    
    });
  })
}

function congelarCuentas(id_cuenta){

  swal({
      title: "Advertencia!!",
      text:"Esta seguro que desea congelar la cuenta",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      cancelButtonText:"Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: true
    },
  function(){
    
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/cuentas/congelar_cuenta/"+id_cuenta+"";

    $.ajax({
    // la URL para la petición
      url : miurl,
    })
     .done(function(resul) {
       $('#modal_congelar_cuentas').modal();
        $('.preloader').fadeOut();
        $("#contenido_modal_cuentas_c").html(resul);
     }).fail(function(err){
        $('.preloader').fadeOut();
        SU_revise_conexion();    
    });
  })

}


function agregar_vehiculos(){

   
   var rowCount = $('#t_body_vehiculos tr').length;
   rowCount=rowCount+1;
   
   var no= "<input  id='nov_"+rowCount+"'  class='i-readonly' readonly  name='nov["+rowCount+"]' value='"+rowCount+"' style='width:100%; text-align: center;' />";
   var marca= "<input  type='text'  class='t-marca' id='marcav_"+rowCount+"' name='marcav["+rowCount+"]' value='' style='width:100%' />";
   var linea= "<input  type='text'  class='t-linea' id='lineav_"+rowCount+"' name='lineav["+rowCount+"]' value='' style='width:100%' />";
   var placa= "<input  type='text'  class='t-placa' id='placav_"+rowCount+"' name='placav["+rowCount+"]' value='' style='width:100%' />";

   var coderow="<tr id='row_insumo_v"+rowCount+"' >";
   coderow+="<td>"+no+"</td>";
   coderow+="<td>"+marca+"</td>";
   coderow+="<td>"+linea+"</td>";
   coderow+="<td>"+placa+"</td>";
   coderow+="<td><a href='javascript:void(0);'  style='display:block;' onclick='borrar_vehiculos("+rowCount+");'><i class='fas fa-times'></i></a></td>";

   coderow+="</tr>";

   $("#t_body_vehiculos").append(coderow);
}

function agregar_motos(){

  
   var rowCount = $('#t_body_motos tr').length;
   rowCount=rowCount+1;
  
   var no= "<input  id='nom_"+rowCount+"'  readonly class='i-readonly' name='nom["+rowCount+"]' value='"+rowCount+"' style='width:100%;text-align: center;' />";
   var marca= "<input  type='text'  class='t-marcam' id='marcam_"+rowCount+"' name='marcam["+rowCount+"]' value='' style='width:100%' />";
   var linea= "<input  type='text'  class='t-lineam' id='lineam_"+rowCount+"' name='lineam["+rowCount+"]' value='' style='width:100%' />";
   var placa= "<input  type='text'  class='t-placam' id='placam_"+rowCount+"' name='placam["+rowCount+"]' value='' style='width:100%' />";
  

   var coderow="<tr id='row_insumo_m"+rowCount+"' >";
   coderow+="<td>"+no+"</td>";
   coderow+="<td>"+marca+"</td>";
   coderow+="<td>"+linea+"</td>";
   coderow+="<td>"+placa+"</td>";
   coderow+="<td><a href='javascript:void(0);'  style='display:block;' onclick='borrar_motos("+rowCount+");'><i class='fas fa-times'></i></a></td>";

   coderow+="</tr>";

   $("#t_body_motos").append(coderow);
}

function borrar_vehiculos(idrow){
  $('#row_insumo_v'+idrow+'').remove();
}
function borrar_motos(idrow){
  $('#row_insumo_m'+idrow+'').remove();
}

function listadoVehiculos(id_cuenta){

    $('#modal_list_vehiculos').modal();
    $('.preloader').fadeIn();
    var estado = 'V';
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/cuentas/form_listado_vehiculos/"+id_cuenta+'/'+estado+"";

    $.ajax({
    url: miurl
    }).done( function(resul){
      //console.log("Resultado", resul);
      $('.preloader').fadeOut();
      $("#contenido_list_modal_vehiculos").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;

}

function listadoMotos(id_cuenta){

    $('#modal_list_motos').modal();
    $('.preloader').fadeIn();
    var estado = 'M';
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/cuentas/form_listado_vehiculos/"+id_cuenta+'/'+estado+"";

    $.ajax({
    url: miurl
    }).done( function(resul){
      //console.log("Resultado", resul);
      $('.preloader').fadeOut();
      $("#contenido_list_modal_motos").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;
  
}




function descongelarCuentas(id_cuenta){
  swal({
      title: "Advertencia!!",
      text:"Esta seguro que desea descongelar la cuenta",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      cancelButtonText:"Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: true
    },
  function(){
    
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/cuentas/descongelar_cuenta/"+id_cuenta+"";

    $.ajax({
    // la URL para la petición
      url : miurl,
    })
     .done(function(resul) {
       $('#modal_descongelar_cuentas').modal();
        $('.preloader').fadeOut();
        $("#contenido_modal_cuentas_d").html(resul);
     }).fail(function(err){
        $('.preloader').fadeOut();
        SU_revise_conexion();    
    });
  })
}


function activarCuentas(id_cuenta){
  swal({
      title: "Advertencia!!",
      text:"Esta seguro que desea activar la cuenta",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      cancelButtonText:"Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: true
    },
  function(){
    
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/cuentas/activar_cuenta/"+id_cuenta+"";

    $.ajax({
    // la URL para la petición
      url : miurl,
    })
     .done(function(resul) {
       $('#modal_descongelar_cuentas').modal();
        $('.preloader').fadeOut();
        $("#contenido_modal_cuentas_d").html(resul);
     }).fail(function(err){
        $('.preloader').fadeOut();
        SU_revise_conexion();    
    });
  })
}

$(document).on("submit","#f_crear_cuenta",function(e){
   //funcion para crear un nuevo usuario
   console.log("entro a crear la cuenta");
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/cuentas/crear_cuenta";

  
  $.ajax({
    // la URL para la petición
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html'
  })
  .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_modal_cuentas").html(resul);
   })
  .fail(function(err){
      $('.preloader').fadeOut();
      SU_revise_conexion();    
  });
});



$(document).on("submit","#f_editar_cuenta",function(e){
  //funcion para actualizar los datos del usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/cuentas/editar_cuenta_acu";

  
  $.ajax({
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html',
    })
    .done(function(resul) {
      console.log("Resul xxxxxxxxxxx", resul);
     $('.preloader').fadeOut();
      $("#contenido_editar_modal_cuentas").html(resul);

    })
    .fail(function(err){
        SU_revise_conexion();
        $(".preloader").hide();
         
    });
  

});
