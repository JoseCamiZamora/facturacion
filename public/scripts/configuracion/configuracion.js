function config_form_crear_valor(){
    
    $('#modal_valores').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/configuracion/form_nuevo_valor";

    $.ajax({
    url: miurl
    }).done( function(resul) 
    {
      $('.preloader').fadeOut();
      $("#contenido_modal_valores").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;


}

function config_form_crear_comunicado(){
    
    $('#modal_comunicados').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/configuracion/form_nuevo_comunicado";

    $.ajax({
    url: miurl
    }).done( function(resul) 
    {
      $('.preloader').fadeOut();
      $("#contenido_modal_comunicados").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;


}

function config_form_nuevo_cargo(){
   console.log("cargo");
    $('#modal_cargos').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/configuracion/form_nuevo_cargo";

    $.ajax({
    url: miurl
    }).done( function(resul) 
    {
      $('.preloader').fadeOut();
      $("#contenido_modal_cargos").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;


}

function config_form_nuevo_cargo_mora(){
   console.log("cargo");
    $('#modal_cargos').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/configuracion/form_nuevo_cargo_mora";

    $.ajax({
    url: miurl
    }).done( function(resul) 
    {
      $('.preloader').fadeOut();
      $("#contenido_modal_cargos").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;


}

function config_form_editar_valor(idvalor){
    $('#modal_valores').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/configuracion/form_editar_valor/"+idvalor+"";

    $.ajax({
    url: miurl
    }).done( function(resul) 
    {
      $('.preloader').fadeOut();
      $("#contenido_modal_valores").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;

}

function config_form_borrar_comunicado(idvalor){
   
    $('.preloader').fadeIn();

    swal({
      title: "Advertencia!!",
      text:"Esta seguro que desea borrar el comunicado",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      cancelButtonText:"Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: true
    },
  function(){
    $('#modal_comunicados_borrar').modal();

    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/configuracion/form_borrar_valor/"+idvalor+"";

    $.ajax({
    // la URL para la petición
      url : miurl,
    })
     .done(function(resul) {
        $('.preloader').fadeOut();
        $("#contenido_modal_comunicados_borrar").html(resul);
     }).fail(function(err){
        $('.preloader').fadeOut();
        SU_revise_conexion();    
    });
  })
}



function config_form_editar_comunicado(idvalor){
    $('#modal_comunicados_editar').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/configuracion/form_editar_comunicado/"+idvalor+"";

    $.ajax({
    url: miurl
    }).done( function(resul) 
    {
      $('.preloader').fadeOut();
      $("#contenido_modal_comunicados_editar").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;

}


$(document).on("submit","#f_editar_valor",function(e){
   //funcion para crear un nuevo usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/configuracion/editar_valor";

  
  $.ajax({
    // la URL para la petición
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html'
  })
  .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_modal_valores").html(resul);

   })
  .fail(function(err){
      $('.preloader').fadeOut();
      SU_revise_conexion();
         
  });


});

$(document).on("submit","#f_editar_comunicado",function(e){
   //funcion para crear un nuevo usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/configuracion/editar_comunicado";

  
  $.ajax({
    // la URL para la petición
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html'
  })
  .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_modal_comunicados_editar").html(resul);

   })
  .fail(function(err){
      $('.preloader').fadeOut();
      SU_revise_conexion();
         
  });


});



$(document).on("submit","#f_nuevo_valor",function(e){
   //funcion para crear un nuevo usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/configuracion/nuevo_valor";

  
  $.ajax({
    // la URL para la petición
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html'
  })
  .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_modal_valores").html(resul);

   })
  .fail(function(err){
      $('.preloader').fadeOut();
      SU_revise_conexion();
         
  });


});

$(document).on("submit","#f_nuevo_comunicado",function(e){
   //funcion para crear un nuevo usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/configuracion/nuevo_comunicado";

  
  $.ajax({
    // la URL para la petición
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html'
  })
  .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_modal_comunicados").html(resul);

   })
  .fail(function(err){
      $('.preloader').fadeOut();
      SU_revise_conexion();
         
  });


});




$(document).on("submit","#f_nuevo_cargo",function(e){
   //funcion para crear un nuevo usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/configuracion/nuevo_cargo";

  
  $.ajax({
    // la URL para la petición
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html'
  })
  .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_modal_cargos").html(resul);

   })
  .fail(function(err){
      $('.preloader').fadeOut();
      SU_revise_conexion();
         
  });


});

$(document).on("submit","#f_nuevo_cargo_mora",function(e){
   //funcion para crear un nuevo usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/configuracion/nuevo_cargo_mora";

  
  $.ajax({
    // la URL para la petición
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html'
  })
  .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_modal_cargos").html(resul);

   })
  .fail(function(err){
      $('.preloader').fadeOut();
      SU_revise_conexion();
         
  });


});

function config_form_editar_cargo(idvalor){
    $('#modal_cargos').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/configuracion/form_editar_cargo/"+idvalor+"";

    $.ajax({
    url: miurl
    }).done( function(resul) 
    {
      $('.preloader').fadeOut();
      $("#contenido_modal_cargos").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;

}

function config_form_editar_cargo_mora(idvalor){
    $('#modal_cargos').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+"/configuracion/form_editar_cargo_mora/"+idvalor+"";

    $.ajax({
    url: miurl
    }).done( function(resul) 
    {
      $('.preloader').fadeOut();
      $("#contenido_modal_cargos").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;

}


$(document).on("submit","#f_editar_cargo",function(e){
   //funcion para crear un nuevo usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/configuracion/editar_cargo";

  
  $.ajax({
    // la URL para la petición
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html'
  })
  .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_modal_cargos").html(resul);

   })
  .fail(function(err){
      $('.preloader').fadeOut();
      SU_revise_conexion();
         
  });


});



$(document).on("submit","#f_editar_cargo_mora",function(e){
   //funcion para crear un nuevo usuario
  e.preventDefault();
  $('.preloader').fadeIn();

  var formu=$(this);
  var urlraiz=$("#url_raiz_proyecto").val();
  var varurl=urlraiz+"/configuracion/editar_cargo_mora";

  
  $.ajax({
    // la URL para la petición
    url : varurl,
    data : formu.serialize(),
    method: 'POST',
    dataType : 'html'
  })
  .done(function(resul) {
      $('.preloader').fadeOut();
      $("#contenido_modal_cargos").html(resul);

   })
  .fail(function(err){
      $('.preloader').fadeOut();
      SU_revise_conexion();
         
  });


});