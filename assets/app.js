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

var nf = new Intl.NumberFormat();

var app = angular.module('FlockJob', []);

app.controller('Main', function($scope, $http) {

    var currentParams = getUrlParams(window.location.href);

	  $scope.sliders = [];
      for(var i=0; i<1; i++){
        $scope.sliders.push({});
      }

    $scope.salary = currentParams['minsal'];
    $scope.salaryClean = "$" + nf.format(currentParams['minsal']);

    $http.get("/api/index.php?action=jobsearch&job=" + currentParams['job'] + "&location=1&minsal=" + currentParams['minsal'])
    .then(function(response) {
        $scope.Jobs = response.data.jobs;
        $scope.TopInfo = response.data.topinfo + nf.format(currentParams['minsal']);
        $scope.AppTitle = $scope.TopInfo;
        $scope.AverageSalary = response.data.avgSalary;
        $scope.JobCount = response.data.count;
    });
});

