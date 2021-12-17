import "../css/style.css";

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
;var layoutEngine=(function(){var h=document.documentElement,n=h.style,o=" vendor-",c="edge",k="ie",i="khtml",g="mozilla",m="opera",a="webkit",q=" browser-",r="android",j="chrome",e="safari",d=e+"-ios",b="wiiu",f=o,p;if("msScrollLimit" in n||"behavior" in n){if("msTextSizeAdjust" in n&&!("msFlex" in n)){f+=c;p={vendor:c}}else{f+=k+o+k;p={vendor:k};if("msImeAlign" in n){f+="-11";p.version=11}else{if("msUserSelect" in n){f+="-10";p.version=10}else{if("fill" in n){f+="-9";p.version=9}else{if("widows" in n){f+="-8";p.version=8}else{f+="-7";p.version=7}}}}}}else{if("MozAppearance" in n){f+=g;p={vendor:g}}else{if("WebkitAppearance" in n){f+=a;var l=navigator.userAgent;p={vendor:a};if(!!window.chrome||l.indexOf("OPR")>=0||l.indexOf("wv")>=0){f+=q+j;p.browser=j}else{if("webkitDashboardRegion" in n){f+=q+e;p.browser=e}else{if("webkitOverflowScrolling" in n){f+=q+d;p.browser=d}else{if(l.indexOf("Android")>=0){f+=q+r;p.browser=r}else{if(!!window.wiiu){f+=q+b;p.browser=b}}}}}}else{if("OLink" in n||!!window.opera){f+=m;p={vendor:m};if("OMiniFold" in n){f+="-mini";p.browser="mini"}}else{if("KhtmlUserInput" in n){f+=i;p={vendor:i}}else{return false}}}}}h.className+=f;return p})();


/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens. (See header code)
 */
 ( function() {
	var container, button, menu;

	container = document.getElementById( 'site-navigation' );
	if ( ! container )
		return;

	button = container.getElementsByTagName( 'label' )[0];
	if ( 'undefined' === typeof button )
		return;

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( -1 === menu.className.indexOf( 'nav-menu' ) )
		menu.className += ' nav-menu';

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) )
			container.className = container.className.replace( ' toggled', '' );
		else
			container.className += ' toggled';
	};
} )();


/**
 * skip-link-focus-fix.js
 *
 * Correctly bypasses navigation for accessible screens. (See header code)
 */
 ( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && 'undefined' !== typeof( document.getElementById ) ) {
		var eventMethod = ( window.addEventListener ) ? 'addEventListener' : 'attachEvent';
		window[ eventMethod ]( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
					element.tabIndex = -1;

				element.focus();
			}
		}, false );
	}
})();


// Copyright 2016 - ScientiaMobile, Inc., Reston, VA
// WURFL Device Detection
// Terms of service:
// http://web.wurfl.io/license

eval(function(p,a,c,k,e,d){e=function(c){return c};if(!''.replace(/^/,String)){while(c--){d[c]=k[c]||c}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('8 7={"6":5,"4":"3 2","1":"0"};',9,9,'Desktop|form_factor|Chrome|Google|complete_device_name|false|is_mobile|WURFL|var'.split('|'),0,{}))



// Allow new JS and CSS to load in browser without a traditional page refresh
if (module.hot) {
    module.hot.accept();
}
