$(document).ready(function() {

});

onKeyPressTextMessage = function(){
      var textArea = event.currentTarget;
      textArea.style.height = 'auto';
      textArea.style.height = textArea.scrollHeight + 5 + 'px';
};

var app = angular.module('FlockJob', []);

app.controller('Main', function($scope, $http) {
    $http.get("/Other-Sites/UserAppBackend/?action=job")
    .then(function(response) {
        $scope.Response = response.data;
    });
});