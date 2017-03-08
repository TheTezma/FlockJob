$(document).ready(function() {

});

onKeyPressTextMessage = function(){
      var textArea = event.currentTarget;
      textArea.style.height = 'auto';
      textArea.style.height = textArea.scrollHeight + 5 + 'px';
};

function updateUrlParameter(url, param, value){
    var regex = new RegExp('('+param+'=)[^\&]+');
    return url.replace( regex , '$1' + value);
}

function getUrlParams(url) {
  var queryString = url.split("?")[1];
  var keyValuePairs = queryString.split("&");
  var keyValue, params = {};
  keyValuePairs.forEach(function(pair) {
    keyValue = pair.split("=");
    params[keyValue[0]] = decodeURIComponent(keyValue[1]).replace("+", " ");
});
  return params
}

function SalarySearch(value) {
  var currentParams = getUrlParams(window.location.href);

  window.location.href = "/search?job=" + currentParams['job'] + "&location=" + currentParams['location'] + "&minsal=" + value;
}

function LocationSearch(value) {
  var currentParams = getUrlParams(window.location.href);

  window.location.href = "/search?job=" + currentParams['job'] + "&location=" + value + "&minsal=" + currentParams['minsal'];
}

var nf = new Intl.NumberFormat();

var app = angular.module('FlockJob', []);

app.controller('Main', function($scope, $http) {

  $scope.AppTitle = "FlockJob";

});

app.controller('Search', function($scope, $http, $sce) {

    $scope.getHtml = function(html){
        return $sce.trustAsHtml(html);
    };

    $http.get("/api/index.php?action=userdata")
    .then(function(response) {
      $scope.Name = response.data.userdata.name;
      $scope.Email = response.data.userdata.email;
      $scope.Id = response.data.userdata.id;
      $scope.Status = response.data.status;

      if($scope.Status == "false") {
        $scope.UserSection = "<a href='/login'>Login</a> / <a href='/register'>Register</a>";
      }

      if($scope.Status == "true") {
        $scope.UserSection = "<a>" + $scope.Name + "</a>"
      }

    });

    var currentParams = getUrlParams(window.location.href);

	  $scope.sliders = [];
      for(var i=0; i<1; i++){
        $scope.sliders.push({});
      }

    $scope.salary = currentParams['minsal'];
    $scope.salaryClean = "$" + nf.format(currentParams['minsal']);

    $http.get("/api/index.php?action=jobsearch&job=" + currentParams['job'] + "&location=" + currentParams['location'] + "&minsal=" + currentParams['minsal'])
    .then(function(response) {
        $scope.Jobs = response.data.jobs;
        $scope.TopInfo = response.data.topinfo + nf.format(currentParams['minsal']);
        $scope.AppTitle = $scope.TopInfo;
        $scope.AverageSalary = response.data.avgSalary;
        $scope.JobCount = response.data.count;
    });

    $http.get("/api/index.php?action=locations&location=" + currentParams['location'])
    .then(function(response) {
        $scope.Locations = response.data.locations;
        $scope.Location = response.data.searchLocation;
    });

});

app.controller('Advertise', function($scope, $http) {



});



