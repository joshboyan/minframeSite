"use strict";function offsetAnchor(){0!==location.hash.length&&window.scrollTo(window.scrollX,window.scrollY-100)}document.querySelector(".closed").onclick=function(){document.querySelector("#submenu").classList.toggle("slideDown")},document.querySelector("#mobileTrigger").onclick=function(){document.querySelector(".mobileNav").classList.toggle("slideOut"),document.querySelector("#mobileTrigger i").classList.toggle("spinner"),document.querySelector("#mobileTrigger i").classList.toggle("fa-bars"),document.querySelector("#mobileTrigger i").classList.toggle("fa-times")},document.querySelector(".mobileNav").onclick=function(){document.querySelector(".mobileNav").classList.toggle("slideOut"),document.querySelector("#mobileTrigger i").classList.toggle("spinner"),document.querySelector("#mobileTrigger i").classList.toggle("fa-bars"),document.querySelector("#mobileTrigger i").classList.toggle("fa-times")},window.addEventListener("hashchange",offsetAnchor),window.setTimeout(offsetAnchor,1),function(e){e(document).ready(function(){for(var t=e("aside li").children(),o=[],n=0;n<t.length;n++){var i=t[n],r=e(i).attr("href");o.push(r)}e(window).scroll(function(){for(var t=e(window).scrollTop(),n=(e(window).height(),e(document).height(),0);n<o.length;n++){var i=o[n],r=e(i).offset().top;r-=185;var s=e(i).height();s+=90,t>=r&&t<r+s?e("a[href='"+i+"']").addClass("active"):e("a[href='"+i+"']").removeClass("active")}})})}(jQuery),$(function(){$('a[href*="#"]:not([href="#"])').click(function(){if(location.pathname.replace(/^\//,"")==this.pathname.replace(/^\//,"")&&location.hostname==this.hostname){var e=$(this.hash);if(e=e.length?e:$("[name="+this.hash.slice(1)+"]"),e.length)return $("html, body").animate({scrollTop:e.offset().top-80},1e3),!1}})}),function(){var e=document.documentElement,t="initial",o=null,n=["button","input","select","textarea"],i=[16,17,18,91,93],r={keyup:"keyboard",mousedown:"mouse",mousemove:"mouse",MSPointerDown:"pointer",MSPointerMove:"pointer",pointerdown:"pointer",pointermove:"pointer",touchstart:"touch"},s=[],c=!1,a={2:"touch",3:"touch",4:"mouse"},u=null,l=function(){window.PointerEvent?(e.addEventListener("pointerdown",d),e.addEventListener("pointermove",h)):window.MSPointerEvent?(e.addEventListener("MSPointerDown",d),e.addEventListener("MSPointerMove",h)):(e.addEventListener("mousedown",d),e.addEventListener("mousemove",h),"ontouchstart"in window&&e.addEventListener("touchstart",f)),e.addEventListener(p(),h),e.addEventListener("keydown",d),e.addEventListener("keyup",d)},d=function(e){if(!c){var s=e.which,a=r[e.type];if("pointer"===a&&(a=w(e)),t!==a||o!==a){var u=!(!document.activeElement||-1!==n.indexOf(document.activeElement.nodeName.toLowerCase()));("touch"===a||"mouse"===a&&-1===i.indexOf(s)||"keyboard"===a&&u)&&(t=o=a,m())}}},m=function(){e.setAttribute("data-whatinput",t),e.setAttribute("data-whatintent",t),-1===s.indexOf(t)&&(s.push(t),e.classList.add("whatinput-types-"+t))},h=function(t){if(!c){var n=r[t.type];"pointer"===n&&(n=w(t)),o!==n&&(o=n,e.setAttribute("data-whatintent",o))}},f=function(e){window.clearTimeout(u),d(e),c=!0,u=window.setTimeout(function(){c=!1},200)},w=function(e){return"number"==typeof e.pointerType?a[e.pointerType]:"pen"===e.pointerType?"touch":e.pointerType},p=function(){return"onwheel"in document.createElement("div")?"wheel":void 0!==document.onmousewheel?"mousewheel":"DOMMouseScroll"};"addEventListener"in window&&Array.prototype.indexOf&&function(){r[p()]="mouse",l(),m()}()}();