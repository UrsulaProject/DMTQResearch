window.app.controller('MainController', ['$scope', '$http', '$route', '$location', '$window', function($scope, $http, $route, $location, $window) {
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    $scope.version = $window.document.getElementById('loader').getAttribute('src').split('=');
    $scope.version = $scope.version[1];
    $scope.lineList = [
        {name : '2 Lines', value : 2},
        {name : '3 Lines', value : 3},
        {name : '4 Lines', value : 4}
    ];
    $scope.currentLine = 4;
}]);