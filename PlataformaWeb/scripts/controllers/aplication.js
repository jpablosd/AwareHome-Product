var awarehome =  angular.module( 'awarehome',['ngRoute']); 

awarehome.controller('controladorInicio', ['$scope', function($scope){
    Materialize.toast('BIENVENIDO!', 4000);
    $scope.verDatos = function(){
        console.log("hola");
    }     
    $scope.crearAlerta = function(){
    }
}]);

awarehome.config(['$routeProvider', function($routeProvider){
    $routeProvider.
    when('/',{
        templateUrl: 'views/vistaDatos.html' 
    }).
    when('/verDatos', {
        templateUrl: 'views/vistaDatos.html'
    }).
    when('/crearAlerta', {
        templateUrl: 'views/crearAlerta.html'
    }).
    when('/verAlertas',{
        templateUrl: 'views/verAlertas.html'
    }).
    when('/crearAlertaInteligente',{
        templateUrl: 'views/crearAlertaInteligente.html' 
    }).
    when('/verAlertaInteligente',{
        templateUrl: 'views/verAlertaInteligente.html'
    }).
    when('/verHistorial',{
        templateUrl: 'views/historialGrafico.html' 
    }).
    when('/!',{
        templateUrl: 'views/404.html' 
    }).
    when('/verMapa',{
        templateUrl: 'views/mapa.html' 
    }).
    when('/vistaDatos',{
        templateUrl: 'views/datos.html'
    }).
    when('/test',{
        templateUrl: 'views/crearAlertaCompuesta.html'
    }).
    otherwise({
        redirecTo: '/',
        templateUrl: 'app.html#/verDatos'
    })
}]);

//CREACION DE ALERTA SIMPLE
var sensor_alerta_simple;
var simbolo_alerta_simple;
var nombre_alerta_simple;
var dato_alerta_simple;
//al escojer el tipo de sensor
function sensorAlertaSimple(value){
    sensor_alerta_simple = value;
}
//al seleccionar el simbolo de la alerta simple
function simboloAlertaSimple(value){
    simbolo_alerta_simple = value;
}
//al apretar el boton crear alerta
function crearAlertaSimple(){
    Materialize.toast('Alerta Creada!', 4000);
    nombre_alerta_simple = document.getElementById('nombre_alerta_simple').value;
    dato_alerta_simple = document.getElementById('dato_alerta_simple').value;

    console.log("alerta simple: "+nombre_alerta_simple+" "+sensor_alerta_simple+" "+simbolo_alerta_simple+" "+dato_alerta_simple);

    var xmlhttp = new XMLHttpRequest();
    var url = "php/crearAlertaSimple.php?nombre_alerta_simple="+nombre_alerta_simple+"&nombre_sensor_alerta="+sensor_alerta_simple+"&simbolo_alerta="+simbolo_alerta_simple+"&dato_alerta="+dato_alerta_simple;

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            myFunction(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();

    function myFunction(response) {
        console.log(response);
        var arr = JSON.parse(response);
        var i;
        var out = "";

        for(i = 0; i < arr.length; i++) {
            console.log(arr[i].success);
        }
    }
}
//CREACION DE ALERTA SIMPLE

//------------------- HISTORIAL -----------------------------

$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
});



var fecha;
var sensorGrafico;
function buscarDatos(valor){
    document.getElementById('progress').style.display = 'block';
    //        document.getElementById('curve_chart').style.display = 'none';


    fecha = document.getElementById("fecha").value;
    sensorGrafico = valor;
    google.load('visualization', '1', {"callback" : drawChart, 'packages': ['corechart']});
    google.setOnLoadCallback(drawChart);

}

function drawChart() {
    var xmlhttp = new XMLHttpRequest();
    var url = "php/verDatosGrafico.php?fecha="+fecha;
    console.log(url);
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log("cargando1");
            myFunction(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    function myFunction(response) {
        //console.log(response);
        var arr = JSON.parse(response);
        console.log(arr.message);
        if(arr.message == "no hay datos por ahora"){
            document.getElementById('progress').style.display = 'none';
            //document.getElementById('curve_chart').style.display = 'none';
            alert("No hay datos en esta fecha");
            javascript_abort();
        }

        var hola = [['Fecha', 'Medición']];

        for(var i = 0; i < arr.length; i++) {
            if (arr[i].sensor == sensorGrafico){
                var med = parseInt(arr[i].medicion);
                hola.push([arr[i].fecha,med]);
            }
        }

        var data = google.visualization.arrayToDataTable(hola);
        var options = {
            title: 'Historial '+sensorGrafico,
            curveType: 'function',
            legend: { position: 'bottom' }
        };
        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);

        console.log("cargando2");
        document.getElementById('progress').style.display = 'none';
        //document.getElementById('curve_chart').style.display = 'block';



    }//myFunction
}

function javascript_abort()
{
    throw new Error('This is not an error. This is just to abort javascript');
}
//------------------- HISTORIAL -----------------------------

