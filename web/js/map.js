var polylineR;
var geoRutaMap;
var infowindow = new google.maps.InfoWindow();
var infoZoneWindow = new google.maps.InfoWindow();
var geocoder = new google.maps.Geocoder;
var globalName;
var globalId;
var globalMap;
var globalColor = '';
var path = [];
var pathRuta = [];
var inter;
var polygon;
var indexClick = 0;
var globalIndexTr = 0;
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
        otherZone();
    });

});

onloadAll = function () {
    closeInfoWindow();
    $('#divMiniMap').empty();
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
                    img.push(items.vehiculo[0].icons.path);
                    if (items.vehiculo[0].zona[0] != undefined) {
                        $(JSON.parse(items.vehiculo[0].zona[0].coordenadas)).each(function (index, itemss) {
                            $(itemss.latLng).each(function (index1, val) {
                                if (index1 == 0) {
                                    globalColor = itemss.colorZona;
                                }
                                path.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                            });
                        });
                        geofence(path, map, items.vehiculo[0].zona[0].zona, items.vehiculo[0].zona[0].id);
                        data += '<br/><strong>Zona:</strong> ' + items.vehiculo[0].zona[0].zona;

                    }
                    path.length = 0;
                    if (items.vehiculo[0].ruta[0] != undefined) {
                        $(JSON.parse(items.vehiculo[0].ruta[0].coordenadas)).each(function (index, itemss) {
                            $(itemss.latLng).each(function (index1, val) {
                                pathRuta.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                            });
                        });
                        georute(pathRuta, map, items.vehiculo[0].ruta[0]);
                        data += '<br/><strong>Ruta:</strong> ' + items.vehiculo[0].ruta[0].ruta;
                    }
                    pathRuta.length = 0;
                    arr.push(data);
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
                    lat.push(parseFloat(items.vehiculo[0].localizar[0].lat));
                    long.push(parseFloat(items.vehiculo[0].localizar[0].lon));
                    img.push(items.vehiculo[0].icons.path);
                    if (items.vehiculo[0].zona[0] != undefined) {
                        $(JSON.parse(items.vehiculo[0].zona[0].coordenadas)).each(function (index, itemss) {
                            $(itemss.latLng).each(function (index1, val) {
                                if (index1 == 0) {
                                    globalColor = itemss.colorZona;
                                }
                                path.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                            });
                        });
                        geofence(path, map, items.vehiculo[0].zona[0].zona, items.vehiculo[0].zona[0].id);
                        data += '<br/><strong>Zona:</strong> ' + items.vehiculo[0].zona[0].zona;
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
                    arr.push(data);
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
    window.clearInterval(inter);
    intervalsMini();
    resizeMapGral();
};

lastMap = function (index) {
    indexClick = 0;
    $('#divMapGeozonaAnterior').empty();
    $('#divMapGeozonaNueva').empty();
    lastPath = [];
    newMap();
    var dataZona = zonas[index];
    $(JSON.parse(dataZona.zona)).each(function (indx, item) {
        $(item.latLng).each(function (indx, val) {
            if (indx == 0) {
                globalColor = item.colorZona;
            }
            lastPath.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
        });
    });
    var mapOptions = {
        zoom: 7
        , mapTypeId: window.google.maps.MapTypeId.MAP
        , center: new google.maps.LatLng(lastPath[0].lat, lastPath[0].lng)
    };
    var map = new google.maps.Map(document.getElementById("divMapGeozonaAnterior"), mapOptions);
    geofence(lastPath, map, dataZona.nombre, dataZona.id);
    for (var i = 0; i < lastPath.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lastPath[i].lat, lastPath[i].lng),
            map: map
        });
    }
    $('#txtZona').val(dataZona.nombre);
    $('#txtIdGeozona').val(dataZona.id);
    $('#colorPicker').val(globalColor);
    lastPath.length = 0;
    globalIndexTr = index;
    otherZone();
};

lastMapRuta = function (index) {
    indexClick = 0;
    $('#divMapGeorutaAnterior').empty();
    $('#divMapGeorutaNueva').empty();
    lastPath = [];
    newMapRuta();
    var dataRuta = rutas[index];
    $(JSON.parse(dataRuta.coordenadas)).each(function (indx, item) {
        $(item.latLng).each(function (indx, val) {
            if (indx == 0) {
                globalColor = item.colorRuta;
            }
            lastPath.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
        });
    });
    var mapOptions = {
        zoom: 16
        , mapTypeId: window.google.maps.MapTypeId.MAP
        , center: new google.maps.LatLng(lastPath[0].lat, lastPath[0].lng)
    };
    var map = new google.maps.Map(document.getElementById("divMapGeorutaAnterior"), mapOptions);
    georute(lastPath, map, dataRuta);
    for (var i = 0; i < lastPath.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lastPath[i].lat, lastPath[i].lng),
            map: map
        });
    }
    $('#txtRuta').val(dataRuta.nombre);
    $('#txtIdRuta').val(dataRuta.id);
    $('#colorPicker').val(globalColor);
    lastPath.length = 0;
    globalIndexTr = index;
};

newMap = function () {
    var mapOptions = {
        zoom: 6
        , mapTypeId: window.google.maps.MapTypeId.MAP
        , center: new google.maps.LatLng(23.945963820559726, -102.53775014999997)
    };
    map = new google.maps.Map(document.getElementById("divMapGeozonaNueva"), mapOptions);
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
        } else {
            crearZona();
        }
        indexClick = indexClick + 1;
    });
    resizeMapGral();
}

newMapRuta = function () {
    var mapOptions = {
        zoom: 6
        , mapTypeId: window.google.maps.MapTypeId.MAP
        , center: new google.maps.LatLng(23.945963820559726, -102.53775014999997)
    };
    geoRutaMap = new google.maps.Map(document.getElementById("divMapGeoruta"), mapOptions);
    geoRutaMap.addListener('click', showError());
};

deleteMap = function (index) {
    $('#divMapGeozona').empty();
    lastPath = [];
    var dataZona = zonas[index];
    $(JSON.parse(dataZona.zona)).each(function (indx, item) {
        $(item.latLng).each(function (indx, val) {
            if (indx == 0) {
                globalColor = item.colorZona;
            }
            lastPath.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
        });
    });
    var mapOptions = {
        zoom: 7
        , mapTypeId: window.google.maps.MapTypeId.MAP
        , center: new google.maps.LatLng(lastPath[0].lat, lastPath[0].lng)
    };
    var map = new google.maps.Map(document.getElementById("divMapGeozona"), mapOptions);
    geofence(lastPath, map, dataZona.nombre, dataZona.id);
    for (var i = 0; i < lastPath.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lastPath[i].lat, lastPath[i].lng),
            map: map
        });
    }
    $('#txtZona').val(dataZona.nombre);
    $('#txtIdGeozona').val(dataZona.id);
    $('#colorPicker').val(globalColor);
    lastPath.length = 0;
    globalIndexTr = index;
    otherZone();
};

deleteMapRuta = function (index) {
    $('#divMapGeoruta').empty();
    lastPath = [];
    var dataRuta = rutas[index];
    $(JSON.parse(dataRuta.coordenadas)).each(function (indx, item) {
        $(item.latLng).each(function (indx, val) {
            if (indx == 0) {
                globalColor = item.colorRuta;
            }
            lastPath.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
        });
    });
    var mapOptions = {
        zoom: 17
        , mapTypeId: window.google.maps.MapTypeId.MAP
        , center: new google.maps.LatLng(lastPath[0].lat, lastPath[0].lng)
    };
    var map = new google.maps.Map(document.getElementById("divMapGeoruta"), mapOptions);
    georute(lastPath, map, dataRuta);
    for (var i = 0; i < lastPath.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lastPath[i].lat, lastPath[i].lng),
            map: map
        });
    }
    $('#txtRuta').val(dataRuta.nombre);
    $('#txtIdRuta').val(dataRuta.id);
    $('#colorPicker').val(globalColor);
    lastPath.length = 0;
    globalIndexTr = index;
    otherRute();
};

asociarMap = function (index) {
    $('#divMapGeozona').empty();
    lastPath = [];
    var dataZona = zonas[index];
    $(JSON.parse(dataZona.zona)).each(function (indx, item) {
        $(item.latLng).each(function (indx, val) {
            if (indx == 0) {
                globalColor = item.colorZona;
            }
            lastPath.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
        });
    });
    var mapOptions = {
        zoom: 7
        , mapTypeId: window.google.maps.MapTypeId.MAP
        , center: new google.maps.LatLng(lastPath[0].lat, lastPath[0].lng)
    };
    var map = new google.maps.Map(document.getElementById("divMapGeozona"), mapOptions);
    geofence(lastPath, map, dataZona.nombre, dataZona.id);
    for (var i = 0; i < lastPath.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lastPath[i].lat, lastPath[i].lng),
            map: map
        });
    }
    $('#txtZona').val(dataZona.nombre);
    $('#txtIdGeozona').val(dataZona.id);
    $('#colorPicker').val(globalColor);
    lastPath.length = 0;
    globalIndexTr = index;
    otherZone();
};

asociarMapRuta = function (index) {
    $('#divMapGeoruta').empty();
    lastPath = [];
    var dataRuta = rutas[index];
    $(JSON.parse(dataRuta.coordenadas)).each(function (indx, item) {
        $(item.latLng).each(function (indx, val) {
            if (indx == 0) {
                globalColor = item.colorRuta;
            }
            lastPath.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
        });
    });
    var mapOptions = {
        zoom: 17
        , mapTypeId: window.google.maps.MapTypeId.MAP
        , center: new google.maps.LatLng(lastPath[0].lat, lastPath[0].lng)
    };
    var map = new google.maps.Map(document.getElementById("divMapGeoruta"), mapOptions);
    georute(lastPath, map, dataRuta);
    for (var i = 0; i < lastPath.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lastPath[i].lat, lastPath[i].lng),
            map: map
        });
    }
    $('#txtRuta').val(dataRuta.nombre);
    $('#txtIdRuta').val(dataRuta.id);
    $('#colorPicker').val(globalColor);
    lastPath.length = 0;
    globalIndexTr = index;
    otherRute();
};

function geoMap() {
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
        } else {
            crearZona();
        }
        indexClick = indexClick + 1;
    });
    resizeMapGral();
}

function ruteMap() {
    var mapOptions = {
        zoom: 6
        , mapTypeId: window.google.maps.MapTypeId.MAP
        , center: new google.maps.LatLng(23.945963820559726, -102.53775014999997)
    };
    geoRutaMap = new google.maps.Map(document.getElementById("divMapGeoruta"), mapOptions);
    geoRutaMap.addListener('click', showError());
    resizeMapGralRute();
}

function localizar(imei) {
    closeInfoWindow();
    $('#divMiniMap').empty();
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
                img.push(item.conductor[0].vehiculo[0].icons.path);
                if (item.conductor[0].vehiculo[0].zona[0] != undefined) {
                    $(JSON.parse(item.conductor[0].vehiculo[0].zona[0].coordenadas)).each(function (index, items) {
                        $(items.latLng).each(function (index1, val) {
                            path.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                        });
                    });
                    geofence(path, map, item.conductor[0].vehiculo[0].zona[0].zona, item.conductor[0].vehiculo[0].zona[0].id);
                    data += '<br/><strong>Zona:</strong> ' + item.conductor[0].vehiculo[0].zona[0].zona;
                }
                path.length = 0;
                if (item.conductor[0].vehiculo[0].ruta[0] != undefined) {
                    $(JSON.parse(item.conductor[0].vehiculo[0].ruta[0].coordenadas)).each(function (index, itemss) {
                        $(itemss.latLng).each(function (index1, val) {
                            pathRuta.push({lat: parseFloat(val.lat), lng: parseFloat(val.long)});
                        });
                    });
                    georute(pathRuta, map, item.conductor[0].vehiculo[0].ruta[0]);
                    data += '<br/><strong>Ruta:</strong> ' + item.conductor[0].vehiculo[0].ruta[0].ruta;
                }
                pathRuta.length = 0;
                arr.push(data);
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
}

function showError() {
    $('#errorGeocoder').text('Busque la colonia para activar la función de crear zona / ruta');
    $('#errorGeocoder').show();
}

function search(address) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({'address': address}, geocodeResult);
}

function geocodeResult(results, status) {
    if (status == 'OK') {
        $('#errorGeocoder').hide();
        var mapOptions = {
            zoom: 17
            , center: results[0].geometry.location,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        geoRutaMap = new google.maps.Map(document.getElementById("divMapGeoruta"), mapOptions);
        geoRutaMap.addListener('click', addLatLng);
        polylineR = new google.maps.Polyline({
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 3
        });
        polylineR.setMap(geoRutaMap);

    } else {
        $('#errorGeocoder').empty();
        $('#errorGeocoder').append('Geocoding no tuvo éxito debido a: ' + getStatus(status));
        $('#errorGeocoder').show();
    }
}

function setColor(colors) {
    polylineR.setOptions({strokeColor: colors});
}

function addLatLng(event) {
    path = polylineR.getPath();
    path.push(event.latLng);
    var marker = new google.maps.Marker({
        position: event.latLng
        , map: geoRutaMap
    });
    $('#txtLength').val('');
    var td = '<td>Posici&oacute;n ' + indexClick
            + ':<input type="text" id="txtPos' + indexClick + '" name="txtPos' + indexClick
            + '" readonly="readOnly" required="required" size="40" value="' + event.latLng + '"/></td>';
    $('#tblCoordenadasGr tr:last').after('<tr>' + td + '</tr>');
    var marker = new google.maps.Marker({
        position: event.latLng
        , title: '#' + path.getLength()
        , map: geoRutaMap
    });
    if (path.length > 1) {
        $('#btnGuardarRuta').prop('disabled', false);
    }
    $('#txtLength').val(indexClick);
    indexClick = indexClick + 1;
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

function resizeMapGralRute() {
    if (typeof geoRutaMap == "undefined")
        return;
    setTimeout(function () {
        resizingMapGralRute();
    }, 300);
}

function resizingMapGralRute() {
    if (typeof geoRutaMap == "undefined")
        return;
    google.maps.event.trigger(geoRutaMap, "resize");
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
            strokeColor: '#000000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: globalColor,
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
                if (index1 == 0) {
                    globalColor = items.colorRuta;
                }
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
            strokeColor: globalColor,
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
    $('#divMiniMap').empty();
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
    path = [];
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
        , fillColor: color != undefined ? color : '#FF2802'
        , fillOpacity: 0.35
    });
    polygon.setMap(map);
}

function enviarGz(method) {
    var idsVehiculo = [];
    var ltlon = [];
    $("input:checkbox:checked").each(function () {
        idsVehiculo.push($(this).val());
    });
    if (method == 1 || method == 5) {
        if (idsVehiculo.length > 0) {
            $('#lblErrorSelect').hide();
            send(method, ltlon, idsVehiculo);
        } else {
            $('#lblErrorSelect').show();
        }
    } else if (method == 2) {
        send(method, ltlon, idsVehiculo);
    } else if (method == 3) {
        send(method, ltlon, idsVehiculo);
    }
}

function enviarRuta(method) {
    var idsVehiculo = [];
    var ltlon = [];
    $('input:checkbox:checked').each(function () {
        idsVehiculo.push($(this).val());
    });

    if (method == 1 || method == 5) {
        if (idsVehiculo.length > 0) {
            $('#lblErrorSelect').hide();
            sendRuta(method, ltlon, idsVehiculo);
        } else {
            $('#lblErrorSelect').show();
        }
    } else if (method == 2) {
        sendRuta(method, ltlon, idsVehiculo);
    } else if (method == 3) {
        sendRuta(method, ltlon, idsVehiculo);
    }
}

function send(method, ltlon, idsVehiculo) {
    var geoFence = new Object();
    for (var index = 1; index < 5; index++) {
        var coordenadas = {};
        var value = $('#txtPos' + index).val();
        var latLng = value.split(',');
        coordenadas.lat = latLng[0];
        coordenadas.long = latLng[1];
        ltlon.push(coordenadas);
    }
    var latLng = new Object();
    geoFence.latLng = ltlon;
    geoFence.colorZona = '#' + $('#colorPicker').val();
    var zonaJson = JSON.stringify(geoFence);
    var data = {'method': method, 'idVehiculos': idsVehiculo, 'txtIdZona': $('#txtIdGeozona').val()
        , 'txtNombre': $('#txtZona').val(), 'json': zonaJson};
    $.getJSON(contextoGlobal + '/com/aestre/system/controller/geozonaController.php'
            , data, function (response) {
                if (method == 1 || method == 5) {
                    $('#lblText').text((method == 1) ? 'La zona fue registrada, se a&ntilde;adieron' : 'Se asociaron ');
                    $('#lblTotal').append(response[0].contador);
                    $('#divMessageSuccessZona').modal('show');
                    location.reload();
                } else if (method == 2) {
                    $('#divMessageUpdate').modal('hide');
                    $('#divMessageSuccessModificarZona').modal('show');
                    location.reload();
                } else if (method == 3) {
                    $('#divMessageEliminarZona').modal('hide');
                    $('#divMessageSuccessEliminarZona').modal('show');
                    location.reload();
                }
            }
    ).error(function (jqXHR, textStatus, errorThrown) {
        console.log("error " + textStatus);
        console.log("incoming Text " + jqXHR.responseText);
    });
    onloadAllMini();
}

function sendRuta(method, ltlon, idsVehiculo) {
    for (var i = 1; i < indexClick; i++) {
        var value = $('#txtPos' + i).val();
        value = value.replace('(', '');
        value = value.replace(')', '');
        var res = value.split(',');
        $('#txtPos' + i).val(res[0] + ',' + res[1]);
    }
    var geoRuta = new Object();
    for (var index = 1; index < indexClick; index++) {
        var coordenadas = {};
        var value = $('#txtPos' + index).val();
        var latLng = value.split(',');
        coordenadas.lat = latLng[0];
        coordenadas.long = latLng[1];
        ltlon.push(coordenadas);
    }
    var latLng = new Object();
    geoRuta.latLng = ltlon;
    geoRuta.colorRuta = '#' + $('#colorPicker').val();
    var rutaJson = JSON.stringify(geoRuta);
    var data = {'method': method, 'txtIdRuta': $('#txtIdRuta').val(), 'txtNombre': $('#txtRuta').val()
        , 'txtLenght': $('#txtLength').val(), 'json': rutaJson, 'idVehiculos': idsVehiculo};
    $.getJSON(contextoGlobal + '/com/aestre/system/controller/georutaController.php'
            , data, function (response) {
                if (method == 1 || method == 5) {
                    $('#lblText').text((method == 1) ? 'La ruta fue registrada, se a&ntilde;adieron' : 'Se asociaron ');
                    $('#lblTotal').append(response[0].contador);
                    $("#divMessageSuccessRuta").modal('show');
                    location.reload();
                } else if (method == 2) {
                    $('#divMessageUpdate').modal('hide');
                    $('#divMessageSuccessModificarRuta').modal('show');
                    location.reload();
                } else if (method == 3) {
                    $('#divMessageEliminarZona').modal('hide');
                    $('#divMessageSuccessEliminarRuta').modal('show');
                    location.reload();
                }
                $('#divRutas').load('#divRutas');


            }
    );
}

function clearZona() {
    $('#container').empty();
    $('#trIntMapIndx' + globalIndexTr).remove();
}

function clear(size) {
    $('#container').empty();
    for (var indx = 0; indx < size; indx++) {
        $('#trIntMapIndx' + indx).remove();
    }
}

function addColor() {
    var input = document.createElement('INPUT');
    input.setAttribute('class', 'jscolor form-control col-xs-1 input-sm');
    input.setAttribute('value', 'FF2802');
    input.setAttribute('id', 'colorPicker');
    input.setAttribute('name', 'colorPicker');
    var picker = new jscolor(input);
    picker.fromHSV(360 / 100 * 0, 100, 100);
    document.getElementById('container').appendChild(input);
}