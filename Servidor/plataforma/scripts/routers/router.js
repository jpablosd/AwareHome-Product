angular.module('awarehome'  , ['ngRoute'])
.config(['$routeProvider', function($routeProvider){
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
    when('/!',{
       templateUrl: 'views/404.html' 
    }).
    otherwise({
        redirecTo: '/',
        templateUrl: 'app.html#/verDatos'
    })
}])