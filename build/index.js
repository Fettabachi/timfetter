/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _css_style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../css/style.scss */ "./css/style.scss");
/* harmony import */ var _modules_HandleOnPageLinks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/HandleOnPageLinks */ "./src/modules/HandleOnPageLinks.js");
/* harmony import */ var _modules_CheckIsTouchDevice__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/CheckIsTouchDevice */ "./src/modules/CheckIsTouchDevice.js");
/* harmony import */ var _modules_CheckBrowser__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modules/CheckBrowser */ "./src/modules/CheckBrowser.js");
/* harmony import */ var _modules_SkipLinkFocusFix__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./modules/SkipLinkFocusFix */ "./src/modules/SkipLinkFocusFix.js");





const handleOnPageLinks = new _modules_HandleOnPageLinks__WEBPACK_IMPORTED_MODULE_1__["default"]();
const checkIsTouchDevice = new _modules_CheckIsTouchDevice__WEBPACK_IMPORTED_MODULE_2__["default"]();
const checkBrowser = new _modules_CheckBrowser__WEBPACK_IMPORTED_MODULE_3__["default"]();
const skipLinkFocusFix = new _modules_SkipLinkFocusFix__WEBPACK_IMPORTED_MODULE_4__["default"]();

// Allow new JS and CSS to load in browser without a traditional page refresh
if (false) {}

/***/ }),

/***/ "./src/modules/CheckBrowser.js":
/*!*************************************!*\
  !*** ./src/modules/CheckBrowser.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class CheckBrowser {
  constructor() {
    this.checkBrowser();
  }
  checkBrowser() {
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
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CheckBrowser);

/***/ }),

/***/ "./src/modules/CheckIsTouchDevice.js":
/*!*******************************************!*\
  !*** ./src/modules/CheckIsTouchDevice.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class CheckIsTouchDevice {
  constructor() {
    this.checkIsTouchDevice();
  }
  checkIsTouchDevice() {
    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Browser_detection_using_the_user_agent
    let hasTouchScreen = false;
    if ("maxTouchPoints" in navigator) {
      hasTouchScreen = navigator.maxTouchPoints > 0;
    } else if ("msMaxTouchPoints" in navigator) {
      hasTouchScreen = navigator.msMaxTouchPoints > 0;
    } else {
      const mQ = matchMedia?.("(pointer:coarse)");
      if (mQ?.media === "(pointer:coarse)") {
        hasTouchScreen = !!mQ.matches;
      } else if ("orientation" in window) {
        hasTouchScreen = true; // deprecated, but good fallback
      } else {
        // Only as a last resort, fall back to user agent sniffing
        const UA = navigator.userAgent;
        hasTouchScreen = /\b(BlackBerry|webOS|iPhone|IEMobile)\b/i.test(UA) || /\b(Android|Windows Phone|iPad|iPod)\b/i.test(UA);
      }
    }
    if (hasTouchScreen) {
      document.body.classList.add("is-touch-device");
    }
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CheckIsTouchDevice);

/***/ }),

/***/ "./src/modules/HandleOnPageLinks.js":
/*!******************************************!*\
  !*** ./src/modules/HandleOnPageLinks.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class HandleOnPageLinks {
  constructor() {
    this.handleOnPageLinks();
  }
  handleOnPageLinks() {
    (function ($) {
      // jQuery( document ).ready( function( $ ) {

      $('.menu-toggle, #menu-main-menu li a').click(function () {
        var menu = $('#menu-main-menu');
        if (menu.hasClass('mobile-menu')) {
          menu.removeClass('mobile-menu');
        } else {
          menu.addClass('mobile-menu');
        }
      });
      if ($('body').hasClass('home')) {
        $('.site-logo, .head-p-name').click(function (e) {
          e.preventDefault();
          $('html, body').animate({
            scrollTop: 0
          }, '500');
        });
      }
      $(function () {
        var headerHeight = $("#masthead").height();
        $('a[href*="#"]:not([href="#"])').on("click", function () {
          if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
              $('html, body').animate({
                scrollTop: target.offset().top - headerHeight
              }, 300, 'linear');
              return false;
            }
          }
        });
      });

      // });        
    })(jQuery);
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (HandleOnPageLinks);

/***/ }),

/***/ "./src/modules/SkipLinkFocusFix.js":
/*!*****************************************!*\
  !*** ./src/modules/SkipLinkFocusFix.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class SkipLinkFocusFix {
  constructor() {
    this.skipLinkFocusFix();
  }
  skipLinkFocusFix() {
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
    })();
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (SkipLinkFocusFix);

/***/ }),

/***/ "./css/style.scss":
/*!************************!*\
  !*** ./css/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

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
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
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
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
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
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
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
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
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
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map