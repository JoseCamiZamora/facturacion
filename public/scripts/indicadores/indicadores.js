
function IND_renderizar_indicador1(facPagadas,facNoPagadas,abonos){

    console.log("llego el escrip",facPagadas,facNoPagadas);
    var data = [{
            data: [facNoPagadas,abonos,facPagadas],
            labels: ["Facturas No Pagadas","Abonos","Facturas Pagadas"],
            backgroundColor: [
              window.chartColors.red,
              window.chartColors.green,
              window.chartColors.blue
            ],
            borderColor: "#fff"
        }];
        
           var options = {
            tooltips: {
             enabled: true
        },
             plugins: {
            
             datalabels: {
                formatter: (value, ctx) => {
                
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                      sum += data;
                  });
                  let percentage = (value*100 / sum).toFixed(2)+"%";
                  return percentage;

              
                },
                color: '#fff',
                     }
        }
    };
   
    var ctx = document.getElementById("chart-area").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: data,
            labels: ["Facturas No Pagadas","Abonos","Facturas Pagadas"]
        },
              options: options
    });
    
}



function IND_renderizar_cargo_multa(multasP,multasnoP){

 var data = [{
            data: [multasnoP,multasP],
            labels: ["No Pagadas","Pagadas"],
            backgroundColor: [
               window.chartColors.red,
				window.chartColors.green
            ],
            borderColor: "#fff"
        }];
        
           var options = {
            tooltips: {
		         enabled: true
		    },
             plugins: {
            
             datalabels: {
                formatter: (value, ctx) => {
                
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                      sum += data;
                  });
                  let percentage = (value*100 / sum).toFixed(2)+"%";
                  return percentage;

              
                },
                color: '#fff',
                     }
        }
    };
    
    
    var ctx = document.getElementById("chart-area-multas").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: data,
            labels: ["No Pagadas","Pagadas"]
        },
              options: options
    });
}

function IND_renderizar_cargo_tendencia(tendenciaP,tendencianoP){

 var data = [{
            data: [tendencianoP,tendenciaP],
            labels: ["No Pagadas","Pagadas"],
            backgroundColor: [
               window.chartColors.red,
        window.chartColors.green
            ],
            borderColor: "#fff"
        }];
        
           var options = {
            tooltips: {
             enabled: true
        },
             plugins: {
            
             datalabels: {
                formatter: (value, ctx) => {
                
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                      sum += data;
                  });
                  let percentage = (value*100 / sum).toFixed(2)+"%";
                  return percentage;

              
                },
                color: '#fff',
                     }
        }
    };
    
    
    var ctx = document.getElementById("chart-area-tendencia").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: data,
            labels: ["No Pagadas","Pagadas"]
        },
              options: options
    });
}

function IND_renderizar_cargo_llavesaccesorios(llavesP,llavesnoP){

 var data = [{
            data: [llavesnoP,llavesP],
            labels: ["No Pagadas","Pagadas"],
            backgroundColor: [
               window.chartColors.red,
        window.chartColors.green
            ],
            borderColor: "#fff"
        }];
        
           var options = {
            tooltips: {
             enabled: true
        },
             plugins: {
            
             datalabels: {
                formatter: (value, ctx) => {
                
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                      sum += data;
                  });
                  let percentage = (value*100 / sum).toFixed(2)+"%";
                  return percentage;

              
                },
                color: '#fff',
                     }
        }
    };
    
    
    var ctx = document.getElementById("chart-area-llaves").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: data,
            labels: ["No Pagadas","Pagadas"]
        },
              options: options
    });
}

function IND_renderizar_cargo_tanque(tanqueP,tanquenoP){

 var data = [{
            data: [tanquenoP,tanqueP],
            labels: ["No Pagadas","Pagadas"],
            backgroundColor: [
               window.chartColors.red,
        window.chartColors.green
            ],
            borderColor: "#fff"
        }];
        
           var options = {
            tooltips: {
             enabled: true
        },
             plugins: {
            
             datalabels: {
                formatter: (value, ctx) => {
                
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                      sum += data;
                  });
                  let percentage = (value*100 / sum).toFixed(2)+"%";
                  return percentage;

              
                },
                color: '#fff',
                     }
        }
    };
    
    
    var ctx = document.getElementById("chart-area-tanque").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: data,
            labels: ["No Pagadas","Pagadas"]
        },
              options: options
    });
}

function IND_renderizar_cargo_recargos(recargosP,recargosnoP){

 var data = [{
            data: [recargosnoP,recargosP],
            labels: ["No Pagadas","Pagadas"],
            backgroundColor: [
               window.chartColors.red,
        window.chartColors.green
            ],
            borderColor: "#fff"
        }];
        
           var options = {
            tooltips: {
             enabled: true
        },
             plugins: {
            
             datalabels: {
                formatter: (value, ctx) => {
                
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                      sum += data;
                  });
                  let percentage = (value*100 / sum).toFixed(2)+"%";
                  return percentage;

              
                },
                color: '#fff',
                     }
        }
    };
    
    
    var ctx = document.getElementById("chart-area-recargos").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: data,
            labels: ["No Pagadas","Pagadas"]
        },
              options: options
    });
}

function IND_renderizar_cargo_otros(otrosP,otrosnoP){

 var data = [{
            data: [otrosnoP,otrosP],
            labels: ["No Pagadas","Pagadas"],
            backgroundColor: [
               window.chartColors.red,
        window.chartColors.green
            ],
            borderColor: "#fff"
        }];
        
           var options = {
            tooltips: {
             enabled: true
        },
             plugins: {
            
             datalabels: {
                formatter: (value, ctx) => {
                
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                      sum += data;
                  });
                  let percentage = (value*100 / sum).toFixed(2)+"%";
                  return percentage;

              
                },
                color: '#fff',
                     }
        }
    };
    
    
    var ctx = document.getElementById("chart-area-otros").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: data,
            labels: ["No Pagadas","Pagadas"]
        },
              options: options
    });
}

function IN_cambiar_fecha_indicadores(){

  var messel=$('#select_mes_val').val();
  var aniosel=$('#select_anio_val').val();
  console.log("Cambio",messel,aniosel);

  var urlraiz=$("#url_raiz_proyecto").val();
  var miurl='';
  miurl=urlraiz+'/indicadores/listado_indicadores/'+aniosel+'/'+messel+'';

  window.location.href= miurl;

}


