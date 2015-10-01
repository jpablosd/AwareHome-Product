            var awarehome =  angular.module( 'awarehome',['ngRoute']); 

            awarehome.controller('controladorInicio', ['$scope', function($scope){
                Materialize.toast('BIENVENIDO!', 4000);
                $scope.verDatos = function(){
                    console.log("hola");
                }     
                $scope.crearAlerta = function(){
                }
            }]);