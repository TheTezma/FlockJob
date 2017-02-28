$(document).ready(function() {

});

onKeyPressTextMessage = function(){
      var textArea = event.currentTarget;
      textArea.style.height = 'auto';
      textArea.style.height = textArea.scrollHeight + 5 + 'px';
};

var app = angular.module('FlockJob', []);

app.controller('Main', function($scope, $http) {
    $http.get("/i/jobs")
    .then(function(response) {
        $scope.Jobs = response.data.jobs;
        $scope.AverageSalary = response.data.avgSalary;
        $scope.JobCount = response.data.count;
    });
});

// app.controller('AverageSalary', function($scope, $http) {
//     $http.get("/i/jobs")
//     .then(function(response) {
//         $scope.Response = response.data;
//     });
// });

