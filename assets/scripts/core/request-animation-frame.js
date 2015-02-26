
/**
 * core/request-animation-frame.js
 *
 * REQUEST ANIMATION FRAME
 */

window.requestAnimationFrame = (function() {

    return window.requestAnimationFrame       ||
           window.webkitRequestAnimationFrame ||
           window.mozRequestAnimationFrame    ||

        function(callback) {

            window.setTimeout(callback, 1000 / 60);

    	};

})();