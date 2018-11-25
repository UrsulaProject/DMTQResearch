<!DOCTYPE html>
<html ng-app="DMTQ">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DJMAX TECHNIKA Q</title>
	<script>if (location.protocol != 'https:'){location.href = 'https:' + window.location.href.substring(window.location.protocol.length);}</script>
    <script id="loader" src="js/loader.js?v=39"></script>
	<script>
		function copy() {
		  var input = document.createElement('input');

		  input.style.position = 'fixed';
		  input.style.left = '0';
		  input.style.top = '0';
		  input.style.opacity = '0';
		  input.value = document.getElementById('myUrl').value;

		  document.body.appendChild(input);
		  input.focus();
		  input.select();

		  document.execCommand('copy');
		  document.body.removeChild(input);
		  alert('Copied');
		}
	</script>
</head>
<body ng-controller="MainController">
    <div class="header">
        <img src="image/header.png" />
        <br />
		<input id="myUrl" type="text" value="" disabled="disabled"/><button id="copy" onclick="copy()">Copy</button>
        <select ng-model="currentLine" ng-options="line.value as line.name for line in lineList">
</select>
    </div>
    <ul class="list" ng-view="" ng-controller="ScoreController"></ul>
</body>
</html>