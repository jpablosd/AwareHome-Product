angular.module( 'awarehome',[])                
    .controller('controladorInicio', ['$scope', function($scope){
        Materialize.toast('BIENVENIDO!', 4000);
        $scope.verDatos = function(){
            console.log("hola");
        }     
        $scope.crearAlerta = function(){
        }
    }])

