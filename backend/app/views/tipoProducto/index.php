<?php  include("../header.php");?>
 <script>
 var app = angular.module('tipoProducto', ['ngRoute']);
 angular.module('tipoProducto', ['ui.bootstrap']);
 function controller($scope, $modal, $log , $http)
 {
    $scope.tipoProducto = [];
    $scope.initialTipoProducto =[]
    angular.element(document).ready(function () {
    	$http.post('./../../controllers/tipoProducto/tipoProductoFunctions.php', '{"action":"query"}').success(function(data){
            $scope.initialTipoProducto = data;
         });
    });

    $scope.alerts = [
      ];

      $scope.addAlert = function() {
        $scope.alerts.push({msg: 'Another alert!'});
      };

      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };

    $scope.deleteRol = function (tipoProducto){
        $scope.alerts = [];
        var index = $scope.initialTipoProducto.indexOf(tipoProducto);
         $scope.initialTipoProducto.splice(index,1);
         
         $http.post('./../../controllers/tipoProducto/tipoProductoFunctions.php','{"action":"delete","tipoProducto":'+JSON.stringify(tipoProducto)+'}').success(function(data){
            $scope.alerts.push({type: 'success', msg: 'Tipo De Producto  Exitosamente Eliminado' });
         });
    }
    $scope.showUpdateDialog = function (data,size){
    	var modalInstanceUpdate = $modal.open({
            templateUrl: 'myModalContent.html',
            controller: ModalInstanceUpdateCtrl,
            size: size,
            resolve: {
                action: function(){
                return "Modificar";
            }, 
                tipoProducto: function () {
              		return data;
          		}
          	}
        });
        modalInstanceUpdate.result.then(function (tipoProducto) {
            $scope.alerts = [];
            $http.post('./../../controllers/tipoProducto/tipoProductoFunctions.php', '{"action":"update","tipoProducto":'+JSON.stringify(tipoProducto)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Tipo de Producto Modificado Exitosamente' });
             });
             
        }, function () {
        });
    } 
    $scope.open = function (size) {
        var modalInstanceOpen = $modal.open({
          templateUrl: 'myModalContent.html',
          controller: ModalInstanceAddCtrl,
          size: size,
          resolve: {
            action: function(){
                return "Insertar"
            }, 
          	tipoProducto: function () {
            		return [];
        		}
        	}
        });

        modalInstanceOpen.result.then(function (tipoProducto) {
                $scope.alerts = [];
                $http.post('./../../controllers/tipoProducto/tipoProductoFunctions.php', '{"action":"insert","tipoProductoName":"'+tipoProducto.nombre+'"}').success(function(data){
                $scope.initialTipoProducto.push(data[0]);
                $scope.alerts.push({type: 'success', msg: 'Tipo de Producto Agregado Exitosamente' });
             });             
        }, function () {});
    };
        

 }
 var ModalInstanceAddCtrl = function ($scope, $modalInstance,tipoProducto,action) {
    $scope.tipoProducto = tipoProducto;
    $scope.action = action;
    $scope.ok = function (tipoProducto) {
        $modalInstance.close(tipoProducto);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};
var ModalInstanceUpdateCtrl = function ($scope, $modalInstance,tipoProducto,action) {
    $scope.tipoProducto = tipoProducto;
    $scope.action = action;
    $scope.ok = function (tipoProducto) {
        $modalInstance.close(tipoProducto);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};
 </script>
<div ng-app="tipoProducto">
	<div ng-controller="controller">
		<div class="row">
              <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
		    <div class="col-lg-12">
		        <h1 class="page-header">Tipos de Producto</h1>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tipos De Producto actuales
                        <button class="btn btn-default pull-right btn-xs" ng-disabled="true"  ng-click="open()">Agregar Tipo de Producto</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Tipo de Producto</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="initialTipoProducto.length > 0">
                                    <tr ng-repeat="data in initialTipoProducto" class="odd gradeX"> 
                                        <td>{{data.id_tipo_producto}}</td>
                                        <td>{{data.nombre}}</td>
                                        <td>
                                        	<div class="btn-group">
											  <button ng-disabled="true" type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" tipoProducto="menu">
											    <li><a   href="#" ng-click="showUpdateDialog(data)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
											    <li><a   href="#" ng-click="deleteRol(data)"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
											  </ul>
											</div>
                                    	</td>    
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>   
            </div>      
        </div>
        <script type="text/ng-template" id="myModalContent.html">
            <div class="modal-header">
                <h3 class="modal-title"¨>{{action}} Tipo De Producto</h3>
            </div>
            <div class="modal-body">
                <form tipoProductoe="form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" ng-model="tipoProducto.nombre" id="exampleInputEmail1" placeholder="Nombre del Tipo de Producto"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" ng-click="ok(tipoProducto)">OK</button>
                <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
            </div>
        </script>
	</div>
</div>
<?php  include("../footer.php"); ?>

