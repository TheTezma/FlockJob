$(document).ready(function() {

});

$(window).on('load', function() { // makes sure the whole site is loaded 
  $('#status').delay(1000).fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(1000).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(1000).css({'overflow':'visible'});
})

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

    var currentParams = getUrlParams(window.location.href);

	  $scope.sliders = [];
      for(var i=0; i<1; i++){
        $scope.sliders.push({});
      }

    $scope.salary = currentParams['minsal'];
    $scope.salaryClean = "$" + nf.format(currentParams['minsal']);
    $scope.SearchTerm = currentParams['job'];

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

app.controller('Profile', function($scope, $http, $sce) {

    

});

app.controller('Advertise', function($scope, $http) {



});

 app.filter('strLimit', ['$filter', function($filter) {
   return function(input, beginlimit, endlimit) {
      if (! input) return;
      if (input.length <= beginlimit + endlimit) {
          return input;
      }

      return $filter('limitTo')(input, beginlimit) + '...' + $filter('limitTo')(input, -endlimit) ;
   };
}]);

