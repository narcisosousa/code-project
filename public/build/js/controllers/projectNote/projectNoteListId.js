angular.module('app.controllers')
    .controller('ProjectNoteListIdController', ['$scope', '$routeParams', 'ProjectNote',
        function ($scope, $routeParams, ProjectNote) {
            $scope.projectNote = ProjectNote.get({id: $routeParams.id, idNote: $routeParams.idNote});
        }]);