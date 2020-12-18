'use strict';
/* eslint-disable */
// =============================================================================
// JS/VENDOR/ILIGHTBOX-2.1.5.MIN.JS
// -----------------------------------------------------------------------------
// jQuery iLightBox - Revolutionary Lightbox Plugin
// http://www.ilightbox.net/
//
// @author: Hemn Chawroka
//          hemn@iprodev.com
//          http://www.iprodev.com/
// =============================================================================

// JavaScript Mouse Wheel
// =============================================================================

(function() {

  var types = ['DOMMouseScroll', 'mousewheel'];

  if (jQuery.event.fixHooks) {
    for ( var i=types.length; i; ) {
      jQuery.event.fixHooks[ types[--i] ] = jQuery.event.mouseHooks;
    }
  }

  jQuery.event.special.mousewheel = {
    setup: function() {
      if ( this.addEventListener ) {
        for ( var i=types.length; i; ) {
          this.addEventListener( types[--i], handler, false );
        }
      } else {
        this.onmousewheel = handler;
      }
    },
    teardown: function() {
      if ( this.removeEventListener ) {
        for ( var i=types.length; i; ) {
          this.removeEventListener( types[--i], handler, false );
        }
      } else {
        this.onmousewheel = null;
      }
    }
  };

  jQuery.fn.extend({
    mousewheel: function(fn) {
      return fn ? this.on("mousewheel", fn) : this.trigger("mousewheel");
    },
    unmousewheel: function(fn) {
      return this.off("mousewheel", fn);
    }
  });


  function handler(event) {
    var orgEvent    = event || window.event,
        args        = [].slice.call( arguments, 1 ),
        delta       = 0,
        returnValue = true,
        deltaX      = 0,
        deltaY      = 0;

    event = jQuery.event.fix(orgEvent);
    event.type = "mousewheel";

    // Old school scrollwheel delta
    if ( orgEvent.wheelDelta ) { delta = orgEvent.wheelDelta/120; }
    if ( orgEvent.detail     ) { delta = -orgEvent.detail/3; }

    // New school multidimensional scroll (touchpads) deltas
    deltaY = delta;

    // Gecko
    if ( orgEvent.axis !== undefined && orgEvent.axis === orgEvent.HORIZONTAL_AXIS ) {
      deltaY = 0;
      deltaX = -1*delta;
    }

    // Webkit
    if ( orgEvent.wheelDeltaY !== undefined ) { deltaY = orgEvent.wheelDeltaY/120; }
    if ( orgEvent.wheelDeltaX !== undefined ) { deltaX = -1*orgEvent.wheelDeltaX/120; }

    // Add event and delta to the front of the arguments
    args.unshift(event, delta, deltaX, deltaY);

    return (jQuery.event.dispatch || jQuery.event.handle).apply(this, args);
  }

})();


var varUnknown


function fnGetElementDimension(obj, name) {
  return parseInt(obj.css(name), 10) || 0;
}

function fnGetWindowDimensions() {
  /** @type {!global this} */
  var container = window;
  /** @type {string} */
  var prefix = "inner";
  if (!("innerWidth" in window)) {
    /** @type {string} */
    prefix = "client";
    /** @type {!Element} */
    container = document.documentElement || document.body;
  }
  return {
    width : container[prefix + "Width"],
    height : container[prefix + "Height"]
  };
}

function fnScrollToPageOffset() {
  var b = fnGetPageOffset();
  window.location.hash = "";
  window.scrollTo(b.x, b.y);
}

function fnPhoneHomeSourceCheck(a, d) {
  /** @type {string} */
  a = "http://ilightbox.net/getSource/jsonp.php?url=" + encodeURIComponent(a).replace(/!/g, "%21").replace(/'/g, "%27").replace(/\(/g, "%28").replace(/\)/g, "%29").replace(/\*/g, "%2A");
  jQuery.ajax({
    url : a,
    dataType : "jsonp"
  }).error(function() {
    d(false);
  });
  /**
   * @param {?} D
   * @return {undefined}
   */
  iLCallback = function(D) {
    d(D);
  };
}

function fnGetMediaUrls(e) {
  /** @type {!Array} */
  var p = [];
  jQuery("*", e).each(function() {
    /** @type {string} */
    var result = "";
    if ("none" != jQuery(this).css("background-image")) {
      result = jQuery(this).css("background-image");
    } else {
      if ("undefined" != typeof jQuery(this).attr("src") && "img" == this.nodeName.toLowerCase()) {
        result = jQuery(this).attr("src");
      }
    }
    if (-1 == result.indexOf("gradient")) {
      /** @type {string} */
      result = result.replace(/url\("/g, "");
      /** @type {string} */
      result = result.replace(/url\(/g, "");
      /** @type {string} */
      result = result.replace(/"\)/g, "");
      /** @type {string} */
      result = result.replace(/\)/g, "");
      /** @type {!Array<string>} */
      result = result.split(",");
      /** @type {number} */
      var i = 0;
      for (; i < result.length; i++) {
        if (0 < result[i].length && -1 == jQuery.inArray(result[i], p)) {
          /** @type {string} */
          var base = "";
          if (varBrowserDetection.msie && 9 > varBrowserDetection.version) {
            /** @type {string} */
            base = "?" + Math.floor(3E3 * Math.random());
          }
          p.push(result[i] + base);
        }
      }
    }
  });
  return p;
}

function fnTrimFileExt(a, b) {
  var value = a.replace(/^.*[\/\\]/g, "");
  if ("string" == typeof b && value.substr(value.length - b.length) == b) {
    value = value.substr(0, value.length - b.length);
  }
  return value;
}

function fnIdentifyFileExt(date, options) {
  /** @type {string} */
  var prop = "";
  /** @type {string} */
  var write = "";
  /** @type {number} */
  var type = 0;
  var opts = {};
  /** @type {number} */
  var value = 0;
  /** @type {number} */
  var i = 0;
  /** @type {boolean} */
  var num = value = false;
  /** @type {boolean} */
  var includePath = false;
  if (!date) {
    return false;
  }
  if (!options) {
    /** @type {string} */
    options = "PATHINFO_ALL";
  }
  var OPTS = {
    PATHINFO_DIRNAME : 1,
    PATHINFO_BASENAME : 2,
    PATHINFO_EXTENSION : 4,
    PATHINFO_FILENAME : 8,
    PATHINFO_ALL : 0
  };
  for (write in OPTS) {
    OPTS.PATHINFO_ALL |= OPTS[write];
  }
  if ("number" !== typeof options) {
    /** @type {!Array<?>} */
    options = [].concat(options);
    /** @type {number} */
    i = 0;
    for (; i < options.length; i++) {
      if (OPTS[options[i]]) {
        /** @type {number} */
        type = type | OPTS[options[i]];
      }
    }
    /** @type {number} */
    options = type;
  }
  /**
   * @param {string} data
   * @return {?}
   */
  write = function(data) {
    /** @type {string} */
    data = data + "";
    /** @type {number} */
    var index = data.lastIndexOf(".") + 1;
    return index ? index !== data.length ? data.substr(index) : "" : false;
  };
  if (options & OPTS.PATHINFO_DIRNAME) {
    type = date.replace(/\\/g, "/").replace(/\/[^\/]*\/?$/, "");
    opts.dirname = type === date ? "." : type;
  }
  if (options & OPTS.PATHINFO_BASENAME) {
    if (false === value) {
      value = fnTrimFileExt(date);
    }
    opts.basename = value;
  }
  if (options & OPTS.PATHINFO_EXTENSION) {
    if (false === value) {
      value = fnTrimFileExt(date);
    }
    if (false === num) {
      num = write(value);
    }
    if (false !== num) {
      opts.extension = num;
    }
  }
  if (options & OPTS.PATHINFO_FILENAME) {
    if (false === value) {
      value = fnTrimFileExt(date);
    }
    if (false === num) {
      num = write(value);
    }
    if (false === includePath) {
      includePath = value.slice(0, value.length - (num ? num.length + 1 : false === num ? 0 : 1));
    }
    opts.filename = includePath;
  }
  /** @type {number} */
  value = 0;
  for (prop in opts) {
    value++;
  }
  return 1 == value ? opts[prop] : opts;
}

function fnIdentifyFileType(string) {
  string = fnIdentifyFileExt(string, "PATHINFO_EXTENSION");
  string = jQuery.isPlainObject(string) ? null : string.toLowerCase();
  return type = 0 <= varMediaTypes.image.indexOf(string) ? "image" : 0 <= varMediaTypes.flash.indexOf(string) ? "flash" : 0 <= varMediaTypes.video.indexOf(string) ? "video" : "iframe";
}

function fnParseInt(s, t) {
  return parseInt(t / 100 * s);
}

function fnParseUrl(date) {
  return (date = String(date).replace(/^\s+|\s+$/g, "").match(/^([^:\/?#]+:)?(\/\/(?:[^:@]*(?::[^:@]*)?@)?(([^:\/?#]*)(?::(\d*))?))?([^?#]*)(\?[^#]*)?(#[\s\S]*)?/)) ? {
    href : date[0] || "",
    protocol : date[1] || "",
    authority : date[2] || "",
    host : date[3] || "",
    hostname : date[4] || "",
    port : date[5] || "",
    pathname : date[6] || "",
    search : date[7] || "",
    hash : date[8] || ""
  } : null;
}

function fnNormalizeUrl(base, href) {
  /**
   * @param {string} fragment
   * @return {?}
   */
  function replacer(fragment) {
    /** @type {!Array} */
    var b = [];
    fragment.replace(/^(\.\.?(\/|$))+/, "").replace(/\/(\.(\/|$))+/g, "/").replace(/\/\.\.$/, "/../").replace(/\/?[^\/]*/g, function(classFunction) {
      if ("/.." === classFunction) {
        b.pop();
      } else {
        b.push(classFunction);
      }
    });
    return b.join("").replace(/^\//, "/" === fragment.charAt(0) ? "/" : "");
  }
  href = fnParseUrl(href || "");
  base = fnParseUrl(base || "");
  return href && base ? (href.protocol || base.protocol) + (href.protocol || href.authority ? href.authority : base.authority) + replacer(href.protocol || href.authority || "/" === href.pathname.charAt(0) ? href.pathname : href.pathname ? (base.authority && !base.pathname ? "/" : "") + base.pathname.slice(0, base.pathname.lastIndexOf("/") + 1) + href.pathname : base.pathname) + (href.protocol || href.authority || href.pathname ? href.search : href.search || base.search) + href.hash : null;
}

function fnVersionCmp(b, a, operator) {
  this.php_js = this.php_js || {};
  this.php_js.ENV = this.php_js.ENV || {};
  /** @type {number} */
  var i = 0;
  /** @type {number} */
  var cell_amount = 0;
  /** @type {number} */
  var server = 0;
  var vm = {
    dev : -6,
    alpha : -5,
    a : -5,
    beta : -4,
    b : -4,
    RC : -3,
    rc : -3,
    "#" : -2,
    p : 1,
    pl : 1
  };
  /**
   * @param {string} b
   * @return {?}
   */
  i = function(b) {
    /** @type {string} */
    b = ("" + b).replace(/[_\-+]/g, ".");
    /** @type {string} */
    b = b.replace(/([^.\d]+)/g, ".$1.").replace(/\.{2,}/g, ".");
    return b.length ? b.split(".") : [-8];
  };
  b = i(b);
  a = i(a);
  /** @type {number} */
  cell_amount = Math.max(b.length, a.length);
  /** @type {number} */
  i = 0;
  for (; i < cell_amount; i++) {
    if (b[i] != a[i]) {
      if (b[i] = b[i] ? isNaN(b[i]) ? vm[b[i]] || -7 : parseInt(b[i], 10) : 0, a[i] = a[i] ? isNaN(a[i]) ? vm[a[i]] || -7 : parseInt(a[i], 10) : 0, b[i] < a[i]) {
        /** @type {number} */
        server = -1;
        break;
      } else {
        if (b[i] > a[i]) {
          /** @type {number} */
          server = 1;
          break;
        }
      }
    }
  }
  if (!operator) {
    return server;
  }
  switch(operator) {
    case ">":
    case "gt":
      return 0 < server;
    case ">=":
    case "ge":
      return 0 <= server;
    case "<=":
    case "le":
      return 0 >= server;
    case "==":
    case "=":
    case "eq":
      return 0 === server;
    case "<>":
    case "!=":
    case "ne":
      return 0 !== server;
    case "":
    case "<":
    case "lt":
      return 0 > server;
    default:
      return null;
  }
}

function fnGetPageOffset() {
  /** @type {number} */
  var l = 0;
  /** @type {number} */
  var t = 0;
  if ("number" == typeof window.pageYOffset) {
    /** @type {number} */
    t = window.pageYOffset;
    /** @type {number} */
    l = window.pageXOffset;
  } else {
    if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
      /** @type {number} */
      t = document.body.scrollTop;
      /** @type {number} */
      l = document.body.scrollLeft;
    } else {
      if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
        /** @type {number} */
        t = document.documentElement.scrollTop;
        /** @type {number} */
        l = document.documentElement.scrollLeft;
      }
    }
  }
  return {
    x : l,
    y : t
  };
}

function fnMakeAttrFromObject(prefix, name, obj) {
  var prop;
  prop = varEmbedElement[prefix + name];
  if (null == prop) {
    prop = varEmbedElement[name];
  }
  return null != prop ? (0 == name.indexOf(prefix) && null == obj && (obj = name.substring(prefix.length)), null == obj && (obj = name), obj + '="' + prop + '" ') : "";
}

function fnMakeAttr(slotName, index) {
  if (0 == slotName.indexOf("emb#")) {
    return "";
  }
  if (0 == slotName.indexOf("obj#") && null == index) {
    index = slotName.substring(4);
  }
  return fnMakeAttrFromObject("obj#", slotName, index);
}

function fnMakeAttr2(value, view) {
  if (0 == value.indexOf("obj#")) {
    return "";
  }
  if (0 == value.indexOf("emb#") && null == view) {
    view = value.substring(4);
  }
  return fnMakeAttrFromObject("emb#", value, view);
}

function fnMakeAttr3(i, args) {
  var filtervalue;
  /** @type {string} */
  var tok = "";
  /** @type {string} */
  var elt = args ? " />" : ">";
  if (-1 == i.indexOf("emb#")) {
    filtervalue = varEmbedElement["obj#" + i];
    if (null == filtervalue) {
      filtervalue = varEmbedElement[i];
    }
    if (0 == i.indexOf("obj#")) {
      i = i.substring(4);
    }
    if (null != filtervalue) {
      /** @type {string} */
      tok = '  <param name="' + i + '" value="' + filtervalue + '"' + elt + "\n";
    }
  }
  return tok;
}

function fnCleanAttrs() {
  /** @type {number} */
  var i = 0;
  for (; i < arguments.length; i++) {
    var attrName = arguments[i];
    delete varEmbedElement[attrName];
    delete varEmbedElement["emb#" + attrName];
    delete varEmbedElement["obj#" + attrName];
  }
}

function fnCreateEmbedObject() {
  var c;
  /** @type {string} */
  c = "QT_GenerateOBJECTText";
  /** @type {!Arguments} */
  var result = arguments;
  if (4 > result.length || 0 != result.length % 2) {
    /** @type {string} */
    result = varErroeMessage1;
    /** @type {string} */
    result = result.replace("%%", c);
    alert(result);
    /** @type {string} */
    c = "";
  } else {
    /** @type {!Array} */
    varEmbedElement = [];
    varEmbedElement.src = result[0];
    varEmbedElement.width = result[1];
    varEmbedElement.height = result[2];
    /** @type {string} */
    varEmbedElement.classid = "clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B";
    /** @type {string} */
    varEmbedElement.pluginspage = "http://www.apple.com/quicktime/download/";
    c = result[3];
    if (null == c || "" == c) {
      /** @type {string} */
      c = "6,0,2,0";
    }
    /** @type {string} */
    varEmbedElement.codebase = "http://www.apple.com/qtactivex/qtplugin.cab#version=" + c;
    var a;
    /** @type {number} */
    var i = 4;
    for (; i < result.length; i = i + 2) {
      a = result[i].toLowerCase();
      c = result[i + 1];
      if ("name" == a || "id" == a) {
        varEmbedElement.name = c;
      } else {
        varEmbedElement[a] = c;
      }
    }
    /** @type {string} */
    result = "<object " + fnMakeAttr("classid") + fnMakeAttr("width") + fnMakeAttr("height") + fnMakeAttr("codebase") + fnMakeAttr("name", "id") + fnMakeAttr("tabindex") + fnMakeAttr("hspace") + fnMakeAttr("vspace") + fnMakeAttr("border") + fnMakeAttr("align") + fnMakeAttr("class") + fnMakeAttr("title") + fnMakeAttr("accesskey") + fnMakeAttr("noexternaldata") + ">\n" + fnMakeAttr3("src", false);
    /** @type {string} */
    i = "  <embed " + fnMakeAttr2("src") + fnMakeAttr2("width") + fnMakeAttr2("height") + fnMakeAttr2("pluginspage") + fnMakeAttr2("name") + fnMakeAttr2("align") + fnMakeAttr2("tabindex");
    fnCleanAttrs("src", "width", "height", "pluginspage", "classid", "codebase", "name", "tabindex", "hspace", "vspace", "border", "align", "noexternaldata", "class", "title", "accesskey");
    for (a in varEmbedElement) {
      c = varEmbedElement[a];
      if (null != c) {
        /** @type {string} */
        i = i + fnMakeAttr2(a);
        /** @type {string} */
        result = result + fnMakeAttr3(a, false);
      }
    }
    /** @type {string} */
    c = result + i + "> </embed>\n</object>";
  }
  return c;
}

function fnMakeHashUri(a) {
  a = a || location.href;
  return "#" + a.replace(/^[^#]*#?(.*)$/, "$1");
}
var varMediaTypes = {
  flash : "swf",
  image : "bmp gif jpeg jpg png tiff tif jfif jpe",
  iframe : "asp aspx cgi cfm htm html jsp php pl php3 php4 php5 phtml rb rhtml shtml txt",
  video : "avi mov mpg mpeg movie mp4 webm ogv ogg 3gp m4v"
};
var $window = jQuery(window);
var $document = jQuery(document);
var varBrowserDetection;
var varPropTransform;
var varPropPerspective;
/** @type {string} */
var varFullscreenState = "";
/** @type {boolean} */
var varHasTouchEvents = !!("ontouchstart" in window);
/** @type {string} */
var varEventClick = varHasTouchEvents ? "itap.iLightBox" : "click.iLightBox";
/** @type {string} */
var varEventMousedown = varHasTouchEvents ? "touchstart.iLightBox" : "mousedown.iLightBox";
/** @type {string} */
var varEventMouseup = varHasTouchEvents ? "touchend.iLightBox" : "mouseup.iLightBox";
/** @type {string} */
var varEventMouseMove = varHasTouchEvents ? "touchmove.iLightBox" : "mousemove.iLightBox";

/**
 * @param {!Object} value
 * @param {!Object} options
 * @param {!Object} api
 * @param {?} ctx
 * @return {undefined}
 */
var iLightBoxClass = function(value, options, api, ctx) {
  var self = this;
  /** @type {!Object} */
  self.options = options;
  self.selector = value.selector || value;
  self.context = value.context;
  self.instant = ctx;
  if (1 > api.length) {
    self.attachItems();
  } else {
    /** @type {!Object} */
    self.items = api;
  }
  self.vars = {
    total : self.items.length,
    start : 0,
    current : null,
    next : null,
    prev : null,
    BODY : jQuery("body"),
    loadRequests : 0,
    overlay : jQuery('<div class="ilightbox-overlay"></div>'),
    loader : jQuery('<div class="ilightbox-loader"><div></div></div>'),
    toolbar : jQuery('<div class="ilightbox-toolbar"></div>'),
    innerToolbar : jQuery('<div class="ilightbox-inner-toolbar"></div>'),
    title : jQuery('<div class="ilightbox-title"></div>'),
    closeButton : jQuery('<a class="ilightbox-close" title="' + self.options.text.close + '"></a>'),
    fullScreenButton : jQuery('<a class="ilightbox-fullscreen" title="' + self.options.text.enterFullscreen + '"></a>'),
    innerPlayButton : jQuery('<a class="ilightbox-play" title="' + self.options.text.slideShow + '"></a>'),
    innerNextButton : jQuery('<a class="ilightbox-next-button" title="' + self.options.text.next + '"></a>'),
    innerPrevButton : jQuery('<a class="ilightbox-prev-button" title="' + self.options.text.previous + '"></a>'),
    holder : jQuery('<div class="ilightbox-holder" ondragstart="return false;"><div class="ilightbox-container"></div></div>'),
    nextPhoto : jQuery('<div class="ilightbox-holder ilightbox-next" ondragstart="return false;"><div class="ilightbox-container"></div></div>'),
    prevPhoto : jQuery('<div class="ilightbox-holder ilightbox-prev" ondragstart="return false;"><div class="ilightbox-container"></div></div>'),
    nextButton : jQuery('<a class="ilightbox-button ilightbox-next-button" ondragstart="return false;" title="' + self.options.text.next + '"><span></span></a>'),
    prevButton : jQuery('<a class="ilightbox-button ilightbox-prev-button" ondragstart="return false;" title="' + self.options.text.previous + '"><span></span></a>'),
    thumbnails : jQuery('<div class="ilightbox-thumbnails" ondragstart="return false;"><div class="ilightbox-thumbnails-container"><a class="ilightbox-thumbnails-dragger"></a><div class="ilightbox-thumbnails-grid"></div></div></div>'),
    thumbs : false,
    nextLock : false,
    prevLock : false,
    hashLock : false,
    isMobile : false,
    mobileMaxWidth : 980,
    isInFullScreen : false,
    isSwipe : false,
    mouseID : 0,
    cycleID : 0,
    isPaused : 0
  };
  self.vars.hideableElements = self.vars.nextButton.add(self.vars.prevButton);
  self.normalizeItems();
  self.availPlugins();
  self.options.startFrom = 0 < self.options.startFrom && self.options.startFrom >= self.vars.total ? self.vars.total - 1 : self.options.startFrom;
  self.options.startFrom = self.options.randomStart ? Math.floor(Math.random() * self.vars.total) : self.options.startFrom;
  self.vars.start = self.options.startFrom;
  if (ctx) {
    self.instantCall();
  } else {
    self.patchItemsEvents();
  }
  if (self.options.linkId) {
    self.hashChangeHandler();
    $window.iLightBoxHashChange(function() {
      self.hashChangeHandler();
    });
  }
  if (varHasTouchEvents) {
    /** @type {!RegExp} */
    value = /(click|mouseenter|mouseleave|mouseover|mouseout)/ig;
    self.options.caption.show = self.options.caption.show.replace(value, "itap");
    self.options.caption.hide = self.options.caption.hide.replace(value, "itap");
    self.options.social.show = self.options.social.show.replace(value, "itap");
    self.options.social.hide = self.options.social.hide.replace(value, "itap");
  }
  if (self.options.controls.arrows) {
    jQuery.extend(self.options.styles, {
      nextOffsetX : 0,
      prevOffsetX : 0,
      nextOpacity : 0,
      prevOpacity : 0
    });
  }
};
iLightBoxClass.prototype = {
  showLoader : function() {
    this.vars.loadRequests += 1;
    if ("horizontal" == this.options.path.toLowerCase()) {
      this.vars.loader.stop().animate({
        top : "-30px"
      }, this.options.show.speed, "easeOutCirc");
    } else {
      this.vars.loader.stop().animate({
        left : "-30px"
      }, this.options.show.speed, "easeOutCirc");
    }
  },
  hideLoader : function() {
    this.vars.loadRequests -= 1;
    this.vars.loadRequests = 0 > this.vars.loadRequests ? 0 : this.vars.loadRequests;
    if ("horizontal" == this.options.path.toLowerCase()) {
      if (0 >= this.vars.loadRequests) {
        this.vars.loader.stop().animate({
          top : "-192px"
        }, this.options.show.speed, "easeInCirc");
      }
    } else {
      if (0 >= this.vars.loadRequests) {
        this.vars.loader.stop().animate({
          left : "-192px"
        }, this.options.show.speed, "easeInCirc");
      }
    }
  },
  createUI : function() {
    var self = this;
    self.ui = {
      currentElement : self.vars.holder,
      nextElement : self.vars.nextPhoto,
      prevElement : self.vars.prevPhoto,
      currentItem : self.vars.current,
      nextItem : self.vars.next,
      prevItem : self.vars.prev,
      hide : function() {
        self.closeAction();
      },
      refresh : function() {
        if (0 < arguments.length) {
          self.repositionPhoto(true);
        } else {
          self.repositionPhoto();
        }
      },
      fullscreen : function() {
        self.fullScreenAction();
      }
    };
  },
  attachItems : function() {
    var a$jscomp$28 = this;
    /** @type {!Array} */
    var b$jscomp$19 = [];
    /** @type {!Array} */
    var c$jscomp$8 = [];
    jQuery(a$jscomp$28.selector, a$jscomp$28.context).each(function() {
      var d$jscomp$7 = jQuery(this);
      var e$jscomp$12 = d$jscomp$7.attr(a$jscomp$28.options.attr) || null;
      var f$jscomp$3 = d$jscomp$7.data("options") && eval("({" + d$jscomp$7.data("options") + "})") || {};
      var h$jscomp$8 = d$jscomp$7.data("caption");
      var l$jscomp$1 = d$jscomp$7.data("title");
      var k$jscomp$1 = d$jscomp$7.data("type") || fnIdentifyFileType(e$jscomp$12);
      c$jscomp$8.push({
        URL : e$jscomp$12,
        caption : h$jscomp$8,
        title : l$jscomp$1,
        type : k$jscomp$1,
        options : f$jscomp$3
      });
      if (!a$jscomp$28.instant) {
        b$jscomp$19.push(d$jscomp$7);
      }
    });
    /** @type {!Array} */
    a$jscomp$28.items = c$jscomp$8;
    /** @type {!Array} */
    a$jscomp$28.itemsObject = b$jscomp$19;
  },
  normalizeItems : function() {
    var data = this;
    /** @type {!Array} */
    var lists = [];
    jQuery.each(data.items, function(canCreateDiscussions, file) {
      if ("string" == typeof file) {
        file = {
          url : file
        };
      }
      var object = file.url || file.URL || null;
      var options = file.options || {};
      var text = file.caption || null;
      var url = file.title || null;
      var type = file.type ? file.type.toLowerCase() : fnIdentifyFileType(object);
      var ext = "object" != typeof object ? fnIdentifyFileExt(object, "PATHINFO_EXTENSION") : "";
      options.thumbnail = options.thumbnail || ("image" == type ? object : null);
      options.videoType = options.videoType || null;
      options.skin = options.skin || data.options.skin;
      options.width = options.width || null;
      options.height = options.height || null;
      options.mousewheel = "undefined" != typeof options.mousewheel ? options.mousewheel : true;
      options.swipe = "undefined" != typeof options.swipe ? options.swipe : true;
      options.social = "undefined" != typeof options.social ? options.social : data.options.social.buttons && jQuery.extend({}, {}, data.options.social.buttons);
      if ("video" == type) {
        options.html5video = "undefined" != typeof options.html5video ? options.html5video : {};
        options.html5video.webm = options.html5video.webm || options.html5video.WEBM || null;
        options.html5video.controls = "undefined" != typeof options.html5video.controls ? options.html5video.controls : "controls";
        options.html5video.preload = options.html5video.preload || "metadata";
        options.html5video.autoplay = "undefined" != typeof options.html5video.autoplay ? options.html5video.autoplay : false;
      }
      if (!(options.width && options.height)) {
        if ("video" == type) {
          /** @type {number} */
          options.width = 1280;
          /** @type {number} */
          options.height = 720;
        } else {
          if ("iframe" == type) {
            /** @type {string} */
            options.width = "100%";
            /** @type {string} */
            options.height = "90%";
          } else {
            if ("flash" == type) {
              /** @type {number} */
              options.width = 1280;
              /** @type {number} */
              options.height = 720;
            }
          }
        }
      }
      delete file.url;
      file.URL = object;
      file.caption = text;
      file.title = url;
      file.type = type;
      file.options = options;
      file.ext = ext;
      lists.push(file);
    });
    /** @type {!Array} */
    data.items = lists;
  },
  instantCall : function() {
    var i = this.vars.start;
    this.vars.current = i;
    this.vars.next = this.items[i + 1] ? i + 1 : null;
    /** @type {(null|number)} */
    this.vars.prev = this.items[i - 1] ? i - 1 : null;
    this.addContents();
    this.patchEvents();
  },
  addContents : function() {
    var self = this;
    var data = self.vars;
    var options = self.options;
    var value = fnGetWindowDimensions();
    var classShiftLeft = options.path.toLowerCase();
    if (options.mobileOptimizer && !options.innerToolbar) {
      /** @type {boolean} */
      data.isMobile = value.width <= data.mobileMaxWidth;
    }
    data.overlay.addClass(options.skin).hide().css({
      opacity : options.overlay.opacity
    });
    if (options.linkId) {
      data.overlay.attr("linkid", options.linkId);
    }
    if (options.controls.toolbar) {
      data.toolbar.addClass(options.skin).append(data.closeButton);
      if (options.controls.fullscreen) {
        data.toolbar.append(data.fullScreenButton);
      }
      if (options.controls.slideshow) {
        data.toolbar.append(data.innerPlayButton);
      }
      if (1 < data.total) {
        data.toolbar.append(data.innerPrevButton).append(data.innerNextButton);
      }
    }
    data.BODY.addClass("ilightbox-noscroll").append(data.overlay).append(data.loader).append(data.holder).append(data.nextPhoto).append(data.prevPhoto);
    if (!options.innerToolbar) {
      data.BODY.append(data.toolbar);
    }
    if (options.controls.arrows) {
      data.BODY.append(data.nextButton).append(data.prevButton);
    }
    if (options.controls.thumbnail && 1 < data.total) {
      data.BODY.append(data.thumbnails);
      data.thumbnails.addClass(options.skin).addClass("ilightbox-" + classShiftLeft);
      jQuery("div.ilightbox-thumbnails-grid", data.thumbnails).empty();
      /** @type {boolean} */
      data.thumbs = true;
    }
    /** @type {({left: number}|{top: number})} */
    value = "horizontal" == options.path.toLowerCase() ? {
      left : parseInt(value.width / 2 - data.loader.outerWidth() / 2)
    } : {
      top : parseInt(value.height / 2 - data.loader.outerHeight() / 2)
    };
    data.loader.addClass(options.skin).css(value);
    data.nextButton.add(data.prevButton).addClass(options.skin);
    if ("horizontal" == classShiftLeft) {
      data.loader.add(data.nextButton).add(data.prevButton).addClass("horizontal");
    }
    data.BODY[data.isMobile ? "addClass" : "removeClass"]("isMobile");
    if (!options.infinite) {
      data.prevButton.add(data.prevButton).add(data.innerPrevButton).add(data.innerNextButton).removeClass("disabled");
      if (!(0 != options.startFrom && 0 != data.current)) {
        data.prevButton.add(data.innerPrevButton).addClass("disabled");
      }
      if (options.startFrom >= data.total - 1 || data.current >= data.total - 1) {
        data.nextButton.add(data.innerNextButton).addClass("disabled");
      }
    }
    if (options.show.effect) {
      setTimeout(function() {
        self.generateBoxes();
      }, options.show.speed);
    } else {
      self.generateBoxes();
    }
    if (options.show.effect) {
      data.overlay.stop().fadeIn(options.show.speed);
      data.toolbar.stop().fadeIn(options.show.speed);
    } else {
      data.overlay.show();
      data.toolbar.show();
    }
    var index = data.total;
    if (options.smartRecognition && 1 < data.total) {
      jQuery.each(self.items, function(key, canCreateDiscussions) {
        var node = self.items[key];
        self.ogpRecognition(node, function(options) {
          if (options) {
            jQuery.extend(true, node, {
              type : options.type,
              options : {
                html5video : options.html5video,
                width : "image" == options.type ? 0 : options.width || node.width,
                height : "image" == options.type ? 0 : options.height || node.height,
                thumbnail : node.options.thumbnail || options.thumbnail
              }
            });
          }
          index--;
          if (0 == index) {
            /** @type {boolean} */
            data.dontGenerateThumbs = false;
            self.generateThumbnails();
          }
        });
      });
    }
    self.createUI();
    window.iLightBox = {
      close : function() {
        self.closeAction();
      },
      fullscreen : function() {
        self.fullScreenAction();
      },
      moveNext : function() {
        self.moveTo("next");
      },
      movePrev : function() {
        self.moveTo("prev");
      },
      goTo : function(index) {
        self.goTo(index);
      },
      refresh : function() {
        self.refresh();
      },
      reposition : function() {
        if (0 < arguments.length) {
          self.repositionPhoto(true);
        } else {
          self.repositionPhoto();
        }
      },
      setOption : function(value) {
        self.setOption(value);
      },
      destroy : function() {
        self.closeAction();
        self.dispatchItemsEvents();
      }
    };
    if (options.linkId) {
      /** @type {boolean} */
      data.hashLock = true;
      /** @type {string} */
      window.location.hash = options.linkId + "/" + data.current;
      setTimeout(function() {
        /** @type {boolean} */
        data.hashLock = false;
      }, 55);
    }
    if (!options.slideshow.startPaused) {
      self.resume();
      data.innerPlayButton.removeClass("ilightbox-play").addClass("ilightbox-pause");
    }
    if ("function" == typeof self.options.callback.onOpen) {
      self.options.callback.onOpen.call(self);
    }
  },
  loadContent : function(o, type, content) {
    var self = this;
    var e;
    var token;
    self.createUI();
    o.speed = content || self.options.effects.loadedFadeSpeed;
    if ("current" == type) {
      /** @type {boolean} */
      self.vars.lockWheel = o.options.mousewheel ? false : true;
      /** @type {boolean} */
      self.vars.lockSwipe = o.options.swipe ? false : true;
    }
    switch(type) {
      case "current":
        e = self.vars.holder;
        token = self.vars.current;
        break;
      case "next":
        e = self.vars.nextPhoto;
        token = self.vars.next;
        break;
      case "prev":
        e = self.vars.prevPhoto;
        token = self.vars.prev;
    }
    e.removeAttr("style class").addClass("ilightbox-holder").addClass(o.options.skin);
    jQuery("div.ilightbox-inner-toolbar", e).remove();
    if (o.title || self.options.innerToolbar) {
      content = self.vars.innerToolbar.clone();
      if (o.title && self.options.show.title) {
        var h = self.vars.title.clone();
        h.empty().html(o.title);
        content.append(h);
      }
      if (self.options.innerToolbar) {
        content.append(1 < self.vars.total ? self.vars.toolbar.clone() : self.vars.toolbar);
      }
      e.prepend(content);
    }
    if (self.options.smartRecognition || o.options.smartRecognition) {
      self.ogpRecognition(o, function(options) {
        var r = o;
        var info = jQuery.extend({}, o, {});
        if (options) {
          o = jQuery.extend(true, o, {
            type : options.type,
            options : {
              html5video : options.html5video,
              width : "image" == options.type ? 0 : options.width || o.width,
              height : "image" == options.type ? 0 : options.height || o.height,
              thumbnail : o.options.thumbnail || options.thumbnail
            }
          });
          r = jQuery.extend({}, o, {
            URL : options.source
          });
          if (o.options.smartRecognition && !info.options.thumbnail) {
            /** @type {boolean} */
            self.vars.dontGenerateThumbs = false;
            self.generateThumbnails();
          }
        }
        self.loadSwitcher(r, e, token, type);
      });
    } else {
      self.loadSwitcher(o, e, token, type);
    }
  },
  loadSwitcher : function(item, p, key, src) {
    var that = this;
    var $ = that.options;
    var parameters = {
      element : p,
      position : key
    };
    switch(item.type) {
      case "image":
        if ("function" == typeof $.callback.onBeforeLoad) {
          $.callback.onBeforeLoad.call(that, that.ui, key);
        }
        if ("function" == typeof item.options.onBeforeLoad) {
          item.options.onBeforeLoad.call(that, parameters);
        }
        that.loadImage(item.URL, function(designSize) {
          if ("function" == typeof $.callback.onAfterLoad) {
            $.callback.onAfterLoad.call(that, that.ui, key);
          }
          if ("function" == typeof item.options.onAfterLoad) {
            item.options.onAfterLoad.call(that, parameters);
          }
          p.data({
            naturalWidth : designSize ? designSize.width : 400,
            naturalHeight : designSize ? designSize.height : 200
          });
          jQuery("div.ilightbox-container", p).empty().append(designSize ? '<img src="' + item.URL + '" class="ilightbox-image" />' : '<span class="ilightbox-alert">' + $.errors.loadImage + "</span>");
          if ("function" == typeof $.callback.onRender) {
            $.callback.onRender.call(that, that.ui, key);
          }
          if ("function" == typeof item.options.onRender) {
            item.options.onRender.call(that, parameters);
          }
          that.configureHolder(item, src, p);
        });
        break;
      case "video":
        p.data({
          naturalWidth : item.options.width,
          naturalHeight : item.options.height
        });
        that.addContent(p, item);
        if ("function" == typeof $.callback.onRender) {
          $.callback.onRender.call(that, that.ui, key);
        }
        if ("function" == typeof item.options.onRender) {
          item.options.onRender.call(that, parameters);
        }
        that.configureHolder(item, src, p);
        break;
      case "iframe":
        that.showLoader();
        p.data({
          naturalWidth : item.options.width,
          naturalHeight : item.options.height
        });
        var element = that.addContent(p, item);
        if ("function" == typeof $.callback.onRender) {
          $.callback.onRender.call(that, that.ui, key);
        }
        if ("function" == typeof item.options.onRender) {
          item.options.onRender.call(that, parameters);
        }
        if ("function" == typeof $.callback.onBeforeLoad) {
          $.callback.onBeforeLoad.call(that, that.ui, key);
        }
        if ("function" == typeof item.options.onBeforeLoad) {
          item.options.onBeforeLoad.call(that, parameters);
        }
        element.bind("load", function() {
          if ("function" == typeof $.callback.onAfterLoad) {
            $.callback.onAfterLoad.call(that, that.ui, key);
          }
          if ("function" == typeof item.options.onAfterLoad) {
            item.options.onAfterLoad.call(that, parameters);
          }
          that.hideLoader();
          that.configureHolder(item, src, p);
          element.unbind("load");
        });
        break;
      case "inline":
        element = jQuery(item.URL);
        var target = that.addContent(p, item);
        var i = fnGetMediaUrls(p);
        p.data({
          naturalWidth : that.items[key].options.width || element.outerWidth(),
          naturalHeight : that.items[key].options.height || element.outerHeight()
        });
        target.children().eq(0).show();
        if ("function" == typeof $.callback.onRender) {
          $.callback.onRender.call(that, that.ui, key);
        }
        if ("function" == typeof item.options.onRender) {
          item.options.onRender.call(that, parameters);
        }
        if ("function" == typeof $.callback.onBeforeLoad) {
          $.callback.onBeforeLoad.call(that, that.ui, key);
        }
        if ("function" == typeof item.options.onBeforeLoad) {
          item.options.onBeforeLoad.call(that, parameters);
        }
        that.loadImage(i, function() {
          if ("function" == typeof $.callback.onAfterLoad) {
            $.callback.onAfterLoad.call(that, that.ui, key);
          }
          if ("function" == typeof item.options.onAfterLoad) {
            item.options.onAfterLoad.call(that, parameters);
          }
          that.configureHolder(item, src, p);
        });
        break;
      case "flash":
        element = that.addContent(p, item);
        p.data({
          naturalWidth : that.items[key].options.width || element.outerWidth(),
          naturalHeight : that.items[key].options.height || element.outerHeight()
        });
        if ("function" == typeof $.callback.onRender) {
          $.callback.onRender.call(that, that.ui, key);
        }
        if ("function" == typeof item.options.onRender) {
          item.options.onRender.call(that, parameters);
        }
        that.configureHolder(item, src, p);
        break;
      case "ajax":
        var options = item.options.ajax || {};
        if ("function" == typeof $.callback.onBeforeLoad) {
          $.callback.onBeforeLoad.call(that, that.ui, key);
        }
        if ("function" == typeof item.options.onBeforeLoad) {
          item.options.onBeforeLoad.call(that, parameters);
        }
        that.showLoader();
        jQuery.ajax({
          url : item.URL || $.ajaxSetup.url,
          data : options.data || null,
          dataType : options.dataType || "html",
          type : options.type || $.ajaxSetup.type,
          cache : options.cache || $.ajaxSetup.cache,
          crossDomain : options.crossDomain || $.ajaxSetup.crossDomain,
          global : options.global || $.ajaxSetup.global,
          ifModified : options.ifModified || $.ajaxSetup.ifModified,
          username : options.username || $.ajaxSetup.username,
          password : options.password || $.ajaxSetup.password,
          beforeSend : options.beforeSend || $.ajaxSetup.beforeSend,
          complete : options.complete || $.ajaxSetup.complete,
          success : function(b, status, e) {
            that.hideLoader();
            var i = jQuery(b);
            var txt = jQuery("div.ilightbox-container", p);
            var u = that.items[key].options.width || parseInt(i.attr("width"));
            var l = that.items[key].options.height || parseInt(i.attr("height"));
            /** @type {({overflow: string}|{})} */
            var v = i.attr("width") && i.attr("height") ? {
              overflow : "hidden"
            } : {};
            txt.empty().append(jQuery('<div class="ilightbox-wrapper"></div>').css(v).html(i));
            p.show().data({
              naturalWidth : u || txt.outerWidth(),
              naturalHeight : l || txt.outerHeight()
            }).hide();
            if ("function" == typeof $.callback.onRender) {
              $.callback.onRender.call(that, that.ui, key);
            }
            if ("function" == typeof item.options.onRender) {
              item.options.onRender.call(that, parameters);
            }
            i = fnGetMediaUrls(p);
            that.loadImage(i, function() {
              if ("function" == typeof $.callback.onAfterLoad) {
                $.callback.onAfterLoad.call(that, that.ui, key);
              }
              if ("function" == typeof item.options.onAfterLoad) {
                item.options.onAfterLoad.call(that, parameters);
              }
              that.configureHolder(item, src, p);
            });
            $.ajaxSetup.success(b, status, e);
            if ("function" == typeof options.success) {
              options.success(b, status, e);
            }
          },
          error : function(glee, params, m) {
            if ("function" == typeof $.callback.onAfterLoad) {
              $.callback.onAfterLoad.call(that, that.ui, key);
            }
            if ("function" == typeof item.options.onAfterLoad) {
              item.options.onAfterLoad.call(that, parameters);
            }
            that.hideLoader();
            jQuery("div.ilightbox-container", p).empty().append('<span class="ilightbox-alert">' + $.errors.loadContents + "</span>");
            that.configureHolder(item, src, p);
            $.ajaxSetup.error(glee, params, m);
            if ("function" == typeof options.error) {
              options.error(glee, params, m);
            }
          }
        });
        break;
      case "html":
        target = item.URL;
        container = jQuery("div.ilightbox-container", p);
        if (target[0].nodeName) {
          element = target.clone();
        } else {
          target = jQuery(target);
          element = target.selector ? jQuery("<div>" + target + "</div>") : target;
        }
        var y = that.items[key].options.width || parseInt(element.attr("width"));
        var s = that.items[key].options.height || parseInt(element.attr("height"));
        that.addContent(p, item);
        element.appendTo(document.documentElement).hide();
        if ("function" == typeof $.callback.onRender) {
          $.callback.onRender.call(that, that.ui, key);
        }
        if ("function" == typeof item.options.onRender) {
          item.options.onRender.call(that, parameters);
        }
        i = fnGetMediaUrls(p);
        if ("function" == typeof $.callback.onBeforeLoad) {
          $.callback.onBeforeLoad.call(that, that.ui, key);
        }
        if ("function" == typeof item.options.onBeforeLoad) {
          item.options.onBeforeLoad.call(that, parameters);
        }
        that.loadImage(i, function() {
          if ("function" == typeof $.callback.onAfterLoad) {
            $.callback.onAfterLoad.call(that, that.ui, key);
          }
          if ("function" == typeof item.options.onAfterLoad) {
            item.options.onAfterLoad.call(that, parameters);
          }
          p.show().data({
            naturalWidth : y || container.outerWidth(),
            naturalHeight : s || container.outerHeight()
          }).hide();
          element.remove();
          that.configureHolder(item, src, p);
        });
    }
  },
  configureHolder : function(options, to, t) {
    var self = this;
    var data = self.vars;
    var config = self.options;
    if ("current" != to) {
      if ("next" == to) {
        t.addClass("ilightbox-next");
      } else {
        t.addClass("ilightbox-prev");
      }
    }
    if ("current" == to) {
      var i = data.current;
    } else {
      if ("next" == to) {
        var target = config.styles.nextOpacity;
        i = data.next;
      } else {
        target = config.styles.prevOpacity;
        i = data.prev;
      }
    }
    var parameters = {
      element : t,
      position : i
    };
    self.items[i].options.width = self.items[i].options.width || 0;
    self.items[i].options.height = self.items[i].options.height || 0;
    if ("current" == to) {
      if (config.show.effect) {
        t.css(varPropTransform, varPropPerspective).fadeIn(options.speed, function() {
          t.css(varPropTransform, "");
          if (options.caption) {
            self.setCaption(options, t);
            var n = jQuery("div.ilightbox-caption", t);
            /** @type {number} */
            var whiteRating = parseInt(n.outerHeight() / t.outerHeight() * 100);
            if (config.caption.start & 50 >= whiteRating) {
              n.fadeIn(config.effects.fadeSpeed);
            }
          }
          if (n = options.options.social) {
            self.setSocial(n, options.URL, t);
            if (config.social.start) {
              jQuery("div.ilightbox-social", t).fadeIn(config.effects.fadeSpeed);
            }
          }
          self.generateThumbnails();
          if ("function" == typeof config.callback.onShow) {
            config.callback.onShow.call(self, self.ui, i);
          }
          if ("function" == typeof options.options.onShow) {
            options.options.onShow.call(self, parameters);
          }
        });
      } else {
        t.show();
        self.generateThumbnails();
        if ("function" == typeof config.callback.onShow) {
          config.callback.onShow.call(self, self.ui, i);
        }
        if ("function" == typeof options.options.onShow) {
          options.options.onShow.call(self, parameters);
        }
      }
    } else {
      if (config.show.effect) {
        t.fadeTo(options.speed, target, function() {
          if ("next" == to) {
            /** @type {boolean} */
            data.nextLock = false;
          } else {
            /** @type {boolean} */
            data.prevLock = false;
          }
          self.generateThumbnails();
          if ("function" == typeof config.callback.onShow) {
            config.callback.onShow.call(self, self.ui, i);
          }
          if ("function" == typeof options.options.onShow) {
            options.options.onShow.call(self, parameters);
          }
        });
      } else {
        t.css({
          opacity : target
        }).show();
        if ("next" == to) {
          /** @type {boolean} */
          data.nextLock = false;
        } else {
          /** @type {boolean} */
          data.prevLock = false;
        }
        self.generateThumbnails();
        if ("function" == typeof config.callback.onShow) {
          config.callback.onShow.call(self, self.ui, i);
        }
        if ("function" == typeof options.options.onShow) {
          options.options.onShow.call(self, parameters);
        }
      }
    }
    setTimeout(function() {
      self.repositionPhoto();
    }, 0);
  },
  generateBoxes : function() {
    var item = this.vars;
    var options = this.options;
    if (options.infinite && 3 <= item.total) {
      if (item.current == item.total - 1) {
        /** @type {number} */
        item.next = 0;
      }
      if (0 == item.current) {
        /** @type {number} */
        item.prev = item.total - 1;
      }
    } else {
      /** @type {boolean} */
      options.infinite = false;
    }
    this.loadContent(this.items[item.current], "current", options.show.speed);
    if (this.items[item.next]) {
      this.loadContent(this.items[item.next], "next", options.show.speed);
    }
    if (this.items[item.prev]) {
      this.loadContent(this.items[item.prev], "prev", options.show.speed);
    }
  },
  generateThumbnails : function() {
    var that = this;
    var data = that.vars;
    var o = that.options;
    /** @type {null} */
    var _takingTooLongTimeout = null;
    if (data.thumbs && !that.vars.dontGenerateThumbs) {
      var c = data.thumbnails;
      var q = jQuery("div.ilightbox-thumbnails-container", c);
      var item = jQuery("div.ilightbox-thumbnails-grid", q);
      /** @type {number} */
      var actor_timeout = 0;
      item.removeAttr("style").empty();
      jQuery.each(that.items, function(i, feature) {
        /** @type {string} */
        var n = data.current == i ? "ilightbox-active" : "";
        var textInputOpac = data.current == i ? o.thumbnails.activeOpacity : o.thumbnails.normalOpacity;
        var src = feature.options.thumbnail;
        var preview = jQuery('<div class="ilightbox-thumbnail"></div>');
        var title = jQuery('<div class="ilightbox-thumbnail-icon"></div>');
        preview.css({
          opacity : 0
        }).addClass(n);
        if ("video" != feature.type && "flash" != feature.type || "undefined" != typeof feature.options.icon) {
          if (feature.options.icon) {
            title.addClass("ilightbox-thumbnail-" + feature.options.icon);
            preview.append(title);
          }
        } else {
          title.addClass("ilightbox-thumbnail-video");
          preview.append(title);
        }
        if (src) {
          that.loadImage(src, function(img) {
            actor_timeout++;
            if (img) {
              preview.data({
                naturalWidth : img.width,
                naturalHeight : img.height
              }).append('<img src="' + src + '" border="0" />');
            } else {
              preview.data({
                naturalWidth : o.thumbnails.maxWidth,
                naturalHeight : o.thumbnails.maxHeight
              });
            }
            clearTimeout(_takingTooLongTimeout);
            /** @type {number} */
            _takingTooLongTimeout = setTimeout(function() {
              that.positionThumbnails(c, q, item);
            }, 20);
            setTimeout(function() {
              preview.fadeTo(o.effects.loadedFadeSpeed, textInputOpac);
            }, 20 * actor_timeout);
          });
        }
        item.append(preview);
      });
      /** @type {boolean} */
      that.vars.dontGenerateThumbs = true;
    }
  },
  positionThumbnails : function(t, n, i) {
    var context = this;
    var x = context.vars;
    var opts = context.options;
    var y = fnGetWindowDimensions();
    var rY = opts.path.toLowerCase();
    if (!t) {
      t = x.thumbnails;
    }
    if (!n) {
      n = jQuery("div.ilightbox-thumbnails-container", t);
    }
    if (!i) {
      i = jQuery("div.ilightbox-thumbnails-grid", n);
    }
    var c = jQuery(".ilightbox-thumbnail", i);
    /** @type {number} */
    x = "horizontal" == rY ? y.width - opts.styles.pageOffsetX : c.eq(0).outerWidth() - opts.styles.pageOffsetX;
    /** @type {number} */
    y = "horizontal" == rY ? c.eq(0).outerHeight() - opts.styles.pageOffsetY : y.height - opts.styles.pageOffsetY;
    /** @type {number} */
    var newX = "horizontal" == rY ? 0 : x;
    /** @type {number} */
    var d = "horizontal" == rY ? y : 0;
    var element = jQuery(".ilightbox-active", i);
    var s = {};
    if (3 > arguments.length) {
      c.css({
        opacity : opts.thumbnails.normalOpacity
      });
      element.css({
        opacity : opts.thumbnails.activeOpacity
      });
    }
    c.each(function($parent) {
      $parent = jQuery(this);
      var oImg = $parent.data();
      var width = "horizontal" == rY ? 0 : opts.thumbnails.maxWidth;
      height = "horizontal" == rY ? opts.thumbnails.maxHeight : 0;
      dims = context.getNewDimenstions(width, height, oImg.naturalWidth, oImg.naturalHeight, true);
      $parent.css({
        width : dims.width,
        height : dims.height
      });
      if ("horizontal" == rY) {
        $parent.css({
          "float" : "left"
        });
      }
      if ("horizontal" == rY) {
        newX = newX + $parent.outerWidth();
      } else {
        d = d + $parent.outerHeight();
      }
    });
    s = {
      width : newX,
      height : d
    };
    i.css(s);
    s = {};
    c = i.offset();
    var pos = element.length ? element.offset() : {
      top : parseInt(y / 2),
      left : parseInt(x / 2)
    };
    c.top -= $document.scrollTop();
    c.left -= $document.scrollLeft();
    /** @type {number} */
    pos.top = pos.top - c.top - $document.scrollTop();
    /** @type {number} */
    pos.left = pos.left - c.left - $document.scrollLeft();
    if ("horizontal" == rY) {
      /** @type {number} */
      s.top = 0;
      /** @type {number} */
      s.left = parseInt(x / 2 - pos.left - element.outerWidth() / 2);
    } else {
      /** @type {number} */
      s.top = parseInt(y / 2 - pos.top - element.outerHeight() / 2);
      /** @type {number} */
      s.left = 0;
    }
    if (3 > arguments.length) {
      i.stop().animate(s, opts.effects.repositionSpeed, "easeOutCirc");
    } else {
      i.css(s);
    }
  },
  loadImage : function(item, resolve) {
    if (!Array.isArray(item)) {
      /** @type {!Array} */
      item = [item];
    }
    var _ = this;
    var itemLen = item.length;
    if (0 < itemLen) {
      _.showLoader();
      jQuery.each(item, function(url, canCreateDiscussions) {
        /** @type {!Image} */
        var img = new Image;
        /**
         * @return {undefined}
         */
        img.onload = function() {
          /** @type {number} */
          itemLen = itemLen - 1;
          if (0 == itemLen) {
            _.hideLoader();
            resolve(img);
          }
        };
        /** @type {function(): undefined} */
        img.onerror = img.onabort = function() {
          /** @type {number} */
          itemLen = itemLen - 1;
          if (0 == itemLen) {
            _.hideLoader();
            resolve(false);
          }
        };
        img.src = item[url];
      });
    } else {
      resolve(false);
    }
  },
  patchItemsEvents : function() {
    var config = this;
    var data = config.vars;
    /** @type {string} */
    var eventName = varHasTouchEvents ? "itap.iLightBox" : "click.iLightBox";
    /** @type {string} */
    var $closingAreaRight = varHasTouchEvents ? "click.iLightBox" : "itap.iLightBox";
    jQuery.each(config.itemsObject, function(index, $mmEvents) {
      $mmEvents.on(eventName, function() {
        /** @type {number} */
        data.current = index;
        data.next = config.items[index + 1] ? index + 1 : null;
        /** @type {(null|number)} */
        data.prev = config.items[index - 1] ? index - 1 : null;
        config.addContents();
        config.patchEvents();
        return false;
      }).on($closingAreaRight, function() {
        return false;
      });
    });
  },
  dispatchItemsEvents : function() {
    jQuery.each(this.itemsObject, function(a, PlaybackModel) {
      PlaybackModel.off(".iLightBox");
    });
  },
  refresh : function() {
    this.dispatchItemsEvents();
    this.attachItems();
    this.normalizeItems();
    this.patchItemsEvents();
  },
  patchEvents : function() {
    /**
     * @param {!Object} e
     * @return {undefined}
     */
    function start(e) {
      if (!("mousemove" !== e.type || data.isMobile)) {
        if (!data.mouseID) {
          data.hideableElements.show();
        }
        data.mouseID = clearTimeout(data.mouseID);
        /** @type {number} */
        data.mouseID = setTimeout(function() {
          data.hideableElements.hide();
          data.mouseID = clearTimeout(data.mouseID);
        }, 3E3);
      }
    }
    var me = this;
    var data = me.vars;
    var self = me.options;
    var center = self.path.toLowerCase();
    var r = jQuery(".ilightbox-holder");
    /** @type {string} */
    var m = varFullscreenState.fullScreenEventName + ".iLightBox";
    /** @type {number} */
    var l = verticalDistanceThreshold = 100;
    $window.bind("resize.iLightBox", function() {
      var rect = fnGetWindowDimensions();
      if (self.mobileOptimizer && !self.innerToolbar) {
        /** @type {boolean} */
        data.isMobile = rect.width <= data.mobileMaxWidth;
      }
      data.BODY[data.isMobile ? "addClass" : "removeClass"]("isMobile");
      me.repositionPhoto(null);
      if (varHasTouchEvents) {
        clearTimeout(data.setTime);
        /** @type {number} */
        data.setTime = setTimeout(function() {
          var scrollTop = fnGetPageOffset().y;
          window.scrollTo(0, scrollTop - 30);
          window.scrollTo(0, scrollTop + 30);
          window.scrollTo(0, scrollTop);
        }, 2E3);
      }
      if (data.thumbs) {
        me.positionThumbnails();
      }
    }).bind("keydown.iLightBox", function(event) {
      if (self.controls.keyboard) {
        switch(event.keyCode) {
          case 13:
            if (event.shiftKey && self.keyboard.shift_enter) {
              me.fullScreenAction();
            }
            break;
          case 27:
            if (self.keyboard.esc) {
              me.closeAction();
            }
            break;
          case 37:
            if (self.keyboard.left && !data.lockKey) {
              me.moveTo("prev");
            }
            break;
          case 38:
            if (self.keyboard.up && !data.lockKey) {
              me.moveTo("prev");
            }
            break;
          case 39:
            if (self.keyboard.right && !data.lockKey) {
              me.moveTo("next");
            }
            break;
          case 40:
            if (self.keyboard.down && !data.lockKey) {
              me.moveTo("next");
            }
        }
      }
    });
    if (varFullscreenState.supportsFullScreen) {
      $window.bind(m, function() {
        me.doFullscreen();
      });
    }
    /** @type {!Array<?>} */
    m = [self.caption.show + ".iLightBox", self.caption.hide + ".iLightBox", self.social.show + ".iLightBox", self.social.hide + ".iLightBox"].filter(function(item, value, c) {
      return c.lastIndexOf(item) === value;
    });
    /** @type {string} */
    var k = "";
    jQuery.each(m, function(a, miniBatchSize) {
      if (0 != a) {
        k = k + " ";
      }
      k = k + miniBatchSize;
    });
    $document.on(varEventClick, ".ilightbox-overlay", function() {
      if (self.overlay.blur) {
        me.closeAction();
      }
    }).on(varEventClick, ".ilightbox-next, .ilightbox-next-button", function() {
      me.moveTo("next");
    }).on(varEventClick, ".ilightbox-prev, .ilightbox-prev-button", function() {
      me.moveTo("prev");
    }).on(varEventClick, ".ilightbox-thumbnail", function() {
      var index = jQuery(this);
      index = jQuery(".ilightbox-thumbnail", data.thumbnails).index(index);
      if (index != data.current) {
        me.goTo(index);
      }
    }).on(k, ".ilightbox-holder:not(.ilightbox-next, .ilightbox-prev)", function(verifiedEvent) {
      var o = jQuery("div.ilightbox-caption", data.holder);
      var list = jQuery("div.ilightbox-social", data.holder);
      var to = self.effects.fadeSpeed;
      if (data.nextLock || data.prevLock) {
        if (verifiedEvent.type != self.caption.show || o.is(":visible")) {
          if (verifiedEvent.type == self.caption.hide && o.is(":visible")) {
            o.fadeOut(to);
          }
        } else {
          o.fadeIn(to);
        }
        if (verifiedEvent.type != self.social.show || list.is(":visible")) {
          if (verifiedEvent.type == self.social.hide && list.is(":visible")) {
            list.fadeOut(to);
          }
        } else {
          list.fadeIn(to);
        }
      } else {
        if (verifiedEvent.type != self.caption.show || o.is(":visible")) {
          if (verifiedEvent.type == self.caption.hide && o.is(":visible")) {
            o.stop().fadeOut(to);
          }
        } else {
          o.stop().fadeIn(to);
        }
        if (verifiedEvent.type != self.social.show || list.is(":visible")) {
          if (verifiedEvent.type == self.social.hide && list.is(":visible")) {
            list.stop().fadeOut(to);
          }
        } else {
          list.stop().fadeIn(to);
        }
      }
    }).on("mouseenter.iLightBox mouseleave.iLightBox", ".ilightbox-wrapper", function(e) {
      /** @type {boolean} */
      data.lockWheel = "mouseenter" == e.type ? true : false;
    }).on(varEventClick, ".ilightbox-toolbar a.ilightbox-close, .ilightbox-toolbar a.ilightbox-fullscreen, .ilightbox-toolbar a.ilightbox-play, .ilightbox-toolbar a.ilightbox-pause", function() {
      var fieldset = jQuery(this);
      if (fieldset.hasClass("ilightbox-fullscreen")) {
        me.fullScreenAction();
      } else {
        if (fieldset.hasClass("ilightbox-play")) {
          me.resume();
          fieldset.addClass("ilightbox-pause").removeClass("ilightbox-play");
        } else {
          if (fieldset.hasClass("ilightbox-pause")) {
            me.pause();
            fieldset.addClass("ilightbox-play").removeClass("ilightbox-pause");
          } else {
            me.closeAction();
          }
        }
      }
    }).on(varEventMouseMove, ".ilightbox-overlay, .ilightbox-thumbnails-container", function(event) {
      event.preventDefault();
    });
    if (self.controls.arrows && !varHasTouchEvents) {
      $document.on("mousemove.iLightBox", start);
    }
    if (self.controls.slideshow && self.slideshow.pauseOnHover) {
      $document.on("mouseenter.iLightBox mouseleave.iLightBox", ".ilightbox-holder:not(.ilightbox-next, .ilightbox-prev)", function(e) {
        if ("mouseenter" == e.type && data.cycleID) {
          me.pause();
        } else {
          if ("mouseleave" == e.type && data.isPaused) {
            me.resume();
          }
        }
      });
    }
    m = jQuery(".ilightbox-overlay, .ilightbox-holder, .ilightbox-thumbnails");
    if (self.controls.mousewheel) {
      m.on("mousewheel.iLightBox", function(event, canCreateDiscussions) {
        if (!data.lockWheel) {
          event.preventDefault();
          if (0 > canCreateDiscussions) {
            me.moveTo("next");
          } else {
            if (0 < canCreateDiscussions) {
              me.moveTo("prev");
            }
          }
        }
      });
    }
    if (self.controls.swipe) {
      r.on(varEventMousedown, function(event) {
        /**
         * @param {!Object} e
         * @return {undefined}
         */
        function init(e) {
          if (start) {
            var point = e.originalEvent.touches ? e.originalEvent.touches[0] : e;
            stop = {
              time : (new Date).getTime(),
              coords : [point.pageX - offsetX, point.pageY - offsetY]
            };
            r.each(function() {
              var b = jQuery(this);
              var x = b.data("offset") || {
                top : b.offset().top - offsetY,
                left : b.offset().left - offsetX
              };
              /** @type {number} */
              var y = x.top;
              /** @type {number} */
              x = x.left;
              /** @type {!Array} */
              var remoteX = [start.coords[0] - stop.coords[0], start.coords[1] - stop.coords[1]];
              if ("horizontal" == center) {
                b.stop().css({
                  left : x - remoteX[0]
                });
              } else {
                b.stop().css({
                  top : y - remoteX[1]
                });
              }
            });
            e.preventDefault();
          }
        }
        /**
         * @return {undefined}
         */
        function chart() {
          r.each(function() {
            var t = jQuery(this);
            var val = t.data("offset") || {
              top : t.offset().top - offsetY,
              left : t.offset().left - offsetX
            };
            /** @type {number} */
            var y = val.top;
            /** @type {number} */
            val = val.left;
            t.css(varPropTransform, varPropPerspective).stop().animate({
              top : y,
              left : val
            }, 500, "easeOutCirc", function() {
              t.css(varPropTransform, "");
            });
          });
        }
        if (!data.nextLock && !data.prevLock && 1 != data.total && !data.lockSwipe) {
          data.BODY.addClass("ilightbox-closedhand");
          event = event.originalEvent.touches ? event.originalEvent.touches[0] : event;
          var offsetY = $document.scrollTop();
          var offsetX = $document.scrollLeft();
          var start = {
            time : (new Date).getTime(),
            coords : [event.pageX - offsetX, event.pageY - offsetY]
          };
          var stop;
          r.bind(varEventMouseMove, init);
          $document.one(varEventMouseup, function(a) {
            r.unbind(varEventMouseMove, init);
            data.BODY.removeClass("ilightbox-closedhand");
            if (start && stop) {
              if ("horizontal" == center && 1E3 > stop.time - start.time && Math.abs(start.coords[0] - stop.coords[0]) > l && Math.abs(start.coords[1] - stop.coords[1]) < verticalDistanceThreshold) {
                if (start.coords[0] > stop.coords[0]) {
                  if (data.current != data.total - 1 || self.infinite) {
                    /** @type {boolean} */
                    data.isSwipe = true;
                    me.moveTo("next");
                  } else {
                    chart();
                  }
                } else {
                  if (0 != data.current || self.infinite) {
                    /** @type {boolean} */
                    data.isSwipe = true;
                    me.moveTo("prev");
                  } else {
                    chart();
                  }
                }
              } else {
                if ("vertical" == center && 1E3 > stop.time - start.time && Math.abs(start.coords[1] - stop.coords[1]) > l && Math.abs(start.coords[0] - stop.coords[0]) < verticalDistanceThreshold) {
                  if (start.coords[1] > stop.coords[1]) {
                    if (data.current != data.total - 1 || self.infinite) {
                      /** @type {boolean} */
                      data.isSwipe = true;
                      me.moveTo("next");
                    } else {
                      chart();
                    }
                  } else {
                    if (0 != data.current || self.infinite) {
                      /** @type {boolean} */
                      data.isSwipe = true;
                      me.moveTo("prev");
                    } else {
                      chart();
                    }
                  }
                } else {
                  chart();
                }
              }
            }
            start = stop = H$jscomp$0;
          });
        }
      });
    }
  },
  goTo : function(i) {
    var that = this;
    var data = that.vars;
    var opts = that.options;
    /** @type {number} */
    var snI = i - data.current;
    if (opts.infinite) {
      if (i == data.total - 1 && 0 == data.current) {
        /** @type {number} */
        snI = -1;
      }
      if (data.current == data.total - 1 && 0 == i) {
        /** @type {number} */
        snI = 1;
      }
    }
    if (1 == snI) {
      that.moveTo("next");
    } else {
      if (-1 == snI) {
        that.moveTo("prev");
      } else {
        if (data.nextLock || data.prevLock) {
          return false;
        }
        if ("function" == typeof opts.callback.onBeforeChange) {
          opts.callback.onBeforeChange.call(that, that.ui);
        }
        if (opts.linkId) {
          /** @type {boolean} */
          data.hashLock = true;
          /** @type {string} */
          window.location.hash = opts.linkId + "/" + i;
        }
        if (that.items[i]) {
          if (that.items[i].options.mousewheel) {
            /** @type {boolean} */
            that.vars.lockWheel = false;
          } else {
            /** @type {boolean} */
            data.lockWheel = true;
          }
          /** @type {boolean} */
          data.lockSwipe = that.items[i].options.swipe ? false : true;
        }
        jQuery.each([data.holder, data.nextPhoto, data.prevPhoto], function(a, Utils) {
          Utils.css(varPropTransform, varPropPerspective).fadeOut(opts.effects.loadedFadeSpeed);
        });
        /** @type {number} */
        data.current = i;
        data.next = i + 1;
        /** @type {number} */
        data.prev = i - 1;
        that.createUI();
        setTimeout(function() {
          that.generateBoxes();
        }, opts.effects.loadedFadeSpeed + 50);
        jQuery(".ilightbox-thumbnail", data.thumbnails).removeClass("ilightbox-active").eq(i).addClass("ilightbox-active");
        that.positionThumbnails();
        if (opts.linkId) {
          setTimeout(function() {
            /** @type {boolean} */
            data.hashLock = false;
          }, 55);
        }
        if (!opts.infinite) {
          data.nextButton.add(data.prevButton).add(data.innerPrevButton).add(data.innerNextButton).removeClass("disabled");
          if (0 == data.current) {
            data.prevButton.add(data.innerPrevButton).addClass("disabled");
          }
          if (data.current >= data.total - 1) {
            data.nextButton.add(data.innerNextButton).addClass("disabled");
          }
        }
        that.resetCycle();
        if ("function" == typeof opts.callback.onAfterChange) {
          opts.callback.onAfterChange.call(that, that.ui);
        }
      }
    }
  },
  moveTo : function(d) {
    var that = this;
    var self = that.vars;
    var data = that.options;
    var BODY = data.path.toLowerCase();
    var x = fnGetWindowDimensions();
    var transition = data.effects.switchSpeed;
    if (self.nextLock || self.prevLock) {
      return false;
    }
    var i = "next" == d ? self.next : self.prev;
    if (data.linkId) {
      /** @type {boolean} */
      self.hashLock = true;
      /** @type {string} */
      window.location.hash = data.linkId + "/" + i;
    }
    if ("next" == d) {
      if (!that.items[i]) {
        return false;
      }
      var el = self.nextPhoto;
      var b = self.holder;
      var node = self.prevPhoto;
      /** @type {string} */
      var y = "ilightbox-prev";
      /** @type {string} */
      var classIdPrefix = "ilightbox-next";
    } else {
      if ("prev" == d) {
        if (!that.items[i]) {
          return false;
        }
        el = self.prevPhoto;
        b = self.holder;
        node = self.nextPhoto;
        /** @type {string} */
        y = "ilightbox-next";
        /** @type {string} */
        classIdPrefix = "ilightbox-prev";
      }
    }
    if ("function" == typeof data.callback.onBeforeChange) {
      data.callback.onBeforeChange.call(that, that.ui);
    }
    if ("next" == d) {
      /** @type {boolean} */
      self.nextLock = true;
    } else {
      /** @type {boolean} */
      self.prevLock = true;
    }
    var n = jQuery("div.ilightbox-caption", b);
    var r = jQuery("div.ilightbox-social", b);
    if (n.length) {
      n.stop().fadeOut(transition, function() {
        jQuery(this).remove();
      });
    }
    if (r.length) {
      r.stop().fadeOut(transition, function() {
        jQuery(this).remove();
      });
    }
    if (that.items[i].caption) {
      that.setCaption(that.items[i], el);
      n = jQuery("div.ilightbox-caption", el);
      /** @type {number} */
      r = parseInt(n.outerHeight() / el.outerHeight() * 100);
      if (data.caption.start && 50 >= r) {
        n.fadeIn(transition);
      }
    }
    if (n = that.items[i].options.social) {
      that.setSocial(n, that.items[i].URL, el);
      if (data.social.start) {
        jQuery("div.ilightbox-social", el).fadeIn(data.effects.fadeSpeed);
      }
    }
    jQuery.each([el, b, node], function(a, miniWidget) {
      miniWidget.removeClass("ilightbox-next ilightbox-prev");
    });
    var o = el.data("offset");
    /** @type {number} */
    n = x.width - data.styles.pageOffsetX;
    /** @type {number} */
    x = x.height - data.styles.pageOffsetY;
    r = o.newDims.width;
    var e = o.newDims.height;
    var t = o.thumbsOffset;
    o = o.diff;
    /** @type {number} */
    var pos = parseInt(x / 2 - e / 2 - o.H - t.H / 2);
    /** @type {number} */
    o = parseInt(n / 2 - r / 2 - o.W - t.W / 2);
    el.css(varPropTransform, varPropPerspective).animate({
      top : pos,
      left : o,
      opacity : 1
    }, transition, self.isSwipe ? "easeOutCirc" : "easeInOutCirc", function() {
      el.css(varPropTransform, "");
    });
    jQuery("div.ilightbox-container", el).animate({
      width : r,
      height : e
    }, transition, self.isSwipe ? "easeOutCirc" : "easeInOutCirc");
    e = b.data("offset");
    var a = e.object;
    o = e.diff;
    r = e.newDims.width;
    e = e.newDims.height;
    /** @type {number} */
    r = parseInt(r * data.styles["next" == d ? "prevScale" : "nextScale"]);
    /** @type {number} */
    e = parseInt(e * data.styles["next" == d ? "prevScale" : "nextScale"]);
    /** @type {number} */
    pos = "horizontal" == BODY ? parseInt(x / 2 - a.offsetY - e / 2 - o.H - t.H / 2) : parseInt(x - a.offsetX - o.H - t.H / 2);
    if ("prev" == d) {
      /** @type {number} */
      o = "horizontal" == BODY ? parseInt(n - a.offsetX - o.W - t.W / 2) : parseInt(n / 2 - r / 2 - o.W - a.offsetY - t.W / 2);
    } else {
      /** @type {number} */
      pos = "horizontal" == BODY ? pos : parseInt(a.offsetX - o.H - e - t.H / 2);
      /** @type {number} */
      o = "horizontal" == BODY ? parseInt(a.offsetX - o.W - r - t.W / 2) : parseInt(n / 2 - a.offsetY - r / 2 - o.W - t.W / 2);
    }
    jQuery("div.ilightbox-container", b).animate({
      width : r,
      height : e
    }, transition, self.isSwipe ? "easeOutCirc" : "easeInOutCirc");
    b.addClass(y).css(varPropTransform, varPropPerspective).animate({
      top : pos,
      left : o,
      opacity : data.styles.prevOpacity
    }, transition, self.isSwipe ? "easeOutCirc" : "easeInOutCirc", function() {
      b.css(varPropTransform, "");
      jQuery(".ilightbox-thumbnail", self.thumbnails).removeClass("ilightbox-active").eq(i).addClass("ilightbox-active");
      that.positionThumbnails();
      if (that.items[i]) {
        /** @type {boolean} */
        self.lockWheel = that.items[i].options.mousewheel ? false : true;
        /** @type {boolean} */
        self.lockSwipe = that.items[i].options.swipe ? false : true;
      }
      /** @type {boolean} */
      self.isSwipe = false;
      if ("next" == d) {
        self.nextPhoto = node;
        self.prevPhoto = b;
        self.holder = el;
        self.nextPhoto.hide();
        self.next += 1;
        self.prev = self.current;
        self.current += 1;
        if (data.infinite) {
          if (self.current > self.total - 1) {
            /** @type {number} */
            self.current = 0;
          }
          if (self.current == self.total - 1) {
            /** @type {number} */
            self.next = 0;
          }
          if (0 == self.current) {
            /** @type {number} */
            self.prev = self.total - 1;
          }
        }
        that.createUI();
        if (that.items[self.next]) {
          that.loadContent(that.items[self.next], "next");
        } else {
          /** @type {boolean} */
          self.nextLock = false;
        }
      } else {
        self.prevPhoto = node;
        self.nextPhoto = b;
        self.holder = el;
        self.prevPhoto.hide();
        self.next = self.current;
        self.current = self.prev;
        /** @type {number} */
        self.prev = self.current - 1;
        if (data.infinite) {
          if (self.current == self.total - 1) {
            /** @type {number} */
            self.next = 0;
          }
          if (0 == self.current) {
            /** @type {number} */
            self.prev = self.total - 1;
          }
        }
        that.createUI();
        if (that.items[self.prev]) {
          that.loadContent(that.items[self.prev], "prev");
        } else {
          /** @type {boolean} */
          self.prevLock = false;
        }
      }
      if (data.linkId) {
        setTimeout(function() {
          /** @type {boolean} */
          self.hashLock = false;
        }, 55);
      }
      if (!data.infinite) {
        self.nextButton.add(self.prevButton).add(self.innerPrevButton).add(self.innerNextButton).removeClass("disabled");
        if (0 == self.current) {
          self.prevButton.add(self.innerPrevButton).addClass("disabled");
        }
        if (self.current >= self.total - 1) {
          self.nextButton.add(self.innerNextButton).addClass("disabled");
        }
      }
      that.repositionPhoto();
      that.resetCycle();
      if ("function" == typeof data.callback.onAfterChange) {
        data.callback.onAfterChange.call(that, that.ui);
      }
    });
    pos = "horizontal" == BODY ? fnGetElementDimension(node, "top") : "next" == d ? parseInt(-(x / 2) - node.outerHeight()) : parseInt(2 * pos);
    o = "horizontal" == BODY ? "next" == d ? parseInt(-(n / 2) - node.outerWidth()) : parseInt(2 * o) : fnGetElementDimension(node, "left");
    node.css(varPropTransform, varPropPerspective).animate({
      top : pos,
      left : o,
      opacity : data.styles.nextOpacity
    }, transition, self.isSwipe ? "easeOutCirc" : "easeInOutCirc", function() {
      node.css(varPropTransform, "");
    }).addClass(classIdPrefix);
  },
  setCaption : function(element, content) {
    var table = jQuery('<div class="ilightbox-caption"></div>');
    if (element.caption) {
      table.html(element.caption);
      jQuery("div.ilightbox-container", content).append(table);
    }
  },
  normalizeSocial : function(nodes, key) {
    var opts = this.options;
    /** @type {string} */
    var a = window.location.href;
    jQuery.each(nodes, function(i, options) {
      var format;
      var err;
      switch(i.toLowerCase()) {
        case "facebook":
          /** @type {string} */
          format = "http://www.facebook.com/share.php?v=4&src=bm&u={URL}";
          /** @type {string} */
          err = "Share on Facebook";
          break;
        case "twitter":
          /** @type {string} */
          format = "http://twitter.com/home?status={URL}";
          /** @type {string} */
          err = "Share on Twitter";
          break;
        case "googleplus":
          /** @type {string} */
          format = "https://plus.google.com/share?url={URL}";
          /** @type {string} */
          err = "Share on Google+";
          break;
        case "delicious":
          /** @type {string} */
          format = "http://delicious.com/post?url={URL}";
          /** @type {string} */
          err = "Share on Delicious";
          break;
        case "digg":
          /** @type {string} */
          format = "http://digg.com/submit?phase=2&url={URL}";
          /** @type {string} */
          err = "Share on Digg";
          break;
        case "reddit":
          /** @type {string} */
          format = "http://reddit.com/submit?url={URL}";
          /** @type {string} */
          err = "Share on reddit";
      }
      nodes[i] = {
        URL : options.URL && fnNormalizeUrl(a, options.URL) || opts.linkId && window.location.href || "string" !== typeof key && a || key && fnNormalizeUrl(a, key) || a,
        source : options.source || format || options.URL && fnNormalizeUrl(a, options.URL) || key && fnNormalizeUrl(a, key),
        text : err || options.text || "Share on " + i,
        width : "undefined" == typeof options.width || isNaN(options.width) ? 640 : parseInt(options.width),
        height : options.height || 360
      };
    });
    return nodes;
  },
  setSocial : function(index, container, y) {
    var title = jQuery('<div class="ilightbox-social"></div>');
    /** @type {string} */
    var titleStr = "<ul>";
    index = this.normalizeSocial(index, container);
    jQuery.each(index, function(p_Interval, data) {
      p_Interval.toLowerCase();
      var c = data.source.replace("{URL}", encodeURIComponent(data.URL).replace(/!/g, "%21").replace(/'/g, "%27").replace(/\(/g, "%28").replace(/\)/g, "%29").replace(/\*/g, "%2A").replace(/%20/g, "+"));
      titleStr = titleStr + ('<li class="' + p_Interval + '"><a href="' + c + '" onclick="javascript:window.open(this.href' + (0 >= data.width || 0 >= data.height ? "" : ", '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=" + data.height + ",width=" + data.width + ",left=40,top=40'") + ');return false;" title="' + data.text + '" target="_blank"></a></li>');
    });
    titleStr = titleStr + "</ul>";
    title.html(titleStr);
    jQuery("div.ilightbox-container", y).append(title);
  },
  fullScreenAction : function() {
    if (varFullscreenState.supportsFullScreen) {
      if (varFullscreenState.isFullScreen()) {
        varFullscreenState.cancelFullScreen(document.documentElement);
      } else {
        varFullscreenState.requestFullScreen(document.documentElement);
      }
    } else {
      this.doFullscreen();
    }
  },
  doFullscreen : function() {
    var options = this.vars;
    var c = fnGetWindowDimensions();
    var $ = this.options;
    if ($.fullAlone) {
      var $clone = options.holder;
      var h = this.items[options.current];
      var width = c.width;
      var d = c.height;
      /** @type {!Array} */
      var graphInit = [$clone, options.nextPhoto, options.prevPhoto, options.nextButton, options.prevButton, options.overlay, options.toolbar, options.thumbnails, options.loader];
      /** @type {!Array} */
      c = [options.nextPhoto, options.prevPhoto, options.nextButton, options.prevButton, options.loader, options.thumbnails];
      if (options.isInFullScreen) {
        /** @type {boolean} */
        options.isInFullScreen = options.lockKey = options.lockWheel = options.lockSwipe = false;
        options.overlay.css({
          opacity : this.options.overlay.opacity
        });
        jQuery.each(c, function(a, commonModal) {
          commonModal.show();
        });
        options.fullScreenButton.attr("title", $.text.enterFullscreen);
        $clone.data({
          naturalWidth : $clone.data("naturalWidthOld"),
          naturalHeight : $clone.data("naturalHeightOld"),
          naturalWidthOld : null,
          naturalHeightOld : null
        });
        jQuery.each(graphInit, function(a, miniWidget) {
          miniWidget.removeClass("ilightbox-fullscreen");
        });
        if ("function" == typeof $.callback.onExitFullScreen) {
          $.callback.onExitFullScreen.call(this, this.ui);
        }
      } else {
        /** @type {boolean} */
        options.isInFullScreen = options.lockKey = options.lockWheel = options.lockSwipe = true;
        options.overlay.css({
          opacity : 1
        });
        jQuery.each(c, function(a, EmptyContentCollectionOverlay) {
          EmptyContentCollectionOverlay.hide();
        });
        options.fullScreenButton.attr("title", $.text.exitFullscreen);
        if (-1 != $.fullStretchTypes.indexOf(h.type)) {
          $clone.data({
            naturalWidthOld : $clone.data("naturalWidth"),
            naturalHeightOld : $clone.data("naturalHeight"),
            naturalWidth : width,
            naturalHeight : d
          });
        } else {
          c = h.options.fullViewPort || $.fullViewPort || "";
          options = width;
          h = d;
          width = $clone.data("naturalWidth");
          var height = $clone.data("naturalHeight");
          if ("fill" == c.toLowerCase()) {
            /** @type {number} */
            h = options / width * height;
            if (h < d) {
              /** @type {number} */
              options = d / height * width;
              h = d;
            }
          } else {
            if ("fit" == c.toLowerCase()) {
              d = this.getNewDimenstions(options, h, width, height, true);
              options = d.width;
              h = d.height;
            } else {
              if ("stretch" != c.toLowerCase()) {
                d = this.getNewDimenstions(options, h, width, height, width > options || height > h ? true : false);
                options = d.width;
                h = d.height;
              }
            }
          }
          $clone.data({
            naturalWidthOld : $clone.data("naturalWidth"),
            naturalHeightOld : $clone.data("naturalHeight"),
            naturalWidth : options,
            naturalHeight : h
          });
        }
        jQuery.each(graphInit, function(a, $tabSelector) {
          $tabSelector.addClass("ilightbox-fullscreen");
        });
        if ("function" == typeof $.callback.onEnterFullScreen) {
          $.callback.onEnterFullScreen.call(this, this.ui);
        }
      }
    } else {
      /** @type {boolean} */
      options.isInFullScreen = options.isInFullScreen ? false : true;
    }
    this.repositionPhoto(true);
  },
  closeAction : function() {
    var data = this.vars;
    var opts = this.options;
    $window.unbind(".iLightBox");
    if (data.isInFullScreen) {
      varFullscreenState.cancelFullScreen(document.documentElement);
    }
    $document.off(".iLightBox");
    jQuery(".ilightbox-overlay, .ilightbox-holder, .ilightbox-thumbnails").off(".iLightBox");
    if (opts.hide.effect) {
      data.overlay.stop().fadeOut(opts.hide.speed, function() {
        data.overlay.remove();
        data.BODY.removeClass("ilightbox-noscroll").off(".iLightBox");
      });
    } else {
      data.overlay.remove();
      data.BODY.removeClass("ilightbox-noscroll").off(".iLightBox");
    }
    jQuery.each([data.toolbar, data.holder, data.nextPhoto, data.prevPhoto, data.nextButton, data.prevButton, data.loader, data.thumbnails], function(a, $ori) {
      $ori.removeAttr("style").remove();
    });
    /** @type {boolean} */
    data.dontGenerateThumbs = data.isInFullScreen = false;
    /** @type {null} */
    window.iLightBox = null;
    if (opts.linkId) {
      /** @type {boolean} */
      data.hashLock = true;
      fnScrollToPageOffset();
      setTimeout(function() {
        /** @type {boolean} */
        data.hashLock = false;
      }, 55);
    }
    if ("function" == typeof opts.callback.onHide) {
      opts.callback.onHide.call(this, this.ui);
    }
  },
  repositionPhoto : function() {
    var data = this.vars;
    var options = this.options;
    var left = options.path.toLowerCase();
    var item = fnGetWindowDimensions();
    var surfaceWidth = item.width;
    var d = item.height;
    item = data.isInFullScreen && options.fullAlone || data.isMobile ? 0 : "horizontal" == left ? 0 : data.thumbnails.outerWidth();
    var speed = data.isMobile ? data.toolbar.outerHeight() : data.isInFullScreen && options.fullAlone ? 0 : "horizontal" == left ? data.thumbnails.outerHeight() : 0;
    surfaceWidth = data.isInFullScreen && options.fullAlone ? surfaceWidth : surfaceWidth - options.styles.pageOffsetX;
    d = data.isInFullScreen && options.fullAlone ? d : d - options.styles.pageOffsetY;
    var l = "horizontal" == left ? parseInt(this.items[data.next] || this.items[data.prev] ? 2 * (options.styles.nextOffsetX + options.styles.prevOffsetX) : 30 >= surfaceWidth / 10 ? 30 : surfaceWidth / 10) : parseInt(30 >= surfaceWidth / 10 ? 30 : surfaceWidth / 10) + item;
    var k = "horizontal" == left ? parseInt(30 >= d / 10 ? 30 : d / 10) + speed : parseInt(this.items[data.next] || this.items[data.prev] ? 2 * (options.styles.nextOffsetX + options.styles.prevOffsetX) : 30 >= d / 10 ? 30 : d / 10);
    item = {
      type : "current",
      width : surfaceWidth,
      height : d,
      item : this.items[data.current],
      offsetW : l,
      offsetH : k,
      thumbsOffsetW : item,
      thumbsOffsetH : speed,
      animate : arguments.length,
      holder : data.holder
    };
    this.repositionEl(item);
    if (this.items[data.next]) {
      item = jQuery.extend(item, {
        type : "next",
        item : this.items[data.next],
        offsetX : options.styles.nextOffsetX,
        offsetY : options.styles.nextOffsetY,
        holder : data.nextPhoto
      });
      this.repositionEl(item);
    }
    if (this.items[data.prev]) {
      item = jQuery.extend(item, {
        type : "prev",
        item : this.items[data.prev],
        offsetX : options.styles.prevOffsetX,
        offsetY : options.styles.prevOffsetY,
        holder : data.prevPhoto
      });
      this.repositionEl(item);
    }
    /** @type {({left: number}|{top: number})} */
    options = "horizontal" == left ? {
      left : parseInt(surfaceWidth / 2 - data.loader.outerWidth() / 2)
    } : {
      top : parseInt(d / 2 - data.loader.outerHeight() / 2)
    };
    data.loader.css(options);
  },
  repositionEl : function(data) {
    var width = this.vars;
    var options = this.options;
    var to = options.path.toLowerCase();
    var max = "current" == data.type ? width.isInFullScreen && options.fullAlone ? data.width : data.width - data.offsetW : data.width - data.offsetW;
    var w = "current" == data.type ? width.isInFullScreen && options.fullAlone ? data.height : data.height - data.offsetH : data.height - data.offsetH;
    var val = data.item;
    var d = data.item.options;
    var el = data.holder;
    var x = data.offsetX || 0;
    var left = data.offsetY || 0;
    var padding = data.thumbsOffsetW;
    var i = data.thumbsOffsetH;
    if ("current" == data.type) {
      if ("number" == typeof d.width && d.width) {
        max = width.isInFullScreen && options.fullAlone && (-1 != options.fullStretchTypes.indexOf(val.type) || d.fullViewPort || options.fullViewPort) ? max : d.width > max ? max : d.width;
      }
      if ("number" == typeof d.height && d.height) {
        w = width.isInFullScreen && options.fullAlone && (-1 != options.fullStretchTypes.indexOf(val.type) || d.fullViewPort || options.fullViewPort) ? w : d.height > w ? w : d.height;
      }
    } else {
      if ("number" == typeof d.width && d.width) {
        max = d.width > max ? max : d.width;
      }
      if ("number" == typeof d.height && d.height) {
        w = d.height > w ? w : d.height;
      }
    }
    /** @type {number} */
    w = parseInt(w - jQuery(".ilightbox-inner-toolbar", el).outerHeight());
    width = "string" == typeof d.width && -1 != d.width.indexOf("%") ? fnParseInt(parseInt(d.width.replace("%", "")), data.width) : el.data("naturalWidth");
    val = "string" == typeof d.height && -1 != d.height.indexOf("%") ? fnParseInt(parseInt(d.height.replace("%", "")), data.height) : el.data("naturalHeight");
    val = "string" == typeof d.width && -1 != d.width.indexOf("%") || "string" == typeof d.height && -1 != d.height.indexOf("%") ? {
      width : width,
      height : val
    } : this.getNewDimenstions(max, w, width, val);
    max = jQuery.extend({}, val, {});
    if ("prev" == data.type || "next" == data.type) {
      /** @type {number} */
      width = parseInt(val.width * ("next" == data.type ? options.styles.nextScale : options.styles.prevScale));
      /** @type {number} */
      val = parseInt(val.height * ("next" == data.type ? options.styles.nextScale : options.styles.prevScale));
    } else {
      width = val.width;
      val = val.height;
    }
    /** @type {number} */
    w = parseInt((fnGetElementDimension(el, "padding-left") + fnGetElementDimension(el, "padding-right") + fnGetElementDimension(el, "border-left-width") + fnGetElementDimension(el, "border-right-width")) / 2);
    /** @type {number} */
    d = parseInt((fnGetElementDimension(el, "padding-top") + fnGetElementDimension(el, "padding-bottom") + fnGetElementDimension(el, "border-top-width") + fnGetElementDimension(el, "border-bottom-width") + jQuery(".ilightbox-inner-toolbar", el).outerHeight()) / 2);
    switch(data.type) {
      case "current":
        /** @type {number} */
        var ctop = parseInt(data.height / 2 - val / 2 - d - i / 2);
        /** @type {number} */
        var cleft = parseInt(data.width / 2 - width / 2 - w - padding / 2);
        break;
      case "next":
        /** @type {number} */
        ctop = "horizontal" == to ? parseInt(data.height / 2 - left - val / 2 - d - i / 2) : parseInt(data.height - x - d - i / 2);
        /** @type {number} */
        cleft = "horizontal" == to ? parseInt(data.width - x - w - padding / 2) : parseInt(data.width / 2 - width / 2 - w - left - padding / 2);
        break;
      case "prev":
        /** @type {number} */
        ctop = "horizontal" == to ? parseInt(data.height / 2 - left - val / 2 - d - i / 2) : parseInt(x - d - val - i / 2);
        /** @type {number} */
        cleft = "horizontal" == to ? parseInt(x - w - width - padding / 2) : parseInt(data.width / 2 - left - width / 2 - w - padding / 2);
    }
    el.data("offset", {
      top : ctop,
      left : cleft,
      newDims : max,
      diff : {
        W : w,
        H : d
      },
      thumbsOffset : {
        W : padding,
        H : i
      },
      object : data
    });
    if (0 < data.animate && options.effects.reposition) {
      el.css(varPropTransform, varPropPerspective).stop().animate({
        top : ctop,
        left : cleft
      }, options.effects.repositionSpeed, "easeOutCirc", function() {
        el.css(varPropTransform, "");
      });
      jQuery("div.ilightbox-container", el).stop().animate({
        width : width,
        height : val
      }, options.effects.repositionSpeed, "easeOutCirc");
      jQuery("div.ilightbox-inner-toolbar", el).stop().animate({
        width : width
      }, options.effects.repositionSpeed, "easeOutCirc", function() {
        jQuery(this).css("overflow", "visible");
      });
    } else {
      el.css({
        top : ctop,
        left : cleft
      });
      jQuery("div.ilightbox-container", el).css({
        width : width,
        height : val
      });
      jQuery("div.ilightbox-inner-toolbar", el).css({
        width : width
      });
    }
  },
  resume : function(priority) {
    var data = this;
    var self = data.vars;
    var opts = data.options;
    if (!(!opts.slideshow.pauseTime || opts.controls.slideshow && 1 >= self.total || priority < self.isPaused)) {
      /** @type {number} */
      self.isPaused = 0;
      if (self.cycleID) {
        self.cycleID = clearTimeout(self.cycleID);
      }
      /** @type {number} */
      self.cycleID = setTimeout(function() {
        if (self.current == self.total - 1) {
          data.goTo(0);
        } else {
          data.moveTo("next");
        }
      }, opts.slideshow.pauseTime);
    }
  },
  pause : function(priority) {
    var self = this.vars;
    if (!(priority < self.isPaused)) {
      self.isPaused = priority || 100;
      if (self.cycleID) {
        self.cycleID = clearTimeout(self.cycleID);
      }
    }
  },
  resetCycle : function() {
    var options = this.vars;
    if (this.options.controls.slideshow && options.cycleID && !options.isPaused) {
      this.resume();
    }
  },
  getNewDimenstions : function(width, value, n, amount, suppressZero) {
    /** @type {number} */
    factor = width ? value ? Math.min(width / n, value / amount) : width / n : value / amount;
    if (!suppressZero) {
      if (factor > this.options.maxScale) {
        factor = this.options.maxScale;
      } else {
        if (factor < this.options.minScale) {
          factor = this.options.minScale;
        }
      }
    }
    width = this.options.keepAspectRatio ? Math.round(n * factor) : width;
    value = this.options.keepAspectRatio ? Math.round(amount * factor) : value;
    return {
      width : width,
      height : value,
      ratio : factor
    };
  },
  setOption : function(o) {
    this.options = jQuery.extend(true, this.options, o || {});
    this.refresh();
  },
  availPlugins : function() {
    /** @type {!Element} */
    var vEl = document.createElement("video");
    this.plugins = {
      flash : 0 <= parseInt(varPluginDetect.getVersion("Shockwave")) || 0 <= parseInt(varPluginDetect.getVersion("Flash")) ? true : false,
      quicktime : 0 <= parseInt(varPluginDetect.getVersion("QuickTime")) ? true : false,
      html5H264 : !(!vEl.canPlayType || !vEl.canPlayType("video/mp4").replace(/no/, "")),
      html5WebM : !(!vEl.canPlayType || !vEl.canPlayType("video/webm").replace(/no/, "")),
      html5Vorbis : !(!vEl.canPlayType || !vEl.canPlayType("video/ogg").replace(/no/, "")),
      html5QuickTime : !(!vEl.canPlayType || !vEl.canPlayType("video/quicktime").replace(/no/, ""))
    };
  },
  addContent : function(text, options) {
    var target;
    switch(options.type) {
      case "video":
        /** @type {boolean} */
        target = false;
        var type = options.videoType;
        var settings = options.options.html5video;
        if (("video/mp4" == type || "mp4" == options.ext || "m4v" == options.ext || settings.h264) && this.plugins.html5H264) {
          /** @type {string} */
          options.ext = "mp4";
          options.URL = settings.h264 || options.URL;
        } else {
          if (settings.webm && this.plugins.html5WebM) {
            /** @type {string} */
            options.ext = "webm";
            options.URL = settings.webm || options.URL;
          } else {
            if (settings.ogg && this.plugins.html5Vorbis) {
              /** @type {string} */
              options.ext = "ogv";
              options.URL = settings.ogg || options.URL;
            }
          }
        }
        if (!this.plugins.html5H264 || "video/mp4" != type && "mp4" != options.ext && "m4v" != options.ext) {
          if (!this.plugins.html5WebM || "video/webm" != type && "webm" != options.ext) {
            if (!this.plugins.html5Vorbis || "video/ogg" != type && "ogv" != options.ext) {
              if (!(!this.plugins.html5QuickTime || "video/quicktime" != type && "mov" != options.ext && "qt" != options.ext)) {
                /** @type {boolean} */
                target = true;
                /** @type {string} */
                type = "video/quicktime";
              }
            } else {
              /** @type {boolean} */
              target = true;
              /** @type {string} */
              type = "video/ogg";
            }
          } else {
            /** @type {boolean} */
            target = true;
            /** @type {string} */
            type = "video/webm";
          }
        } else {
          /** @type {boolean} */
          target = true;
          /** @type {string} */
          type = "video/mp4";
        }
        if (target) {
          target = jQuery("<video />", {
            width : "100%",
            height : "100%",
            preload : settings.preload,
            autoplay : settings.autoplay,
            poster : settings.poster,
            controls : settings.controls
          }).append(jQuery("<source />", {
            src : options.URL,
            type : type
          }));
        } else {
          if (this.plugins.quicktime) {
            target = jQuery("<object />", {
              type : "video/quicktime",
              pluginspage : "http://www.apple.com/quicktime/download"
            }).attr({
              data : options.URL,
              width : "100%",
              height : "100%"
            }).append(jQuery("<param />", {
              name : "src",
              value : options.URL
            })).append(jQuery("<param />", {
              name : "autoplay",
              value : "false"
            })).append(jQuery("<param />", {
              name : "loop",
              value : "false"
            })).append(jQuery("<param />", {
              name : "scale",
              value : "tofit"
            }));
            if (varBrowserDetection.msie) {
              target = fnCreateEmbedObject(options.URL, "100%", "100%", "", "SCALE", "tofit", "AUTOPLAY", "false", "LOOP", "false");
            }
          } else {
            target = jQuery("<span />", {
              "class" : "ilightbox-alert",
              html : this.options.errors.missingPlugin.replace("{pluginspage}", "http://www.apple.com/quicktime/download").replace("{type}", "QuickTime")
            });
          }
        }
        break;
      case "flash":
        if (this.plugins.flash) {
          /** @type {string} */
          var flashVarsString = "";
          /** @type {number} */
          var h = 0;
          if (options.options.flashvars) {
            jQuery.each(options.options.flashvars, function(PROXY_URL, requestedUrl) {
              if (0 != h) {
                flashVarsString = flashVarsString + "&";
              }
              /** @type {string} */
              flashVarsString = flashVarsString + (PROXY_URL + "=" + encodeURIComponent(requestedUrl));
              h++;
            });
          } else {
            /** @type {null} */
            flashVarsString = null;
          }
          target = jQuery("<embed />").attr({
            type : "application/x-shockwave-flash",
            src : options.URL,
            width : "number" == typeof options.options.width && options.options.width && "1" == this.options.minScale && "1" == this.options.maxScale ? options.options.width : "100%",
            height : "number" == typeof options.options.height && options.options.height && "1" == this.options.minScale && "1" == this.options.maxScale ? options.options.height : "100%",
            quality : "high",
            bgcolor : "#000000",
            play : "true",
            loop : "true",
            menu : "true",
            wmode : "transparent",
            scale : "showall",
            allowScriptAccess : "always",
            allowFullScreen : "true",
            flashvars : flashVarsString,
            fullscreen : "yes"
          });
        } else {
          target = jQuery("<span />", {
            "class" : "ilightbox-alert",
            html : this.options.errors.missingPlugin.replace("{pluginspage}", "http://www.adobe.com/go/getflash").replace("{type}", "Adobe Flash player")
          });
        }
        break;
      case "iframe":
        target = jQuery("<iframe />").attr({
          width : "number" == typeof options.options.width && options.options.width && "1" == this.options.minScale && "1" == this.options.maxScale ? options.options.width : "100%",
          height : "number" == typeof options.options.height && options.options.height && "1" == this.options.minScale && "1" == this.options.maxScale ? options.options.height : "100%",
          src : options.URL,
          frameborder : 0,
          webkitAllowFullScreen : "",
          mozallowfullscreen : "",
          allowFullScreen : ""
        });
        break;
      case "inline":
        target = jQuery('<div class="ilightbox-wrapper"></div>').html(jQuery(options.URL).clone(true));
        break;
      case "html":
        target = options.URL;
        if (!target[0].nodeName) {
          target = jQuery(options.URL);
          target = target.selector ? jQuery("<div>" + target + "</div>") : target;
        }
        target = jQuery('<div class="ilightbox-wrapper"></div>').html(target);
    }
    jQuery("div.ilightbox-container", text).empty().html(target);
    return target;
  },
  ogpRecognition : function(obj, resolve) {
    var _ = this;
    var url = obj.URL;
    var data = {
      length : false
    };
    _.showLoader();
    fnPhoneHomeSourceCheck(url, function(result) {
      _.hideLoader();
      if (200 == result.status) {
        result = result.results;
        var gistname = result.type;
        var options = result.source;
        data.source = options.src;
        data.width = options.width && parseInt(options.width) || 0;
        data.height = options.height && parseInt(options.height) || 0;
        data.type = gistname;
        data.thumbnail = options.thumbnail || result.images[0];
        data.html5video = result.html5video || {};
        /** @type {boolean} */
        data.length = true;
        if ("application/x-shockwave-flash" == options.type) {
          /** @type {string} */
          data.type = "flash";
        } else {
          if (-1 != options.type.indexOf("video/")) {
            /** @type {string} */
            data.type = "video";
          } else {
            if (-1 != options.type.indexOf("/html")) {
              /** @type {string} */
              data.type = "iframe";
            } else {
              if (-1 != options.type.indexOf("image/")) {
                /** @type {string} */
                data.type = "image";
              }
            }
          }
        }
      } else {
        if ("undefined" != typeof result.response) {
          throw result.response;
        }
      }
      resolve(data.length ? data : false);
    });
  },
  hashChangeHandler : function(url) {
    var i = this.vars;
    var opts = this.options;
    url = fnParseUrl(url || window.location.href).hash;
    var d = url.indexOf("#" + opts.linkId + "/");
    var sepor = url.split("/");
    if (!(i.hashLock || "#" + opts.linkId != sepor[0] && 1 < url.length)) {
      if (-1 != d) {
        i = sepor[1] || 0;
        if (this.items[i]) {
          url = jQuery(".ilightbox-overlay");
          if (url.length && url.attr("linkid") == opts.linkId) {
            this.goTo(i);
          } else {
            this.itemsObject[i].trigger("click");
          }
        } else {
          url = jQuery(".ilightbox-overlay");
          if (url.length) {
            this.closeAction();
          }
        }
      } else {
        url = jQuery(".ilightbox-overlay");
        if (url.length) {
          this.closeAction();
        }
      }
    }
  }
};
/**
 * @return {?}
 */
jQuery.fn.iLightBox = function() {
  /** @type {!Arguments} */
  var input = arguments;
  var value = jQuery.isPlainObject(input[0]) ? input[0] : input[1];
  var data = Array.isArray(input[0]) || "string" == typeof input[0] ? input[0] : input[1];
  if (!value) {
    value = {};
  }
  value = jQuery.extend(true, {
    attr : "href",
    path : "vertical",
    skin : "dark",
    linkId : false,
    infinite : false,
    startFrom : 0,
    randomStart : false,
    keepAspectRatio : true,
    maxScale : 1,
    minScale : .2,
    innerToolbar : false,
    smartRecognition : false,
    mobileOptimizer : true,
    fullAlone : true,
    fullViewPort : null,
    fullStretchTypes : "flash, video",
    overlay : {
      blur : true,
      opacity : .85
    },
    controls : {
      arrows : false,
      slideshow : false,
      toolbar : true,
      fullscreen : true,
      thumbnail : true,
      keyboard : true,
      mousewheel : true,
      swipe : true
    },
    keyboard : {
      left : true,
      right : true,
      up : true,
      down : true,
      esc : true,
      shift_enter : true
    },
    show : {
      effect : true,
      speed : 300,
      title : true
    },
    hide : {
      effect : true,
      speed : 300
    },
    caption : {
      start : true,
      show : "mouseenter",
      hide : "mouseleave"
    },
    social : {
      start : true,
      show : "mouseenter",
      hide : "mouseleave",
      buttons : false
    },
    styles : {
      pageOffsetX : 0,
      pageOffsetY : 0,
      nextOffsetX : 45,
      nextOffsetY : 0,
      nextOpacity : 1,
      nextScale : 1,
      prevOffsetX : 45,
      prevOffsetY : 0,
      prevOpacity : 1,
      prevScale : 1
    },
    thumbnails : {
      maxWidth : 120,
      maxHeight : 80,
      normalOpacity : 1,
      activeOpacity : .6
    },
    effects : {
      reposition : true,
      repositionSpeed : 200,
      switchSpeed : 500,
      loadedFadeSpeed : 180,
      fadeSpeed : 200
    },
    slideshow : {
      pauseTime : 5E3,
      pauseOnHover : false,
      startPaused : true
    },
    text : {
      close : "Press Esc to close",
      enterFullscreen : "Enter Fullscreen (Shift+Enter)",
      exitFullscreen : "Exit Fullscreen (Shift+Enter)",
      slideShow : "Slideshow",
      next : "Next",
      previous : "Previous"
    },
    errors : {
      loadImage : "An error occurred when trying to load photo.",
      loadContents : "An error occurred when trying to load contents.",
      missingPlugin : "The content your are attempting to view requires the <a href='{pluginspage}' target='_blank'>{type} plugin</a>."
    },
    ajaxSetup : {
      url : "",
      beforeSend : function(setting, settings) {
      },
      cache : false,
      complete : function(edit, continuousCompletion) {
      },
      crossDomain : false,
      error : function(glee, app, id) {
      },
      success : function(a, doc, fn) {
      },
      global : true,
      ifModified : false,
      username : null,
      password : null,
      type : "GET"
    },
    callback : {}
  }, value);
  /** @type {boolean} */
  var member = Array.isArray(data) || "string" == typeof data ? true : false;
  data = Array.isArray(data) ? data : [];
  if ("string" == typeof input[0]) {
    data[0] = input[0];
  }
  if (fnVersionCmp(jQuery.fn.jquery, "1.8", ">=")) {
    var me = new iLightBoxClass(jQuery(this), value, data, member);
    return {
      close : function() {
        me.closeAction();
      },
      fullscreen : function() {
        me.fullScreenAction();
      },
      moveNext : function() {
        me.moveTo("next");
      },
      movePrev : function() {
        me.moveTo("prev");
      },
      goTo : function(index) {
        me.goTo(index);
      },
      refresh : function() {
        me.refresh();
      },
      reposition : function() {
        if (0 < arguments.length) {
          me.repositionPhoto(true);
        } else {
          me.repositionPhoto();
        }
      },
      setOption : function(value) {
        me.setOption(value);
      },
      destroy : function() {
        me.closeAction();
        me.dispatchItemsEvents();
      }
    };
  }
  throw "The jQuery version that was loaded is too old. iLightBox requires jQuery 1.8+";
};
/**
 * @param {?} preflightData
 * @param {?} prefetch
 * @return {?}
 */
jQuery.iLightBox = function(preflightData, prefetch) {
  return jQuery.fn.iLightBox(preflightData, prefetch);
};
jQuery.extend(jQuery.easing, {
  easeInCirc : function(d, pos, c, t, duration) {
    return -t * (Math.sqrt(1 - (pos = pos / duration) * pos) - 1) + c;
  },
  easeOutCirc : function(pos, d, n, t, c) {
    return t * Math.sqrt(1 - (d = d / c - 1) * d) + n;
  },
  easeInOutCirc : function(d, pos, c, t, speed) {
    return 1 > (pos = pos / (speed / 2)) ? -t / 2 * (Math.sqrt(1 - pos * pos) - 1) + c : t / 2 * (Math.sqrt(1 - (pos = pos - 2) * pos) + 1) + c;
  }
});
jQuery(document);
jQuery.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight scrollstart scrollstop".split(" "), function(a, name) {
  /**
   * @param {?} fn
   * @return {?}
   */
  jQuery.fn[name] = function(fn) {
    return fn ? this.bind(name, fn) : this.trigger(name);
  };
  if (jQuery.attrFn) {
    /** @type {boolean} */
    jQuery.attrFn[name] = true;
  }
});
jQuery.event.special.itap = {
  setup : function() {
    var a = this;
    var b = jQuery(this);
    var mv;
    var realVector;
    b.bind("touchstart.iTap", function(canCreateDiscussions) {
      mv = fnGetPageOffset();
      b.one("touchend.iTap", function(event) {
        realVector = fnGetPageOffset();
        event = jQuery.event.fix(event || window.event);
        /** @type {string} */
        event.type = "itap";
        if (mv && realVector && mv.x == realVector.x && mv.y == realVector.y) {
          (jQuery.event.dispatch || jQuery.event.handle).call(a, event);
        }
        mv = realVector = varUnknown;
      });
    });
  },
  teardown : function() {
    jQuery(this).unbind("touchstart.iTap");
  }
};
(function() {
  varFullscreenState = {
    supportsFullScreen : false,
    isFullScreen : function() {
      return false;
    },
    requestFullScreen : function() {
    },
    cancelFullScreen : function() {
    },
    fullScreenEventName : "",
    prefix : ""
  };
  /** @type {!Array} */
  browserPrefixes = ["webkit", "moz", "o", "ms", "khtml"];
  if ("undefined" != typeof document.cancelFullScreen) {
    /** @type {boolean} */
    varFullscreenState.supportsFullScreen = true;
  } else {
    /** @type {number} */
    var i = 0;
    /** @type {number} */
    var l = browserPrefixes.length;
    for (; i < l; i++) {
      if (varFullscreenState.prefix = browserPrefixes[i], "undefined" != typeof document[varFullscreenState.prefix + "CancelFullScreen"]) {
        /** @type {boolean} */
        varFullscreenState.supportsFullScreen = true;
        break;
      }
    }
  }
  if (varFullscreenState.supportsFullScreen) {
    /** @type {string} */
    varFullscreenState.fullScreenEventName = varFullscreenState.prefix + "fullscreenchange";
    /**
     * @return {?}
     */
    varFullscreenState.isFullScreen = function() {
      switch(this.prefix) {
        case "":
          return document.fullScreen;
        case "webkit":
          return document.webkitIsFullScreen;
        default:
          return document[this.prefix + "FullScreen"];
      }
    };
    /**
     * @param {!Element} el
     * @return {?}
     */
    varFullscreenState.requestFullScreen = function(el) {
      return "" === this.prefix ? el.requestFullScreen() : el[this.prefix + "RequestFullScreen"]();
    };
    /**
     * @param {(Node|Window)} el
     * @return {?}
     */
    varFullscreenState.cancelFullScreen = function(el) {
      return "" === this.prefix ? document.cancelFullScreen() : document[this.prefix + "CancelFullScreen"]();
    };
  }
})();
(function() {
  var a;
  var v;
  /** @type {string} */
  a = navigator.userAgent;
  /** @type {string} */
  a = a.toLowerCase();
  /** @type {!Array<string>} */
  v = /(chrome)[ \/]([\w.]+)/.exec(a) || /(webkit)[ \/]([\w.]+)/.exec(a) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(a) || /(msie) ([\w.]+)/.exec(a) || 0 > a.indexOf("compatible") && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(a) || [];
  /** @type {string} */
  a = v[1] || "";
  /** @type {string} */
  v = v[2] || "0";
  varBrowserDetection = {};
  if (a) {
    /** @type {boolean} */
    varBrowserDetection[a] = true;
    /** @type {string} */
    varBrowserDetection.version = v;
  }
  if (varBrowserDetection.chrome) {
    /** @type {boolean} */
    varBrowserDetection.webkit = true;
  } else {
    if (varBrowserDetection.webkit) {
      /** @type {boolean} */
      varBrowserDetection.safari = true;
    }
  }
})();
(function() {
  /**
   * @param {string} prop
   * @return {?}
   */
  function testProp(prop) {
    /** @type {number} */
    var p = 0;
    /** @type {number} */
    var pLen = prefixes.length;
    for (; p < pLen; p++) {
      var prefixedProp = prefixes[p] ? prefixes[p] + prop.charAt(0).toUpperCase() + prop.slice(1) : prop;
      if (el.style[prefixedProp] !== varUnknown) {
        return prefixedProp;
      }
    }
  }
  /** @type {!Array} */
  var prefixes = ["", "webkit", "moz", "ms", "o"];
  /** @type {!Element} */
  var el = document.createElement("div");
  varPropTransform = testProp("transform") || "";
  /** @type {string} */
  varPropPerspective = testProp("perspective") ? "translateZ(0) " : "";
})();

var varPluginDetect = {
  version : "0.7.9",
  name : "PluginDetect",
  handler : function(error, response, date) {
    return function() {
      error(response, date);
    };
  },
  openTag : "<",
  isDefined : function(value) {
    return "undefined" != typeof value;
  },
  isArray : function(obj) {
    return /array/i.test(Object.prototype.toString.call(obj));
  },
  isFunc : function(fn) {
    return "function" == typeof fn;
  },
  isString : function(val) {
    return "string" == typeof val;
  },
  isNum : function(n) {
    return "number" == typeof n;
  },
  isStrNum : function(arg) {
    return "string" == typeof arg && /\d/.test(arg);
  },
  getNumRegx : /[\d][\d\._,-]*/,
  splitNumRegx : /[\._,-]/g,
  getNum : function(name, value) {
    var c = this.isStrNum(name) ? (this.isDefined(value) ? RegExp(value) : this.getNumRegx).exec(name) : null;
    return c ? c[0] : null;
  },
  compareNums : function(c, d, type) {
    /** @type {function(*, (number|undefined)): number} */
    var toInt = parseInt;
    if (this.isStrNum(c) && this.isStrNum(d)) {
      if (this.isDefined(type) && type.compareNums) {
        return type.compareNums(c, d);
      }
      c = c.split(this.splitNumRegx);
      d = d.split(this.splitNumRegx);
      /** @type {number} */
      type = 0;
      for (; type < Math.min(c.length, d.length); type++) {
        if (toInt(c[type], 10) > toInt(d[type], 10)) {
          return 1;
        }
        if (toInt(c[type], 10) < toInt(d[type], 10)) {
          return -1;
        }
      }
    }
    return 0;
  },
  formatNum : function(num, x) {
    var j;
    var attr;
    if (!this.isStrNum(num)) {
      return null;
    }
    if (!this.isNum(x)) {
      /** @type {number} */
      x = 4;
    }
    x--;
    attr = num.replace(/\s/g, "").split(this.splitNumRegx).concat(["0", "0", "0", "0"]);
    /** @type {number} */
    j = 0;
    for (; 4 > j; j++) {
      if (/^(0+)(.+)$/.test(attr[j]) && (attr[j] = RegExp.$2), j > x || !/\d/.test(attr[j])) {
        /** @type {string} */
        attr[j] = "0";
      }
    }
    return attr.slice(0, 4).join(",");
  },
  $$hasMimeType : function(util) {
    return function(x) {
      if (!util.isIE && x) {
        var formElement;
        var i;
        var p = util.isArray(x) ? x : util.isString(x) ? [x] : [];
        /** @type {number} */
        i = 0;
        for (; i < p.length; i++) {
          if (util.isString(p[i]) && /[^\s]/.test(p[i]) && (formElement = (x = navigator.mimeTypes[p[i]]) ? x.enabledPlugin : 0) && (formElement.name || formElement.description)) {
            return x;
          }
        }
      }
      return null;
    };
  },
  findNavPlugin : function(reg, type, str) {
    /** @type {!RegExp} */
    reg = RegExp(reg, "i");
    /** @type {(RegExp|number)} */
    type = !this.isDefined(type) || type ? /\d/ : 0;
    /** @type {(RegExp|number)} */
    str = str ? RegExp(str, "i") : 0;
    /** @type {!PluginArray} */
    var plugins = navigator.plugins;
    var i;
    var s;
    var c;
    /** @type {number} */
    i = 0;
    for (; i < plugins.length; i++) {
      if (c = plugins[i].description || "", s = plugins[i].name || "", reg.test(c) && (!type || type.test(RegExp.leftContext + RegExp.rightContext)) || reg.test(s) && (!type || type.test(RegExp.leftContext + RegExp.rightContext))) {
        if (!str || !str.test(c) && !str.test(s)) {
          return plugins[i];
        }
      }
    }
    return null;
  },
  getMimeEnabledPlugin : function(el, q, i) {
    var x;
    /** @type {!RegExp} */
    q = RegExp(q, "i");
    /** @type {(RegExp|number)} */
    i = i ? RegExp(i, "i") : 0;
    var width;
    var layer_i;
    var crossfilterable_layers = this.isString(el) ? [el] : el;
    /** @type {number} */
    layer_i = 0;
    for (; layer_i < crossfilterable_layers.length; layer_i++) {
      if ((x = this.hasMimeType(crossfilterable_layers[layer_i])) && (x = x.enabledPlugin) && (width = x.description || "", el = x.name || "", q.test(width) || q.test(el)) && (!i || !i.test(width) && !i.test(el))) {
        return x;
      }
    }
    return 0;
  },
  getPluginFileVersion : function(b, s) {
    var range;
    var src;
    var tobj;
    var f;
    /** @type {number} */
    var factor = -1;
    if (2 < this.OS || !b || !b.version || !(range = this.getNum(b.version))) {
      return s;
    }
    if (!s) {
      return range;
    }
    range = this.formatNum(range);
    s = this.formatNum(s);
    src = s.split(this.splitNumRegx);
    tobj = range.split(this.splitNumRegx);
    /** @type {number} */
    f = 0;
    for (; f < src.length; f++) {
      if (-1 < factor && f > factor && "0" != src[f] || tobj[f] != src[f] && (-1 == factor && (factor = f), "0" != src[f])) {
        return s;
      }
    }
    return range;
  },
  AXO : window.ActiveXObject,
  getAXO : function(a) {
    /** @type {null} */
    var cached = null;
    try {
      cached = new this.AXO(a);
    } catch (c) {
    }
    return cached;
  },
  convertFuncs : function(a) {
    var key;
    var p;
    /** @type {!RegExp} */
    var VALID_IDENTIFIER_EXPR = /^[\$][\$]/;
    for (key in a) {
      if (VALID_IDENTIFIER_EXPR.test(key)) {
        try {
          /** @type {string} */
          p = key.slice(2);
          if (0 < p.length && !a[p]) {
            a[p] = a[key](a);
            delete a[key];
          }
        } catch (e) {
        }
      }
    }
  },
  initObj : function(obj, data, id) {
    var i;
    if (obj) {
      if (1 == obj[data[0]] || id) {
        /** @type {number} */
        i = 0;
        for (; i < data.length; i = i + 2) {
          obj[data[i]] = data[i + 1];
        }
      }
      for (i in obj) {
        if ((id = obj[i]) && 1 == id[data[0]]) {
          this.initObj(id, data);
        }
      }
    }
  },
  initScript : function() {
    /** @type {!Navigator} */
    var data = navigator;
    var i;
    /** @type {!HTMLDocument} */
    var doc = document;
    /** @type {string} */
    var ua = data.userAgent || "";
    /** @type {string} */
    var vimeoParams = data.vendor || "";
    /** @type {string} */
    var p = data.platform || "";
    /** @type {string} */
    data = data.product || "";
    this.initObj(this, ["$", this]);
    for (i in this.Plugins) {
      if (this.Plugins[i]) {
        this.initObj(this.Plugins[i], ["$", this, "$$", this.Plugins[i]], 1);
      }
    }
    this.convertFuncs(this);
    /** @type {number} */
    this.OS = 100;
    if (p) {
      /** @type {!Array} */
      var ret = ["Win", 1, "Mac", 2, "Linux", 3, "FreeBSD", 4, "iPhone", 21.1, "iPod", 21.2, "iPad", 21.3, "Win.*CE", 22.1, "Win.*Mobile", 22.2, "Pocket\\s*PC", 22.3, "", 100];
      /** @type {number} */
      i = ret.length - 2;
      for (; 0 <= i; i = i - 2) {
        if (ret[i] && RegExp(ret[i], "i").test(p)) {
          this.OS = ret[i + 1];
          break;
        }
      }
    }
    /** @type {!Element} */
    this.head = doc.getElementsByTagName("head")[0] || doc.getElementsByTagName("body")[0] || doc.body || null;
    /** @type {(null|number)} */
    this.verIE = (this.isIE = (new Function("return/*@cc_on!@*/!1"))()) && /MSIE\s*(\d+\.?\d*)/i.test(ua) ? parseFloat(RegExp.$1, 10) : null;
    /** @type {null} */
    this.docModeIE = this.verIEfull = null;
    if (this.isIE) {
      /** @type {!Element} */
      i = document.createElement("div");
      try {
        /** @type {string} */
        i.style.behavior = "url(#default#clientcaps)";
        this.verIEfull = i.getComponentVersion("{89820200-ECBD-11CF-8B85-00AA005B4383}", "componentid").replace(/,/g, ".");
      } catch (g) {
      }
      /** @type {number} */
      i = parseFloat(this.verIEfull || "0", 10);
      this.docModeIE = doc.documentMode || (/back/i.test(doc.compatMode || "") ? 5 : i) || this.verIE;
      this.verIE = i || this.docModeIE;
    }
    /** @type {boolean} */
    this.ActiveXEnabled = false;
    if (this.isIE) {
      /** @type {!Array<string>} */
      doc = "Msxml2.XMLHTTP Msxml2.DOMDocument Microsoft.XMLDOM ShockwaveFlash.ShockwaveFlash TDCCtl.TDCCtl Shell.UIHelper Scripting.Dictionary wmplayer.ocx".split(" ");
      /** @type {number} */
      i = 0;
      for (; i < doc.length; i++) {
        if (this.getAXO(doc[i])) {
          /** @type {boolean} */
          this.ActiveXEnabled = true;
          break;
        }
      }
    }
    this.verGecko = (this.isGecko = /Gecko/i.test(data) && /Gecko\s*\/\s*\d/i.test(ua)) ? this.formatNum(/rv\s*:\s*([\.,\d]+)/i.test(ua) ? RegExp.$1 : "0.9") : null;
    this.verChrome = (this.isChrome = /Chrome\s*\/\s*(\d[\d\.]*)/i.test(ua)) ? this.formatNum(RegExp.$1) : null;
    this.verSafari = (this.isSafari = (/Apple/i.test(vimeoParams) || !vimeoParams && !this.isChrome) && /Safari\s*\/\s*(\d[\d\.]*)/i.test(ua)) && /Version\s*\/\s*(\d[\d\.]*)/i.test(ua) ? this.formatNum(RegExp.$1) : null;
    /** @type {(null|number)} */
    this.verOpera = (this.isOpera = /Opera\s*[\/]?\s*(\d+\.?\d*)/i.test(ua)) && (/Version\s*\/\s*(\d+\.?\d*)/i.test(ua) || 1) ? parseFloat(RegExp.$1, 10) : null;
    this.addWinEvent("load", this.handler(this.runWLfuncs, this));
  },
  init : function(v) {
    var p;
    var o = {
      status : -3,
      plugin : 0
    };
    if (!this.isString(v)) {
      return o;
    }
    if (1 == v.length) {
      return this.getVersionDelimiter = v, o;
    }
    v = v.toLowerCase().replace(/\s/g, "");
    p = this.Plugins[v];
    if (!p || !p.getVersion) {
      return o;
    }
    o.plugin = p;
    if (!this.isDefined(p.installed)) {
      /** @type {null} */
      p.installed = null;
      /** @type {null} */
      p.version = null;
      /** @type {null} */
      p.version0 = null;
      /** @type {null} */
      p.getVersionDone = null;
      /** @type {string} */
      p.pluginName = v;
    }
    /** @type {boolean} */
    this.garbage = false;
    if (this.isIE && !this.ActiveXEnabled && "java" !== v) {
      return o.status = -2, o;
    }
    /** @type {number} */
    o.status = 1;
    return o;
  },
  fPush : function(val, copy) {
    if (this.isArray(copy) && (this.isFunc(val) || this.isArray(val) && 0 < val.length && this.isFunc(val[0]))) {
      copy.push(val);
    }
  },
  callArray : function(array) {
    var i;
    if (this.isArray(array)) {
      /** @type {number} */
      i = 0;
      for (; i < array.length && null !== array[i]; i++) {
        this.call(array[i]);
        /** @type {null} */
        array[i] = null;
      }
    }
  },
  call : function(arg) {
    var id2 = this.isArray(arg) ? arg.length : -1;
    if (0 < id2 && this.isFunc(arg[0])) {
      arg[0](this, 1 < id2 ? arg[1] : 0, 2 < id2 ? arg[2] : 0, 3 < id2 ? arg[3] : 0);
    } else {
      if (this.isFunc(arg)) {
        arg(this);
      }
    }
  },
  getVersionDelimiter : ",",
  $$getVersion : function(state) {
    return function(options, pre, cur) {
      options = state.init(options);
      if (0 > options.status) {
        return null;
      }
      options = options.plugin;
      if (1 != options.getVersionDone) {
        options.getVersion(null, pre, cur);
        if (null === options.getVersionDone) {
          /** @type {number} */
          options.getVersionDone = 1;
        }
      }
      state.cleanup();
      return pre = (pre = options.version || options.version0) ? pre.replace(state.splitNumRegx, state.getVersionDelimiter) : pre;
    };
  },
  cleanup : function() {
    if (this.garbage && this.isDefined(window.CollectGarbage)) {
      window.CollectGarbage();
    }
  },
  isActiveXObject : function(status, url) {
    /** @type {boolean} */
    var c = false;
    /** @type {string} */
    var replace = '<object width="1" height="1" style="display:none" ' + status.getCodeBaseVersion(url) + ">" + status.HTML + this.openTag + "/object>";
    if (!this.head) {
      return c;
    }
    this.head.insertBefore(document.createElement("object"), this.head.firstChild);
    /** @type {string} */
    this.head.firstChild.outerHTML = replace;
    try {
      this.head.firstChild.classid = status.classID;
    } catch (e) {
    }
    try {
      if (this.head.firstChild.object) {
        /** @type {boolean} */
        c = true;
      }
    } catch (f) {
    }
    try {
      if (c && 4 > this.head.firstChild.readyState) {
        /** @type {boolean} */
        this.garbage = true;
      }
    } catch (h) {
    }
    this.head.removeChild(this.head.firstChild);
    return c;
  },
  codebaseSearch : function(m, x) {
    var self = this;
    if (!self.ActiveXEnabled || !m) {
      return null;
    }
    if (m.BIfuncs && m.BIfuncs.length && null !== m.BIfuncs[m.BIfuncs.length - 1]) {
      self.callArray(m.BIfuncs);
    }
    var a;
    var obj = m.SEARCH;
    if (self.isStrNum(x)) {
      if (obj.match && obj.min && 0 >= self.compareNums(x, obj.min)) {
        return true;
      }
      if (obj.match && obj.max && 0 <= self.compareNums(x, obj.max)) {
        return false;
      }
      if ((a = self.isActiveXObject(m, x)) && (!obj.min || 0 < self.compareNums(x, obj.min))) {
        /** @type {string} */
        obj.min = x;
      }
      if (!(a || obj.max && !(0 > self.compareNums(x, obj.max)))) {
        /** @type {string} */
        obj.max = x;
      }
      return a;
    }
    /** @type {!Array} */
    var r = [0, 0, 0, 0];
    /** @type {!Array<?>} */
    var b = [].concat(obj.digits);
    /** @type {number} */
    var isNewStyle = obj.min ? 1 : 0;
    var i;
    var arr;
    /**
     * @param {!Object} a
     * @param {!Object} b
     * @return {?}
     */
    var merge = function(a, b) {
      /** @type {!Array<?>} */
      var colors = [].concat(r);
      /** @type {!Object} */
      colors[a] = b;
      return self.isActiveXObject(m, colors.join(","));
    };
    if (obj.max) {
      a = obj.max.split(self.splitNumRegx);
      /** @type {number} */
      i = 0;
      for (; i < a.length; i++) {
        /** @type {number} */
        a[i] = parseInt(a[i], 10);
      }
      if (a[0] < b[0]) {
        b[0] = a[0];
      }
    }
    if (obj.min) {
      arr = obj.min.split(self.splitNumRegx);
      /** @type {number} */
      i = 0;
      for (; i < arr.length; i++) {
        /** @type {number} */
        arr[i] = parseInt(arr[i], 10);
      }
      if (arr[0] > r[0]) {
        r[0] = arr[0];
      }
    }
    if (arr && a) {
      /** @type {number} */
      i = 1;
      for (; i < arr.length && arr[i - 1] == a[i - 1]; i++) {
        if (a[i] < b[i]) {
          b[i] = a[i];
        }
        if (arr[i] > r[i]) {
          r[i] = arr[i];
        }
      }
    }
    if (obj.max) {
      /** @type {number} */
      i = 1;
      for (; i < b.length; i++) {
        if (0 < a[i] && 0 == b[i] && b[i - 1] < obj.digits[i - 1]) {
          b[i - 1] += 1;
          break;
        }
      }
    }
    /** @type {number} */
    i = 0;
    for (; i < b.length; i++) {
      arr = {};
      /** @type {number} */
      obj = 0;
      for (; 20 > obj && !(1 > b[i] - r[i]); obj++) {
        /** @type {number} */
        a = Math.round((b[i] + r[i]) / 2);
        if (arr["a" + a]) {
          break;
        }
        /** @type {number} */
        arr["a" + a] = 1;
        if (merge(i, a)) {
          /** @type {number} */
          r[i] = a;
          /** @type {number} */
          isNewStyle = 1;
        } else {
          /** @type {number} */
          b[i] = a;
        }
      }
      b[i] = r[i];
      if (!isNewStyle && merge(i, r[i])) {
        /** @type {number} */
        isNewStyle = 1;
      }
      if (!isNewStyle) {
        break;
      }
    }
    return isNewStyle ? r.join(",") : null;
  },
  addWinEvent : function(type, fn) {
    /** @type {!global this} */
    var obj = window;
    var val;
    if (this.isFunc(fn)) {
      if (obj.addEventListener) {
        obj.addEventListener(type, fn, false);
      } else {
        if (obj.attachEvent) {
          obj.attachEvent("on" + type, fn);
        } else {
          val = obj["on" + type];
          obj["on" + type] = this.winHandler(fn, val);
        }
      }
    }
  },
  winHandler : function(bodyFn, callback) {
    return function() {
      bodyFn();
      if ("function" == typeof callback) {
        callback();
      }
    };
  },
  WLfuncs0 : [],
  WLfuncs : [],
  runWLfuncs : function(low) {
    /** @type {boolean} */
    low.winLoaded = true;
    low.callArray(low.WLfuncs0);
    low.callArray(low.WLfuncs);
    if (low.onDoneEmptyDiv) {
      low.onDoneEmptyDiv();
    }
  },
  winLoaded : false,
  $$onWindowLoaded : function(a) {
    return function(b) {
      if (a.winLoaded) {
        a.call(b);
      } else {
        a.fPush(b, a.WLfuncs);
      }
    };
  },
  div : null,
  divID : "plugindetect",
  divWidth : 50,
  pluginSize : 1,
  emptyDiv : function() {
    var i;
    var j;
    var c;
    var d;
    if (this.div && this.div.childNodes) {
      /** @type {number} */
      i = this.div.childNodes.length - 1;
      for (; 0 <= i; i--) {
        if ((c = this.div.childNodes[i]) && c.childNodes) {
          /** @type {number} */
          j = c.childNodes.length - 1;
          for (; 0 <= j; j--) {
            d = c.childNodes[j];
            try {
              c.removeChild(d);
            } catch (e) {
            }
          }
        }
        if (c) {
          try {
            this.div.removeChild(c);
          } catch (f) {
          }
        }
      }
    }
    if (!this.div && (i = document.getElementById(this.divID))) {
      /** @type {!Element} */
      this.div = i;
    }
    if (this.div && this.div.parentNode) {
      try {
        this.div.parentNode.removeChild(this.div);
      } catch (h) {
      }
      /** @type {null} */
      this.div = null;
    }
  },
  DONEfuncs : [],
  onDoneEmptyDiv : function() {
    var i;
    var client;
    if (this.winLoaded && (!this.WLfuncs || !this.WLfuncs.length || null === this.WLfuncs[this.WLfuncs.length - 1])) {
      for (i in this) {
        if ((client = this[i]) && client.funcs && (3 == client.OTF || client.funcs.length && null !== client.funcs[client.funcs.length - 1])) {
          return;
        }
      }
      /** @type {number} */
      i = 0;
      for (; i < this.DONEfuncs.length; i++) {
        this.callArray(this.DONEfuncs);
      }
      this.emptyDiv();
    }
  },
  getWidth : function(node) {
    return node && (node = node.scrollWidth || node.offsetWidth, this.isNum(node)) ? node : -1;
  },
  getTagStatus : function(item, element, type, num) {
    var name = item.span;
    var w = this.getWidth(name);
    type = type.span;
    var x = this.getWidth(type);
    element = element.span;
    var width = this.getWidth(element);
    if (!(name && type && element && this.getDOMobj(item))) {
      return -2;
    }
    if (x < width || 0 > w || 0 > x || 0 > width || width <= this.pluginSize || 1 > this.pluginSize) {
      return 0;
    }
    if (w >= width) {
      return -1;
    }
    try {
      if (w == this.pluginSize && (!this.isIE || 4 == this.getDOMobj(item).readyState) && (!item.winLoaded && this.winLoaded || item.winLoaded && this.isNum(num) && (this.isNum(item.count) || (item.count = num), 10 <= num - item.count))) {
        return 1;
      }
    } catch (k) {
    }
    return 0;
  },
  getDOMobj : function(element, ancientEL) {
    var parent = element ? element.span : 0;
    /** @type {number} */
    var forward = parent && parent.firstChild ? 1 : 0;
    try {
      if (forward && ancientEL) {
        this.div.focus();
      }
    } catch (e) {
    }
    return forward ? parent.firstChild : null;
  },
  setStyle : function(t, a) {
    var b = t.style;
    var i;
    if (b && a) {
      /** @type {number} */
      i = 0;
      for (; i < a.length; i = i + 2) {
        try {
          b[a[i]] = a[i + 1];
        } catch (e) {
        }
      }
    }
  },
  insertDivInBody : function(a, win) {
    /** @type {null} */
    var c = null;
    var doc = win ? window.top.document : window.document;
    var e = doc.getElementsByTagName("body")[0] || doc.body;
    if (!e) {
      try {
        doc.write('<div id="pd33993399">.' + this.openTag + "/div>");
        c = doc.getElementById("pd33993399");
      } catch (f) {
      }
    }
    if (e = doc.getElementsByTagName("body")[0] || doc.body) {
      e.insertBefore(a, e.firstChild);
      if (c) {
        e.removeChild(c);
      }
    }
  },
  insertHTML : function(url, element, position, value, node) {
    /** @type {!HTMLDocument} */
    node = document;
    var outerHTML;
    /** @type {!Element} */
    var div = node.createElement("span");
    var i;
    /** @type {!Array<string>} */
    var _ = "outlineStyle none borderStyle none padding 0px margin 0px visibility visible".split(" ");
    if (!this.isDefined(value)) {
      /** @type {string} */
      value = "";
    }
    if (this.isString(url) && /[^\s]/.test(url)) {
      url = url.toLowerCase().replace(/\s/g, "");
      /** @type {string} */
      outerHTML = this.openTag + url + ' width="' + this.pluginSize + '" height="' + this.pluginSize + '" ';
      /** @type {string} */
      outerHTML = outerHTML + 'style="outline-style:none;border-style:none;padding:0px;margin:0px;visibility:visible;display:inline;" ';
      /** @type {number} */
      i = 0;
      for (; i < element.length; i = i + 2) {
        if (/[^\s]/.test(element[i + 1])) {
          /** @type {string} */
          outerHTML = outerHTML + (element[i] + '="' + element[i + 1] + '" ');
        }
      }
      /** @type {string} */
      outerHTML = outerHTML + ">";
      /** @type {number} */
      i = 0;
      for (; i < position.length; i = i + 2) {
        if (/[^\s]/.test(position[i + 1])) {
          /** @type {string} */
          outerHTML = outerHTML + (this.openTag + 'param name="' + position[i] + '" value="' + position[i + 1] + '" />');
        }
      }
      /** @type {string} */
      outerHTML = outerHTML + (value + this.openTag + "/" + url + ">");
    } else {
      /** @type {string} */
      outerHTML = value;
    }
    if (!this.div) {
      if (element = node.getElementById(this.divID)) {
        /** @type {string} */
        this.div = element;
      } else {
        /** @type {!Element} */
        this.div = node.createElement("div");
        this.div.id = this.divID;
      }
      this.setStyle(this.div, _.concat(["width", this.divWidth + "px", "height", this.pluginSize + 3 + "px", "fontSize", this.pluginSize + 3 + "px", "lineHeight", this.pluginSize + 3 + "px", "verticalAlign", "baseline", "display", "block"]));
      if (!element) {
        this.setStyle(this.div, "position absolute right 0px top 0px".split(" "));
        this.insertDivInBody(this.div);
      }
    }
    if (this.div && this.div.parentNode) {
      this.setStyle(div, _.concat(["fontSize", this.pluginSize + 3 + "px", "lineHeight", this.pluginSize + 3 + "px", "verticalAlign", "baseline", "display", "inline"]));
      try {
        div.innerHTML = outerHTML;
      } catch (m) {
      }
      try {
        this.div.appendChild(div);
      } catch (n) {
      }
      return {
        span : div,
        winLoaded : this.winLoaded,
        tagName : url,
        outerHTML : outerHTML
      };
    }
    return {
      span : null,
      winLoaded : this.winLoaded,
      tagName : "",
      outerHTML : outerHTML
    };
  },
  Plugins : {
    quicktime : {
      mimeType : ["video/quicktime", "application/x-quicktimeplayer", "image/x-macpaint", "image/x-quicktime"],
      progID : "QuickTimeCheckObject.QuickTimeCheck.1",
      progID0 : "QuickTime.QuickTime",
      classID : "clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B",
      minIEver : 7,
      HTML : '<param name="src" value="" /><param name="controller" value="false" />',
      getCodeBaseVersion : function(url) {
        return 'codebase="#version=' + url + '"';
      },
      SEARCH : {
        min : 0,
        max : 0,
        match : 0,
        digits : [16, 128, 128, 0]
      },
      getVersion : function(type) {
        var data = this.$;
        /** @type {null} */
        var num = null;
        /** @type {null} */
        var node = null;
        if (data.isIE) {
          if (data.isStrNum(type)) {
            type = type.split(data.splitNumRegx);
            if (3 < type.length && 0 < parseInt(type[3], 10)) {
              /** @type {string} */
              type[3] = "9999";
            }
            type = type.join(",");
          }
          if (data.isStrNum(type) && data.verIE >= this.minIEver && 0 < this.canUseIsMin()) {
            this.installed = this.isMin(type);
            /** @type {number} */
            this.getVersionDone = 0;
            return;
          }
          /** @type {number} */
          this.getVersionDone = 1;
          if (!num && data.verIE >= this.minIEver) {
            num = this.CDBASE2VER(data.codebaseSearch(this));
          }
          if (!num) {
            if ((node = data.getAXO(this.progID)) && node.QuickTimeVersion) {
              num = node.QuickTimeVersion.toString(16);
              /** @type {string} */
              num = parseInt(num.charAt(0), 16) + "." + parseInt(num.charAt(1), 16) + "." + parseInt(num.charAt(2), 16);
            }
          }
        } else {
          if (data.hasMimeType(this.mimeType) && (node = 3 != data.OS ? data.findNavPlugin("QuickTime.*Plug-?in", 0) : null) && node.name) {
            num = data.getNum(node.name);
          }
        }
        /** @type {number} */
        this.installed = num ? 1 : node ? 0 : -1;
        this.version = data.formatNum(num, 3);
      },
      cdbaseUpper : ["7,60,0,0", "0,0,0,0"],
      cdbaseLower : ["7,50,0,0", null],
      cdbase2ver : [function(resizeable, clusterShardData) {
        var pzy = clusterShardData.split(resizeable.$.splitNumRegx);
        return [pzy[0], pzy[1].charAt(0), pzy[1].charAt(1), pzy[2]].join();
      }, null],
      CDBASE2VER : function(s) {
        var Util = this.$;
        var i;
        var potentialExits = this.cdbaseUpper;
        var clips = this.cdbaseLower;
        if (s) {
          s = Util.formatNum(s);
          /** @type {number} */
          i = 0;
          for (; i < potentialExits.length; i++) {
            if (potentialExits[i] && 0 > Util.compareNums(s, potentialExits[i]) && clips[i] && 0 <= Util.compareNums(s, clips[i]) && this.cdbase2ver[i]) {
              return this.cdbase2ver[i](this, s);
            }
          }
        }
        return s;
      },
      canUseIsMin : function() {
        var rawNode = this.$;
        var i;
        var c = this.canUseIsMin;
        var widgets_def = this.cdbaseUpper;
        var unloadHandlers = this.cdbaseLower;
        if (!c.value) {
          /** @type {number} */
          c.value = -1;
          /** @type {number} */
          i = 0;
          for (; i < widgets_def.length; i++) {
            if (widgets_def[i] && rawNode.codebaseSearch(this, widgets_def[i])) {
              /** @type {number} */
              c.value = 1;
              break;
            }
            if (unloadHandlers[i] && rawNode.codebaseSearch(this, unloadHandlers[i])) {
              /** @type {number} */
              c.value = -1;
              break;
            }
          }
        }
        /** @type {number} */
        this.SEARCH.match = 1 == c.value ? 1 : 0;
        return c.value;
      },
      isMin : function(val) {
        return this.$.codebaseSearch(this, val) ? .7 : -1;
      }
    },
    flash : {
      mimeType : "application/x-shockwave-flash",
      progID : "ShockwaveFlash.ShockwaveFlash",
      classID : "clsid:D27CDB6E-AE6D-11CF-96B8-444553540000",
      getVersion : function() {
        /**
         * @param {string} rev
         * @return {?}
         */
        var cb = function(rev) {
          return rev ? (rev = /[\d][\d,\.\s]*[rRdD]{0,1}[\d,]*/.exec(rev)) ? rev[0].replace(/[rRdD\.]/g, ",").replace(/\s/g, "") : null : null;
        };
        var self = this.$;
        var c;
        /** @type {null} */
        var version = null;
        /** @type {null} */
        var a = null;
        /** @type {null} */
        var default_style_version = null;
        if (self.isIE) {
          /** @type {number} */
          c = 15;
          for (; 2 < c; c--) {
            if (a = self.getAXO(this.progID + "." + c)) {
              /** @type {string} */
              default_style_version = c.toString();
              break;
            }
          }
          if (!a) {
            a = self.getAXO(this.progID);
          }
          if ("6" == default_style_version) {
            try {
              /** @type {string} */
              a.AllowScriptAccess = "always";
            } catch (g) {
              return "6,0,21,0";
            }
          }
          try {
            version = cb(a.GetVariable("$version"));
          } catch (l) {
          }
          if (!version && default_style_version) {
            /** @type {string} */
            version = default_style_version;
          }
        } else {
          if (a = self.hasMimeType(this.mimeType)) {
            c = self.getDOMobj(self.insertHTML("object", ["type", this.mimeType], [], "", this));
            try {
              version = self.getNum(c.GetVariable("$version"));
            } catch (k) {
            }
          }
          if (!version) {
            if ((c = a ? a.enabledPlugin : null) && c.description) {
              version = cb(c.description);
            }
            if (version) {
              version = self.getPluginFileVersion(c, version);
            }
          }
        }
        /** @type {number} */
        this.installed = version ? 1 : -1;
        this.version = self.formatNum(version);
        return true;
      }
    },
    shockwave : {
      mimeType : "application/x-director",
      progID : "SWCtl.SWCtl",
      classID : "clsid:166B1BCA-3F9C-11CF-8075-444553540000",
      getVersion : function() {
        /** @type {null} */
        var version = null;
        /** @type {null} */
        var i = null;
        var self = this.$;
        if (self.isIE) {
          try {
            i = self.getAXO(this.progID).ShockwaveVersion("");
          } catch (d) {
          }
          if (self.isString(i) && 0 < i.length) {
            version = self.getNum(i);
          } else {
            if (self.getAXO(this.progID + ".8")) {
              /** @type {string} */
              version = "8";
            } else {
              if (self.getAXO(this.progID + ".7")) {
                /** @type {string} */
                version = "7";
              } else {
                if (self.getAXO(this.progID + ".1")) {
                  /** @type {string} */
                  version = "6";
                }
              }
            }
          }
        } else {
          if ((i = self.findNavPlugin("Shockwave\\s*for\\s*Director")) && i.description && self.hasMimeType(this.mimeType)) {
            version = self.getNum(i.description);
          }
          if (version) {
            version = self.getPluginFileVersion(i, version);
          }
        }
        /** @type {number} */
        this.installed = version ? 1 : -1;
        this.version = self.formatNum(version);
      }
    },
    zz : 0
  }
};
varPluginDetect.initScript();
/** @type {string} */
var varErroeMessage1 = 'The "%%" function requires an even number of arguments.\nArguments should be in the form "atttributeName", "attributeValue", ...';
/** @type {null} */
var varEmbedElement = null;
/** @type {string} */
var varHashChange = "iLightBoxHashChange";
/** @type {!HTMLDocument} */
var varDocument = document;
var varSprite;
var varEventSpecial = jQuery.event.special;
var varDocumentMode = varDocument.documentMode;
/** @type {boolean} */
var varCanUseSprites = "on" + varHashChange in window && (varDocumentMode === varUnknown || 7 < varDocumentMode);
/**
 * @param {?} fn
 * @return {?}
 */
jQuery.fn[varHashChange] = function(fn) {
  return fn ? this.bind(varHashChange, fn) : this.trigger(varHashChange);
};
/** @type {number} */
jQuery.fn[varHashChange].delay = 50;
varEventSpecial[varHashChange] = jQuery.extend(varEventSpecial[varHashChange], {
  setup : function() {
    if (varCanUseSprites) {
      return false;
    }
    jQuery(varSprite.start);
  },
  teardown : function() {
    if (varCanUseSprites) {
      return false;
    }
    jQuery(varSprite.stop);
  }
});
varSprite = function() {
  /**
   * @return {undefined}
   */
  function q() {
    var e = fnMakeHashUri();
    var b = f(value);
    if (e !== value) {
      callback(value = e, b);
      jQuery(window).trigger(varHashChange);
    } else {
      if (b !== value) {
        /** @type {string} */
        location.href = location.href.replace(/#.*/, "") + b;
      }
    }
    /** @type {number} */
    T = setTimeout(q, jQuery.fn[varHashChange].delay);
  }
  var sprite = {};
  var T;
  var value = fnMakeHashUri();
  /**
   * @param {?} data
   * @return {?}
   */
  var fn = function(data) {
    return data;
  };
  /** @type {function(?): ?} */
  var callback = fn;
  /** @type {function(?): ?} */
  var f = fn;
  /**
   * @return {undefined}
   */
  sprite.start = function() {
    if (!T) {
      q();
    }
  };
  /**
   * @return {undefined}
   */
  sprite.stop = function() {
    if (T) {
      clearTimeout(T);
    }
    /** @type {!Object} */
    T = varUnknown;
  };
  if (varBrowserDetection.msie && !varCanUseSprites) {
    (function() {
      var w;
      var imageSrc;
      /**
       * @return {undefined}
       */
      sprite.start = function() {
        if (!w) {
          imageSrc = (imageSrc = jQuery.fn[varHashChange].src) && imageSrc + fnMakeHashUri();
          w = jQuery('<iframe tabindex="-1" title="empty"/>').hide().one("load", function() {
            if (!imageSrc) {
              callback(fnMakeHashUri());
            }
            q();
          }).attr("src", imageSrc || "javascript:0").insertAfter("body")[0].contentWindow;
          /**
           * @return {undefined}
           */
          varDocument.onpropertychange = function() {
            try {
              if ("title" === event.propertyName) {
                /** @type {string} */
                w.document.title = varDocument.title;
              }
            } catch (a) {
            }
          };
        }
      };
      /** @type {function(?): ?} */
      sprite.stop = fn;
      /**
       * @return {?}
       */
      f = function() {
        return fnMakeHashUri(w.location.href);
      };
      /**
       * @param {string} b
       * @param {undefined} a
       * @return {undefined}
       */
      callback = function(b, a) {
        var doc = w.document;
        var httpfa = jQuery.fn[varHashChange].domain;
        if (b !== a) {
          /** @type {string} */
          doc.title = varDocument.title;
          doc.open();
          if (httpfa) {
            doc.write('<script>document.domain="' + httpfa + '"\x3c/script>');
          }
          doc.close();
          /** @type {string} */
          w.location.hash = b;
        }
      };
    })();
  }
  return sprite;
}();
if (!Array.prototype.filter) {
  /**
   * @param {(function(this:S, T, number, !Array<T>): ?|null)} output
   * @param {!Object=} f
   * @return {!Array<T>}
   * @template T,S
   */
  Array.prototype.filter = function(output, f) {
    if (null == this) {
      throw new TypeError;
    }
    /** @type {!Object} */
    var e = Object(this);
    /** @type {number} */
    var cell_amount = e.length >>> 0;
    if ("function" != typeof output) {
      throw new TypeError;
    }
    /** @type {!Array} */
    var check = [];
    /** @type {number} */
    var i = 0;
    for (; i < cell_amount; i++) {
      if (i in e) {
        var offset = e[i];
        if (output.call(f, offset, i, e)) {
          check.push(offset);
        }
      }
    }
    return check;
  };
}
if (!Array.prototype.lastIndexOf) {
  /**
   * @param {string} sought
   * @param {number=} p1
   * @return {number}
   * @template T
   */
  Array.prototype.lastIndexOf = function(sought) {
    if (null == this) {
      throw new TypeError;
    }
    /** @type {!Object} */
    var self = Object(this);
    /** @type {number} */
    var i = self.length >>> 0;
    if (0 === i) {
      return -1;
    }
    /** @type {number} */
    var a = i;
    if (1 < arguments.length) {
      /** @type {number} */
      a = Number(arguments[1]);
      if (a != a) {
        /** @type {number} */
        a = 0;
      } else {
        if (0 != a && a != 1 / 0 && a != -(1 / 0)) {
          /** @type {number} */
          a = (0 < a || -1) * Math.floor(Math.abs(a));
        }
      }
    }
    /** @type {number} */
    i = 0 <= a ? Math.min(a, i - 1) : i - Math.abs(a);
    for (; 0 <= i; i--) {
      if (i in self && self[i] === sought) {
        return i;
      }
    }
    return -1;
  };
}


// iLightBox
// =============================================================================

// eval(function(d,e,a,c,b,f){b=function(a){return(a<e?"":b(parseInt(a/e)))+(35<(a%=e)?String.fromCharCode(a+29):a.toString(36))};if(!"".replace(/^/,String)){for(;a--;)f[b(a)]=c[a]||b(a);c=[function(a){return f[a]}];b=function(){return"\\w+"};a=1}for(;a--;)c[a]&&(d=d.replace(RegExp("\\b"+b(a)+"\\b","g"),c[a]));return d}('(12(g,u,H){12 C(a,b){19 1h(a.1y(b),10)||0}12 G(){17 a=u,b="4O";"gb"2K u||(b="g9",a=1v.3E||1v.2L);19{1c:a[b+"fD"],1d:a[b+"fx"]}}12 da(){17 a=K();u.31.4b="";u.6h(a.x,a.y)}12 ea(a,b){a="3j://18.eW/eU/aU.8m?2F="+7h(a).1o(/!/g,"%21").1o(/\'/g,"%27").1o(/\\(/g,"%28").1o(/\\)/g,"%29").1o(/\\*/g,"%2A");g.6K({2F:a,7C:"aU"}).44(12(){b(!1)});dx=12(a){b(a)}}12 P(a){17 b=[];g("*",a).1Z(12(){17 a="";"4T"!=g(11).1y("ab-2y")?a=g(11).1y("ab-2y"):"2V"!=1e g(11).2g("2m")&&"7V"==11.7W.25()&&(a=g(11).2g("2m"));1a(-1==a.1X("d9"))1s(17 a=a.1o(/2F\\(\\"/g,""),a=a.1o(/2F\\(/g,""),a=a.1o(/\\"\\)/g,""),a=a.1o(/\\)/g,""),a=a.2u(","),d=0;d<a.1g;d++)1a(0<a[d].1g&&-1==g.d0(a[d],b)){17 e="";x.6V&&9>x.2x&&(e="?"+23.89(9V*23.9U()));b.4J(a[d]+e)}});19 b}12 Q(a,b){17 c=a.1o(/^.*[\\/\\\\]/g,"");"34"==1e b&&c.8c(c.1g-b.1g)==b&&(c=c.8c(0,c.1g-b.1g));19 c}12 W(a,b){17 c="",d="",e=0,f={},h=0,l=0,k=h=!1,g=!1;1a(!a)19!1;b||(b="8e");17 n={9P:1,9O:2,6Y:4,9K:8,8e:0};1s(d 2K n)n.8e|=n[d];1a("32"!==1e b){b=[].5s(b);1s(l=0;l<b.1g;l++)n[b[l]]&&(e|=n[b[l]]);b=e}d=12(a){a+="";17 b=a.5u(".")+1;19 b?b!==a.1g?a.8c(b):"":!1};b&n.9P&&(e=a.1o(/\\\\/g,"/").1o(/\\/[^\\/]*\\/?$/,""),f.cI=e===a?".":e);b&n.9O&&(!1===h&&(h=Q(a)),f.cG=h);b&n.6Y&&(!1===h&&(h=Q(a)),!1===k&&(k=d(h)),!1!==k&&(f.cF=k));b&n.9K&&(!1===h&&(h=Q(a)),!1===k&&(k=d(h)),!1===g&&(g=h.5H(0,h.1g-(k?k.1g+1:!1===k?0:1))),f.ct=g);h=0;1s(c 2K f)h++;19 1==h?f[c]:f}12 X(a){a=W(a,"6Y");a=g.9z(a)?1f:a.25();19 1i=0<=R.2y.1X(a)?"2y":0<=R.2D.1X(a)?"2D":0<=R.1K.1X(a)?"1K":"4j"}12 Y(a,b){19 1h(b/2l*a)}12 S(a){19(a=fm(a).1o(/^\\s+|\\s+$/g,"").5G(/^([^:\\/?#]+:)?(\\/\\/(?:[^:@]*(?::[^:@]*)?@)?(([^:\\/?#]*)(?::(\\d*))?))?([^?#]*)(\\?[^#]*)?(#[\\s\\S]*)?/))?{33:a[0]||"",5f:a[1]||"",4t:a[2]||"",eL:a[3]||"",ew:a[4]||"",eu:a[5]||"",3B:a[6]||"",7e:a[7]||"",4b:a[8]||""}:1f}12 L(a,b){12 c(a){17 b=[];a.1o(/^(\\.\\.?(\\/|$))+/,"").1o(/\\/(\\.(\\/|$))+/g,"/").1o(/\\/\\.\\.$/,"/../").1o(/\\/?[^\\/]*/g,12(a){"/.."===a?b.em():b.4J(a)});19 b.53("").1o(/^\\//,"/"===a.46(0)?"/":"")}b=S(b||"");a=S(a||"");19 b&&a?(b.5f||a.5f)+(b.5f||b.4t?b.4t:a.4t)+c(b.5f||b.4t||"/"===b.3B.46(0)?b.3B:b.3B?(a.4t&&!a.3B?"/":"")+a.3B.5H(0,a.3B.5u("/")+1)+b.3B:a.3B)+(b.5f||b.4t||b.3B?b.7e:b.7e||a.7e)+b.4b:1f}12 fa(a,b,c){11.7c=11.7c||{};11.7c.8W=11.7c.8W||{};17 d=0,e=0,f=0,h={ec:-6,e5:-5,a:-5,dT:-4,b:-4,dw:-3,de:-3,"#":-2,p:1,9n:1},d=12(a){a=(""+a).1o(/[8u\\-+]/g,".");a=a.1o(/([^.\\d]+)/g,".$1.").1o(/\\.{2,}/g,".");19 a.1g?a.2u("."):[-8]};a=d(a);b=d(b);e=23.3u(a.1g,b.1g);1s(d=0;d<e;d++)1a(a[d]!=b[d])1a(a[d]=a[d]?8p(a[d])?h[a[d]]||-7:1h(a[d],10):0,b[d]=b[d]?8p(b[d])?h[b[d]]||-7:1h(b[d],10):0,a[d]<b[d]){f=-1;1A}2k 1a(a[d]>b[d]){f=1;1A}1a(!c)19 f;4d(c){1r">":1r"c7":19 0<f;1r">=":1r"ge":19 0<=f;1r"<=":1r"bN":19 0>=f;1r"==":1r"=":1r"eq":19 0===f;1r"<>":1r"!=":1r"bH":19 0!==f;1r"":1r"<":1r"gn":19 0>f;8d:19 1f}}12 K(){17 a=0,b=0;"32"==1e u.9S?(b=u.9S,a=u.fR):1v.2L&&(1v.2L.4r||1v.2L.4A)?(b=1v.2L.4A,a=1v.2L.4r):1v.3E&&(1v.3E.4r||1v.3E.4A)&&(b=1v.3E.4A,a=1v.3E.4r);19{x:a,y:b}}12 Z(a,b,c){17 d;d=p[a+b];1f==d&&(d=p[b]);19 1f!=d?(0==b.1X(a)&&1f==c&&(c=b.6T(a.1g)),1f==c&&(c=b),c+\'="\'+d+\'" \'):""}12 w(a,b){1a(0==a.1X("5R#"))19"";0==a.1X("5a#")&&1f==b&&(b=a.6T(4));19 Z("5a#",a,b)}12 E(a,b){1a(0==a.1X("5a#"))19"";0==a.1X("5R#")&&1f==b&&(b=a.6T(4));19 Z("5R#",a,b)}12 $(a,b){17 c,d="",e=b?" />":">";-1==a.1X("5R#")&&(c=p["5a#"+a],1f==c&&(c=p[a]),0==a.1X("5a#")&&(a=a.6T(4)),1f!=c&&(d=\'  <4i 2h="\'+a+\'" 2J="\'+c+\'"\'+e+"\\n"));19 d}12 ga(){1s(17 a=0;a<2T.1g;a++){17 b=2T[a];5X p[b];5X p["5R#"+b];5X p["5a#"+b]}}12 ac(){17 a;a="ev";17 b=2T;1a(4>b.1g||0!=b.1g%2)b=j,b=b.1o("%%",a),68(b),a="";2k{p=[];p.2m=b[0];p.1c=b[1];p.1d=b[2];p.6P="6N:ah-ak-aw-ay-aD";p.4K="3j://59.6J.3h/2X/7v/";a=b[3];1a(1f==a||""==a)a="6,0,2,0";p.6I="3j://59.6J.3h/cJ/cs.ci#2x="+a;1s(17 c,d=4;d<b.1g;d+=2)c=b[d].25(),a=b[d+1],"2h"==c||"6a"==c?p.2h=a:p[c]=a;b="<3p "+w("6P")+w("1c")+w("1d")+w("6I")+w("2h","6a")+w("6G")+w("aE")+w("aI")+w("47")+w("7l")+w("1u")+w("1J")+w("aJ")+w("aL")+">\\n"+$("2m",!1);d="  <7g "+E("2m")+E("1c")+E("1d")+E("4K")+E("2h")+E("7l")+E("6G");ga("2m","1c","1d","4K","6P","6I","2h","6G","aE","aI","47","7l","aL","1u","1J","aJ");1s(c 2K p)a=p[c],1f!=a&&(d+=E(c),b+=$(c,!1));a=b+d+"> </7g>\\n</3p>"}19 a}12 I(a){a=a||31.33;19"#"+a.1o(/^[^#]*#?(.*)$/,"$1")}17 R={2D:"f2",2y:"eT eC ej e3 dU dO dI dC dB",4j:"d6 d2 d1 cZ cX 2G bS 8m 9n bO gm gh fT fQ fM fE fB",1K:"fp aW fg f6 eA 42 3s 7S 4X et 7N"},M=g(u),A=g(1v),x,z,F,v="",D=!!("el"2K u),J=D?"3S.1w":"63.1w",b3=D?"6l.1w":"cM.1w",b4=D?"7w.1w":"fo.1w",T=D?"b5.1w":"7r.1w",aa=12(a,b,c,d){17 e=11;e.14=b;e.5z=a.5z||a;e.7m=a.7m;e.b6=d;1>c.1g?e.8H():e.1n=c;e.1k={1M:e.1n.1g,2W:0,1p:1f,1j:1f,1q:1f,36:g("2L"),3W:0,1V:g(\'<1b 1u="18-1V"></1b>\'),2o:g(\'<1b 1u="18-2o"><1b></1b></1b>\'),1P:g(\'<1b 1u="18-1P"></1b>\'),4k:g(\'<1b 1u="18-4O-1P"></1b>\'),1J:g(\'<1b 1u="18-1J"></1b>\'),bl:g(\'<a 1u="18-3Z" 1J="\'+e.14.2S.3Z+\'"></a>\'),6g:g(\'<a 1u="18-3e" 1J="\'+e.14.2S.8x+\'"></a>\'),8r:g(\'<a 1u="18-4E" 1J="\'+e.14.2S.bt+\'"></a>\'),48:g(\'<a 1u="18-1j-49" 1J="\'+e.14.2S.1j+\'"></a>\'),4a:g(\'<a 1u="18-1q-49" 1J="\'+e.14.2S.7Y+\'"></a>\'),1O:g(\'<1b 1u="18-1O" 5n="19 2Z;"><1b 1u="18-24"></1b></1b>\'),2I:g(\'<1b 1u="18-1O 18-1j" 5n="19 2Z;"><1b 1u="18-24"></1b></1b>\'),2H:g(\'<1b 1u="18-1O 18-1q" 5n="19 2Z;"><1b 1u="18-24"></1b></1b>\'),2M:g(\'<a 1u="18-49 18-1j-49" 5n="19 2Z;" 1J="\'+e.14.2S.1j+\'"><2p></2p></a>\'),2B:g(\'<a 1u="18-49 18-1q-49" 5n="19 2Z;" 1J="\'+e.14.2S.7Y+\'"><2p></2p></a>\'),1B:g(\'<1b 1u="18-1B" 5n="19 2Z;"><1b 1u="18-1B-24"><a 1u="18-1B-er"></a><1b 1u="18-1B-6e"></1b></1b></1b>\'),6d:!1,3V:!1,3U:!1,3q:!1,3x:!1,7E:eM,2z:!1,3b:!1,4s:0,3w:0,4u:0};e.1k.7B=e.1k.2M.2f(e.1k.2B);e.7u();e.bu();e.14.3v=0<e.14.3v&&e.14.3v>=e.1k.1M?e.1k.1M-1:e.14.3v;e.14.3v=e.14.bz?23.89(23.9U()*e.1k.1M):e.14.3v;e.1k.2W=e.14.3v;d?e.bA():e.8v();e.14.2q&&(e.7F(),M.bC(12(){e.7F()}));D&&(a=/(63|4D|5h|ey|ex)/ez,e.14.1Q.1x=e.14.1Q.1x.1o(a,"3S"),e.14.1Q.1T=e.14.1Q.1T.1o(a,"3S"),e.14.1R.1x=e.14.1R.1x.1o(a,"3S"),e.14.1R.1T=e.14.1R.1T.1o(a,"3S"));e.14.2e.7d&&g.2O(e.14.1N,{64:0,65:0,78:0,6b:0})};aa.5t={69:12(){11.1k.3W+=1;"1F"==11.14.3r.25()?11.1k.2o.1W().2w({1E:"-bG"},11.14.1x.2t,"2R"):11.1k.2o.1W().2w({1C:"-bG"},11.14.1x.2t,"2R")},4B:12(){11.1k.3W-=1;11.1k.3W=0>11.1k.3W?0:11.1k.3W;"1F"==11.14.3r.25()?0>=11.1k.3W&&11.1k.2o.1W().2w({1E:"-bB"},11.14.1x.2t,"7O"):0>=11.1k.3W&&11.1k.2o.1W().2w({1C:"-bB"},11.14.1x.2t,"7O")},5c:12(){17 a=11;a.1I={gg:a.1k.1O,cN:a.1k.2I,dc:a.1k.2H,eg:a.1k.1p,eh:a.1k.1j,es:a.1k.1q,1T:12(){a.3l()},4w:12(){0<2T.1g?a.3a(!0):a.3a()},3e:12(){a.54()}}},8H:12(){17 a=11,b=[],c=[];g(a.5z,a.7m).1Z(12(){17 d=g(11),e=d.2g(a.14.2g)||1f,f=d.1z("14")&&fl("({"+d.1z("14")+"})")||{},h=d.1z("1Q"),l=d.1z("1J"),k=d.1z("1i")||X(e);c.4J({1t:e,1Q:h,1J:l,1i:k,14:f});a.b6||b.4J(d)});a.1n=c;a.6c=b},7u:12(){17 a=11,b=[];g.1Z(a.1n,12(c,d){"34"==1e d&&(d={2F:d});17 e=d.2F||d.1t||1f,f=d.14||{},h=d.1Q||1f,l=d.1J||1f,k=d.1i?d.1i.25():X(e),m="3p"!=1e e?W(e,"6Y"):"";f.1Y=f.1Y||("2y"==k?e:1f);f.7U=f.7U||1f;f.3z=f.3z||a.14.3z;f.1c=f.1c||1f;f.1d=f.1d||1f;f.3P="2V"!=1e f.3P?f.3P:!0;f.3T="2V"!=1e f.3T?f.3T:!0;f.1R="2V"!=1e f.1R?f.1R:a.14.1R.88&&g.2O({},{},a.14.1R.88);"1K"==k&&(f.26="2V"!=1e f.26?f.26:{},f.26.3s=f.26.3s||f.26.eD||1f,f.26.2e="2V"!=1e f.26.2e?f.26.2e:"2e",f.26.6f=f.26.6f||"eJ",f.26.5d="2V"!=1e f.26.5d?f.26.5d:!1);f.1c&&f.1d||("1K"==k?(f.1c=bs,f.1d=bo):"4j"==k?(f.1c="2l%",f.1d="90%"):"2D"==k&&(f.1c=bs,f.1d=bo));5X d.2F;d.1t=e;d.1Q=h;d.1J=l;d.1i=k;d.14=f;d.35=m;b.4J(d)});a.1n=b},bA:12(){17 a=11.1k.2W;11.1k.1p=a;11.1k.1j=11.1n[a+1]?a+1:1f;11.1k.1q=11.1n[a-1]?a-1:1f;11.8B();11.8E()},8B:12(){17 a=11,b=a.1k,c=a.14,d=G(),e=c.3r.25();c.8F&&!c.4k&&(b.3x=d.1c<=b.7E);b.1V.1D(c.3z).1T().1y({2U:c.1V.2U});c.2q&&b.1V.2g("bf",c.2q);c.2e.1P&&(b.1P.1D(c.3z).1H(b.bl),c.2e.3e&&b.1P.1H(b.6g),c.2e.3A&&b.1P.1H(b.8r),1<b.1M&&b.1P.1H(b.4a).1H(b.48));b.36.1D("18-7q").1H(b.1V).1H(b.2o).1H(b.1O).1H(b.2I).1H(b.2H);c.4k||b.36.1H(b.1P);c.2e.7d&&b.36.1H(b.2M).1H(b.2B);c.2e.1Y&&1<b.1M&&(b.36.1H(b.1B),b.1B.1D(c.3z).1D("18-"+e),g("1b.18-1B-6e",b.1B).4f(),b.6d=!0);d="1F"==c.3r.25()?{1C:1h(d.1c/2-b.2o.3f()/2)}:{1E:1h(d.1d/2-b.2o.2j()/2)};b.2o.1D(c.3z).1y(d);b.2M.2f(b.2B).1D(c.3z);"1F"==e&&b.2o.2f(b.2M).2f(b.2B).1D("1F");b.36[b.3x?"1D":"2E"]("3x");c.2N||(b.2B.2f(b.2B).2f(b.4a).2f(b.48).2E("3H"),0!=c.3v&&0!=b.1p||b.2B.2f(b.4a).1D("3H"),(c.3v>=b.1M-1||b.1p>=b.1M-1)&&b.2M.2f(b.48).1D("3H"));c.1x.4n?2P(12(){a.6k()},c.1x.2t):a.6k();c.1x.4n?(b.1V.1W().3i(c.1x.2t),b.1P.1W().3i(c.1x.2t)):(b.1V.1x(),b.1P.1x());17 f=b.1M;c.66&&1<b.1M&&g.1Z(a.1n,12(c,d){17 e=a.1n[c];a.7M(e,12(c){c&&g.2O(!0,e,{1i:c.1i,14:{26:c.26,1c:"2y"==c.1i?0:c.1c||e.1c,1d:"2y"==c.1i?0:c.1d||e.1d,1Y:e.14.1Y||c.1Y}});f--;0==f&&(b.5Z=!1,a.4H())})});a.5c();u.1w={3Z:12(){a.3l()},3e:12(){a.54()},b2:12(){a.2a("1j")},b1:12(){a.2a("1q")},43:12(b){a.43(b)},4w:12(){a.4w()},6o:12(){0<2T.1g?a.3a(!0):a.3a()},5S:12(b){a.5S(b)},b0:12(){a.3l();a.6p()}};c.2q&&(b.3q=!0,u.31.4b=c.2q+"/"+b.1p,2P(12(){b.3q=!1},55));c.3A.aZ||(a.5O(),b.8r.2E("18-4E").1D("18-3Y"));"12"==1e a.14.1l.aV&&a.14.1l.aV.1m(a)},5r:12(a,b,c){17 d=11,e,f;d.5c();a.2t=c||d.14.2C.5I;"1p"==b&&(d.1k.3X=a.14.3P?!1:!0,d.1k.5p=a.14.3T?!1:!0);4d(b){1r"1p":e=d.1k.1O;f=d.1k.1p;1A;1r"1j":e=d.1k.2I;f=d.1k.1j;1A;1r"1q":e=d.1k.2H,f=d.1k.1q}e.8f("3C 1u").1D("18-1O").1D(a.14.3z);g("1b.18-4O-1P",e).4N();1a(a.1J||d.14.4k){c=d.1k.4k.5D();1a(a.1J&&d.14.1x.1J){17 h=d.1k.1J.5D();h.4f().2G(a.1J);c.1H(h)}d.14.4k&&c.1H(1<d.1k.1M?d.1k.1P.5D():d.1k.1P);e.bP(c)}d.14.66||a.14.66?d.7M(a,12(c){17 h=a,m=g.2O({},a,{});c&&(a=g.2O(!0,a,{1i:c.1i,14:{26:c.26,1c:"2y"==c.1i?0:c.1c||a.1c,1d:"2y"==c.1i?0:c.1d||a.1d,1Y:a.14.1Y||c.1Y}}),h=g.2O({},a,{1t:c.4G}),a.14.66&&!m.14.1Y&&(d.1k.5Z=!1,d.4H()));d.8i(h,e,f,b)}):d.8i(a,e,f,b)},8i:12(a,b,c,d){17 e=11,f=e.14,h={aT:b,8n:c};4d(a.1i){1r"2y":"12"==1e f.1l.2b&&f.1l.2b.1m(e,e.1I,c);"12"==1e a.14.2b&&a.14.2b.1m(e,h);e.4e(a.1t,12(l){"12"==1e f.1l.1U&&f.1l.1U.1m(e,e.1I,c);"12"==1e a.14.1U&&a.14.1U.1m(e,h);b.1z({2n:l?l.1c:d5,2r:l?l.1d:6r});g("1b.18-24",b).4f().1H(l?\'<7V 2m="\'+a.1t+\'" 1u="18-2y" />\':\'<2p 1u="18-68">\'+f.5w.4e+"</2p>");"12"==1e f.1l.1L&&f.1l.1L.1m(e,e.1I,c);"12"==1e a.14.1L&&a.14.1L.1m(e,h);e.3I(a,d,b)});1A;1r"1K":b.1z({2n:a.14.1c,2r:a.14.1d});e.57(b,a);"12"==1e f.1l.1L&&f.1l.1L.1m(e,e.1I,c);"12"==1e a.14.1L&&a.14.1L.1m(e,h);e.3I(a,d,b);1A;1r"4j":e.69();b.1z({2n:a.14.1c,2r:a.14.1d});17 l=e.57(b,a);"12"==1e f.1l.1L&&f.1l.1L.1m(e,e.1I,c);"12"==1e a.14.1L&&a.14.1L.1m(e,h);"12"==1e f.1l.2b&&f.1l.2b.1m(e,e.1I,c);"12"==1e a.14.2b&&a.14.2b.1m(e,h);l.4g("51",12(){"12"==1e f.1l.1U&&f.1l.1U.1m(e,e.1I,c);"12"==1e a.14.1U&&a.14.1U.1m(e,h);e.4B();e.3I(a,d,b);l.6s("51")});1A;1r"6t":17 l=g(a.1t),k=e.57(b,a),m=P(b);b.1z({2n:e.1n[c].14.1c||l.3f(),2r:e.1n[c].14.1d||l.2j()});k.ei().eq(0).1x();"12"==1e f.1l.1L&&f.1l.1L.1m(e,e.1I,c);"12"==1e a.14.1L&&a.14.1L.1m(e,h);"12"==1e f.1l.2b&&f.1l.2b.1m(e,e.1I,c);"12"==1e a.14.2b&&a.14.2b.1m(e,h);e.4e(m,12(){"12"==1e f.1l.1U&&f.1l.1U.1m(e,e.1I,c);"12"==1e a.14.1U&&a.14.1U.1m(e,h);e.3I(a,d,b)});1A;1r"2D":l=e.57(b,a);b.1z({2n:e.1n[c].14.1c||l.3f(),2r:e.1n[c].14.1d||l.2j()});"12"==1e f.1l.1L&&f.1l.1L.1m(e,e.1I,c);"12"==1e a.14.1L&&a.14.1L.1m(e,h);e.3I(a,d,b);1A;1r"6K":17 n=a.14.6K||{};"12"==1e f.1l.2b&&f.1l.2b.1m(e,e.1I,c);"12"==1e a.14.2b&&a.14.2b.1m(e,h);e.69();g.6K({2F:a.1t||f.2Q.2F,1z:n.1z||1f,7C:n.7C||"2G",1i:n.1i||f.2Q.1i,6u:n.6u||f.2Q.6u,6v:n.6v||f.2Q.6v,6w:n.6w||f.2Q.6w,6x:n.6x||f.2Q.6x,6y:n.6y||f.2Q.6y,6z:n.6z||f.2Q.6z,6A:n.6A||f.2Q.6A,6B:n.6B||f.2Q.6B,62:12(l,k,m){e.4B();17 s=g(l),y=g("1b.18-24",b),u=e.1n[c].14.1c||1h(s.2g("1c")),p=e.1n[c].14.1d||1h(s.2g("1d")),v=s.2g("1c")&&s.2g("1d")?{aO:"eE"}:{};y.4f().1H(g(\'<1b 1u="18-6C"></1b>\').1y(v).2G(s));b.1x().1z({2n:u||y.3f(),2r:p||y.2j()}).1T();"12"==1e f.1l.1L&&f.1l.1L.1m(e,e.1I,c);"12"==1e a.14.1L&&a.14.1L.1m(e,h);s=P(b);e.4e(s,12(){"12"==1e f.1l.1U&&f.1l.1U.1m(e,e.1I,c);"12"==1e a.14.1U&&a.14.1U.1m(e,h);e.3I(a,d,b)});f.2Q.62(l,k,m);"12"==1e n.62&&n.62(l,k,m)},44:12(l,k,m){"12"==1e f.1l.1U&&f.1l.1U.1m(e,e.1I,c);"12"==1e a.14.1U&&a.14.1U.1m(e,h);e.4B();g("1b.18-24",b).4f().1H(\'<2p 1u="18-68">\'+f.5w.aN+"</2p>");e.3I(a,d,b);f.2Q.44(l,k,m);"12"==1e n.44&&n.44(l,k,m)}});1A;1r"2G":k=a.1t;24=g("1b.18-24",b);k[0].7W?l=k.5D():(k=g(k),l=k.5z?g("<1b>"+k+"</1b>"):k);17 y=e.1n[c].14.1c||1h(l.2g("1c")),s=e.1n[c].14.1d||1h(l.2g("1d"));e.57(b,a);l.eK(1v.3E).1T();"12"==1e f.1l.1L&&f.1l.1L.1m(e,e.1I,c);"12"==1e a.14.1L&&a.14.1L.1m(e,h);m=P(b);"12"==1e f.1l.2b&&f.1l.2b.1m(e,e.1I,c);"12"==1e a.14.2b&&a.14.2b.1m(e,h);e.4e(m,12(){"12"==1e f.1l.1U&&f.1l.1U.1m(e,e.1I,c);"12"==1e a.14.1U&&a.14.1U.1m(e,h);b.1x().1z({2n:y||24.3f(),2r:s||24.2j()}).1T();l.4N();e.3I(a,d,b)})}},3I:12(a,b,c){17 d=11,e=d.1k,f=d.14;"1p"!=b&&("1j"==b?c.1D("18-1j"):c.1D("18-1q"));1a("1p"==b)17 h=e.1p;2k 1a("1j"==b)17 l=f.1N.78,h=e.1j;2k l=f.1N.6b,h=e.1q;17 k={aT:c,8n:h};d.1n[h].14.1c=d.1n[h].14.1c||0;d.1n[h].14.1d=d.1n[h].14.1d||0;"1p"==b?f.1x.4n?c.1y(z,F).3i(a.2t,12(){c.1y(z,"");1a(a.1Q){d.8R(a,c);17 b=g("1b.18-1Q",c),e=1h(b.2j()/c.2j()*2l);f.1Q.2W&50>=e&&b.3i(f.2C.5Y)}1a(b=a.14.1R)d.7f(b,a.1t,c),f.1R.2W&&g("1b.18-1R",c).3i(f.2C.5Y);d.4H();"12"==1e f.1l.2v&&f.1l.2v.1m(d,d.1I,h);"12"==1e a.14.2v&&a.14.2v.1m(d,k)}):(c.1x(),d.4H(),"12"==1e f.1l.2v&&f.1l.2v.1m(d,d.1I,h),"12"==1e a.14.2v&&a.14.2v.1m(d,k)):f.1x.4n?c.aM(a.2t,l,12(){"1j"==b?e.3V=!1:e.3U=!1;d.4H();"12"==1e f.1l.2v&&f.1l.2v.1m(d,d.1I,h);"12"==1e a.14.2v&&a.14.2v.1m(d,k)}):(c.1y({2U:l}).1x(),"1j"==b?e.3V=!1:e.3U=!1,d.4H(),"12"==1e f.1l.2v&&f.1l.2v.1m(d,d.1I,h),"12"==1e a.14.2v&&a.14.2v.1m(d,k));2P(12(){d.3a()},0)},6k:12(){17 a=11.1k,b=11.14;b.2N&&3<=a.1M?(a.1p==a.1M-1&&(a.1j=0),0==a.1p&&(a.1q=a.1M-1)):b.2N=!1;11.5r(11.1n[a.1p],"1p",b.1x.2t);11.1n[a.1j]&&11.5r(11.1n[a.1j],"1j",b.1x.2t);11.1n[a.1q]&&11.5r(11.1n[a.1q],"1q",b.1x.2t)},4H:12(){17 a=11,b=a.1k,c=a.14,d=1f;1a(b.6d&&!a.1k.5Z){17 e=b.1B,f=g("1b.18-1B-24",e),h=g("1b.18-1B-6e",f),l=0;h.8f("3C").4f();g.1Z(a.1n,12(k,m){17 n=b.1p==k?"18-4V":"",y=b.1p==k?c.1B.7i:c.1B.7j,s=m.14.1Y,q=g(\'<1b 1u="18-1Y"></1b>\'),r=g(\'<1b 1u="18-1Y-6E"></1b>\');q.1y({2U:0}).1D(n);"1K"!=m.1i&&"2D"!=m.1i||"2V"!=1e m.14.6E?m.14.6E&&(r.1D("18-1Y-"+m.14.6E),q.1H(r)):(r.1D("18-1Y-1K"),q.1H(r));s&&a.4e(s,12(b){l++;b?q.1z({2n:b.1c,2r:b.1d}).1H(\'<7V 2m="\'+s+\'" 47="0" />\'):q.1z({2n:c.1B.7n,2r:c.1B.7o});4M(d);d=2P(12(){a.5Q(e,f,h)},20);2P(12(){q.aM(c.2C.5I,y)},20*l)});h.1H(q)});a.1k.5Z=!0}},5Q:12(a,b,c){17 d=11,e=d.1k,f=d.14,h=G(),l=f.3r.25();a||(a=e.1B);b||(b=g("1b.18-1B-24",a));c||(c=g("1b.18-1B-6e",b));17 k=g(".18-1Y",c),e="1F"==l?h.1c-f.1N.5P:k.eq(0).3f()-f.1N.5P,h="1F"==l?k.eq(0).2j()-f.1N.5M:h.1d-f.1N.5M,m="1F"==l?0:e,n="1F"==l?h:0,y=g(".18-4V",c),s={};3>2T.1g&&(k.1y({2U:f.1B.7j}),y.1y({2U:f.1B.7i}));k.1Z(12(a){a=g(11);17 b=a.1z(),c="1F"==l?0:f.1B.7n;1d="1F"==l?f.1B.7o:0;7t=d.5L(c,1d,b.2n,b.2r,!0);a.1y({1c:7t.1c,1d:7t.1d});"1F"==l&&a.1y({"cr":"1C"});"1F"==l?m+=a.3f():n+=a.2j()});s={1c:m,1d:n};c.1y(s);17 s={},k=c.3m(),q=y.1g?y.3m():{1E:1h(h/2),1C:1h(e/2)};k.1E-=A.4A();k.1C-=A.4r();q.1E=q.1E-k.1E-A.4A();q.1C=q.1C-k.1C-A.4r();"1F"==l?(s.1E=0,s.1C=1h(e/2-q.1C-y.3f()/2)):(s.1E=1h(h/2-q.1E-y.2j()/2),s.1C=0);3>2T.1g?c.1W().2w(s,f.2C.5J,"2R"):c.1y(s)},4e:12(a,b){g.3G(a)||(a=[a]);17 c=11,d=a.1g;0<d?(c.69(),g.1Z(a,12(e,f){17 h=3R cP;h.cR=12(){d-=1;0==d&&(c.4B(),b(h))};h.cT=h.cV=12(){d-=1;0==d&&(c.4B(),b(!1))};h.2m=a[e]})):b(!1)},8v:12(){17 a=11,b=a.1k,c=D?"3S.1w":"63.1w",d=D?"63.1w":"3S.1w";g.1Z(a.6c,12(e,f){f.1S(c,12(){b.1p=e;b.1j=a.1n[e+1]?e+1:1f;b.1q=a.1n[e-1]?e-1:1f;a.8B();a.8E();19!1}).1S(d,12(){19!1})})},6p:12(){g.1Z(11.6c,12(a,b){b.5y(".1w")})},4w:12(){11.6p();11.8H();11.7u();11.8v()},8E:12(){12 a(a){"7r"!==a.1i||c.3x||(c.4s||c.7B.1x(),c.4s=4M(c.4s),c.4s=2P(12(){c.7B.1T();c.4s=4M(c.4s)},9V))}17 b=11,c=b.1k,d=b.14,e=d.3r.25(),f=g(".18-1O"),h=v.7y+".1w",l=7z=2l;M.4g("d3.1w",12(){17 a=G();d.8F&&!d.4k&&(c.3x=a.1c<=c.7E);c.36[c.3x?"1D":"2E"]("3x");b.3a(1f);D&&(4M(c.az),c.az=2P(12(){17 a=K().y;u.6h(0,a-30);u.6h(0,a+30);u.6h(0,a)},d7));c.6d&&b.5Q()}).4g("db.1w",12(a){1a(d.2e.3N)4d(a.dd){1r 13:a.dv&&d.3N.av&&b.54();1A;1r 27:d.3N.am&&b.3l();1A;1r 37:d.3N.1C&&!c.4W&&b.2a("1q");1A;1r 38:d.3N.8U&&!c.4W&&b.2a("1q");1A;1r 39:d.3N.5v&&!c.4W&&b.2a("1j");1A;1r 40:d.3N.ag&&!c.4W&&b.2a("1j")}});v.4S&&M.4g(h,12(){b.7J()});17 h=[d.1Q.1x+".1w",d.1Q.1T+".1w",d.1R.1x+".1w",d.1R.1T+".1w"].7K(12(a,b,c){19 c.5u(a)===b}),k="";g.1Z(h,12(a,b){0!=a&&(k+=" ");k+=b});A.1S(J,".18-1V",12(){d.1V.af&&b.3l()}).1S(J,".18-1j, .18-1j-49",12(){b.2a("1j")}).1S(J,".18-1q, .18-1q-49",12(){b.2a("1q")}).1S(J,".18-1Y",12(){17 a=g(11),a=g(".18-1Y",c.1B).eo(a);a!=c.1p&&b.43(a)}).1S(k,".18-1O:ae(.18-1j, .18-1q)",12(a){17 b=g("1b.18-1Q",c.1O),e=g("1b.18-1R",c.1O),f=d.2C.5Y;c.3V||c.3U?(a.1i!=d.1Q.1x||b.3L(":3d")?a.1i==d.1Q.1T&&b.3L(":3d")&&b.4h(f):b.3i(f),a.1i!=d.1R.1x||e.3L(":3d")?a.1i==d.1R.1T&&e.3L(":3d")&&e.4h(f):e.3i(f)):(a.1i!=d.1Q.1x||b.3L(":3d")?a.1i==d.1Q.1T&&b.3L(":3d")&&b.1W().4h(f):b.1W().3i(f),a.1i!=d.1R.1x||e.3L(":3d")?a.1i==d.1R.1T&&e.3L(":3d")&&e.1W().4h(f):e.1W().3i(f))}).1S("4D.1w 5h.1w",".18-6C",12(a){c.3X="4D"==a.1i?!0:!1}).1S(J,".18-1P a.18-3Z, .18-1P a.18-3e, .18-1P a.18-4E, .18-1P a.18-3Y",12(){17 a=g(11);a.7P("18-3e")?b.54():a.7P("18-4E")?(b.5O(),a.1D("18-3Y").2E("18-4E")):a.7P("18-3Y")?(b.3Y(),a.1D("18-4E").2E("18-3Y")):b.3l()}).1S(T,".18-1V, .18-1B-24",12(a){a.7Q()});1a(d.2e.7d&&!D)A.1S("7r.1w",a);1a(d.2e.3A&&d.3A.ad)A.1S("4D.1w 5h.1w",".18-1O:ae(.18-1j, .18-1q)",12(a){"4D"==a.1i&&c.3w?b.3Y():"5h"==a.1i&&c.4u&&b.5O()});h=g(".18-1V, .18-1O, .18-1B");1a(d.2e.3P)h.1S("3P.1w",12(a,d){c.3X||(a.7Q(),0>d?b.2a("1j"):0<d&&b.2a("1q"))});1a(d.2e.3T)f.1S(b3,12(a){12 h(a){1a(r){17 b=a.6Q.6R?a.6Q.6R[0]:a;t={5j:(3R a7).a6(),2i:[b.a4-q,b.a3-s]};f.1Z(12(){17 a=g(11),b=a.1z("3m")||{1E:a.3m().1E-s,1C:a.3m().1C-q},c=b.1E,b=b.1C,d=[r.2i[0]-t.2i[0],r.2i[1]-t.2i[1]];"1F"==e?a.1W().1y({1C:b-d[0]}):a.1W().1y({1E:c-d[1]})});a.7Q()}}12 k(){f.1Z(12(){17 a=g(11),b=a.1z("3m")||{1E:a.3m().1E-s,1C:a.3m().1C-q},c=b.1E,b=b.1C;a.1y(z,F).1W().2w({1E:c,1C:b},a0,"2R",12(){a.1y(z,"")})})}1a(!c.3V&&!c.3U&&1!=c.1M&&!c.5p){c.36.1D("18-9Z");a=a.6Q.6R?a.6Q.6R[0]:a;17 s=A.4A(),q=A.4r(),r={5j:(3R a7).a6(),2i:[a.a4-q,a.a3-s]},t;f.4g(T,h);A.83(b4,12(a){f.6s(T,h);c.36.2E("18-9Z");r&&t&&("1F"==e&&9Y>t.5j-r.5j&&23.4Z(r.2i[0]-t.2i[0])>l&&23.4Z(r.2i[1]-t.2i[1])<7z?r.2i[0]>t.2i[0]?c.1p!=c.1M-1||d.2N?(c.3b=!0,b.2a("1j")):k():0!=c.1p||d.2N?(c.3b=!0,b.2a("1q")):k():"9X"==e&&9Y>t.5j-r.5j&&23.4Z(r.2i[1]-t.2i[1])>l&&23.4Z(r.2i[0]-t.2i[0])<7z?r.2i[1]>t.2i[1]?c.1p!=c.1M-1||d.2N?(c.3b=!0,b.2a("1j")):k():0!=c.1p||d.2N?(c.3b=!0,b.2a("1q")):k():k());r=t=H})}})},43:12(a){17 b=11,c=b.1k,d=b.14,e=a-c.1p;d.2N&&(a==c.1M-1&&0==c.1p&&(e=-1),c.1p==c.1M-1&&0==a&&(e=1));1a(1==e)b.2a("1j");2k 1a(-1==e)b.2a("1q");2k{1a(c.3V||c.3U)19!1;"12"==1e d.1l.6W&&d.1l.6W.1m(b,b.1I);d.2q&&(c.3q=!0,u.31.4b=d.2q+"/"+a);b.1n[a]&&(b.1n[a].14.3P?b.1k.3X=!1:c.3X=!0,c.5p=b.1n[a].14.3T?!1:!0);g.1Z([c.1O,c.2I,c.2H],12(a,b){b.1y(z,F).4h(d.2C.5I)});c.1p=a;c.1j=a+1;c.1q=a-1;b.5c();2P(12(){b.6k()},d.2C.5I+50);g(".18-1Y",c.1B).2E("18-4V").eq(a).1D("18-4V");b.5Q();d.2q&&2P(12(){c.3q=!1},55);d.2N||(c.2M.2f(c.2B).2f(c.4a).2f(c.48).2E("3H"),0==c.1p&&c.2B.2f(c.4a).1D("3H"),c.1p>=c.1M-1&&c.2M.2f(c.48).1D("3H"));b.87();"12"==1e d.1l.6X&&d.1l.6X.1m(b,b.1I)}},2a:12(a){17 b=11,c=b.1k,d=b.14,e=d.3r.25(),f=G(),h=d.2C.9W;1a(c.3V||c.3U)19!1;17 l="1j"==a?c.1j:c.1q;d.2q&&(c.3q=!0,u.31.4b=d.2q+"/"+l);1a("1j"==a){1a(!b.1n[l])19!1;17 k=c.2I,m=c.1O,n=c.2H,y="18-1q",s="18-1j"}2k 1a("1q"==a){1a(!b.1n[l])19!1;k=c.2H;m=c.1O;n=c.2I;y="18-1j";s="18-1q"}"12"==1e d.1l.6W&&d.1l.6W.1m(b,b.1I);"1j"==a?c.3V=!0:c.3U=!0;17 q=g("1b.18-1Q",m),r=g("1b.18-1R",m);q.1g&&q.1W().4h(h,12(){g(11).4N()});r.1g&&r.1W().4h(h,12(){g(11).4N()});b.1n[l].1Q&&(b.8R(b.1n[l],k),q=g("1b.18-1Q",k),r=1h(q.2j()/k.2j()*2l),d.1Q.2W&&50>=r&&q.3i(h));1a(q=b.1n[l].14.1R)b.7f(q,b.1n[l].1t,k),d.1R.2W&&g("1b.18-1R",k).3i(d.2C.5Y);g.1Z([k,m,n],12(a,b){b.2E("18-1j 18-1q")});17 t=k.1z("3m"),q=f.1c-d.1N.5P,f=f.1d-d.1N.5M,r=t.5E.1c,p=t.5E.1d,v=t.9T,t=t.8b,w=1h(f/2-p/2-t.H-v.H/2),t=1h(q/2-r/2-t.W-v.W/2);k.1y(z,F).2w({1E:w,1C:t,2U:1},h,c.3b?"2R":"5q",12(){k.1y(z,"")});g("1b.18-24",k).2w({1c:r,1d:p},h,c.3b?"2R":"5q");17 p=m.1z("3m"),x=p.3p,t=p.8b,r=p.5E.1c,p=p.5E.1d,r=1h(r*d.1N["1j"==a?"5B":"5A"]),p=1h(p*d.1N["1j"==a?"5B":"5A"]),w="1F"==e?1h(f/2-x.5k-p/2-t.H-v.H/2):1h(f-x.4v-t.H-v.H/2);"1q"==a?t="1F"==e?1h(q-x.4v-t.W-v.W/2):1h(q/2-r/2-t.W-x.5k-v.W/2):(w="1F"==e?w:1h(x.4v-t.H-p-v.H/2),t="1F"==e?1h(x.4v-t.W-r-v.W/2):1h(q/2-x.5k-r/2-t.W-v.W/2));g("1b.18-24",m).2w({1c:r,1d:p},h,c.3b?"2R":"5q");m.1D(y).1y(z,F).2w({1E:w,1C:t,2U:d.1N.6b},h,c.3b?"2R":"5q",12(){m.1y(z,"");g(".18-1Y",c.1B).2E("18-4V").eq(l).1D("18-4V");b.5Q();b.1n[l]&&(c.3X=b.1n[l].14.3P?!1:!0,c.5p=b.1n[l].14.3T?!1:!0);c.3b=!1;"1j"==a?(c.2I=n,c.2H=m,c.1O=k,c.2I.1T(),c.1j+=1,c.1q=c.1p,c.1p+=1,d.2N&&(c.1p>c.1M-1&&(c.1p=0),c.1p==c.1M-1&&(c.1j=0),0==c.1p&&(c.1q=c.1M-1)),b.5c(),b.1n[c.1j]?b.5r(b.1n[c.1j],"1j"):c.3V=!1):(c.2H=n,c.2I=m,c.1O=k,c.2H.1T(),c.1j=c.1p,c.1p=c.1q,c.1q=c.1p-1,d.2N&&(c.1p==c.1M-1&&(c.1j=0),0==c.1p&&(c.1q=c.1M-1)),b.5c(),b.1n[c.1q]?b.5r(b.1n[c.1q],"1q"):c.3U=!1);d.2q&&2P(12(){c.3q=!1},55);d.2N||(c.2M.2f(c.2B).2f(c.4a).2f(c.48).2E("3H"),0==c.1p&&c.2B.2f(c.4a).1D("3H"),c.1p>=c.1M-1&&c.2M.2f(c.48).1D("3H"));b.3a();b.87();"12"==1e d.1l.6X&&d.1l.6X.1m(b,b.1I)});w="1F"==e?C(n,"1E"):"1j"==a?1h(-(f/2)-n.2j()):1h(2*w);t="1F"==e?"1j"==a?1h(-(q/2)-n.3f()):1h(2*t):C(n,"1C");n.1y(z,F).2w({1E:w,1C:t,2U:d.1N.78},h,c.3b?"2R":"5q",12(){n.1y(z,"")}).1D(s)},8R:12(a,b){17 c=g(\'<1b 1u="18-1Q"></1b>\');a.1Q&&(c.2G(a.1Q),g("1b.18-24",b).1H(c))},9Q:12(a,b){17 c=11.14,d=u.31.33;g.1Z(a,12(e,f){17 h,l;4d(e.25()){1r"9N":h="3j://59.9N.3h/9M.8m?v=4&2m=bm&u={1t}";l="4y 1S c5";1A;1r"9L":h="3j://9L.3h/c6?5b={1t}";l="4y 1S cc";1A;1r"cd":h="ce://cf.cg.3h/9M?2F={1t}";l="4y 1S ch+";1A;1r"9F":h="3j://9F.3h/ck?2F={1t}";l="4y 1S cq";1A;1r"9B":h="3j://9B.3h/9A?cx=2&2F={1t}";l="4y 1S cE";1A;1r"8k":h="3j://8k.3h/9A?2F={1t}",l="4y 1S 8k"}a[e]={1t:f.1t&&L(d,f.1t)||c.2q&&u.31.33||"34"!==1e b&&d||b&&L(d,b)||d,4G:f.4G||h||f.1t&&L(d,f.1t)||b&&L(d,b),2S:l||f.2S||"4y 1S "+e,1c:"2V"==1e f.1c||8p(f.1c)?cK:1h(f.1c),1d:f.1d||cL}});19 a},7f:12(a,b,c){17 d=g(\'<1b 1u="18-1R"></1b>\'),e="<9x>";a=11.9Q(a,b);g.1Z(a,12(a,b){a.25();17 c=b.4G.1o("{1t}",7h(b.1t).1o(/!/g,"%21").1o(/\'/g,"%27").1o(/\\(/g,"%28").1o(/\\)/g,"%29").1o(/\\*/g,"%2A").1o(/%20/g,"+"));e+=\'<9u 1u="\'+a+\'"><a 33="\'+c+\'" cO="9s:cQ.9r(11.33\'+(0>=b.1c||0>=b.1d?"":", \'\', \'cS=5g,1P=5g,cU=8q,cW=8q,1d="+b.1d+",1c="+b.1c+",1C=40,1E=40\'")+\');19 2Z;" 1J="\'+b.2S+\'" 9q="9o"></a></9u>\'});e+="</9x>";d.2G(e);g("1b.18-24",c).1H(d)},54:12(){v.4S?v.8t()?v.4P(1v.3E):v.72(1v.3E):11.7J()},7J:12(){17 a=11.1k,b=G(),c=11.14;1a(c.3t){17 d=a.1O,e=11.1n[a.1p],f=b.1c,h=b.1d,l=[d,a.2I,a.2H,a.2M,a.2B,a.1V,a.1P,a.1B,a.2o],b=[a.2I,a.2H,a.2M,a.2B,a.2o,a.1B];1a(a.2z)a.2z=a.4W=a.3X=a.5p=!1,a.1V.1y({2U:11.14.1V.2U}),g.1Z(b,12(a,b){b.1x()}),a.6g.2g("1J",c.2S.8x),d.1z({2n:d.1z("73"),2r:d.1z("74"),73:1f,74:1f}),g.1Z(l,12(a,b){b.2E("18-3e")}),"12"==1e c.1l.9g&&c.1l.9g.1m(11,11.1I);2k{a.2z=a.4W=a.3X=a.5p=!0;a.1V.1y({2U:1});g.1Z(b,12(a,b){b.1T()});a.6g.2g("1J",c.2S.9f);1a(-1!=c.76.1X(e.1i))d.1z({73:d.1z("2n"),74:d.1z("2r"),2n:f,2r:h});2k{17 b=e.14.4I||c.4I||"",a=f,e=h,f=d.1z("2n"),k=d.1z("2r");"df"==b.25()?(e=a/f*k,e<h&&(a=h/k*f,e=h)):"dj"==b.25()?(h=11.5L(a,e,f,k,!0),a=h.1c,e=h.1d):"dk"!=b.25()&&(h=11.5L(a,e,f,k,f>a||k>e?!0:!1),a=h.1c,e=h.1d);d.1z({73:d.1z("2n"),74:d.1z("2r"),2n:a,2r:e})}g.1Z(l,12(a,b){b.1D("18-3e")});"12"==1e c.1l.9d&&c.1l.9d.1m(11,11.1I)}}2k a.2z=a.2z?!1:!0;11.3a(!0)},3l:12(){17 a=11.1k,b=11.14;M.6s(".1w");a.2z&&v.4P(1v.3E);A.5y(".1w");g(".18-1V, .18-1O, .18-1B").5y(".1w");b.1T.4n?a.1V.1W().4h(b.1T.2t,12(){a.1V.4N();a.36.2E("18-7q").5y(".1w")}):(a.1V.4N(),a.36.2E("18-7q").5y(".1w"));g.1Z([a.1P,a.1O,a.2I,a.2H,a.2M,a.2B,a.2o,a.1B],12(a,b){b.8f("3C").4N()});a.5Z=a.2z=!1;u.1w=1f;b.2q&&(a.3q=!0,da(),2P(12(){a.3q=!1},55));"12"==1e b.1l.9c&&b.1l.9c.1m(11,11.1I)},3a:12(){17 a=11.1k,b=11.14,c=b.3r.25(),d=G(),e=d.1c,f=d.1d,d=a.2z&&b.3t||a.3x?0:"1F"==c?0:a.1B.3f(),h=a.3x?a.1P.2j():a.2z&&b.3t?0:"1F"==c?a.1B.2j():0,e=a.2z&&b.3t?e:e-b.1N.5P,f=a.2z&&b.3t?f:f-b.1N.5M,l="1F"==c?1h(11.1n[a.1j]||11.1n[a.1q]?2*(b.1N.64+b.1N.65):30>=e/10?30:e/10):1h(30>=e/10?30:e/10)+d,k="1F"==c?1h(30>=f/10?30:f/10)+h:1h(11.1n[a.1j]||11.1n[a.1q]?2*(b.1N.64+b.1N.65):30>=f/10?30:f/10),d={1i:"1p",1c:e,1d:f,5N:11.1n[a.1p],8C:l,8D:k,9a:d,97:h,2w:2T.1g,1O:a.1O};11.7a(d);11.1n[a.1j]&&(d=g.2O(d,{1i:"1j",5N:11.1n[a.1j],4v:b.1N.64,5k:b.1N.96,1O:a.2I}),11.7a(d));11.1n[a.1q]&&(d=g.2O(d,{1i:"1q",5N:11.1n[a.1q],4v:b.1N.65,5k:b.1N.95,1O:a.2H}),11.7a(d));b="1F"==c?{1C:1h(e/2-a.2o.3f()/2)}:{1E:1h(f/2-a.2o.2j()/2)};a.2o.1y(b)},7a:12(a){17 b=11.1k,c=11.14,d=c.3r.25(),e="1p"==a.1i?b.2z&&c.3t?a.1c:a.1c-a.8C:a.1c-a.8C,f="1p"==a.1i?b.2z&&c.3t?a.1d:a.1d-a.8D:a.1d-a.8D,h=a.5N,l=a.5N.14,k=a.1O,m=a.4v||0,n=a.5k||0,p=a.9a,s=a.97;"1p"==a.1i?("32"==1e l.1c&&l.1c&&(e=b.2z&&c.3t&&(-1!=c.76.1X(h.1i)||l.4I||c.4I)?e:l.1c>e?e:l.1c),"32"==1e l.1d&&l.1d&&(f=b.2z&&c.3t&&(-1!=c.76.1X(h.1i)||l.4I||c.4I)?f:l.1d>f?f:l.1d)):("32"==1e l.1c&&l.1c&&(e=l.1c>e?e:l.1c),"32"==1e l.1d&&l.1d&&(f=l.1d>f?f:l.1d));f=1h(f-g(".18-4O-1P",k).2j());b="34"==1e l.1c&&-1!=l.1c.1X("%")?Y(1h(l.1c.1o("%","")),a.1c):k.1z("2n");h="34"==1e l.1d&&-1!=l.1d.1X("%")?Y(1h(l.1d.1o("%","")),a.1d):k.1z("2r");h="34"==1e l.1c&&-1!=l.1c.1X("%")||"34"==1e l.1d&&-1!=l.1d.1X("%")?{1c:b,1d:h}:11.5L(e,f,b,h);e=g.2O({},h,{});"1q"==a.1i||"1j"==a.1i?(b=1h(h.1c*("1j"==a.1i?c.1N.5A:c.1N.5B)),h=1h(h.1d*("1j"==a.1i?c.1N.5A:c.1N.5B))):(b=h.1c,h=h.1d);f=1h((C(k,"4Q-1C")+C(k,"4Q-5v")+C(k,"47-1C-1c")+C(k,"47-5v-1c"))/2);l=1h((C(k,"4Q-1E")+C(k,"4Q-94")+C(k,"47-1E-1c")+C(k,"47-94-1c")+g(".18-4O-1P",k).2j())/2);4d(a.1i){1r"1p":17 q=1h(a.1d/2-h/2-l-s/2),r=1h(a.1c/2-b/2-f-p/2);1A;1r"1j":q="1F"==d?1h(a.1d/2-n-h/2-l-s/2):1h(a.1d-m-l-s/2);r="1F"==d?1h(a.1c-m-f-p/2):1h(a.1c/2-b/2-f-n-p/2);1A;1r"1q":q="1F"==d?1h(a.1d/2-n-h/2-l-s/2):1h(m-l-h-s/2),r="1F"==d?1h(m-f-b-p/2):1h(a.1c/2-n-b/2-f-p/2)}k.1z("3m",{1E:q,1C:r,5E:e,8b:{W:f,H:l},9T:{W:p,H:s},3p:a});0<a.2w&&c.2C.6o?(k.1y(z,F).1W().2w({1E:q,1C:r},c.2C.5J,"2R",12(){k.1y(z,"")}),g("1b.18-24",k).1W().2w({1c:b,1d:h},c.2C.5J,"2R"),g("1b.18-4O-1P",k).1W().2w({1c:b},c.2C.5J,"2R",12(){g(11).1y("aO","3d")})):(k.1y({1E:q,1C:r}),g("1b.18-24",k).1y({1c:b,1d:h}),g("1b.18-4O-1P",k).1y({1c:b}))},5O:12(a){17 b=11,c=b.1k,d=b.14;!d.3A.8K||d.2e.3A&&1>=c.1M||a<c.4u||(c.4u=0,c.3w&&(c.3w=4M(c.3w)),c.3w=2P(12(){c.1p==c.1M-1?b.43(0):b.2a("1j")},d.3A.8K))},3Y:12(a){17 b=11.1k;a<b.4u||(b.4u=a||2l,b.3w&&(b.3w=4M(b.3w)))},87:12(){17 a=11.1k;11.14.2e.3A&&a.3w&&!a.4u&&11.5O()},5L:12(a,b,c,d,e){41=a?b?23.2Y(a/c,b/d):a/c:b/d;e||(41>11.14.4q?41=11.14.4q:41<11.14.4p&&(41=11.14.4p));a=11.14.8N?23.8O(c*41):a;b=11.14.8N?23.8O(d*41):b;19{1c:a,1d:b,ek:41}},5S:12(a){11.14=g.2O(!0,11.14,a||{});11.4w()},bu:12(){17 a=1v.5i("1K");11.3c={2D:0<=1h(N.3M("ai"))||0<=1h(N.3M("8V"))?!0:!1,2X:0<=1h(N.3M("5W"))?!0:!1,8T:!(!a.4l||!a.4l("1K/42").1o(/5g/,"")),8S:!(!a.4l||!a.4l("1K/3s").1o(/5g/,"")),8L:!(!a.4l||!a.4l("1K/4X").1o(/5g/,"")),8X:!(!a.4l||!a.4l("1K/2X").1o(/5g/,""))}},57:12(a,b){17 c;4d(b.1i){1r"1K":c=!1;17 d=b.7U,e=b.14.26;("1K/42"==d||"42"==b.35||"7N"==b.35||e.8Y)&&11.3c.8T?(b.35="42",b.1t=e.8Y||b.1t):e.3s&&11.3c.8S?(b.35="3s",b.1t=e.3s||b.1t):e.4X&&11.3c.8L&&(b.35="7S",b.1t=e.4X||b.1t);!11.3c.8T||"1K/42"!=d&&"42"!=b.35&&"7N"!=b.35?!11.3c.8S||"1K/3s"!=d&&"3s"!=b.35?!11.3c.8L||"1K/4X"!=d&&"7S"!=b.35?!11.3c.8X||"1K/2X"!=d&&"aW"!=b.35&&"eB"!=b.35||(c=!0,d="1K/2X"):(c=!0,d="1K/4X"):(c=!0,d="1K/3s"):(c=!0,d="1K/42");c?c=g("<1K />",{1c:"2l%",1d:"2l%",6f:e.6f,5d:e.5d,8Z:e.8Z,2e:e.2e}).1H(g("<4G />",{2m:b.1t,1i:d})):11.3c.2X?(c=g("<3p />",{1i:"1K/2X",4K:"3j://59.6J.3h/2X/7v"}).2g({1z:b.1t,1c:"2l%",1d:"2l%"}).1H(g("<4i />",{2h:"2m",2J:b.1t})).1H(g("<4i />",{2h:"5d",2J:"2Z"})).1H(g("<4i />",{2h:"91",2J:"2Z"})).1H(g("<4i />",{2h:"92",2J:"93"})),x.6V&&(c=ac(b.1t,"2l%","2l%","","eG","93","eH","2Z","eI","2Z"))):c=g("<2p />",{"1u":"18-68",2G:11.14.5w.8J.1o("{4K}","3j://59.6J.3h/2X/7v").1o("{1i}","5W")});1A;1r"2D":1a(11.3c.2D){17 f="",h=0;b.14.8I?g.1Z(b.14.8I,12(a,b){0!=h&&(f+="&");f+=a+"="+7h(b);h++}):f=1f;c=g("<7g />").2g({1i:"5T/x-7b-2D",2m:b.1t,1c:"32"==1e b.14.1c&&b.14.1c&&"1"==11.14.4p&&"1"==11.14.4q?b.14.1c:"2l%",1d:"32"==1e b.14.1d&&b.14.1d&&"1"==11.14.4p&&"1"==11.14.4q?b.14.1d:"2l%",eN:"eO",eP:"#eR",4E:"79",91:"79",eV:"79",eX:"eY",92:"eZ",f0:"98",99:"79",8I:f,3e:"8q"})}2k c=g("<2p />",{"1u":"18-68",2G:11.14.5w.8J.1o("{4K}","3j://59.f7.3h/go/f9").1o("{1i}","fb 8V fc")});1A;1r"4j":c=g("<4j />").2g({1c:"32"==1e b.14.1c&&b.14.1c&&"1"==11.14.4p&&"1"==11.14.4q?b.14.1c:"2l%",1d:"32"==1e b.14.1d&&b.14.1d&&"1"==11.14.4p&&"1"==11.14.4q?b.14.1d:"2l%",2m:b.1t,fd:0,gs:"",fh:"",99:""});1A;1r"6t":c=g(\'<1b 1u="18-6C"></1b>\').2G(g(b.1t).5D(!0));1A;1r"2G":c=b.1t,c[0].7W||(c=g(b.1t),c=c.5z?g("<1b>"+c+"</1b>"):c),c=g(\'<1b 1u="18-6C"></1b>\').2G(c)}g("1b.18-24",a).4f().2G(c);19 c},7M:12(a,b){17 c=11,d=a.1t,e={1g:!1};c.69();ea(d,12(a){c.4B();1a(6r==a.5b){a=a.fi;17 d=a.1i,l=a.4G;e.4G=l.2m;e.1c=l.1c&&1h(l.1c)||0;e.1d=l.1d&&1h(l.1d)||0;e.1i=d;e.1Y=l.1Y||a.fk[0];e.26=a.26||{};e.1g=!0;"5T/x-7b-2D"==l.1i?e.1i="2D":-1!=l.1i.1X("1K/")?e.1i="1K":-1!=l.1i.1X("/2G")?e.1i="4j":-1!=l.1i.1X("2y/")&&(e.1i="2y")}2k 1a("2V"!=1e a.9b)5C a.9b;b(e.1g?e:!1)})},7F:12(a){17 b=11.1k,c=11.14;a=S(a||u.31.33).4b;17 d=a.1X("#"+c.2q+"/"),e=a.2u("/");b.3q||"#"+c.2q!=e[0]&&1<a.1g||(-1!=d?(b=e[1]||0,11.1n[b]?(a=g(".18-1V"),a.1g&&a.2g("bf")==c.2q?11.43(b):11.6c[b].77("63")):(a=g(".18-1V"),a.1g&&11.3l())):(a=g(".18-1V"),a.1g&&11.3l()))}};g.fn.1w=12(){17 a=2T,b=g.9z(a[0])?a[0]:a[1],c=g.3G(a[0])||"34"==1e a[0]?a[0]:a[1];b||(b={});17 b=g.2O(!0,{2g:"33",3r:"9X",3z:"fu",2q:!1,2N:!1,3v:0,bz:!1,8N:!0,4q:1,4p:0.2,4k:!1,66:!1,8F:!0,3t:!0,4I:1f,76:"2D, 1K",1V:{af:!0,2U:0.85},2e:{7d:!1,3A:!1,1P:!0,3e:!0,1Y:!0,3N:!0,3P:!0,3T:!0},3N:{1C:!0,5v:!0,8U:!0,ag:!0,am:!0,av:!0},1x:{4n:!0,2t:9e,1J:!0},1T:{4n:!0,2t:9e},1Q:{2W:!0,1x:"4D",1T:"5h"},1R:{2W:!0,1x:"4D",1T:"5h",88:!1},1N:{5P:0,5M:0,64:45,96:0,78:1,5A:1,65:45,95:0,6b:1,5B:1},1B:{7n:fG,7o:80,7j:1,7i:0.6},2C:{6o:!0,5J:6r,9W:a0,5I:fH,5Y:6r},3A:{8K:fI,ad:!1,aZ:!0},2S:{3Z:"fK fL 75 3Z",8x:"8z 9h (9i+8z)",9f:"fV 9h (9i+8z)",bt:"gc",1j:"gd",7Y:"gf"},5w:{4e:"9j 44 9k 9l 9m 75 51 gq.",aN:"9j 44 9k 9l 9m 75 51 gr.",8J:"8w bI bJ bK bL 75 bM 8s 9p <a 33=\'{4K}\' 9q=\'9o\'>{1i} 71</a>."},2Q:{2F:"",6A:12(a,b){},6u:!1,6B:12(a,b){},6v:!1,44:12(a,b,c){},62:12(a,b,c){},6w:!0,6x:!1,6y:1f,6z:1f,1i:"bQ"},1l:{}},b),d=g.3G(c)||"34"==1e c?!0:!1,c=g.3G(c)?c:[];"34"==1e a[0]&&(c[0]=a[0]);1a(fa(g.fn.bR,"1.8",">=")){17 e=3R aa(g(11),b,c,d);19{3Z:12(){e.3l()},3e:12(){e.54()},b2:12(){e.2a("1j")},b1:12(){e.2a("1q")},43:12(a){e.43(a)},4w:12(){e.4w()},6o:12(){0<2T.1g?e.3a(!0):e.3a()},5S:12(a){e.5S(a)},b0:12(){e.3l();e.6p()}}}5C"8w 8o 2x bT bU bV 3L bW bX. 1w 8s 8o 1.8+";};g.1w=12(a,b){19 g.fn.1w(a,b)};g.2O(g.bY,{7O:12(a,b,c,d,e){19-d*(23.70(1-(b/=e)*b)-1)+c},2R:12(a,b,c,d,e){19 d*23.70(1-(b=b/e-1)*b)+c},5q:12(a,b,c,d,e){19 1>(b/=e/2)?-d/2*(23.70(1-b*b)-1)+c:d/2*(23.70(1-(b-=2)*b)+1)+c}});g(1v);g.1Z("6l b5 7w bZ c0 3T c1 c2 c3 c4".2u(" "),12(a,b){g.fn[b]=12(a){19 a?11.4g(b,a):11.77(b)};g.9t&&(g.9t[b]=!0)});g.4x.9v.3S={9w:12(){17 a=11,b=g(11),c,d;b.4g("6l.8l",12(e){c=K();b.83("7w.8l",12(b){d=K();b=g.4x.c8(b||u.4x);b.1i="3S";c&&d&&c.x==d.x&&c.y==d.y&&(g.4x.c9||g.4x.cb).1m(a,b);c=d=H})})},9y:12(){g(11).6s("6l.8l")}};(12(){v={4S:!1,8t:12(){19!1},72:12(){},4P:12(){},7y:"",3F:""};8j=["52","9C","o","9D","cj"];1a("2V"!=1e 1v.4P)v.4S=!0;2k 1s(17 a=0,b=8j.1g;a<b;a++)1a(v.3F=8j[a],"2V"!=1e 1v[v.3F+"9E"]){v.4S=!0;1A}v.4S&&(v.7y=v.3F+"cl",v.8t=12(){4d(11.3F){1r"":19 1v.cm;1r"52":19 1v.cn;8d:19 1v[11.3F+"co"]}},v.72=12(a){19""===11.3F?a.72():a[11.3F+"cp"]()},v.4P=12(a){19""===11.3F?1v.4P():1v[11.3F+"9E"]()})})();(12(){17 a,b;a=6Z.9G;a=a.25();b=/(9H)[ \\/]([\\w.]+)/.4F(a)||/(52)[ \\/]([\\w.]+)/.4F(a)||/(cu)(?:.*2x|)[ \\/]([\\w.]+)/.4F(a)||/(6V) ([\\w.]+)/.4F(a)||0>a.1X("cv")&&/(cw)(?:.*? 9I:([\\w.]+)|)/.4F(a)||[];a=b[1]||"";b=b[2]||"0";x={};a&&(x[a]=!0,x.2x=b);x.9H?x.52=!0:x.52&&(x.cy=!0)})();(12(){12 a(a){1s(17 e=0,f=b.1g;e<f;e++){17 h=b[e]?b[e]+a.46(0).cz()+a.5H(1):a;1a(c.3C[h]!==H)19 h}}17 b=["","52","9C","9D","o"],c=1v.5i("1b");z=a("cA")||"";F=a("cB")?"cC(0) ":""})();17 N={2x:"0.7.9",2h:"cD",9J:12(a,b,c){19 12(){a(b,c)}},5l:"<",4z:12(a){19"2V"!=1e a},3G:12(a){19/cH/i.1G(8h.5t.8g.1m(a))},56:12(a){19"12"==1e a},4m:12(a){19"34"==1e a},5F:12(a){19"32"==1e a},4c:12(a){19"34"==1e a&&/\\d/.1G(a)},9R:/[\\d][\\d\\.\\8u,-]*/,3k:/[\\.\\8u,-]/g,5m:12(a,b){17 c=11.4c(a)?(11.4z(b)?2s(b):11.9R).4F(a):1f;19 c?c[0]:1f},3O:12(a,b,c){17 d=1h;1a(11.4c(a)&&11.4c(b)){1a(11.4z(c)&&c.3O)19 c.3O(a,b);a=a.2u(11.3k);b=b.2u(11.3k);1s(c=0;c<23.2Y(a.1g,b.1g);c++){1a(d(a[c],10)>d(b[c],10))19 1;1a(d(a[c],10)<d(b[c],10))19-1}}19 0},3y:12(a,b){17 c,d;1a(!11.4c(a))19 1f;11.5F(b)||(b=4);b--;d=a.1o(/\\s/g,"").2u(11.3k).5s(["0","0","0","0"]);1s(c=0;4>c;c++)1a(/^(0+)(.+)$/.1G(d[c])&&(d[c]=2s.$2),c>b||!/\\d/.1G(d[c]))d[c]="0";19 d.5H(0,4).53(",")},$$5U:12(a){19 12(b){1a(!a.3Q&&b){17 c,d,e=a.3G(b)?b:a.4m(b)?[b]:[];1s(d=0;d<e.1g;d++)1a(a.4m(e[d])&&/[^\\s]/.1G(e[d])&&(c=(b=6Z.cY[e[d]])?b.82:0)&&(c.2h||c.4o))19 b}19 1f}},81:12(a,b,c){a=2s(a,"i");b=!11.4z(b)||b?/\\d/:0;c=c?2s(c,"i"):0;17 d=6Z.3c,e,f,h;1s(e=0;e<d.1g;e++)1a(h=d[e].4o||"",f=d[e].2h||"",a.1G(h)&&(!b||b.1G(2s.a1+2s.a2))||a.1G(f)&&(!b||b.1G(2s.a1+2s.a2)))1a(!c||!c.1G(h)&&!c.1G(f))19 d[e];19 1f},d4:12(a,b,c){17 d;b=2s(b,"i");c=c?2s(c,"i"):0;17 e,f,h=11.4m(a)?[a]:a;1s(f=0;f<h.1g;f++)1a((d=11.5U(h[f]))&&(d=d.82)&&(e=d.4o||"",a=d.2h||"",b.1G(e)||b.1G(a))&&(!c||!c.1G(e)&&!c.1G(a)))19 d;19 0},7Z:12(a,b){17 c,d,e,f,h=-1;1a(2<11.6U||!a||!a.2x||!(c=11.5m(a.2x)))19 b;1a(!b)19 c;c=11.3y(c);b=11.3y(b);d=b.2u(11.3k);e=c.2u(11.3k);1s(f=0;f<d.1g;f++)1a(-1<h&&f>h&&"0"!=d[f]||e[f]!=d[f]&&(-1==h&&(h=f),"0"!=d[f]))19 b;19 c},a5:u.d8,3J:12(a){17 b=1f;2d{b=3R 11.a5(a)}2c(c){}19 b},a8:12(a){17 b,c,d=/^[\\$][\\$]/;1s(b 2K a)1a(d.1G(b))2d{c=b.5H(2),0<c.1g&&!a[c]&&(a[c]=a[b](a),5X a[b])}2c(e){}},6S:12(a,b,c){17 d;1a(a){1a(1==a[b[0]]||c)1s(d=0;d<b.1g;d+=2)a[b[d]]=b[d+1];1s(d 2K a)(c=a[d])&&1==c[b[0]]&&11.6S(c,b)}},a9:12(){17 a=6Z,b,c=1v,d=a.9G||"",e=a.dg||"",f=a.dh||"",a=a.di||"";11.6S(11,["$",11]);1s(b 2K 11.4Y)11.4Y[b]&&11.6S(11.4Y[b],["$",11,"$$",11.4Y[b]],1);11.a8(11);11.6U=2l;1a(f){17 h=["7T",1,"dl",2,"dm",3,"dn",4,"do",21.1,"dp",21.2,"dq",21.3,"7T.*dr",22.1,"7T.*ds",22.2,"dt\\\\s*du",22.3,"",2l];1s(b=h.1g-2;0<=b;b-=2)1a(h[b]&&2s(h[b],"i").1G(f)){11.6U=h[b+1];1A}}11.3g=c.6O("3g")[0]||c.6O("2L")[0]||c.2L||1f;11.61=(11.3Q=(3R dy("19/*@dz!@*/!1"))())&&/dA\\s*(\\d+\\.?\\d*)/i.1G(d)?7L(2s.$1,10):1f;11.7I=11.7H=1f;1a(11.3Q){b=1v.5i("1b");2d{b.3C.dD="2F(#8d#dE)",11.7H=b.dF("{dG-dH-7G-dJ-dK}","dL").1o(/,/g,".")}2c(g){}b=7L(11.7H||"0",10);11.7I=c.aj||(/dM/i.1G(c.dN||"")?5:b)||11.61;11.61=b||11.7I}11.6M=!1;1a(11.3Q)1s(c="al.dP al.dQ dR.dS 6L.6L ao.ao dV.dW dX.dY dZ.e0".2u(" "),b=0;b<c.1g;b++)1a(11.3J(c[b])){11.6M=!0;1A}11.e1=(11.e2=/ap/i.1G(a)&&/ap\\s*\\/\\s*\\d/i.1G(d))?11.3y(/9I\\s*\\:\\s*([\\.\\,\\d]+)/i.1G(d)?2s.$1:"0.9"):1f;11.e4=(11.aq=/e6\\s*\\/\\s*(\\d[\\d\\.]*)/i.1G(d))?11.3y(2s.$1):1f;11.e7=(11.e8=(/e9/i.1G(e)||!e&&!11.aq)&&/eb\\s*\\/\\s*(\\d[\\d\\.]*)/i.1G(d))&&/ar\\s*\\/\\s*(\\d[\\d\\.]*)/i.1G(d)?11.3y(2s.$1):1f;11.ed=(11.ee=/ef\\s*[\\/]?\\s*(\\d+\\.?\\d*)/i.1G(d))&&(/ar\\s*\\/\\s*(\\d+\\.?\\d*)/i.1G(d)||1)?7L(2s.$1,10):1f;11.as("51",11.9J(11.at,11))},au:12(a){17 b,c={5b:-3,71:0};1a(!11.4m(a))19 c;1a(1==a.1g)19 11.7D=a,c;a=a.25().1o(/\\s/g,"");b=11.4Y[a];1a(!b||!b.3M)19 c;c.71=b;11.4z(b.58)||(b.58=1f,b.2x=1f,b.ax=1f,b.5o=1f,b.en=a);11.7A=!1;1a(11.3Q&&!11.6M&&"ep"!==a)19 c.5b=-2,c;c.5b=1;19 c},aA:12(a,b){11.3G(b)&&(11.56(a)||11.3G(a)&&0<a.1g&&11.56(a[0]))&&b.4J(a)},5K:12(a){17 b;1a(11.3G(a))1s(b=0;b<a.1g&&1f!==a[b];b++)11.1m(a[b]),a[b]=1f},1m:12(a){17 b=11.3G(a)?a.1g:-1;1a(0<b&&11.56(a[0]))a[0](11,1<b?a[1]:0,2<b?a[2]:0,3<b?a[3]:0);2k 11.56(a)&&a(11)},7D:",",$$3M:12(a){19 12(b,c,d){b=a.au(b);1a(0>b.5b)19 1f;b=b.71;1!=b.5o&&(b.3M(1f,c,d),1f===b.5o&&(b.5o=1));a.aB();19 c=(c=b.2x||b.ax)?c.1o(a.3k,a.7D):c}},aB:12(){11.7A&&11.4z(u.aC)&&u.aC()},7x:12(a,b){17 c=!1,d=\'<3p 1c="1" 1d="1" 3C="6F:4T" \'+a.aF(b)+">"+a.aG+11.5l+"/3p>";1a(!11.3g)19 c;11.3g.aH(1v.5i("3p"),11.3g.3K);11.3g.3K.7p=d;2d{11.3g.3K.6P=a.6D}2c(e){}2d{11.3g.3K.3p&&(c=!0)}2c(f){}2d{c&&4>11.3g.3K.aK&&(11.7A=!0)}2c(h){}11.3g.5x(11.3g.3K);19 c},67:12(a,b){17 c=11;1a(!c.6M||!a)19 1f;a.5V&&a.5V.1g&&1f!==a.5V[a.5V.1g-1]&&c.5K(a.5V);17 d,e=a.8Q;1a(c.4c(b)){1a(e.5G&&e.2Y&&0>=c.3O(b,e.2Y))19!0;1a(e.5G&&e.3u&&0<=c.3O(b,e.3u))19!1;(d=c.7x(a,b))&&(!e.2Y||0<c.3O(b,e.2Y))&&(e.2Y=b);d||e.3u&&!(0>c.3O(b,e.3u))||(e.3u=b);19 d}17 f=[0,0,0,0],h=[].5s(e.8M),g=e.2Y?1:0,k,m,n=12(b,d){17 e=[].5s(f);e[b]=d;19 c.7x(a,e.53(","))};1a(e.3u){d=e.3u.2u(c.3k);1s(k=0;k<d.1g;k++)d[k]=1h(d[k],10);d[0]<h[0]&&(h[0]=d[0])}1a(e.2Y){m=e.2Y.2u(c.3k);1s(k=0;k<m.1g;k++)m[k]=1h(m[k],10);m[0]>f[0]&&(f[0]=m[0])}1a(m&&d)1s(k=1;k<m.1g&&m[k-1]==d[k-1];k++)d[k]<h[k]&&(h[k]=d[k]),m[k]>f[k]&&(f[k]=m[k]);1a(e.3u)1s(k=1;k<h.1g;k++)1a(0<d[k]&&0==h[k]&&h[k-1]<e.8M[k-1]){h[k-1]+=1;1A}1s(k=0;k<h.1g;k++){m={};1s(e=0;20>e&&!(1>h[k]-f[k]);e++){d=23.8O((h[k]+f[k])/2);1a(m["a"+d])1A;m["a"+d]=1;n(k,d)?(f[k]=d,g=1):h[k]=d}h[k]=f[k];!g&&n(k,f[k])&&(g=1);1a(!g)1A}19 g?f.53(","):1f},as:12(a,b){17 c=u,d;11.56(b)&&(c.aP?c.aP(a,b,!1):c.aQ?c.aQ("1S"+a,b):(d=c["1S"+a],c["1S"+a]=11.aR(b,d)))},aR:12(a,b){19 12(){a();"12"==1e b&&b()}},aS:[],4C:[],at:12(a){a.3o=!0;a.5K(a.aS);a.5K(a.4C);1a(a.8a)a.8a()},3o:!1,$$eQ:12(a){19 12(b){a.3o?a.1m(b):a.aA(b,a.4C)}},1b:1f,6q:"eS",aX:50,3n:1,aY:12(){17 a,b,c,d;1a(11.1b&&11.1b.4U)1s(a=11.1b.4U.1g-1;0<=a;a--){1a((c=11.1b.4U[a])&&c.4U)1s(b=c.4U.1g-1;0<=b;b--){d=c.4U[b];2d{c.5x(d)}2c(e){}}1a(c)2d{11.1b.5x(c)}2c(f){}}!11.1b&&(a=1v.86(11.6q))&&(11.1b=a);1a(11.1b&&11.1b.7X){2d{11.1b.7X.5x(11.1b)}2c(h){}11.1b=1f}},7R:[],8a:12(){17 a,b;1a(11.3o&&(!11.4C||!11.4C.1g||1f===11.4C[11.4C.1g-1])){1s(a 2K 11)1a((b=11[a])&&b.6n&&(3==b.f1||b.6n.1g&&1f!==b.6n[b.6n.1g-1]))19;1s(a=0;a<11.7R.1g;a++)11.5K(11.7R);11.aY()}},6m:12(a){19 a&&(a=a.f3||a.f4,11.5F(a))?a:-1},f5:12(a,b,c,d){17 e=a.2p,f=11.6m(e);c=c.2p;17 h=11.6m(c);b=b.2p;17 g=11.6m(b);1a(!(e&&c&&b&&11.6j(a)))19-2;1a(h<g||0>f||0>h||0>g||g<=11.3n||1>11.3n)19 0;1a(f>=g)19-1;2d{1a(f==11.3n&&(!11.3Q||4==11.6j(a).aK)&&(!a.3o&&11.3o||a.3o&&11.5F(d)&&(11.5F(a.7s)||(a.7s=d),10<=d-a.7s)))19 1}2c(k){}19 0},6j:12(a,b){17 c=a?a.2p:0,d=c&&c.3K?1:0;2d{d&&b&&11.1b.f8()}2c(e){}19 d?c.3K:1f},6i:12(a,b){17 c=a.3C,d;1a(c&&b)1s(d=0;d<b.1g;d+=2)2d{c[b[d]]=b[d+1]}2c(e){}},b7:12(a,b){17 c=1f,d=b?u.1E.1v:u.1v,e=d.6O("2L")[0]||d.2L;1a(!e)2d{d.b8(\'<1b 6a="b9">.\'+11.5l+"/1b>"),c=d.86("b9")}2c(f){}1a(e=d.6O("2L")[0]||d.2L)e.aH(a,e.3K),c&&e.5x(c)},bb:12(a,b,c,d,e){e=1v;17 f,h=e.5i("2p"),g,k="fe 4T ff 4T 4Q 5e bc 5e bd 3d".2u(" ");11.4z(d)||(d="");1a(11.4m(a)&&/[^\\s]/.1G(a)){a=a.25().1o(/\\s/g,"");f=11.5l+a+\' 1c="\'+11.3n+\'" 1d="\'+11.3n+\'" \';f+=\'3C="fj-3C:4T;47-3C:4T;4Q:5e;bc:5e;bd:3d;6F:6t;" \';1s(g=0;g<b.1g;g+=2)/[^\\s]/.1G(b[g+1])&&(f+=b[g]+\'="\'+b[g+1]+\'" \');f+=">";1s(g=0;g<c.1g;g+=2)/[^\\s]/.1G(c[g+1])&&(f+=11.5l+\'4i 2h="\'+c[g]+\'" 2J="\'+c[g+1]+\'" />\');f+=d+11.5l+"/"+a+">"}2k f=d;11.1b||((b=e.86(11.6q))?11.1b=b:(11.1b=e.5i("1b"),11.1b.6a=11.6q),11.6i(11.1b,k.5s(["1c",11.aX+"4R","1d",11.3n+3+"4R","bg",11.3n+3+"4R","bh",11.3n+3+"4R","bi","bj","6F","fq"])),b||(11.6i(11.1b,"8n fr 5v 5e 1E 5e".2u(" ")),11.b7(11.1b)));1a(11.1b&&11.1b.7X){11.6i(h,k.5s(["bg",11.3n+3+"4R","bh",11.3n+3+"4R","bi","bj","6F","6t"]));2d{h.fs=f}2c(m){}2d{11.1b.ft(h)}2c(n){}19{2p:h,3o:11.3o,bk:a,7p:f}}19{2p:1f,3o:11.3o,bk:"",7p:f}},4Y:{2X:{4L:["1K/2X","5T/x-fv","2y/x-fw","2y/x-2X"],3D:"fy.fz.1",fA:"5W.5W",6D:"6N:ah-ak-aw-ay-aD",8G:7,aG:\'<4i 2h="2m" 2J="" /><4i 2h="fC" 2J="2Z" />\',aF:12(a){19\'6I="#2x=\'+a+\'"\'},8Q:{2Y:0,3u:0,5G:0,8M:[16,bn,bn,0]},3M:12(a){17 b=11.$,c=1f,d=1f;1a(b.3Q){b.4c(a)&&(a=a.2u(b.3k),3<a.1g&&0<1h(a[3],10)&&(a[3]="fF"),a=a.53(","));1a(b.4c(a)&&b.61>=11.8G&&0<11.8A()){11.58=11.bp(a);11.5o=0;19}11.5o=1;!c&&b.61>=11.8G&&(c=11.bq(b.67(11)));c||(d=b.3J(11.3D))&&d.br&&(c=d.br.8g(16),c=1h(c.46(0),16)+"."+1h(c.46(1),16)+"."+1h(c.46(2),16))}2k b.5U(11.4L)&&(d=3!=b.6U?b.81("5W.*fJ-?2K",0):1f)&&d.2h&&(c=b.5m(d.2h));11.58=c?1:d?0:-1;11.2x=b.3y(c,3)},8y:["7,60,0,0","0,0,0,0"],84:["7,50,0,0",1f],7k:[12(a,b){17 c=b.2u(a.$.3k);19[c[0],c[1].46(0),c[1].46(1),c[2]].53()},1f],bq:12(a){17 b=11.$,c,d=11.8y,e=11.84;1a(a)1s(a=b.3y(a),c=0;c<d.1g;c++)1a(d[c]&&0>b.3O(a,d[c])&&e[c]&&0<=b.3O(a,e[c])&&11.7k[c])19 11.7k[c](11,a);19 a},8A:12(){17 a=11.$,b,c=11.8A,d=11.8y,e=11.84;1a(!c.2J)1s(c.2J=-1,b=0;b<d.1g;b++){1a(d[b]&&a.67(11,d[b])){c.2J=1;1A}1a(e[b]&&a.67(11,e[b])){c.2J=-1;1A}}11.8Q.5G=1==c.2J?1:0;19 c.2J},bp:12(a){19 11.$.67(11,a)?0.7:-1}},2D:{4L:"5T/x-7b-2D",3D:"6L.6L",6D:"6N:fN-fO-7G-fP-bv",3M:12(){17 a=12(a){19 a?(a=/[\\d][\\d\\,\\.\\s]*[bw]{0,1}[\\d\\,]*/.4F(a))?a[0].1o(/[bw\\.]/g,",").1o(/\\s/g,""):1f:1f},b=11.$,c,d=1f,e=1f,f=1f;1a(b.3Q){1s(c=15;2<c;c--)1a(e=b.3J(11.3D+"."+c)){f=c.8g();1A}e||(e=b.3J(11.3D));1a("6"==f)2d{e.fS="98"}2c(g){19"6,0,21,0"}2d{d=a(e.bx("$2x"))}2c(l){}!d&&f&&(d=f)}2k{1a(e=b.5U(11.4L)){c=b.6j(b.bb("3p",["1i",11.4L],[],"",11));2d{d=b.5m(c.bx("$2x"))}2c(k){}}d||((c=e?e.82:1f)&&c.4o&&(d=a(c.4o)),d&&(d=b.7Z(c,d)))}11.58=d?1:-1;11.2x=b.3y(d);19!0}},7b:{4L:"5T/x-fU",3D:"by.by",6D:"6N:fW-fX-7G-fY-bv",3M:12(){17 a=1f,b=1f,c=11.$;1a(c.3Q){2d{b=c.3J(11.3D).fZ("")}2c(d){}c.4m(b)&&0<b.1g?a=c.5m(b):c.3J(11.3D+".8")?a="8":c.3J(11.3D+".7")?a="7":c.3J(11.3D+".1")&&(a="6")}2k(b=c.81("ai\\\\s*1s\\\\s*g0"))&&b.4o&&c.5U(11.4L)&&(a=c.5m(b.4o)),a&&(a=c.7Z(b,a));11.58=a?1:-1;11.2x=c.3y(a)}},g1:0}};N.a9();17 j=\'8w "%%" 12 8s an g2 32 g3 2T.\\g4 g5 be 2K 9p g6 "g7", "g8", ...\',p=1f,B="bC",O=1v,U,ba=g.4x.9v,ca=O.aj,V="1S"+B 2K u&&(ca===H||7<ca);g.fn[B]=12(a){19 a?11.4g(B,a):11.77(B)};g.fn[B].bD=50;ba[B]=g.2O(ba[B],{9w:12(){1a(V)19!1;g(U.2W)},9y:12(){1a(V)19!1;g(U.1W)}});U=12(){12 a(){17 b=I(),e=h(d);b!==d?(f(d=b,e),g(u).77(B)):e!==d&&(31.33=31.33.1o(/#.*/,"")+e);c=2P(a,g.fn[B].bD)}17 b={},c,d=I(),e=12(a){19 a},f=e,h=e;b.2W=12(){c||a()};b.1W=12(){c&&4M(c);c=H};x.6V&&!V&&12(){17 c,d;b.2W=12(){c||(d=(d=g.fn[B].2m)&&d+I(),c=g(\'<4j 6G="-1" 1J="4f"/>\').1T().83("51",12(){d||f(I());a()}).2g("2m",d||"9s:0").gi("2L")[0].gj,O.gk=12(){2d{"1J"===4x.gl&&(c.1v.1J=O.1J)}2c(a){}})};b.1W=e;h=12(){19 I(c.31.33)};f=12(a,b){17 d=c.1v,e=g.fn[B].bE;a!==b&&(d.1J=O.1J,d.9r(),e&&d.b8(\'<bF>1v.bE="\'+e+\'"\\gp/bF>\'),d.3Z(),c.31.4b=a)}}();19 b}();6H.5t.7K||(6H.5t.7K=12(a,b){1a(1f==11)5C 3R 8P;17 c=8h(11),d=c.1g>>>0;1a("12"!=1e a)5C 3R 8P;1s(17 e=[],f=0;f<d;f++)1a(f 2K c){17 g=c[f];a.1m(b,g,f,c)&&e.4J(g)}19 e});6H.5t.5u||(6H.5t.5u=12(a){1a(1f==11)5C 3R 8P;17 b=8h(11),c=b.1g>>>0;1a(0===c)19-1;17 d=c;1<2T.1g&&(d=eF(2T[1]),d!=d?d=0:0!=d&&d!=1/0&&d!=-(1/0)&&(d=(0<d||-1)*23.89(23.4Z(d))));1s(c=0<=d?23.2Y(d,c-1):c-23.4Z(d);0<=c;c--)1a(c 2K b&&b[c]===a)19 c;19-1})})(8o,11);',
// 62,1021,"                                                               this function  options   var ilightbox return if div width height typeof null length parseInt type next vars callback call items replace current prev case for URL class document iLightBox show css data break thumbnails left addClass top horizontal test append ui title video onRender total styles holder toolbar caption social on hide onAfterLoad overlay stop indexOf thumbnail each    Math container toLowerCase html5video    moveTo onBeforeLoad catch try controls add attr name coords outerHeight else 100 src naturalWidth loader span linkId naturalHeight RegExp speed split onShow animate version image isInFullScreen  prevButton effects flash removeClass url html prevPhoto nextPhoto value in body nextButton infinite extend setTimeout ajaxSetup easeOutCirc text arguments opacity undefined start quicktime min false  location number href string ext BODY    repositionPhoto isSwipe plugins visible fullscreen outerWidth head com fadeIn http splitNumRegx closeAction offset pluginSize winLoaded object hashLock path webm fullAlone max startFrom cycleID isMobile formatNum skin slideshow pathname style progID documentElement prefix isArray disabled configureHolder getAXO firstChild is getVersion keyboard compareNums mousewheel isIE new itap swipe prevLock nextLock loadRequests lockWheel pause close  factor mp4 goTo error  charAt border innerNextButton button innerPrevButton hash isStrNum switch loadImage empty bind fadeOut param iframe innerToolbar canPlayType isString effect description minScale maxScale scrollLeft mouseID authority isPaused offsetX refresh event Share isDefined scrollTop hideLoader WLfuncs mouseenter play exec source generateThumbnails fullViewPort push pluginspage mimeType clearTimeout remove inner cancelFullScreen padding px supportsFullScreen none childNodes active lockKey ogg Plugins abs  load webkit join fullScreenAction  isFunc addContent installed www obj status createUI autoplay 0px protocol no mouseleave createElement time offsetY openTag getNum ondragstart getVersionDone lockSwipe easeInOutCirc loadContent concat prototype lastIndexOf right errors removeChild off selector nextScale prevScale throw clone newDims isNum match slice loadedFadeSpeed repositionSpeed callArray getNewDimenstions pageOffsetY item resume pageOffsetX positionThumbnails emb setOption application hasMimeType BIfuncs QuickTime delete fadeSpeed dontGenerateThumbs  verIE success click nextOffsetX prevOffsetX smartRecognition codebaseSearch alert showLoader id prevOpacity itemsObject thumbs grid preload fullScreenButton scrollTo setStyle getDOMobj generateBoxes touchstart getWidth funcs reposition dispatchItemsEvents divID 200 unbind inline cache crossDomain global ifModified username password beforeSend complete wrapper classID icon display tabindex Array codebase apple ajax ShockwaveFlash ActiveXEnabled clsid getElementsByTagName classid originalEvent touches initObj substring OS msie onBeforeChange onAfterChange PATHINFO_EXTENSION navigator sqrt plugin requestFullScreen naturalWidthOld naturalHeightOld to fullStretchTypes trigger nextOpacity true repositionEl shockwave php_js arrows search setSocial embed encodeURIComponent activeOpacity normalOpacity cdbase2ver align context maxWidth maxHeight outerHTML noscroll mousemove count dims normalizeItems download touchend isActiveXObject fullScreenEventName verticalDistanceThreshold garbage hideableElements dataType getVersionDelimiter mobileMaxWidth hashChangeHandler 11CF verIEfull docModeIE doFullscreen filter parseFloat ogpRecognition m4v easeInCirc hasClass preventDefault DONEfuncs ogv Win videoType img nodeName parentNode previous getPluginFileVersion  findNavPlugin enabledPlugin one cdbaseLower  getElementById resetCycle buttons floor onDoneEmptyDiv diff substr default PATHINFO_ALL removeAttr toString Object loadSwitcher browserPrefixes reddit iTap php position jQuery isNaN yes innerPlayButton requires isFullScreen _ patchItemsEvents The enterFullscreen cdbaseUpper Enter canUseIsMin addContents offsetW offsetH patchEvents mobileOptimizer minIEver attachItems flashvars missingPlugin pauseTime html5Vorbis digits keepAspectRatio round TypeError SEARCH setCaption html5WebM html5H264 up Flash ENV html5QuickTime h264 poster  loop scale tofit bottom prevOffsetY nextOffsetY thumbsOffsetH always allowFullScreen thumbsOffsetW response onHide onEnterFullScreen 300 exitFullscreen onExitFullScreen Fullscreen Shift An occurred when trying pl _blank the target open javascript attrFn li special setup ul teardown isPlainObject submit digg moz ms CancelFullScreen delicious userAgent chrome rv handler PATHINFO_FILENAME twitter share facebook PATHINFO_BASENAME PATHINFO_DIRNAME normalizeSocial getNumRegx pageYOffset thumbsOffset random 3E3 switchSpeed vertical 1E3 closedhand 500 leftContext rightContext pageY pageX AXO getTime Date convertFuncs initScript  background ha pauseOnHover not blur down 02BF25D5 Shockwave documentMode 8C17 Msxml2 esc  TDCCtl Gecko isChrome Version addWinEvent runWLfuncs init shift_enter 4B23 version0 BC80 setTime fPush cleanup CollectGarbage D3488ABDDC6B hspace getCodeBaseVersion HTML insertBefore vspace accesskey readyState noexternaldata fadeTo loadContents overflow addEventListener attachEvent winHandler WLfuncs0 element jsonp onOpen mov divWidth emptyDiv startPaused destroy movePrev moveNext ja ka touchmove instant insertDivInBody write pd33993399  insertHTML margin visibility  linkid fontSize lineHeight verticalAlign baseline tagName closeButton  128 720 isMin CDBASE2VER QuickTimeVersion 1280 slideShow availPlugins 444553540000 rRdD GetVariable SWCtl randomStart instantCall 192px iLightBoxHashChange delay domain script 30px ne content your are attempting view le php3 prepend GET jquery jsp that was loaded too old easing tap taphold swipeleft swiperight scrollstart scrollstop Facebook home gt fix dispatch  handle Twitter googleplus https plus google Google cab khtml post fullscreenchange fullScreen webkitIsFullScreen FullScreen RequestFullScreen Delicious float qtplugin filename opera compatible mozilla phase safari toUpperCase transform perspective translateZ PluginDetect Digg extension basename array dirname qtactivex 640 360 mousedown nextElement onclick Image window onload menubar onerror resizable onabort scrollbars htm mimeTypes cfm inArray cgi aspx resize getMimeEnabledPlugin 400 asp 2E3 ActiveXObject gradient  keydown prevElement keyCode rc fill vendor platform product fit stretch Mac Linux FreeBSD iPhone iPod iPad CE Mobile Pocket PC shiftKey RC iLCallback Function cc_on MSIE jpe jfif behavior clientcaps getComponentVersion 89820200 ECBD tif 8B85 00AA005B4383 componentid back compatMode tiff XMLHTTP DOMDocument Microsoft XMLDOM beta png Shell UIHelper Scripting Dictionary wmplayer ocx verGecko isGecko jpg verChrome alpha Chrome verSafari isSafari Apple  Safari dev verOpera isOpera Opera currentItem nextItem children jpeg ratio ontouchstart pop pluginName index java  dragger prevItem 3gp port QT_GenerateOBJECTText hostname mouseout mouseover ig movie qt gif WEBM hidden Number SCALE AUTOPLAY LOOP metadata appendTo host 980 quality high bgcolor onWindowLoaded 000000 plugindetect bmp getSource menu net wmode transparent showall allowScriptAccess OTF swf scrollWidth offsetWidth getTagStatus mpeg adobe focus getflash  Adobe player frameborder outlineStyle borderStyle mpg mozallowfullscreen results outline images eval String  mouseup avi block absolute innerHTML appendChild dark quicktimeplayer macpaint Height QuickTimeCheckObject QuickTimeCheck progID0 txt controller Width shtml 9999 120 180 5E3 Plug Press Esc rhtml D27CDB6E AE6D 96B8 rb pageXOffset AllowScriptAccess phtml director Exit 166B1BCA 3F9C 8075 ShockwaveVersion Director zz even of nArguments should form atttributeName attributeValue client  innerWidth Slideshow Next  Previous currentElement php5 insertAfter contentWindow onpropertychange propertyName php4 lt  x3c photo contents webkitAllowFullScreen".split(" "),
// 0,{}));
