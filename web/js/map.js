var infowindow = new google.maps.InfoWindow();
var infoZoneWindow = new google.maps.InfoWindow();
var geocoder = new google.maps.Geocoder;
var globalName;
var globalId;
var globalMap;
var path = [];
var pathRuta = [];
var inter;
var polygon;
var indexClick = 0;
var map;
function intervals() {
    inter = setInterval(function () {
        onloadAll();
    }, 60000);
}

function intervalsMini() {
    inter = setInterval(function () {
        onloadAllMini();
    }, 60000);
}

$(document).ready(function () {
    $('#btnUpdateMap').on('click', function () {
        onloadAll();
    });

});

onloadAll = function () {
    closeInfoWindow();
    $('#divMap').empty();
    var data = {'method': 0};
    $.getJSON(contextoGlobal + '/com/aestre/system/controller/localizarController.php', data, function (response) {
        var markersArray = [];
        var arr = [];
        var img = [];
        var lat = [];
        var long = [];
        var path = [];
        var pathRuta = [];
        if (response.length >= 1) {
            var mapOptions = {
                zoom: 5
                , mapTypeId: window.google.maps.MapTypeId.MAP
                , center: new google.maps.LatLng(23.945963820559726, -102.53775014999997)
            };
            var map = new google.maps.Map(document.getElementById("divMap"), mapOptions);
            infowindow = new google.maps.InfoWindow();
            $.each(response, function (index, item) {
                $.each(item.conductor, function (index, items) {
                    var conductor;
                    if ((items.nombre != undefined) && (items.paterno != undefined) && (items.materno != undefined)) {
                        conductor = items.nombre + ' ' + items.paterno + ' ' + items.materno;
                    } else {
                        conductor = 'No especificado'
                    }
                    var data = '<strong>Conductor:</strong> ' + conductor
                            + '<br/><strong>Veh&iacute;culo:</strong> ' + items.vehiculo[0].modelo
                            + '<br/><strong>Marca:</strong> ' + items.vehiculo[0].marca
                            + '<br/><strong>Placa:</strong> ' + items.vehiculo[0].placa
                            + '<br/><strong>Uso:</strong> ' + items.vehiculo[0].uso.uso;
                    var dateTime = items.vehiculo[0].localizar[0].dt.split(' ');
                    var date = dateTime[0].replace(/-/g, '/').split('/');
                    data += '<br/><strong>Fecha:</strong> ' + date[2] + '/' + date[1] + '/' + date[0]
                            + '<br/><strong>Hora :</strong> '
                            + dateTime[1]
                            + '<br/><strong>Posici&oacute;n Actual:</strong> ' + items.vehiculo[0].localizar[0].addres
                            + '<br/><strong>Gps:</strong><a href ="http://maps.google.es/?q='
                            + items.vehiculo[0].localizar[0].lat
                            + ',' + items.vehiculo[0].localizar[0].lon
                            + '" target="_blank"> ' + items.vehiculo[0].localizar[0].lat
                            + ' / ' + items.vehiculo[0].localizar[0].lon + '</a>';
                    ;
                    lat.push(parseFloat(items.vehiculo[0].localizar[0].lat));
                    long.push(parseFloat(items.vehiculo[0].localizar[0].lon));
                    arr.push(data);
                    img.push(items.vehiculo[0].icons.path);
                    if (items.vehiculo[0].zona[0] != undefined) {
                        $(JSON.parse(items.vehiculo[0].zona[0].coordenadas)).each(function (index, itemss) {
                            $(itemss.latLng).each(function (index1, val) {
                                path.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                            });
                        });
                        geofence(path, map, items.vehiculo[0].zona[0].zona, items.vehiculo[0].zona[0].id);
                    }
                    path.length = 0;
                    if (items.vehiculo[0].ruta[0] != undefined) {
                        $(JSON.parse(items.vehiculo[0].ruta[0].coordenadas)).each(function (index, itemss) {
                            $(itemss.latLng).each(function (index1, val) {
                                pathRuta.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                            });
                        });
                        georute(pathRuta, map, items.vehiculo[0].ruta[0]);
                    }
                    pathRuta.length = 0;
                });
            });
            for (var i = 0; i < arr.length; i++) {
                var contenido = arr[i];
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lat[i], long[i])
                    , icon: img[i]
                });
                (function (marker, contenido) {
                    google.maps.event.addListener(marker, "mouseover", function () {
                        infowindow.setContent(contenido);
                        infowindow.open(map, this);
                    });
                    google.maps.event.addListener(marker, "click", function () {
                        infowindow.setContent(contenido);
                        infowindow.open(map, this);
                    });
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                })(marker, contenido);
                markersArray.push(marker);
            }
            var mc = new MarkerClusterer(map, markersArray);
        }
    });
    intervals();
};

onloadAllMini = function () {
    closeInfoWindow();
    $('#divMiniMap').empty();
    var data = {'method': 0};
    $.getJSON(contextoGlobal + '/com/aestre/system/controller/localizarController.php', data, function (response) {
        var markersArray = [];
        var arr = [];
        var img = [];
        var lat = [];
        var long = [];
        var path = [];
        var pathRuta = [];
        if (response.length >= 1) {
            var mapOptions = {
                zoom: 5
                , mapTypeId: window.google.maps.MapTypeId.MAP
                , center: new google.maps.LatLng(23.945963820559726, -102.53775014999997)
            };
            var map = new google.maps.Map(document.getElementById("divMiniMap"), mapOptions);
            infowindow = new google.maps.InfoWindow();
            $.each(response, function (index, item) {
                $.each(item.conductor, function (index, items) {
                    var conductor;
                    if ((items.nombre != undefined) && (items.paterno != undefined) && (items.materno != undefined)) {
                        conductor = items.nombre + ' ' + items.paterno + ' ' + items.materno;
                    } else {
                        conductor = 'No especificado'
                    }
                    var data = '<strong>Conductor:</strong> ' + conductor
                            + '<br/><strong>Veh&iacute;culo:</strong> ' + items.vehiculo[0].modelo
                            + '<br/><strong>Marca:</strong> ' + items.vehiculo[0].marca
                            + '<br/><strong>Placa:</strong> ' + items.vehiculo[0].placa
                            + '<br/><strong>Uso:</strong> ' + items.vehiculo[0].uso.uso;
                    var dateTime = items.vehiculo[0].localizar[0].dt.split(' ');
                    var date = dateTime[0].replace(/-/g, '/').split('/');
                    data += '<br/><strong>Fecha:</strong> ' + date[2] + '/' + date[1] + '/' + date[0]
                            + '<br/><strong>Hora :</strong> '
                            + dateTime[1]
                            + '<br/><strong>Posici&oacute;n Actual:</strong> ' + items.vehiculo[0].localizar[0].addres
                            + '<br/><strong>Gps:</strong><a href ="http://maps.google.es/?q='
                            + items.vehiculo[0].localizar[0].lat
                            + ',' + items.vehiculo[0].localizar[0].lon
                            + '" target="_blank"> ' + items.vehiculo[0].localizar[0].lat
                            + ' / ' + items.vehiculo[0].localizar[0].lon + '</a>';
                    ;
                    lat.push(parseFloat(items.vehiculo[0].localizar[0].lat));
                    long.push(parseFloat(items.vehiculo[0].localizar[0].lon));
                    arr.push(data);
                    img.push(items.vehiculo[0].icons.path);
                    if (items.vehiculo[0].zona[0] != undefined) {
                        $(JSON.parse(items.vehiculo[0].zona[0].coordenadas)).each(function (index, itemss) {
                            $(itemss.latLng).each(function (index1, val) {
                                path.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                            });
                        });
                        geofence(path, map, items.vehiculo[0].zona[0].zona, items.vehiculo[0].zona[0].id);
                    }
                    path.length = 0;
                    if (items.vehiculo[0].ruta[0] != undefined) {
                        $(JSON.parse(items.vehiculo[0].ruta[0].coordenadas)).each(function (index, itemss) {
                            $(itemss.latLng).each(function (index1, val) {
                                pathRuta.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                            });
                        });
                        georute(pathRuta, map, items.vehiculo[0].ruta[0]);
                    }
                    pathRuta.length = 0;
                });
            });
            for (var i = 0; i < arr.length; i++) {
                var contenido = arr[i];
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lat[i], long[i])
                    , icon: img[i]
                });
                (function (marker, contenido) {
                    google.maps.event.addListener(marker, "mouseover", function () {
                        infowindow.setContent(contenido);
                        infowindow.open(map, this);
                    });
                    google.maps.event.addListener(marker, "click", function () {
                        infowindow.setContent(contenido);
                        infowindow.open(map, this);
                    });
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                })(marker, contenido);
                markersArray.push(marker);
            }
            var mc = new MarkerClusterer(map, markersArray);
        }
    });
    intervalsMini();
    resizeMapGral();
};

function geoMap(){
    var mapOptions = {
        zoom: 6
        , mapTypeId: window.google.maps.MapTypeId.MAP
        , center: new google.maps.LatLng(23.945963820559726, -102.53775014999997)
    };
    map = new google.maps.Map(document.getElementById("divMapGeozona"), mapOptions);
    google.maps.event.addListener(map, 'click', function (event) {
        if ($('#txtPos1').val() == '') {
            $('#txtPos1').val(event.latLng);
            $('#txtPos5').val(event.latLng);
        } else if ($('#txtPos2').val() == '') {
            $('#txtPos2').val(event.latLng);
        } else if ($('#txtPos3').val() == '') {
            $('#txtPos3').val(event.latLng);
        } else if ($('#txtPos4').val() == '') {
            $('#txtPos4').val(event.latLng);
            crearZona();
        }
        if (indexClick < 4) {
            var marker = new google.maps.Marker({
                position: event.latLng,
                map: map
            });
        }else{
            crearZona();
        }
        indexClick = indexClick + 1;
    });
    resizeMapGral();
}

function localizar(imei) {
    closeInfoWindow();
    $('#divMap').empty();
    var data = {'method': 1, 'txtImei': imei};
    $.getJSON(contextoGlobal + '/com/aestre/system/controller/localizarController.php', data, function (response) {
        var arr = [];
        var img = [];
        var lat = [];
        var long = [];
        if (response != null) {
            var mapOptions = {
                zoom: 10
                , mapTypeId: window.google.maps.MapTypeId.MAP
                , center: new google.maps.LatLng(23.945963820559726, -102.53775014999997)
            };
            map = new google.maps.Map(document.getElementById("divMap"), mapOptions);
            infowindow = new google.maps.InfoWindow();
            $.each(response, function (index, item) {
                var conductor;
                if ((item.conductor[0].nombre != undefined) && (item.conductor[0].paterno != undefined) && (item.conductor[0].materno != undefined)) {
                    conductor = item.conductor[0].nombre + ' ' + item.conductor[0].paterno + ' ' + item.conductor[0].materno;
                } else {
                    conductor = 'No especificado'
                }
                var data = '<strong>Conductor:</strong> ' + conductor
                        + '<br/><strong>Veh&iacute;culo:</strong> ' + item.conductor[0].vehiculo[0].modelo
                        + '<br/><strong>Marca:</strong> ' + item.conductor[0].vehiculo[0].marca
                        + '<br/><strong>Placa:</strong> ' + item.conductor[0].vehiculo[0].placa
                        + '<br/><strong>Uso:</strong> ' + item.conductor[0].vehiculo[0].uso.uso;
                var dateTime = item.conductor[0].vehiculo[0].localizar[0].dt.split(' ');
                var date = dateTime[0].replace(/-/g, '/').split('/');
                data += '<br/><strong>Fecha:</strong> ' + date[2] + '/' + date[1] + '/' + date[0]
                        + '<br/><strong>Hora :</strong> '
                        + dateTime[1]
                        + '<br/><strong>Posici&oacute;n Actual:</strong> ' + item.conductor[0].vehiculo[0].localizar[0].addres
                        + '<br/><strong>Gps:</strong><a href ="http://maps.google.es/?q='
                        + item.conductor[0].vehiculo[0].localizar[0].lat
                        + ',' + item.conductor[0].vehiculo[0].localizar[0].lon
                        + '" target="_blank"> ' + item.conductor[0].vehiculo[0].localizar[0].lat
                        + ' / ' + item.conductor[0].vehiculo[0].localizar[0].lon + '</a>';
                lat.push(parseFloat(item.conductor[0].vehiculo[0].localizar[0].lat));
                long.push(parseFloat(item.conductor[0].vehiculo[0].localizar[0].lon));
                arr.push(data);
                img.push(item.conductor[0].vehiculo[0].icons.path);
                if (item.conductor[0].vehiculo[0].zona[0] != undefined) {
                    $(JSON.parse(item.conductor[0].vehiculo[0].zona[0].coordenadas)).each(function (index, items) {
                        $(items.latLng).each(function (index1, val) {
                            path.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                        });
                    });
                    geofence(path, map, item.conductor[0].vehiculo[0].zona[0].zona, item.conductor[0].vehiculo[0].zona[0].id);
                }
                path.length = 0;
                if (item.conductor[0].vehiculo[0].ruta[0] != undefined) {
                    $(JSON.parse(item.conductor[0].vehiculo[0].ruta[0].coordenadas)).each(function (index, itemss) {
                        $(itemss.latLng).each(function (index1, val) {
                            pathRuta.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                        });
                    });
                    georute(pathRuta, map, item.conductor[0].vehiculo[0].ruta[0]);
                }
                pathRuta.length = 0;
            });
            if (lat.length > 0) {
                var lt = parseFloat(lat[0]);
                var lng = parseFloat(long[0]);
                var latlng = new google.maps.LatLng(lt, lng);
                geocoder.geocode({'location': latlng}, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            var marker = new google.maps.Marker({
                                position: latlng
                                , icon: img[0]
                                , map: map
                                , animation: google.maps.Animation.BOUNCE
                            });
                            infowindow.setContent(arr[0]);
                            infowindow.open(map, marker);
                            google.maps.event.addListener(marker, "mouseover", function () {
                                infowindow.setContent(arr[0]);
                                infowindow.open(map, this);
                            });
                            google.maps.event.addListener(marker, 'click', function () {
                                infowindow.setContent(arr[0]);
                                infowindow.open(map, this);
                            });
                        }
                    }
                });
                map.setCenter(latlng);
                resizeMapGral();
            }
        } else {
            infowindow.close();
            map = null;
        }
    });
    //clearRdb();
}

function resizeMapGral() {
    if (typeof map == "undefined")
        return;
    setTimeout(function () {
        resizingMapGral();
    }, 300);
}

function resizingMapGral() {
    if (typeof map == "undefined")
        return;
    google.maps.event.trigger(map, "resize");
}

function closeInfoWindow() {
    infowindow.close();
}

function geofence(path, map, name, id) {
    if (path.length > 0) {
        globalName = name;
        globalId = id;
        polygon = new google.maps.Polygon({
            paths: path,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
        });
        polygon.setMap(map);
        polygon.addListener('click', showArrays);
        globalMap = map;
    }
}

function showArrays(event) {
    var geocoder = new google.maps.Geocoder;
    var index = 1;
    var vertices = this.getPath();
    var contentString = '<strong>N<sup>o</sup> Gezona:</strong>' + globalId + '<br>'
            + '<strong>Gezona:</strong>' + globalName + '<br>'
            + '<strong>Coordenadas:</strong>';
    for (var i = 0; i < vertices.getLength(); i++) {
        var xy = vertices.getAt(i);
        var latlng = {lat: parseFloat(xy.lat()), lng: parseFloat(xy.lng())};
        geocoder.geocode({'location': latlng}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    infoZoneWindow.setContent(contentString += '<br>' + '<strong>Punto ' + index + ':</strong><br>' + results[0].formatted_address);
                    index++;
                }
            }
        });
    }
    infoZoneWindow.setPosition(event.latLng);
    infoZoneWindow.open(globalMap);
}

function georute(pathRuta, map, rutaJson) {
    var contenido;
    var indexMarker = 0;
    if (pathRuta.length > 0) {
        $(JSON.parse(rutaJson.coordenadas)).each(function (index, items) {
            $(items.latLng).each(function (index1, val) {
                contenido = '<strong>Ruta N<sup>o</sup>:</strong>' + rutaJson.id
                        + '<br/><strong>Ruta:</strong>' + rutaJson.ruta;
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng({lat: parseFloat(val.lat), lng: parseFloat(val.long)})
                    , title: '#' + indexMarker + '\nCoordenadas: ' + val.lat + '/' + val.long
                    , map: map
                });
                google.maps.event.addListener(marker, "dblclick", function (event) {
                    var mapOptions = {
                        zoom: 20
                        , center: event.latLng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    map.setOptions(mapOptions);
                });
                google.maps.event.addListener(marker, "mouseover", function () {
                    infowindow.setContent(contenido);
                    infowindow.open(map, this);
                });
                google.maps.event.addListener(marker, "click", function () {
                    infowindow.setContent(contenido);
                    infowindow.open(map, this);
                });
                indexMarker++;
            });
        });
        polyline = new google.maps.Polyline({
            path: pathRuta,
            map: map,
            strokeColor: '#000000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#0000FF',
            fillOpacity: 0.35
        });
    }
}

function getHistorial() {
    closeInfoWindow();
    $('#divMap').empty();
    if ($('#dtpDesde').val() == '') {
        $('#errorDesde').show();
    } else {
        $('#errorDesde').hide();
        var data = {'method': 2
            , txtImei: $('#txtImei').val()
            , txtFechaInicial: $('#dtpDesde').val()
            , txtFechaFinal: $('#dtpHasta').val()
            , txtHoraInicial: $('#cboHrInicial').val()
            , txtHoraFinal: $('#cboHrFinal').val()};
        $.getJSON(contextoGlobal + '/com/aestre/system/controller/localizarController.php', data, function (response) {
            if (response != null) {
                map = new google.maps.Map(document.getElementById("divMap"));
                infowindow = new google.maps.InfoWindow();
                var stops = [];
                var fecha = [];
                var dire = [];
                var arr = [];
                var lat = [];
                var long = [];
                var latAnt;
                var longAnt;
                var data;
                $.each(response, function (index, item) {
                    img = item.conductor[0].vehiculo[0].icons.path;
                    var conductor;
                    if ((item.conductor[0].nombre != undefined) && (item.conductor[0].paterno != undefined) && (item.conductor[0].materno != undefined)) {
                        conductor = item.conductor[0].nombre + ' ' + item.conductor[0].paterno + ' ' + item.conductor[0].materno;
                    } else {
                        conductor = 'No especificado'
                    }
                    data = '<strong>Conductor:</strong> ' + conductor
                            + '<br/><strong>Veh&iacute;culo:</strong> ' + item.conductor[0].vehiculo[0].modelo
                            + '<br/><strong>Marca:</strong> ' + item.conductor[0].vehiculo[0].marca
                            + '<br/><strong>Placa:</strong> ' + item.conductor[0].vehiculo[0].placa
                            + '<br/><strong>Uso:</strong> ' + item.conductor[0].vehiculo[0].uso.uso;
                    $.each(item.conductor[0].vehiculo[0].localizar, function (index, items) {
                        if ((latAnt == undefined) && (longAnt == undefined)) {
                            stops.push(getObject(items));
                        } else {
                            if ((latAnt != items.lat) && (longAnt != items.lon)) {
                                stops.push(getObject(items));
                            }
                        }
                        arr.push(data + '<br/><strong>Posici&oacute;n Actual:</strong> ' + items.addres);
                        lat.push(parseFloat(items.lat));
                        long.push(parseFloat(items.lon));
                        var dateTime = items.dt.split(' ');
                        var date = dateTime[0].replace(/-/g, '/').split('/');
                        fecha.push(date[2] + '/' + date[1] + '/' + date[0]);
                        dire.push(items.addres);
                        latAnt = parseFloat(items.lat);
                        longAnt = parseFloat(items.lon);
                    });
                    var directionsDisplay = new window.google.maps.DirectionsRenderer({
                        suppressMarkers: true
                    });
                    var directionsService = new window.google.maps.DirectionsService();
                    Tour_startUp(stops, arr, dire, fecha, lat, long, img);
                    window.tour.loadMap(map, directionsDisplay);
                    window.tour.fitBounds(map);
                    if (stops.length > 1) {
                        window.tour.calcRoute(directionsService, directionsDisplay);
                    }
                });
                resizeMapGral();
                window.clearInterval(inter);

            } else {
                $('#noDataHistorial').modal('show');
            }
        });
    }
}

function Tour_startUp(stops, arr, dire, fecha, lat, long, img) {
    var legs;
    if (!window.tour)
        window.tour = {
            updateStops: function (newStops) {
                stops = newStops;
            },
            loadMap: function (maps, directionsDisplay) {
                var myOptions = {
                    zoom: 10,
                    center: new window.google.maps.LatLng(51.507937, -0.076188),
                    mapTypeId: window.google.maps.MapTypeId.ROADMAP,
                };
                maps.setOptions(myOptions);
                directionsDisplay.setMap(maps);
            },
            fitBounds: function (map) {
                var bounds = new window.google.maps.LatLngBounds();
                jQuery.each(stops, function (key, val) {
                    var myLatlng = new window.google.maps.LatLng(val.Geometry.Latitude, val.Geometry.Longitude);
                    bounds.extend(myLatlng);
                });
                map.fitBounds(bounds);
            },
            calcRoute: function (directionsService, directionsDisplay) {
                var batches = [];
                var itemsPerBatch = 10;
                var itemsCounter = 0;
                var wayptsExist = stops.length > 0;
                while (wayptsExist) {
                    var subBatch = [];
                    var subitemsCounter = 0;
                    for (var j = itemsCounter; j < stops.length; j++) {
                        subitemsCounter++;
                        subBatch.push({
                            location: new window.google.maps.LatLng(stops[j].Geometry.Latitude, stops[j].Geometry.Longitude),
                            stopover: true
                        });
                        if (subitemsCounter == itemsPerBatch)
                            break;
                    }

                    itemsCounter += subitemsCounter;
                    batches.push(subBatch);
                    wayptsExist = itemsCounter < stops.length;
                    itemsCounter--;
                }
                var combinedResults;
                var unsortedResults = [{}];
                var directionsResultsReturned = 0;
                for (var k = 0; k < batches.length; k++) {
                    var lastIndex = batches[k].length - 1;
                    var start = batches[k][0].location;
                    var end = batches[k][lastIndex].location;
                    waypts = batches[k];
                    waypts.splice(0, 1);
                    waypts.splice(waypts.length - 1, 1);
                    var request = {
                        origin: start,
                        destination: end,
                        waypoints: waypts,
                        travelMode: window.google.maps.TravelMode.DRIVING
                    };
                    var index = 0;
                    (function (kk) {
                        directionsService.route(request, function (result, status) {
                            var unsortedResult = {order: kk, result: result};
                            unsortedResults.push(unsortedResult);
                            directionsResultsReturned++;
                            if (directionsResultsReturned == batches.length) {
                                unsortedResults.sort(function (a, b) {
                                    return parseFloat(a.order) - parseFloat(b.order);
                                });
                                var count = 0;
                                for (var key in unsortedResults) {
                                    if (unsortedResults[key].result != null) {
                                        if (unsortedResults.hasOwnProperty(key)) {
                                            if (count == 0)
                                                combinedResults = unsortedResults[key].result;
                                            else {
                                                combinedResults.routes[0].legs = combinedResults.routes[0].legs.concat(unsortedResults[key].result.routes[0].legs);
                                                combinedResults.routes[0].overview_path = combinedResults.routes[0].overview_path.concat(unsortedResults[key].result.routes[0].overview_path);
                                                combinedResults.routes[0].bounds = combinedResults.routes[0].bounds.extend(unsortedResults[key].result.routes[0].bounds.getNorthEast());
                                                combinedResults.routes[0].bounds = combinedResults.routes[0].bounds.extend(unsortedResults[key].result.routes[0].bounds.getSouthWest());
                                            }
                                            count++;
                                        }
                                    }
                                }
                                directionsDisplay.setDirections(combinedResults);
                                legs = combinedResults.routes[0].legs;
                                for (var i = 0; i < legs.length; i++) {
                                    var contenido = arr[0] + fecha[i]
                                            + '<br/><strong> Gps : </strong><a href ="http://maps.google.es/?q=' + lat[i] + ',' + long[i]
                                            + '" target="_blank">' + lat[i] + ' / ' + long[i] + '</a>';
                                    createMarker(directionsDisplay.getMap(), legs[i].start_location, "Marcador No : " + i, contenido + "<br><strong>Direcci&oacute;n : </strong>" + legs[i].start_address, img);
                                }
                            }
                        });
                        index = index + 1;
                    })(k);
                }
            }
        };
}

function createMarker(maps, latlng, label, html, img) {
    var contentString = '<b>' + label + '</b><br>' + html;
    var marker = new google.maps.Marker({
        position: latlng,
        icon: img,
        zIndex: Math.round(latlng.lat() * -100000) << 5
    });
    marker.setMap(maps);
    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(contentString);
        infowindow.open(maps, marker);
    });
    return marker;
}

function getObject(item) {
    var dtoObject = new Object();
    dtoObject.Geometry = {};
    dtoObject.Geometry.Latitude = item.lat;
    dtoObject.Geometry.Longitude = item.lon;
    return dtoObject;
}

function crearZona() {
    path.lenght = 0;    
    for (var i = 1; i < 6; i++) {
        if ($('#txtPos' + i) != '') {
            var value = $('#txtPos' + i).val();
            value = value.replace('(', '');
            value = value.replace(')', '');
            var res = value.split(',');
            $('#txtPos' + i).val(res[0] + ',' + res[1]);
            path.push({lat: parseFloat(res[0]), lng: parseFloat(res[1])});
            if ((indexClick == 4) && (color != undefined)) {
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(parseFloat(res[0]), parseFloat(res[1]))
                    , map: map
                });
            }
        }
    }
    polygon = new google.maps.Polygon({
        paths: path
        , strokeColor: '#FF0000'
        , strokeOpacity: 0.8
        , strokeWeight: 2
        , fillColor: color != undefined ? color : '#ab2567'
        , fillOpacity: 0.35
    });
    polygon.setMap(map);
}