var tco="object"==typeof tco?tco:{};tco.main=function(e){var t={};function o(n){if(t[n])return t[n].exports;var a=t[n]={i:n,l:!1,exports:{}};return e[n].call(a.exports,a,a.exports,o),a.l=!0,a.exports}return o.m=e,o.c=t,o.d=function(e,t,n){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(e,t){if(1&t&&(e=o(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)o.d(n,a,function(t){return e[t]}.bind(null,a));return n},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="",o(o.s=2)}([function(e,t){e.exports=window.tco},function(e,t){!function(){e.exports=this.jQuery}()},function(e,t,o){"use strict";o.r(t);var n=o(0),a=o.n(n),c=o(1),r=o.n(c);const i=window.csDashboardHomeData;a.a.addDataSource(i),a.a.addModule("cs-updates",(function(e,t,o){var n=t["check-now"]||!1,c=t["latest-available"]||!1;n&&c&&(o.latest&&c.html(o.latest),n.find("a").on("click",(function(e){e.preventDefault(),n.html(o.checking),a.a.ajax({action:"cs_update_check",_cs_nonce:window.csDashboardHomeData._cs_nonce,done:function(e){e.latest&&e.latest!==o.latest?(n.html(o.completeNew),c.html(e.latest)):n.html(o.complete)},fail:function(e){console.warn("Cornerstone Update Check Error",e),n.html(o.error)}})})))})),a.a.addModule("cs-validation",(function(e,t,o){let n=t.message||!1,c=t.button||!1,i=t.overlay||!1,s=t.input||!1,l=t.form||!1,u=t["preload-key"]||!1;if(n&&c&&i&&s&&l&&u){l.on("submit",(function(t){t.preventDefault(),s.prop("disabled",!0),e.tcoShowMessage(o.verifying),a.a.ajax({action:"cs_validation",code:s.val(),_cs_nonce:window.csDashboardHomeData._cs_nonce,done:d,fail:v})}));var f=u.val();"string"==typeof f&&f.length>1&&(s.val(f),l.submit()),r()("body").on("click",'a[data-tco-focus="validation-input"]',(function(e){e.preventDefault(),s.focus()}))}function d(t){if(!t.message)return v(t);t.complete?(e.tcoShowMessage(t.message),setTimeout(p,2500)):m(t)}function m(t){n.html(t.message),c.html(t.button);setTimeout((function(){e.tcoShowMessage("")}),1300),setTimeout((function(){i.addClass("tco-active")}),1950),t.url?(c.attr("href",t.url),t.newTab&&c.attr("target","_blank")):c.attr("href","#"),c.off("click"),t.dismiss&&c.on("click",(function(){i.removeClass("tco-active"),e.tcoRemoveMessage(),setTimeout((function(){s.val("").prop("disabled",!1)}),1300)}))}function p(){var e=a.a.queryString.parse(window.location.search);delete e["tco-key"],e.notice="validation-complete",window.location.search=a.a.queryString.stringify(e)}function v(e){var t=e.message?e.message:e;t.responseText&&(t=t.responseText),m({message:o.error,button:o.errorButton,dismiss:!0}),n.find("[data-tco-error-details]").on("click",(function(e){e.preventDefault(),a.a.confirm({message:t,acceptBtn:"",declineBtn:o.errorButton,class:"tco-confirm-error"})}))}})),a.a.addModule("cs-validation-revoke",(function(e,t,o){var n=t.revoke||!1;function c(){var e=a.a.queryString.parse(a.a.queryString.extract(window.location.href));delete e["tco-key"],e.notice="validation-revoked",window.location.search=a.a.queryString.stringify(e)}n&&n.on("click",(function(){a.a.confirm({message:o.confirm,acceptClass:"tco-btn-nope",acceptBtn:o.accept,declineBtn:o.decline,accept:function(){n.removeAttr("href"),n.html(o.revoking),a.a.ajax({action:"cs_validation_revoke",done:c,fail:c,_cs_nonce:window.csDashboardHomeData._cs_nonce})}})}))})),function(){if(i.modules&&i.notices)for(var e in i.modules){var t=i.modules[e];if(t.notices)for(var o in t.notices)-1!==i.notices.indexOf(o)&&a.a.showNotice(t.notices[o])}}()}]);