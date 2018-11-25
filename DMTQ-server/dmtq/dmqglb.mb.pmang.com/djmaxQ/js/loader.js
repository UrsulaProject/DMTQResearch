var myScript = document.getElementById('loader');
var version = myScript.getAttribute('src').split('=');
version = version[1];
function includeJsOld(jsFilePath, version) {
    var js = document.createElement('script');
    js.type = 'text/javascript';
    js.src = jsFilePath + '?v=' + version;
    document.body.appendChild(js);
}
function includeJs(url, version) {
    var ajax = new XMLHttpRequest();
    ajax.open( 'GET', url + '?v=' + version, false );
    ajax.onreadystatechange = function () {
        var script = ajax.response || ajax.responseText;
        if (ajax.readyState === 4) {
            switch(ajax.status) {
                case 200:
                    eval.apply( window, [script] );
                    break;
                default:
            }
        }
    };
    ajax.send(null);
}
function includeCss(url, version) {
    var head  = document.getElementsByTagName('head')[0];
    var link  = document.createElement('link');
    link.rel  = 'stylesheet';
    link.type = 'text/css';
    link.href = url + '?v=' + version;
    link.media = 'all';
    head.appendChild(link);
}
includeCss('css/main.css', version);
includeJs('js/jquery-1.8.2.min.js', version);
includeJs('bower_components/jquery.scrollTo/jquery.scrollTo.min.js')
includeJs('bower_components/angular/angular.min.js', version);
includeJs('bower_components/angular-route/angular-route.min.js', version);
includeJs('bower_components/angular-toArrayFilter/toArrayFilter.js', version);
includeJs('js/main.js', version);
includeJs('js/mainController.js', version);
includeJs('js/scoreController.js', version);