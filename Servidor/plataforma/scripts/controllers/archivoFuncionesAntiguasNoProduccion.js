//------- INDEX ----------
$(document).ready(function(){

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });
    //tooltip
    $('.tooltipped').tooltip({delay: 50});
    $('.collapsible').collapsible({
        accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
    document.getElementById('ver_datos').style.display = 'block';
    document.getElementById('ver_alertas').style.display = 'none';
    document.getElementById('crear_alertas').style.display = 'none';
    document.getElementById('crear_alertas_inteligentes').style.display = 'none';
    document.getElementById('ver_alertas_inteligentes').style.display= 'none';


    document.getElementById('modaldrag1').style.display = 'none';
    document.getElementById('modaldrag2').style.display = 'none';
    document.getElementById('modaldrag3').style.display = 'none';
    document.getElementById('modaldrag4').style.display = 'none';
    document.getElementById('modaldrag5').style.display = 'none';
    document.getElementById('modaldrag6').style.display = 'none';

});
//DOCUMENT READY

function verDatos(){
    document.getElementById('ver_datos').style.display = 'block';
    document.getElementById('ver_alertas').style.display = 'none';
    document.getElementById('crear_alertas').style.display = 'none';
    document.getElementById('crear_alertas_inteligentes').style.display = 'none';

    document.getElementById('ver_alertas_inteligentes').style.display = 'none';




}
function crearAlerta(){
    document.getElementById('crear_alertas').style.display = 'block';
    document.getElementById('ver_alertas').style.display = 'none';
    document.getElementById('ver_datos').style.display = 'none';
    document.getElementById('crear_alertas_inteligentes').style.display = 'none';
    document.getElementById('ver_alertas_inteligentes').style.display = 'none';


}
function verAlerta(){
    document.getElementById('ver_alertas').style.display = 'block';
    document.getElementById('ver_datos').style.display = 'none';
    document.getElementById('crear_alertas').style.display = 'none';
    document.getElementById('crear_alertas_inteligentes').style.display = 'none';
    document.getElementById('ver_alertas_inteligentes').style.display = 'none';


    cargarAlertas();

}
function crearAlertaInteligente(){
    document.getElementById('ver_alertas').style.display = 'none';
    document.getElementById('ver_datos').style.display = 'none';
    document.getElementById('crear_alertas').style.display = 'none';
    document.getElementById('crear_alertas_inteligentes').style.display = 'block';
    document.getElementById('ver_alertas_inteligentes').style.display = 'none';

}

function verAlertaInteligente(){
    document.getElementById('ver_datos').style.display = 'none';
    document.getElementById('ver_alertas').style.display = 'none';
    document.getElementById('crear_alertas').style.display = 'none';
    document.getElementById('crear_alertas_inteligentes').style.display = 'none';
    document.getElementById('ver_alertas_inteligentes').style.display= 'block';

    cargarAlertasComplejas();
}

function cerrarSesion(){
    document.write("<script>location.href='index.html'</script>"); 
}

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

/*
var doughnutData = [
    {
        value: 1,
        label: "One"
    },
    {
        value: 2,
        label: "Two"
    },
    {
        value: 5,
        label: "Three"
    },
    {
        value: 2,
        label: "Four"
    },
    {
        value: 1,
        label: "Five"
    }
];
*/
window.onload = function(){

    var doughnutData = [
        {
            value: 0,
        },{
            value:0,
        }
        ,{
            value:5,
        }
    ];
    var ctx = document.getElementById("chart-area").getContext("2d");
    window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true});

    var ctx2 = document.getElementById("chart-area2").getContext("2d");
    window.myDoughnut2 = new Chart(ctx2).Doughnut(doughnutData, {responsive : true});

    var ctx3 = document.getElementById("chart-area3").getContext("2d");
    window.myDoughnut3 = new Chart(ctx3).Doughnut(doughnutData, {responsive : true});



    var myDataRef = new Firebase('https://awarehome.firebaseio.com/');
    // Update our GUI to change a user"s status.
    myDataRef.on("child_changed", function(snapshot) {
        var message = snapshot.val();
        //console.log("child changed: "+message);

        //console.log("gas :"+message.gas);
        //console.log("temp :"+message.temperatura);
        //console.log("hum :"+message.humedad);

        if (message.temperatura >= 50){
            myDoughnut.segments[0].value = message.temperatura;
            myDoughnut.segments[2].value = 0;
            myDoughnut.update();
            document.getElementById('dato_temperatura').innerHTML = message.temperatura + "ºC";
        }
        else{
            myDoughnut.segments[2].value = message.temperatura;
            myDoughnut.segments[0].value = 0;
            myDoughnut.update();
            document.getElementById('dato_temperatura').innerHTML = message.temperatura + "ºC";
        }

        myDoughnut2.segments[2].value = message.humedad;
        myDoughnut2.update();
        document.getElementById('dato_humedad').innerHTML = message.humedad + "%";

        myDoughnut3.segments[2].value = message.gas;
        myDoughnut3.update();
        document.getElementById('dato_gas').innerHTML = message.gas + "ppm";

    });



    //grafico
    var ctxgrafico = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctxgrafico).Line(lineChartData, {
        responsive: true
    });


    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
    var lineChartData = {
        labels : ["January","February","March","April","May","June","July"],
        datasets : [
            {
                label: "My First dataset",
                fillColor : "rgba(220,220,220,0.2)",
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
            },
            {
                label: "My Second dataset",
                fillColor : "rgba(151,187,205,0.2)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
                data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
            }
        ]

    }




    };//windows onload



//------------------- VER ALERTAS ----------------------
function cargarAlertas(){
    var out = "";

    document.getElementById("lista").innerHTML = out;


    var xmlhttp = new XMLHttpRequest();
    var url = "php/verActualizarAlertas.php";

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

        for(i = 0; i < arr.length; i++) {
            console.log(arr[i].nombre_alerta);
            console.log(arr[i].sensor);
            console.log(arr[i].signo);
            console.log(arr[i].valor);
            console.log(arr[i].estado);
            var estado;
            if (arr[i].estado == 1){
                estado = "Activada";
            }else{
                estado = "Desactivada";
            }
            var sensor;
            if (arr[i].sensor == 1){
                sensor = "Temperatura";
            }
            else if(arr[i].sensor == 2){
                sensor = "Humedad";
            }
            else if(arr[i].sensor == 3){
                sensor = "Gas";
            }



            out += "<li class='collection-item avatar'><i class='mdi-action-assessment circle green'></i><span class='title'>"+arr[i].nombre_alerta+"</span><p>"+sensor+" "+arr[i].signo+" "+arr[i].valor+"<br>"+estado+"</p><a href='#!' class='secondary-content'><i class='mdi-action-grade'></i></a></li>";
            //lista
        }
        //document.getElementById("lista").innerHTML = out;
        //$("#lista").html(out);

        $("#lista").prepend(out);

    }

}
//------------------- VER ALERTAS ----------------------


//------------------- VER ALERTAS COMPLEJAS----------------------
function cargarAlertasComplejas(){
    //Materialize.toast('Alerta Creada!', 4000);

    var out = "";

    document.getElementById("lista_alertas_inteligentes").innerHTML = out;


    var xmlhttp = new XMLHttpRequest();
    var url = "php/monitorearAlertaInteligente.php";

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

        for(i = 0; i < arr.length; i++) {
            console.log(arr[i].nombre_alerta_inteligente);
            console.log(arr[i].nombre_sensor1);
            console.log(arr[i].simbolo_sensor1);
            console.log(arr[i].valor_sensor1);
            console.log(arr[i].nombre_sensor2);
            console.log(arr[i].simbolo_sensor2);
            console.log(arr[i].valor_sensor2);
            console.log(arr[i].nombre_sensor3);
            console.log(arr[i].simbolo_sensor3);
            console.log(arr[i].valor_sensor3);
            console.log(arr[i].estado);
            console.log(arr[i].operador_1);
            console.log(arr[i].operador_2);

            var estado;
            if (arr[i].estado == 1){
                estado = "Activada";
            }else{
                estado = "Desactivada";
            }

            out += "<li class='collection-item avatar'><i class='mdi-action-assessment circle green'></i><span class='title'>"+arr[i].nombre_alerta_inteligente+"</span><p>"+arr[i].nombre_sensor1+" "+arr[i].simbolo_sensor1+" "+arr[i].valor_sensor1+" "+arr[i].operador_1+" "+arr[i].nombre_sensor2+" "+arr[i].simbolo_sensor2+" "+arr[i].valor_sensor2+" "+arr[i].operador_2+" "+arr[i].nombre_sensor3+" "+arr[i].simbolo_sensor3+" "+arr[i].valor_sensor3+" "+"<br>"+estado+"</p><a href='#!' class='secondary-content'><i class='mdi-action-grade'></i></a></li>";
            //lista
        }
        //document.getElementById("lista").innerHTML = out;
        //$("#lista").html(out);

        $("#lista_alertas_inteligentes").prepend(out);

    }

}
//------------------- VER ALERTAS COMPLEJAS----------------------





//------- DRAG AND DROP ----------
//recoje el valor del sensor1
var tipoSensor1,simboloSensor1,valorSensor1;
function tipoSensor1(valor){
    tipoSensor1 = valor;
}
function simboloSensor1(valor){
    simboloSensor1 = valor;
}
function valoresSensor1(){
    valorSensor1 = document.getElementById('valorSensor1').value;
}
//recoje el valor del sensor1


//recoje el valor del sensor2
var tipoSensor2,simboloSensor2,valorSensor2;
function tipoSensor2(valor){
    tipoSensor2 = valor;
}
function simboloSensor2(valor){
    simboloSensor2 = valor;
}
function valoresSensor2(){
    valorSensor2 = document.getElementById('valorSensor2').value;
}
//recoje el valor del sensor2


//recoje el valor del sensor3
var tipoSensor3,simboloSensor3,valorSensor3;
function tipoSensor3(valor){
    tipoSensor3 = valor;
}
function simboloSensor3(valor){
    simboloSensor3 = valor;
}
function valoresSensor3(){
    valorSensor3 = document.getElementById('valorSensor3').value;
}
//recoje el valor del sensor3


//recoje el valor del operador 1
var tipoOperador1;
function tipoOperador1(valor){
    tipoOperador1 = valor;
}
function valorOperador1(){
    console.log("valorOperador1 " + tipoOperador1);
}


//recoje el valor del operador 1
var tipoOperador2;
function tipoOperador2(valor){
    tipoOperador2 = valor;
}
function valorOperador2(){
    console.log("valorOperador2 " + tipoOperador2);
}


/*
//fecha
var fecha;
function valorFecha(){
    if(document.getElementById('lunes').checked){
        alert("lunes checkeado");
    }
    //fecha = document.getElementById('fecha_accion_alerta').value;
    console.log(fecha);
}
*/

//alerta_inteligente
var alerta_inteligente = "";





var sensor_agregado1 = 0;
var operador_agregado1 = 0;
var sensor_agregado2 = 0;
var operador_agregado2 = 0;
var sensor_agregado3 = 0;
var fecha_agregada = 0;



//------- DRAG AND DROP ----------

(function (interact) {

    'use strict';

    var transformProp;

    interact.maxInteractions(Infinity);

    // setup draggable elements.
    interact('.js-drag')
    .draggable({ max: Infinity })
    .on('dragstart', function (event) {
        event.interaction.x = parseInt(event.target.getAttribute('data-x'), 10) || 0;
        event.interaction.y = parseInt(event.target.getAttribute('data-y'), 10) || 0;
    })
    .on('dragmove', function (event) {
        event.interaction.x += event.dx;
        event.interaction.y += event.dy;

        if (transformProp) {
            event.target.style[transformProp] =
                'translate(' + event.interaction.x + 'px, ' + event.interaction.y + 'px)';
        }
        else {
            event.target.style.left = event.interaction.x + 'px';
            event.target.style.top  = event.interaction.y + 'px';
        }
    })
    .on('dragend', function (event) {
        event.target.setAttribute('data-x', event.interaction.x);
        event.target.setAttribute('data-y', event.interaction.y);
    });

    // setup drop areas.
    // dropzone #1 accepts draggable #1
    setupDropzone('#drop1', '#drag1');
    // dropzone #2 accepts draggable #1 and #2
    setupDropzone('#drop2', '#drag2');
    // every dropzone accepts draggable #3
    //setupDropzone('.js-drop', '#drag3');
    setupDropzone('#drop3', '#drag4');
    setupDropzone('#drop5', '#drag5');
    setupDropzone('#drop4', '#drag6');
    setupDropzone('#drop6', '#drag3');

    /**
     * Setup a given element as a dropzone.
     *
     * @param {HTMLElement|String} el
     * @param {String} accept
     */
    function setupDropzone(el, accept) {
        interact(el)
        .dropzone({
            accept: accept,
            ondropactivate: function (event) {
                addClass(event.relatedTarget, '-drop-possible');
                //console.log("1");
            },
            ondropdeactivate: function (event) {
                removeClass(event.relatedTarget, '-drop-possible');
                //console.log("2");
            }
        })
        .on('dropactivate', function (event) {
            var active = event.target.getAttribute('active')|0;
            //console.log("3");

            // change style if it was previously not active
            if (active === 0) {
                //console.log("4");
                addClass(event.target, '-drop-possible');
                event.target.textContent = 'Drop me here!';
            }
            event.target.setAttribute('active', active + 1);
            //console.log("5");
        })
        .on('dropdeactivate', function (event) {

            var active = event.target.getAttribute('active')|0;
            //console.log("6");

            // change style if it was previously active
            // but will no longer be active
            if (active === 1) {
                //suelto el div q estoy arrastrando
                removeClass(event.target, '-drop-possible');
                //console.log("7");
                //event.target.textContent = 'asd';
            }
            event.target.setAttribute('active', active - 1);
        })
        .on('dragenter', function (event) {
            addClass(event.target, '-drop-over');
            //console.log("8");
            //event.relatedTarget.textContent = 'I\'m in';
        })
        .on('dragleave', function (event) {
            removeClass(event.target, '-drop-over');
            //event.relatedTarget.textContent = 'Drag me…';
            //console.log("9");
        })
        .on('drop', function (event) {
            removeClass(event.target, '-drop-over');
            //event.relatedTarget.textContent = 'Dropped';

            /*AQUI CAPTURO CUANDO SUELTO EL DIV DENTRO DEL DIV QUE LE DI PERMISO*/
            //console.log(event.target.id);
            if (event.target.id == 'drop1'){
                console.log("drop1 sensor");
                console.log(tipoSensor1);
                console.log(simboloSensor1);
                console.log(valorSensor1);

                if(sensor_agregado1 == 0){
                    alerta_inteligente += tipoSensor1 + " " +simboloSensor1 + " " +valorSensor1 +" ";
                    console.log(alerta_inteligente);
                    sensor_agregado1 = 1;

                }else{
                    alert("Este sensor ya fue agregado");
                }


            }

            if (event.target.id == 'drop2'){
                console.log("drop2 operador");

                if (operador_agregado1 == 0){
                    alerta_inteligente += tipoOperador1 + " ";
                    console.log(alerta_inteligente);
                    operador_agregado1 = 1;

                }else{
                    alert("Este operador ya fue agregado");
                }
            }

            if (event.target.id == 'drop3'){
                console.log("drop3 sensor");
                console.log(tipoSensor2);
                console.log(simboloSensor2);
                console.log(valorSensor2);

                if (sensor_agregado2 == 0){
                    alerta_inteligente += tipoSensor2 + " " + simboloSensor2 + " " + valorSensor2 + " ";
                    console.log(alerta_inteligente);
                    sensor_agregado2 = 1;

                }else{
                    alert("Este sensor ya fue agregado");
                }
            }

            if (event.target.id == 'drop4'){
                console.log("drop4 operador");
                if(operador_agregado2 == 0){
                    alerta_inteligente += tipoOperador2+" ";
                    operador_agregado2 = 1;


                }else{
                    alert("Este operador ya fue agregado");
                }
            }

            if (event.target.id == 'drop5'){
                console.log("drop5 sensor");
                console.log(tipoSensor3);
                console.log(simboloSensor3);
                console.log(valorSensor3);

                if(sensor_agregado3 == 0){
                    alerta_inteligente += tipoSensor3 + " " + simboloSensor3 + " " + valorSensor3 + " ";
                    console.log(alerta_inteligente);
                    sensor_agregado3 = 1;

                }else{
                    alert("Este sensor ya fue agregado");
                }
            }

            if (event.target.id == 'drop6'){
                console.log("drop6 time");

                if (fecha_agregada == 0){
                    alerta_inteligente += fecha;
                    console.log(alerta_inteligente);
                    fecha_agregada = 1;

                }else{
                    alert("La fecha ya fue agregada");
                }
                sensor_agregado1 = 0;
                sensor_agregado2 = 0;
                sensor_agregado3 = 0;
                operador_agregado1 = 0;
                operador_agregado2 = 0;
                fecha_agregada = 0;
            }
            //console.log("10");
        });
    }

    function addClass (element, className) {
        if (element.classList) {
            //console.log("11");
            return element.classList.add(className);
        }
        else {
            //console.log("12");
            element.className += ' ' + className;
        }
    }

    function removeClass (element, className) {
        if (element.classList) {
            //console.log("13");
            return element.classList.remove(className);
        }
        else {
            //console.log("14");
            element.className = element.className.replace(new RegExp(className + ' *', 'g'), '');
        }
    }

    interact(document).on('ready', function () {
        transformProp = 'transform' in document.body.style
        ? 'transform': 'webkitTransform' in document.body.style
        ? 'webkitTransform': 'mozTransform' in document.body.style
        ? 'mozTransform': 'oTransform' in document.body.style
        ? 'oTransform': 'msTransform' in document.body.style
        ? 'msTransform': null;
    });

}(window.interact));

var nombre_alerta_inteligente ;
//guardar alerta inteligente
function guardarAlertaInteligente(){
    nombre_alerta_inteligente = document.getElementById('nombre_alerta_inteligente').value;

    var xmlhttp = new XMLHttpRequest();
    var url = "php/crearAlertaInteligente.php?nombre_alerta_inteligente="+nombre_alerta_inteligente+"&tipoSensor1="+tipoSensor1+"&simboloSensor1="+simboloSensor1+"&valorSensor1="+valorSensor1+"&tipoSensor2="+tipoSensor2+"&simboloSensor2="+simboloSensor2+"&valorSensor2="+valorSensor2+"&tipoSensor3="+tipoSensor3+"&simboloSensor3="+simboloSensor3+"&valorSensor3="+valorSensor3+"&tipoOperador2="+tipoOperador2+"&fecha="+fecha;

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

        //        for(i = 0; i < arr.length; i++) {
        //            console.log(arr[i].success);
        //        }
    }  
}//guardar alerta inteligente

//------- DRAG AND DROP ----------





//------- INDEX ----------
