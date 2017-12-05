angular.module('app.controllers')
    .controller('ClientListIdController',
        ['$scope','$routeParams', 'Client',
            function ($scope, $routeParams, Client) {
                $scope.client = Client.get({id: $routeParams.id});
            }]);