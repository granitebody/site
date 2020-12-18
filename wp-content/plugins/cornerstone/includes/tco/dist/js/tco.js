var tco="object"==typeof tco?tco:{};tco.main=function(t){var e={};function n(o){if(e[o])return e[o].exports;var c=e[o]={i:o,l:!1,exports:{}};return t[o].call(c.exports,c,c.exports,n),c.l=!0,c.exports}return n.m=t,n.c=e,n.d=function(t,e,o){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:o})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var c in t)n.d(o,c,function(e){return t[e]}.bind(null,c));return o},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=1)}([function(t,e){!function(){t.exports=this.jQuery}()},function(t,e,n){"use strict";n.r(e);var o=n(0),c=n.n(o);const i={};var a,r,s;!function(){var t={};function e(e,n,o){t[e]||(t[e]={}),t[e][n]=o}i.addModule=function(t,n){e(t,"callback",n)},i.addDataSource=function(t){if(t.modules)for(var n in t.modules)e(n,"data",t.modules[n])},i.debug=function(){return window.tcoCommon&&"1"===window.tcoCommon.debug},i.l18n=function(t){return window.tcoCommon&&window.tcoCommon.strings&&window.tcoCommon.strings[t]?window.tcoCommon.strings[t]:""},i.logo=function(){return window.tcoCommon&&window.tcoCommon.logo?window.tcoCommon.logo:""},c()((function(){c()("[data-tco-module]").each((function(){var e=c()(this),n=e.data("tco-module");if(t[n]&&"function"==typeof t[n].callback){var o={};c.a.extend(e,function(t){var e=t.find(".tco-status-text");if(!e.length)return{};var n=t.find("[data-tco-module-processor]");n=n.length?n:t;var o,c,a,r,s=e.clone();e.after(s);var l=!0,u=e,d=s;function f(){}var m=!0,p=f;function v(t,e){if(m){if(clearTimeout(o),!t||!Number.isInteger(t))return g(e);o=setTimeout((function(){g(e)}),t)}else p=function(){v(t,e)}}function g(t){u.removeClass("tco-active"),d.html(""),clearTimeout(c),c=setTimeout((function(){n.removeClass("tco-processing"),"function"==typeof t&&t()}),650)}function h(t,i,a,r){m?(clearTimeout(o),clearTimeout(c),n.hasClass("tco-processing")?(d.html(t),r&&r.length&&d.append(r),u.removeClass("tco-active"),u=(l=!l)?e:s,d=l?s:e,b(i,a)):(u.html(t),r&&r.length&&u.append(r),n.addClass("tco-processing"),b(i,a))):p=function(){h(t,i,a,r)}}function b(t,e){m=!1,clearTimeout(a),a=setTimeout((function(){u.addClass("tco-active"),t&&Number.isInteger(t)&&v(t,e),clearTimeout(r),r=setTimeout((function(){m=!0,p(),p=f}),650)}),650)}return{tcoShowMessage:h,tcoRemoveMessage:v,tcoShowErrorMessage:function(t,e,n){h(t,!1,n,i.makeErrorDelegate({message:e}))}}}(e)),e.find("[data-tco-module-target]").each((function(){var t=c()(this);o[t.data("tco-module-target")]=t}));var a=t[n].data||{};t[n].callback.call(this,e,o,a)}}))}))}(),i.ajax=function(t){var e="function"==typeof t.done?t.done:function(){},n="function"==typeof t.fail?t.fail:function(){};delete t.done,delete t.fail,t._tco_nonce=window.tcoCommon._tco_nonce,window.wp.ajax.post(t).done(e).fail((function(t){if("string"==typeof t){var o=t.match(/{"success":\w*?,"data.*/),c={};try{c=JSON.parse(o[0])}catch(t){}if(c.data){if(!0===c.success)return console.warn("TCO AJAX recovered from malformed success response: ",t),void e(c.data);if(!1===c.success)return console.warn("TCO AJAX recovered from malformed error response: ",t),void n(c.data)}}n(t)}))},a={accept:null,decline:null,message:"",class:"",acceptBtn:i.l18n("yep"),declineBtn:i.l18n("nope"),acceptClass:"",declineClass:"",attach:!0,detach:!1},i.confirm=function(t){var e=c.a.extend({},a,t),n=c()('<div class="tco-modal-outer"><div class="tco-modal-inner"><div class="tco-confirm"><div class="tco-confirm-text"></div><div class="tco-confirm-actions"></div></div></div></div>');if(n.find(".tco-confirm-text").html(e.message),e.class&&n.find(".tco-confirm").addClass(e.class),e.acceptBtn&&""!==e.acceptBtn){var o=c()('<button class="tco-btn">'+e.acceptBtn+"</button>");e.acceptClass&&o.addClass(e.acceptClass),n.find(".tco-confirm-actions").append(o),o.on("click",(function(){r.call(this,"accept")}))}if(e.declineBtn&&""!==e.declineBtn){var i=c()('<button class="tco-btn">'+e.declineBtn+"</button>");e.declineClass&&i.addClass(e.declineClass),n.find(".tco-confirm-actions").append(i),i.on("click",(function(){r.call(this,"decline")}))}function r(t){var o=e[t];if("function"==typeof o)o();else{var c=o,i=!1;if("object"==typeof c&&null!==c&&(i=!0===c.newTab,c=c.url||null),"string"==typeof c)if(i){var a=window.open(c,"_blank");a&&a.focus()}else window.location=c}n.removeClass("tco-active"),setTimeout((function(){n[e.detach?"detach":"remove"]()}),650)}return e.attach&&(c()("body").append(n),setTimeout((function(){n.addClass("tco-active")}),0)),n},function(){var t='<div class="tco-notice notice"><a class="tco-notice-logo" href="https://theme.co/" target="_blank">'+i.logo()+"</a><p></p></div>",e={message:"",dismissible:!0};i.showNotice=function(n){var o=c()(".tco-content .wrap").first();if(o.length){"string"==typeof n&&(n={message:n});var i=c.a.extend({},e,n),a=c()(t);if(a.find("p").first().html(i.message),i.dismissible){a.addClass("is-dismissible");var r=c()('<button type="button" class="notice-dismiss"><span class="screen-reader-text"></span></button>');r.find(".screen-reader-text").text(""),r.on("click.wp-dismiss-notice",(function(t){t.preventDefault(),a.fadeTo(100,0,(function(){a.slideUp(100,(function(){a.remove()}))}))})),a.append(r)}return o.append(a),a}console.warn("tco.showNotice requires the WordPress wrap div.")}}(),function(){var t={details:i.l18n("details"),message:"",back:i.l18n("back"),backClass:""};i.makeErrorDelegate=function(e){var n=c.a.extend({},t,e),o=c()("<a> "+n.details+"</a>");return o.on("click",(function(){i.confirm({message:n.message,acceptBtn:"",declineBtn:n.back,declineClass:n.backClass,class:"tco-confirm-error"})})),o}}(),c()((function(){c()('a[href="#"]').on("click",(function(t){t.preventDefault()})),c()("[data-tco-toggle]").on("click",(function(t){t.preventDefault();var e=c()(this).data("tco-toggle");c()(e).toggleClass("tco-active")})),c()(".tco-accordion-toggle").on("click",(function(){c()(this).hasClass("tco-active")?c()(this).removeClass("tco-active").next().slideUp():(c()(".tco-accordion-panel").slideUp(),c()(this).siblings().removeClass("tco-active"),c()(this).addClass("tco-active").next().slideDown())}))})),s=function(t){return encodeURIComponent(t).replace(/[!'()*]/g,(function(t){return"%"+t.charCodeAt(0).toString(16).toUpperCase()}))},(r={}).extract=function(t){return t.split("?")[1]||""},r.parse=function(t){return"string"!=typeof t?{}:(t=t.trim().replace(/^(\?|#|&)/,""))?t.split("&").reduce((function(t,e){var n=e.replace(/\+/g," ").split("="),o=n.shift(),c=n.length>0?n.join("="):void 0;return o=decodeURIComponent(o),c=void 0===c?null:decodeURIComponent(c),t.hasOwnProperty(o)?Array.isArray(t[o])?t[o].push(c):t[o]=[t[o],c]:t[o]=c,t}),{}):{}},r.stringify=function(t){return t?Object.keys(t).sort().map((function(e){var n=t[e];return void 0===n?"":null===n?e:Array.isArray(n)?n.slice().sort().map((function(t){return s(e)+"="+s(t)})).join("&"):s(e)+"="+s(n)})).filter((function(t){return t.length>0})).join("&"):""},i.queryString=r,window.tco=i,e.default=i}]);