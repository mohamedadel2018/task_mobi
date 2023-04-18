let map;
var markers = [[26.98479562441095,27.21031976567458],
                [27.414737468273042,18.77281976567458],
                [28.6559370727279,14.94957757817458],
                [29.65373735461529,21.84899164067458],
                [29.424337804484363,26.46324945317458],
                [28.19216723480078,38.767936953174576],
                [25.20896887513145,30.15465570317458]
            ];

let Mymarkers = [];


function addMarker(latlngm, title ){
    return  new google.maps.Marker({
        position: latlng,
        map: map,
        title:title,
        draggable:true,
      });
    
}

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 30.044420, lng: 31.235712 },
    zoom: 5,
  });

  const infowindow = new google.maps.InfoWindow();


  for(let i=0; i< markers.length ; i++)
  {
    console.log(markers[i][0]);
    var marker = new google.maps.Marker({
        position: {lat: markers[i][0],lng: markers[i][1]},
        map: map,
        title:'Test Marker',
        label: i+'',
        draggable:true,
      });


      Mymarkers.push(marker);
      Mymarkers[i].addListener("click", () => {
        infowindow.close();
        infowindow.setContent(Mymarkers[i].getTitle());
        infowindow.open(Mymarkers[i].getMap(),Mymarkers[i]);

      });

      


    
      $('.latLng').append(`
      <p>lat`+i+`: <span id="lat`+i+`">  </span></p>
      <p>lng`+i+`: <span id="lng`+i+`">  </span></p>
      <a href="#" class="removemarker" marker="`+i+`"> Remove Marker</a>
      `);


      google.maps.event.addListener(marker,'drag', function(markerevent){
        // document.getElementById('lat').innerHTML = markerevent.latLng.lat();
        // document.getElementById('lng').innerHTML = markerevent.latLng.lng();
        $('#lat'+i).text(markerevent.latLng.lat());
        $('#lng'+i).text(markerevent.latLng.lng());
        console.log(markerevent);
    });

  }

  $(document).on('click','.removemarker',function(){
    var mark = $(this).attr('marker');
    Mymarkers[mark].setMap(null);
    $('#lat'+mark).parent('p').remove();
    return false;
  });

  var mainmarker = new google.maps.Marker(
    {
    position: {lat: 30.044420, lng: 31.235712},
    map: map,
    title:'Test Marker',
    draggable:true,
  });

  google.maps.event.addListener(mainmarker,'drag', function(markerevent){
    // document.getElementById('lat').innerHTML = markerevent.latLng.lat();
    // document.getElementById('lng').innerHTML = markerevent.latLng.lng();
    $('#lat').text(markerevent.latLng.lat());
    console.log(markerevent);
});

  map.addListener('click',function(event){
    // console.log('lat =' + event.latlng.lat());
    // console.log('lng =' +event.latlng.lng());

    var marker = new google.maps.Marker({
        position: {lat:event.latLng.lat() ,  lng:event.latLng.lng()},
        map: map,
        title:'Test Marker',
        draggable:true,
      });

      google.maps.event.addListener(marker,'dragend', function(markerevent){
                console.log("["+markerevent.latLng.lat()+","+markerevent.latLng.lng()+"],");
      });
  });



setTimeout(function(){
        if($('#map').find('.dismissButton').length == 1){
            $('#map').children('div:nth-of-type(2)').remove();
        }
}, 1000);
}



$(document).ready(function(){



  
   initMap();
   



});
