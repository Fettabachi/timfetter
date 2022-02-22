/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _css_style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../css/style.scss */ "./css/style.scss");
 // mobile menu button
// var hamburger = document.querySelector(".hamburger");
// hamburger.addEventListener("click", function () {
//     hamburger.classList.toggle("is-active");
// });
// check for touch devices

var supportsTouch = "ontouchstart" in window || navigator.msMaxTouchPoints;

if (supportsTouch) {
  document.body.className += " touch-device";
}
/*!
* Layout Engine v0.10.3
*
* Copyright (c) 2015-2019 Matt Stow
* http://mattstow.com
* Licensed under the MIT license
*/


;

var layoutEngine = function () {
  var h = document.documentElement,
      n = h.style,
      o = " vendor-",
      c = "edge",
      k = "ie",
      i = "khtml",
      g = "mozilla",
      m = "opera",
      a = "webkit",
      q = " browser-",
      r = "android",
      j = "chrome",
      e = "safari",
      d = e + "-ios",
      b = "wiiu",
      f = o,
      p;

  if ("msScrollLimit" in n || "behavior" in n) {
    if ("msTextSizeAdjust" in n && !("msFlex" in n)) {
      f += c;
      p = {
        vendor: c
      };
    } else {
      f += k + o + k;
      p = {
        vendor: k
      };

      if ("msImeAlign" in n) {
        f += "-11";
        p.version = 11;
      } else {
        if ("msUserSelect" in n) {
          f += "-10";
          p.version = 10;
        } else {
          if ("fill" in n) {
            f += "-9";
            p.version = 9;
          } else {
            if ("widows" in n) {
              f += "-8";
              p.version = 8;
            } else {
              f += "-7";
              p.version = 7;
            }
          }
        }
      }
    }
  } else {
    if ("MozAppearance" in n) {
      f += g;
      p = {
        vendor: g
      };
    } else {
      if ("WebkitAppearance" in n) {
        f += a;
        var l = navigator.userAgent;
        p = {
          vendor: a
        };

        if (!!window.chrome || l.indexOf("OPR") >= 0 || l.indexOf("wv") >= 0) {
          f += q + j;
          p.browser = j;
        } else {
          if ("webkitDashboardRegion" in n) {
            f += q + e;
            p.browser = e;
          } else {
            if ("webkitOverflowScrolling" in n) {
              f += q + d;
              p.browser = d;
            } else {
              if (l.indexOf("Android") >= 0) {
                f += q + r;
                p.browser = r;
              } else {
                if (!!window.wiiu) {
                  f += q + b;
                  p.browser = b;
                }
              }
            }
          }
        }
      } else {
        if ("OLink" in n || !!window.opera) {
          f += m;
          p = {
            vendor: m
          };

          if ("OMiniFold" in n) {
            f += "-mini";
            p.browser = "mini";
          }
        } else {
          if ("KhtmlUserInput" in n) {
            f += i;
            p = {
              vendor: i
            };
          } else {
            return false;
          }
        }
      }
    }
  }

  h.className += f;
  return p;
}();
/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens. (See header code)
 */


(function () {
  var container, button, menu;
  container = document.getElementById('site-navigation');
  if (!container) return;
  button = container.getElementsByTagName('label')[0];
  if ('undefined' === typeof button) return;
  menu = container.getElementsByTagName('ul')[0]; // Hide menu toggle button if menu is empty and return early.

  if ('undefined' === typeof menu) {
    button.style.display = 'none';
    return;
  }

  if (-1 === menu.className.indexOf('nav-menu')) menu.className += ' nav-menu';

  button.onclick = function () {
    if (-1 !== container.className.indexOf('toggled')) container.className = container.className.replace(' toggled', '');else container.className += ' toggled';
  };
})();
/**
 * skip-link-focus-fix.js
 *
 * Correctly bypasses navigation for accessible screens. (See header code)
 */


(function () {
  var is_webkit = navigator.userAgent.toLowerCase().indexOf('webkit') > -1,
      is_opera = navigator.userAgent.toLowerCase().indexOf('opera') > -1,
      is_ie = navigator.userAgent.toLowerCase().indexOf('msie') > -1;

  if ((is_webkit || is_opera || is_ie) && 'undefined' !== typeof document.getElementById) {
    var eventMethod = window.addEventListener ? 'addEventListener' : 'attachEvent';
    window[eventMethod]('hashchange', function () {
      var element = document.getElementById(location.hash.substring(1));

      if (element) {
        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) element.tabIndex = -1;
        element.focus();
      }
    }, false);
  }
})(); // Copyright 2016 - ScientiaMobile, Inc., Reston, VA
// WURFL Device Detection
// Terms of service:
// http://web.wurfl.io/license


eval(function (p, a, c, k, e, d) {
  e = function (c) {
    return c;
  };

  if (!''.replace(/^/, String)) {
    while (c--) {
      d[c] = k[c] || c;
    }

    k = [function (e) {
      return d[e];
    }];

    e = function () {
      return '\\w+';
    };

    c = 1;
  }

  ;

  while (c--) {
    if (k[c]) {
      p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
    }
  }

  return p;
}('8 7={"6":5,"4":"3 2","1":"0"};', 9, 9, 'Desktop|form_factor|Chrome|Google|complete_device_name|false|is_mobile|WURFL|var'.split('|'), 0, {})); // Allow new JS and CSS to load in browser without a traditional page refresh

if (false) {}

/***/ }),

/***/ "./css/style.scss":
/*!************************!*\
  !*** ./css/style.scss ***!
  \************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunktim_fetter_theme"] = self["webpackChunktim_fetter_theme"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], function() { return __webpack_require__("./src/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map