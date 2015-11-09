
var awarehome =  angular.module( 'awarehome',['ngRoute']); 

awarehome.controller('controladorInicio', ['$scope', function($scope){
    Materialize.toast('BIENVENIDO!', 4000);
//    $scope.verDatos = function(){
//        console.log("hola");
//    }     
//    $scope.crearAlerta = function(){
//    }
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
        templateUrl: 'views/crearAlertaCompuesta.html' 
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
