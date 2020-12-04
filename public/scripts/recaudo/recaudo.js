function RE_cambiar_fecha_facturas(){

console.log("LLego aqui");
   var messel=$('#select_mes_val').val();
   var aniosel=$('#select_anio_val').val();

    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/recaudo/listado_facturas/'+aniosel+'/'+messel+'';

   window.location.href= miurl;

}



function pagarFactura(id_factura,valor,propietario){

	console.log("LLego aqui",id_factura);
    $('#modal_pago_factura').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/recaudo/info_pago_factura/'+id_factura+'/'+valor+'';

    $.ajax({
    url: miurl
    }).done( function(resul){
    
      $('.preloader').fadeOut();
      $("#contenido_pago_modal_factura").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;
}

function congelarFactura(id_factura){


 var elemento = $(this);
  swal({
  title: "Advertencia!!",
  text: "Esta seguro que desea congelar la factura # "+id_factura,
  type: "input",
  showCancelButton: true,
  closeOnConfirm: true,
  inputPlaceholder: "Observaciones"
}, function (inputValue) {
  if (inputValue === false) return false;
  if (inputValue === "") {
    swal.showInputError("Debes ingresar la razón por la cual se congela la factura");
    return false
  }
   $('.preloader').fadeIn();
   $('#modal_factura_congelada').modal();

  
    var urlraiz=$("#url_raiz_proyecto").val();
    var varurl=urlraiz+"/facturas/congelar_factura";
    var formData = new FormData();
    formData.append("id_factura", id_factura);
    formData.append("observaciones", inputValue );
    formData.append("congelada", 1 );
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
       $("#contenido_modal_factura_congelada").html(resul);
    })
      .fail( function (jqXHR, status, error) {
      $('.preloader').fadeOut();
      swal("Error", "Ocurrio un error con la conexion contactese con el administrador del sistema", "warning");
    });
});
 
}

function descongelarFactura(id_factura){
 console.log("descongelar factura");
  swal({
      title: "Advertencia!!",
      text:"Esta seguro que desea descongelar la factura # " + id_factura,
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      cancelButtonText:"Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: true
    },
  function(){
    $('.preloader').fadeIn();
    $('#modal_factura_descongelada').modal();
    var formData = new FormData();
    formData.append("id_factura", id_factura);

    var urlraiz=$("#url_raiz_proyecto").val();
    var varurl=urlraiz+"/facturas/descongelar_factura";

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
       $("#contenido_modal_factura_descongelada").html(resul);
        console.log("descongelar factura");
    })
      .fail( function (jqXHR, status, error) {
      $('.preloader').fadeOut();
      swal("Error", "Ocurrio un error con la conexion contactese con el administrador del sistema", "warning");
    });
  })
}



function registrarAbono(id_factura,valor,propietario){

  
    $('#modal_abono_factura').modal();
    $('.preloader').fadeIn();
    var urlraiz=$("#url_raiz_proyecto").val();
    var miurl='';
    miurl=urlraiz+'/recaudo/info_abono_factura/'+id_factura+'/'+valor+'';

    $.ajax({
    url: miurl
    }).done( function(resul){
    
      $('.preloader').fadeOut();
      $("#contenido_abono_modal_factura").html(resul);
   
    }).fail( function() 
   {
    $('.preloader').fadeOut();
     SU_revise_conexion();
   }) ;
}

function facturaPagada(){
	swal("Esta factura ya se encuentra pagada..")
}


function facturaCongelada(){
  swal("Esta factura se encuentra congelada para realizar esta acción debes descongelar la factura.. Valida la información e intena nuevamente")
}


