window.app = angular.module('DMTQ', ['ngRoute', 'angular-toArrayFilter'])
.config(['$routeProvider', 
    function ($routeProvider) {
        var version = window.document.getElementById('loader').getAttribute('src').split('=');
        version = version[1];
        $routeProvider
        .when('/landing', {
            templateUrl: 'views/score.html?v=' + version
        }).otherwise({
            redirectTo : '/landing'
        });
    }
]).directive("bnLazySrc", function( $window, $document ) {
    var realScrollTop = function () {
        return Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
    };
    var lazyLoader = (function() {
        var images = [];
        var renderTimer = null;
        var renderDelay = 100;
        var win = $('body');
        var doc = $document;
        var documentHeight = doc.height();
        var documentTimer = null;
        var documentDelay = 500;
        var isWatchingWindow = false;
        function addImage( image ) {
            images.push( image );
            if ( ! renderTimer ) startRenderTimer();
            if ( ! isWatchingWindow ) startWatchingWindow();
        }
        function removeImage( image ) {
            for ( var i = 0 ; i < images.length ; i++ ) {
                if ( images[ i ] === image ) {
                    images.splice( i, 1 );
                    break;
                }
            }
            if ( ! images.length ) {
                clearRenderTimer();
                stopWatchingWindow();
            }
        }
        function checkDocumentHeight() {
            if ( renderTimer ) return;
            var currentDocumentHeight = realScrollTop();
            if (currentDocumentHeight === documentHeight ) return;
            documentHeight = currentDocumentHeight;
            startRenderTimer();
        }
        function checkImages() {
            var visible = [];
            var hidden = [];
            var windowHeight = screen.height;
            var scrollTop = realScrollTop();
            var topFoldOffset = scrollTop;
            var bottomFoldOffset = topFoldOffset + windowHeight;
            for ( var i = 0 ; i < images.length ; i++ ) {
                var image = images[ i ];
                if ( image.isVisible( topFoldOffset, bottomFoldOffset ) ) {
                    visible.push( image );
                } else {
                    hidden.push( image );
                }
            }
            for ( var i = 0 ; i < visible.length ; i++ ) {
                visible[ i ].render();
            }
            images = hidden;
            clearRenderTimer();
            if ( ! images.length ) {
                stopWatchingWindow();
            }
        }
        function clearRenderTimer() {
            clearTimeout( renderTimer );
            renderTimer = null;
        }
        function startRenderTimer() {
            renderTimer = setTimeout( checkImages, renderDelay );
        }
        function startWatchingWindow() {
            isWatchingWindow = true;
            win.on( "resize.bnLazySrc", windowChanged );
            win.on( "scroll.bnLazySrc", windowChanged );
            documentTimer = setInterval( checkDocumentHeight, documentDelay );
        }
        function stopWatchingWindow() {
            isWatchingWindow = false;
            win.off( "resize.bnLazySrc" );
            win.off( "scroll.bnLazySrc" );
            clearInterval( documentTimer );
        }
        function windowChanged() {
            if ( ! renderTimer ) startRenderTimer();
        }
        return({
            addImage: addImage,
            removeImage: removeImage
        });
    })();
    function LazyImage( element ) {
        var source = null;
        var isRendered = false;
        var height = null;
        function isVisible( topFoldOffset, bottomFoldOffset ) {
            if ( ! element.is( ":visible" ) ) return( false );
            if ( height === null ) {
                height = element.height();
            }
            var top = element.offset().top;
            var bottom = ( top + height );
            console.log(top,  bottomFoldOffset, topFoldOffset, (
                    (
                        ( top <= bottomFoldOffset ) &&
                        ( top >= topFoldOffset )
                    )
                ||
                    (
                        ( bottom <= bottomFoldOffset ) &&
                        ( bottom >= topFoldOffset )
                    )
                ||
                    (
                        ( top <= topFoldOffset ) &&
                        ( bottom >= bottomFoldOffset )
                    )
            ));
            return (
                    (
                        ( top <= bottomFoldOffset ) &&
                        ( top >= topFoldOffset )
                    )
                ||
                    (
                        ( bottom <= bottomFoldOffset ) &&
                        ( bottom >= topFoldOffset )
                    )
                ||
                    (
                        ( top <= topFoldOffset ) &&
                        ( bottom >= bottomFoldOffset )
                    )
            );
        }
        function render() {
            isRendered = true;
            renderSource();
        }
        function setSource( newSource ) {
            source = newSource;
            if ( isRendered ) renderSource();
        }
        function renderSource() {
            element[ 0 ].src = source;
        }
        return({
            isVisible: isVisible,
            render: render,
            setSource: setSource
        });
    }
    function link( $scope, element, attributes ) {
        var lazyImage = new LazyImage( element );
        lazyLoader.addImage( lazyImage );
        attributes.$observe(
            "bnLazySrc",
            function( newSource ) {
                lazyImage.setSource( newSource );
            }
        );
        $scope.$on(
            "$destroy",
            function() {
                lazyLoader.removeImage( lazyImage );
            }
        );
    }
    return({
        link: link,
        restrict: "A"
    });
});