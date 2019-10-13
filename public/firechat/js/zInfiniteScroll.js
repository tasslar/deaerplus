(function (ng) {
    'use strict';
    var module = ng.module('zInfiniteScroll', []);

    module.directive('zInfiniteScroll', ['$timeout', '$document', function ($timeout, $document) {
        return {
            restrict: 'A',
            link: function link($scope, $element, $attr) {
                var lengthThreshold = $attr.scrollThreshold || 50,
                    timeThreshold   = $attr.timeThreshold || 200,
                    handler         = $scope.$eval($attr.zInfiniteScroll),
                    bodyScroll      = $scope.$eval($attr.bodyScroll) === true ? true : false,
                    inverse         = $scope.$eval($attr.inverse) === true ? true : false,
                    promise         = null,
                    lastScrolled    = 9999,
                    element         = $element[0],
                    scrollEvent,
                    isDestorying = false;

                $scope.$on('$destroy', function handleDestroyEvent() {
                    isDestorying = true;
                    $document.off('scroll', scrollEvent);
                });

                lengthThreshold = parseInt(lengthThreshold, 10);
                timeThreshold = parseInt(timeThreshold, 10);

                // if user not setting the handle function, it would giving default one
                if (!handler || !ng.isFunction(handler)) {
                    handler = ng.noop;
                }

                // -1 means your callback function decide when to scroll
                if (inverse) {
                    scrollEvent = scrollUntilDataReady;
                } else {
                    scrollEvent = scrollUntilTimeout;
                }

                // if element doesn't want to set height, this would be helpful.
                if (bodyScroll) {
                    $document.on('scroll', scrollEvent);
                    element = $document[0].documentElement;
                } else {
                    $element.on('scroll', scrollEvent);
                }

                // it will be scrolled once your data loaded
                function scrollUntilDataReady() {
                    if (isDestorying) return;

                    var scrolled = calculateBarScrolled();
                    // if we have reached the threshold and we scroll up
                    if (scrolled < lengthThreshold && (scrolled - lastScrolled) < 0 && (element.scrollHeight >= element.clientHeight)) {
                        var originalHeight = element.scrollHeight;
                        var handlerCallback = $scope.$apply(handler);
                        if (handlerCallback && typeof handlerCallback.then === 'function') {
                            handlerCallback.then(function() {
                                $timeout(function() {
                                    element.scrollTop = element.scrollHeight - originalHeight;
                                });
                            });
                        }
                    }
                    lastScrolled = scrolled;
                }

                function scrollUntilTimeout() {
                    if (isDestorying) return;
                    var scrolled = calculateBarScrolled();

                    // if we have reached the threshold and we scroll down
                    if (scrolled < lengthThreshold && (scrolled - lastScrolled) < 0 && (element.scrollHeight >= element.clientHeight)) {
                        // if there is already a timer running which has no expired yet we have to cancel it and restart the timer
                        if (promise !== null) {
                            $timeout.cancel(promise);
                        }
                        promise = $timeout(function () {
                            handler();
                            promise = null;
                        }, timeThreshold);
                    }
                    lastScrolled = scrolled;
                }

                // for compatibility for all browser
                function calculateBarScrolled() {
                    var scrollTop;
                    if (bodyScroll) {
                        scrollTop = $document[0].documentElement.scrollTop || $document[0].body.scrollTop;
                    } else {
                        scrollTop = element.scrollTop;
                    }
                    return inverse ? scrollTop : element.scrollHeight - (element.clientHeight + scrollTop);
                }
            }
        };
    }]);
})(angular);
