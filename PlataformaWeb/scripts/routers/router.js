            var awarehome =  angular.module( 'awarehome',['ngRoute']); 

awarehome.config(['$routeProvider', function($routeProvider){
    $routeProvider.
    when('/',{
        templateUrl: 'views/datos.html' 
    }).
    when('/verDatos', {
        templateUrl: 'views/datos.html'
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
    otherwise({
        redirecTo: '/',
        templateUrl: 'app.html#/verDatos'
    })
}]);