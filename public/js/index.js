/*
  Creación de una función personalizada para jQuery que detecta cuando se detiene el scroll en la página
*/
$.fn.scrollEnd = function(callback,timeout) {
  $(this).scroll(function() {
    var $this = $(this);
    if($this.data('scrollTimeout')) {
      clearTimeout($this.data('scrollTimeout'));
    }
    $this.data('scrollTimeout',setTimeout(callback,timeout));
  });
};
/*
  Función que inicializa el elemento Slider
*/

function inicializarSlider() {
  $("#rangoPrecio").ionRangeSlider({
    type: "double",
    grid: false,
    min: 0,
    max: 100000,
    from: 200,
    to: 80000,
    prefix: "$"
  });
}
/*
  Función que reproduce el video de fondo al hacer scroll, y deteiene la reproducción al detener el scroll
*/
function playVideoOnScroll() {
  var ultimoScroll = 0,
    intervalRewind;
  var video = document.getElementById('vidFondo');
  $(window)
    .scroll((event) => {
      var scrollActual = $(window).scrollTop();
      if(scrollActual > ultimoScroll) {

      } else {
        //this.rewind(1.0, video, intervalRewind);
        video.play();
      }
      ultimoScroll = scrollActual;
    })
    .scrollEnd(() => {
      video.pause();
    },10)
}

function getData() {
  var tipo = $('#selectTipo').val();
  var ciudad = $('#selectCiudad').val();
  var queryPamas = [];
  if(tipo) {
    queryPamas.push({
      'key': 'tipo',
      'value': tipo
    })
  }
  if(ciudad) {
    queryPamas.push({
      'key': 'ciudad',
      'value': ciudad
    })
  }
  let url = 'http://localhost:8080/data'
  queryPamas.forEach((e,idx) => {
    if(idx === 0) {
      url = url + `?${e.key}=${e.value}`
    } else {
      url = url + `&${e.key}=${e.value}`
    }

  });

  $.ajax({
    type: 'GET',
    url: url,
    dataType: "json",
    // data:{user_id:user_id},
    success: function(data) {
      // console.log('data',data);
      $(".card-for-sale").remove();
      responseHandler(data)
    }
  });
}
function responseHandler(response, id_str='data') {
  $.each(response,function(i,item) {
    var htmString = ` <div class="card-for-sale">
        <div class="divider">${item.Id}</div>
        <p><strong>Dirección: </strong>${item.Direccion}</p>
        <p><strong>Ciudad: </strong>${item.Ciudad}</p>
        <p><strong>Telefono: </strong>${item.Telefono}</p>
        <p><strong>Codigo Postal: </strong>${item.Codigo_Postal}</p>
        <p><strong>Tipo: </strong>${item.Tipo}</p>
        <p><strong>Precio: </strong>${item.Precio}</p>
        ${item.guardada?
          'Ya esta guardado':`<input type="button" class="btn btn-guardar" value="Guardar" id='${item.Id}' data-id='${item.Id}'></input>`}
        
      </div>
        `
    $(`#${id_str}`).append(htmString);
  });
}
function store(data){
    let url = 'http://localhost:8080/bienes/store'
    $.ajax({
      type: 'POST',
      url: url,
      dataType: "json",
      data:data,
      success: function(data) {
        console.log('guardo', data);
        getData()
      }
    });
  
}
function getBienesGuardados(){
  let url = 'http://localhost:8080/bienes'

  $.ajax({
    type: 'GET',
    url: url,
    dataType: "json",
    success: function(data) {
      $(".card-save").remove();
      formatDatosGuardados(data)
    }
  });
}
function formatDatosGuardados(response, id_str='data-save') {
  $.each(response,function(i,item) {
    var htmString = ` <div class="card-save">
        <div class="divider"></div>
        <p><strong>Dirección: </strong>${item.direccion}</p>
        <p><strong>Ciudad: </strong>${item.ciudad}</p>
        <p><strong>Telefono: </strong>${item.telefono}</p>
        <p><strong>Codigo Postal: </strong>${item.codigo_postal}</p>
        <p><strong>Tipo: </strong>${item.tipo}</p>
        <p><strong>Precio: </strong>${item.precio}</p>
        <input type="button" class="btn red btn-eliminar" value="Eliminar" id='${item.id}' data-id='${item.id}'>
      </div>
        `
    $(`#${id_str}`).append(htmString);
  });
}
function eliminar(id){
  let url = `http://localhost:8080/bienes/delete/${id}`

  $.ajax({
    type: 'DELETE',
    url: url,
    dataType: "json",
    success: function(data) {
      console.log('elimino', data);
      getBienesGuardados()
    }
  });
}
getData();
// inicializarSlider();
// playVideoOnScroll();
