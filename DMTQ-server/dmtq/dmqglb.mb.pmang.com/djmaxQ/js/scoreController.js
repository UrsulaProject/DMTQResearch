window.app.controller('ScoreController', ['$scope', '$http', '$location', '$filter', '$window', function($scope, $http, $location, $filter, $window) {
	var currentDomain = function () {
		var url = window.location.href
		var arr = url.split('/');
		return arr[0] + '//' + arr[2]
	};
    var getParameterByName = function (name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    };
	$window.document.getElementById('myUrl').value = 'https://icentral.konmai.co/djmaxQ?userId=' + getParameterByName('userId');
    $scope.levelList = ['easy', 'normal', 'hard', 'expert'];
    $http({url: currentDomain() + '/djmaxQ/songList.php?t=' + Math.floor(Date.now() / 1000), method: 'POST'}).then(function (response) {
        window.songList = $scope.songList = response.data;
    });
    $http({url: currentDomain() + '/djmaxQ/userScore.php?t=' + Math.floor(Date.now() / 1000), method: 'POST', data: $.param({userId: getParameterByName('userId')})}).then(function (response) {
        window.scoreList = $scope.scoreList = response.data;
    });
    $scope.showLevelOn = function (level, index) {
        return level >= index;
    };
    $scope.showScore = function (score, index) {
        var scoreString = '0000000' + score.toString();
        scoreString = scoreString.substr(-7);
        return scoreString.substr(index - 1, 1)
    }
    $scope.showRate = function (rate, index) {
        var scoreString = rate.toString();
        return scoreString.substr(index - 1, 1)
    }
}]);