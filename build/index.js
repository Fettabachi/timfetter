(()=>{"use strict";var e,t={548:()=>{var e=['a[href]:not([tabindex^="-"])','area[href]:not([tabindex^="-"])','input:not([type="hidden"]):not([type="radio"]):not([disabled]):not([tabindex^="-"])','input[type="radio"]:not([disabled]):not([tabindex^="-"])','select:not([disabled]):not([tabindex^="-"])','textarea:not([disabled]):not([tabindex^="-"])','button:not([disabled]):not([tabindex^="-"])','iframe:not([tabindex^="-"])','audio[controls]:not([tabindex^="-"])','video[controls]:not([tabindex^="-"])','[contenteditable]:not([tabindex^="-"])','[tabindex]:not([tabindex^="-"])'];function t(e){this._show=this.show.bind(this),this._hide=this.hide.bind(this),this._maintainFocus=this._maintainFocus.bind(this),this._bindKeypress=this._bindKeypress.bind(this),this.$el=e,this.shown=!1,this._id=this.$el.getAttribute("data-a11y-dialog")||this.$el.id,this._previouslyFocused=null,this._listeners={},this.create()}function i(e,t){return i=(t||document).querySelectorAll(e),Array.prototype.slice.call(i);var i}function n(e){(e.querySelector("[autofocus]")||e).focus()}function s(){i("[data-a11y-dialog]").forEach((function(e){new t(e)}))}t.prototype.create=function(){this.$el.setAttribute("aria-hidden",!0),this.$el.setAttribute("aria-modal",!0),this.$el.setAttribute("tabindex",-1),this.$el.hasAttribute("role")||this.$el.setAttribute("role","dialog"),this._openers=i('[data-a11y-dialog-show="'+this._id+'"]'),this._openers.forEach(function(e){e.addEventListener("click",this._show)}.bind(this));const e=this.$el;return this._closers=i("[data-a11y-dialog-hide]",this.$el).filter((function(t){return t.closest('[aria-modal="true"], [data-a11y-dialog]')===e})).concat(i('[data-a11y-dialog-hide="'+this._id+'"]')),this._closers.forEach(function(e){e.addEventListener("click",this._hide)}.bind(this)),this._fire("create"),this},t.prototype.show=function(e){return this.shown||(this._previouslyFocused=document.activeElement,this.$el.removeAttribute("aria-hidden"),this.shown=!0,n(this.$el),document.body.addEventListener("focus",this._maintainFocus,!0),document.addEventListener("keydown",this._bindKeypress),this._fire("show",e)),this},t.prototype.hide=function(e){return this.shown?(this.shown=!1,this.$el.setAttribute("aria-hidden","true"),this._previouslyFocused&&this._previouslyFocused.focus&&this._previouslyFocused.focus(),document.body.removeEventListener("focus",this._maintainFocus,!0),document.removeEventListener("keydown",this._bindKeypress),this._fire("hide",e),this):this},t.prototype.destroy=function(){return this.hide(),this._openers.forEach(function(e){e.removeEventListener("click",this._show)}.bind(this)),this._closers.forEach(function(e){e.removeEventListener("click",this._hide)}.bind(this)),this._fire("destroy"),this._listeners={},this},t.prototype.on=function(e,t){return void 0===this._listeners[e]&&(this._listeners[e]=[]),this._listeners[e].push(t),this},t.prototype.off=function(e,t){var i=(this._listeners[e]||[]).indexOf(t);return i>-1&&this._listeners[e].splice(i,1),this},t.prototype._fire=function(e,t){var i=this._listeners[e]||[],n=new CustomEvent(e,{detail:t});this.$el.dispatchEvent(n),i.forEach(function(e){e(this.$el,t)}.bind(this))},t.prototype._bindKeypress=function(t){const n=document.activeElement;n&&n.closest('[aria-modal="true"]')!==this.$el||(this.shown&&"Escape"===t.key&&"alertdialog"!==this.$el.getAttribute("role")&&(t.preventDefault(),this.hide(t)),this.shown&&"Tab"===t.key&&function(t,n){var s=function(t){return i(e.join(","),t).filter((function(e){return!!(e.offsetWidth||e.offsetHeight||e.getClientRects().length)}))}(t),o=s.indexOf(document.activeElement);n.shiftKey&&0===o?(s[s.length-1].focus(),n.preventDefault()):n.shiftKey||o!==s.length-1||(s[0].focus(),n.preventDefault())}(this.$el,t))},t.prototype._maintainFocus=function(e){!this.shown||e.target.closest('[aria-modal="true"]')||e.target.closest("[data-a11y-dialog-ignore-focus-trap]")||n(this.$el)},"undefined"!=typeof document&&("loading"===document.readyState?document.addEventListener("DOMContentLoaded",s):window.requestAnimationFrame?window.requestAnimationFrame(s):window.setTimeout(s,16));new class{constructor(){this.checkIsTouchDevice()}checkIsTouchDevice(){let e=!1;if("maxTouchPoints"in navigator)e=navigator.maxTouchPoints>0;else if("msMaxTouchPoints"in navigator)e=navigator.msMaxTouchPoints>0;else{const t=matchMedia?.("(pointer:coarse)");if("(pointer:coarse)"===t?.media)e=!!t.matches;else if("orientation"in window)e=!0;else{const t=navigator.userAgent;e=/\b(BlackBerry|webOS|iPhone|IEMobile)\b/i.test(t)||/\b(Android|Windows Phone|iPad|iPod)\b/i.test(t)}}e&&document.body.classList.add("is-touch-device")}},new class{constructor(){this.checkBrowser()}checkBrowser(){!function(){var e,t=document.documentElement,i=t.style,n=" vendor-",s="edge",o="ie",r="khtml",a="mozilla",d="opera",c="webkit",l=" browser-",h="android",u="chrome",v="safari",f=v+"-ios",m="wiiu",p=n;if("msScrollLimit"in i||"behavior"in i)"msTextSizeAdjust"in i&&!("msFlex"in i)?(p+=s,e={vendor:s}):(p+=o+n+o,e={vendor:o},"msImeAlign"in i?(p+="-11",e.version=11):"msUserSelect"in i?(p+="-10",e.version=10):"fill"in i?(p+="-9",e.version=9):"widows"in i?(p+="-8",e.version=8):(p+="-7",e.version=7));else if("MozAppearance"in i)p+=a,e={vendor:a};else if("WebkitAppearance"in i){p+=c;var b=navigator.userAgent;e={vendor:c},window.chrome||b.indexOf("OPR")>=0||b.indexOf("wv")>=0?(p+=l+u,e.browser=u):"webkitDashboardRegion"in i?(p+=l+v,e.browser=v):"webkitOverflowScrolling"in i?(p+=l+f,e.browser=f):b.indexOf("Android")>=0?(p+=l+h,e.browser=h):window.wiiu&&(p+=l+m,e.browser=m)}else if("OLink"in i||window.opera)p+=d,e={vendor:d},"OMiniFold"in i&&(p+="-mini",e.browser="mini");else{if(!("KhtmlUserInput"in i))return!1;p+=r,e={vendor:r}}t.className+=p}()}},new class{constructor(){this.skipLinkFocusFix()}skipLinkFocusFix(){!function(){var e=navigator.userAgent.toLowerCase().indexOf("webkit")>-1,t=navigator.userAgent.toLowerCase().indexOf("opera")>-1,i=navigator.userAgent.toLowerCase().indexOf("msie")>-1;if((e||t||i)&&void 0!==document.getElementById){var n=window.addEventListener?"addEventListener":"attachEvent";window[n]("hashchange",(function(){var e=document.getElementById(location.hash.substring(1));e&&(/^(?:a|select|input|button|textarea)$/i.test(e.tagName)||(e.tabIndex=-1),e.focus())}),!1)}}()}},new class{constructor(){this.container=document.querySelector("#site-navigation"),this.button=this.container.querySelector("#responsive-toggle"),this.menu=this.container.querySelector("#menu-main-menu"),this.menuItems=this.menu.querySelectorAll(".menu-item"),this.isNavMenuOpen=!1,this.events()}events(){this.button.addEventListener("click",(()=>{this.toggleMenu()})),this.menuItems.forEach((e=>{e.addEventListener("click",(e=>{this.toggleMenu()}))})),document.addEventListener("keydown",(e=>this.keyPressDispatcher(e)))}toggleMenu(){this.container.classList.contains("toggled")&&this.isNavMenuOpen?(this.container.className=this.container.className.replace(" toggled",""),this.isNavMenuOpen=!1):(this.container.classList.add("toggled"),this.isNavMenuOpen=!0)}keyPressDispatcher(e){"Escape"===e.key&&this.isNavMenuOpen&&this.toggleMenu()}},new class{constructor(){this.openDialogButton=document.querySelectorAll(".btn--view-more"),this.closeDialogButton=document.querySelectorAll(".dialog-close"),this.dialogOverlay=document.querySelectorAll(".dialog-overlay"),this.isDialogOpen=!1,this.events()}events(){this.openDialogButton.forEach((e=>{e.addEventListener("click",(e=>{e.preventDefault(),this.preventBodyScroll()}))})),this.closeDialogButton.forEach((e=>{e.addEventListener("click",(e=>{e.preventDefault(),this.allowBodyScroll()}))})),this.dialogOverlay.forEach((e=>{e.addEventListener("click",(e=>{e.preventDefault(),this.allowBodyScroll()}))})),document.addEventListener("keydown",(e=>this.keyPressDispatcher(e)))}preventBodyScroll(){return console.log("no scroll?"),document.body.classList.add("body-no-scroll"),this.isDialogOpen=!0,!1}allowBodyScroll(){return document.body.classList.remove("body-no-scroll"),this.isDialogOpen=!1,!1}keyPressDispatcher(e){"Escape"===e.key&&this.isDialogOpen&&this.allowBodyScroll()}}}},i={};function n(e){var s=i[e];if(void 0!==s)return s.exports;var o=i[e]={exports:{}};return t[e](o,o.exports,n),o.exports}n.m=t,e=[],n.O=(t,i,s,o)=>{if(!i){var r=1/0;for(l=0;l<e.length;l++){i=e[l][0],s=e[l][1],o=e[l][2];for(var a=!0,d=0;d<i.length;d++)(!1&o||r>=o)&&Object.keys(n.O).every((e=>n.O[e](i[d])))?i.splice(d--,1):(a=!1,o<r&&(r=o));if(a){e.splice(l--,1);var c=s();void 0!==c&&(t=c)}}return t}o=o||0;for(var l=e.length;l>0&&e[l-1][2]>o;l--)e[l]=e[l-1];e[l]=[i,s,o]},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={826:0,431:0};n.O.j=t=>0===e[t];var t=(t,i)=>{var s,o,r=i[0],a=i[1],d=i[2],c=0;if(r.some((t=>0!==e[t]))){for(s in a)n.o(a,s)&&(n.m[s]=a[s]);if(d)var l=d(n)}for(t&&t(i);c<r.length;c++)o=r[c],n.o(e,o)&&e[o]&&e[o][0](),e[o]=0;return n.O(l)},i=self.webpackChunktim_fetter_theme=self.webpackChunktim_fetter_theme||[];i.forEach(t.bind(null,0)),i.push=t.bind(null,i.push.bind(i))})();var s=n.O(void 0,[431],(()=>n(548)));s=n.O(s)})();