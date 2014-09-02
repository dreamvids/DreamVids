
/**
 * main.js
 *
 * Fichier JavaScript principal.
 */

var Application = {

	name: "MarmWork"

};
!function(win,doc){function on(element,event,callback,binding){if(!element.length)return"#document-fragment"===element.nodeName?void on(element.childNodes,event,callback,binding):("function"==typeof elAndCoEvents.list[event]?elAndCoEvents.list[event](element,function(){return function(event){"string"==typeof callback?eval(callback):callback(event,binding)}}(callback,binding)):isset(element.addEventListener)?element.addEventListener(event,function(){return function(a){callback(a,binding)}}(callback,binding),!1):element.attachEvent("on"+event,function(){return function(a){callback(a,binding)}}(callback,binding)),element);for(var i=0;i<element.length;i++)on(element[i],event,callback,binding)}function childNodeList(a){for(var b=[],c=0;c<a.childNodes.length;c++)if(b.push(a.childNodes[c]),a.childNodes[c].childNodes)for(var d=childNodeList(a.childNodes[c]),e=0;e<d.length;e++)b.push(d[e]);return b}function isset(a){return"undefined"!=typeof a}var window=win,document=doc,ELCO_MAX_COMPONENTS_GENERATED=2048,elAndCoEvents={list:{}};elAndCoEvents.add=function(a,b){elAndCoEvents.list[a]=b},elAndCoEvents.onClickEventsList=[],elAndCoEvents.add("CLICK",function(a,b){var c=new elAndCoEvents.onClickObject(a,b);elAndCoEvents.onClickEventsList.push(c)}),elAndCoEvents.onClickObject=function(a,b){this.callback=b,this.element=a,this.touchstart=function(a){return function(b){a.moved=!1,a.startX=b.touches[0].clientX,a.startY=b.touches[0].clientY}}(this),this.touchmove=function(a){return function(b){(Math.abs(b.touches[0].clientX-a.startX)>10||Math.abs(b.touches[0].clientY-a.startY)>10)&&(a.moved=!0)}}(this),this.touchend=function(a){return function(b){a.moved||a.callback(b)}}(this),on(this.element,"touchstart",this.touchstart),on(this.element,"touchmove",this.touchmove),on(this.element,"touchend",this.touchend),on(this.element,"touchcancel",this.touchend),on(this.element,"click",function(a,b){"ontouchstart"in window||b.callback(a)},this)};var El=Element=function(a,b){if(this!==window)var c=Element.create(a,b);else var c=Element.select(a,b);if(c)return c.childs=c.childNodes,c.parent=c.parentNode,c.clone=c.cloneNode,c.add=function(a){return function(b){if("#document-fragment"===b.nodeName){for(var c=[],d=b.childNodes,e=d.length,f=0;e>f;f++)a.appendChild(d[0]),c.push(a.childNodes[a.childNodes.length-1]);return c}if(!b.length)return a.appendChild(b),El(b);for(var f=0;f<b.length;f++){for(var c=[],e=b.length,f=0;e>f;f++)a.appendChild(b[0]),c.push(a.childNodes[a.childNodes.length-1]);return c}}}(c),c.addFirst=function(a){return function(b){if("#document-fragment"===b.nodeName){for(var c=[],d=b.childNodes,e=d.length,f=0;e>f;f++)a.insertBefore(d[0],a.firstChild),c.push(a.childNodes[a.childNodes.length-1]);return c}if(!b.length)return a.insertBefore(b,a.firstChild),El(b);for(var f=0;f<b.length;f++){for(var c=[],e=b.length,f=0;e>f;f++)a.insertBefore(b[0],a.firstChild),c.push(a.childNodes[a.childNodes.length-1]);return c}}}(c),c.on=function(a){return function(b,c,d){on(a,b,c,d)}}(c),c.offset=function(a){return function(){for(var b={x:0,y:0};a;)b.x+=a.offsetLeft-(a==document.body?0:a.scrollLeft)+a.clientLeft,b.y+=a.offsetTop-(a==document.body?0:a.scrollTop)+a.clientTop,a=a.offsetParent;return b}}(c),c.hasClass=function(a){return function(b){return(" "+a.className+" ").indexOf(" "+b+" ")>-1}}(c),c.addClass=function(a){return function(b){return El(a).hasClass(b)||(a.className+=" "+b),El(a)}}(c),c.removeClass=function(a){return function(b){return a.className=(" "+a.className+" ").replace(" "+b+" "," "),El(a)}}(c),c.toggleClass=function(a){return function(b){return El(a).hasClass(b)?El(a).removeClass(b):El(a).addClass(b),El(a)}}(c),c};Element.create=function(a,b){var c,d=/[-\w]+/.exec(a)[0];if(c=document.createElement(d),"object"==typeof b)for(attribute in b)b.hasOwnProperty(attribute)&&!c.getAttribute(attribute)&&c.setAttribute(attribute,b[attribute]);var e=a.replace(/#([a-z-_]+)/i,"").replace(/\w+/,"").split(".");if(e.length>1){c.className="";for(var f=1;f<e.length;f++)c.className+=" "+e[f]}var g=/([a-z-_]+)(#([a-z-_]+))/i.exec(a);return g&&(c.id=g[3]),c},Element.select=function(a){var b;return"string"!=typeof a?b=a:"#"==a[0]&&(b=document.getElementById(a.substring(1))),b};var Co=Component=function(a,b){if(this===window)return Co.generate(a,b);if(a.name&&(Co.components[a.name]=this,"object"==typeof a))for(variable in a)a.hasOwnProperty(variable)&&(isset(this[variable])||(this[variable]=a[variable]))};Co.components={},Component.attributesParser=function(a,b){for(var c={},d=0;d<a.length;d++)if(c[a[d].name]=a[d].value,"string"==typeof a[d].value&&"$"==a[d].value[0]&&b)for(parameter in b)a[d].value==="${"+parameter+"}"&&b.hasOwnProperty(parameter)&&(c[a[d].name]=b[parameter]);return c},Component.prototype.create=function(a){var b=this.render(a),c=childNodeList(b);if(isset(a._CHILDNODES_)&&a._CHILDNODES_.length){for(var d=!1,e=0;e<c.length;e++){var f=c[e];if("_inner_"===f.getAttribute("tag-name")){for(;a._CHILDNODES_.length;)f.parentNode.insertBefore(a._CHILDNODES_[0],f);f.parentNode.removeChild(f),d=!0;break}}if(!d)for(;a._CHILDNODES_.length;)b.appendChild(a._CHILDNODES_[0])}return isset(this.created)&&this.created(b),b},Component.generate=function(a,b){if("string"!=typeof a)return document.createElement("div");a=a.replace(/^\s+|\s+$/g,""),a=a.replace(/<([-\w]*)( (.+?))?\/>/g,"<$1$2></$1>"),a=a.replace(/<([-\w]*)( (.+?))?>/g,'<div tag-name="$1"$2>').replace(/<\/(.+?)>/g,"</div>");var c=document.createElement("div");c.innerHTML=a;var d=!1,e=!1;for(componentsCreated=0;!d;){e=!1,ELCO_MAX_COMPONENTS_GENERATED&&componentsCreated>ELCO_MAX_COMPONENTS_GENERATED&&(console.error("el & co erreur 001\nUne boucle de création de components a été détectée.\nLa génération des components a alors été arrêtée."),d=!0);for(var f=childNodeList(c),g=0;g<f.length;g++){var h=f[g],i="";if(h.getAttribute&&(i=h.getAttribute("tag-name")||""),Co.components[i]){var j=Component.attributesParser(h.attributes,b);j._CHILDNODES_=h.childNodes;var k=Co.components[i].create(j);for(attribute in j)j.hasOwnProperty(attribute)&&null===k.getAttribute(attribute)&&"string"==typeof j[attribute]&&k.setAttribute(attribute,j[attribute]);k.removeAttribute("tag-name"),h.parentNode.insertBefore(k,h),h.parentNode.removeChild(h),e=!0,componentsCreated++;break}}e||(d=!0)}return c.childNodes},Component.inner=function(a){var b=document.createElement("div");return b.setAttribute("tag-name","_inner_"),a.appendChild(b),a},window.Co=window.Component,window.El=window.Element,window.ELCO_MAX_COMPONENTS_GENERATED=ELCO_MAX_COMPONENTS_GENERATED}(window,document);
/*! Hammer.JS - v2.0.2 - 2014-07-28
 * http://hammerjs.github.io/
 *
 * Copyright (c) 2014 Jorik Tangelder <j.tangelder@gmail.com>;
 * Licensed under the MIT license */


!function(a,b,c,d){"use strict";function e(a,b,c){return setTimeout(k(a,c),b)}function f(a,b,c){return Array.isArray(a)?(g(a,c[b],c),!0):!1}function g(a,b,c){var e,f;if(a)if(a.forEach)a.forEach(b,c);else if(a.length!==d)for(e=0,f=a.length;f>e;e++)b.call(c,a[e],e,a);else for(e in a)a.hasOwnProperty(e)&&b.call(c,a[e],e,a)}function h(a,b,c){for(var e=Object.keys(b),f=0,g=e.length;g>f;f++)(!c||c&&a[e[f]]===d)&&(a[e[f]]=b[e[f]]);return a}function i(a,b){return h(a,b,!0)}function j(a,b,c){var d,e=b.prototype;d=a.prototype=Object.create(e),d.constructor=a,d._super=e,c&&h(d,c)}function k(a,b){return function(){return a.apply(b,arguments)}}function l(a,b){return typeof a==hb?a.apply(b?b[0]||d:d,b):a}function m(a,b){return a===d?b:a}function n(a,b,c){g(r(b),function(b){a.addEventListener(b,c,!1)})}function o(a,b,c){g(r(b),function(b){a.removeEventListener(b,c,!1)})}function p(a,b){for(;a;){if(a==b)return!0;a=a.parentNode}return!1}function q(a,b){return a.indexOf(b)>-1}function r(a){return a.trim().split(/\s+/g)}function s(a,b,c){if(a.indexOf&&!c)return a.indexOf(b);for(var d=0,e=a.length;e>d;d++)if(c&&a[d][c]==b||!c&&a[d]===b)return d;return-1}function t(a){return Array.prototype.slice.call(a,0)}function u(a,b,c){for(var d=[],e=[],f=0,g=a.length;g>f;f++){var h=b?a[f][b]:a[f];s(e,h)<0&&d.push(a[f]),e[f]=h}return c&&(d=b?d.sort(function(a,c){return a[b]>c[b]}):d.sort()),d}function v(a,b){for(var c,e,f=b[0].toUpperCase()+b.slice(1),g=0,h=fb.length;h>g;g++)if(c=fb[g],e=c?c+f:b,e in a)return e;return d}function w(){return lb++}function x(b,c){var d=this;this.manager=b,this.callback=c,this.element=b.element,this.target=b.options.inputTarget,this.domHandler=function(a){l(b.options.enable,[b])&&d.handler(a)},this.evEl&&n(this.element,this.evEl,this.domHandler),this.evTarget&&n(this.target,this.evTarget,this.domHandler),this.evWin&&n(a,this.evWin,this.domHandler)}function y(a){var b;return new(b=ob?M:pb?N:nb?P:L)(a,z)}function z(a,b,c){var d=c.pointers.length,e=c.changedPointers.length,f=b&vb&&d-e===0,g=b&(xb|yb)&&d-e===0;c.isFirst=!!f,c.isFinal=!!g,f&&(a.session={}),c.eventType=b,A(a,c),a.emit("hammer.input",c),a.recognize(c),a.session.prevInput=c}function A(a,b){var c=a.session,d=b.pointers,e=d.length;c.firstInput||(c.firstInput=D(b)),e>1&&!c.firstMultiple?c.firstMultiple=D(b):1===e&&(c.firstMultiple=!1);var f=c.firstInput,g=c.firstMultiple,h=g?g.center:f.center,i=b.center=E(d);b.timeStamp=kb(),b.deltaTime=b.timeStamp-f.timeStamp,b.angle=I(h,i),b.distance=H(h,i),B(c,b),b.offsetDirection=G(b.deltaX,b.deltaY),b.scale=g?K(g.pointers,d):1,b.rotation=g?J(g.pointers,d):0,C(c,b);var j=a.element;p(b.srcEvent.target,j)&&(j=b.srcEvent.target),b.target=j}function B(a,b){var c=b.center,d=a.offsetDelta||{},e=a.prevDelta||{},f=a.prevInput||{};(b.eventType===vb||f.eventType===xb)&&(e=a.prevDelta={x:f.deltaX||0,y:f.deltaY||0},d=a.offsetDelta={x:c.x,y:c.y}),b.deltaX=e.x+(c.x-d.x),b.deltaY=e.y+(c.y-d.y)}function C(a,b){var c,e,f,g,h=a.lastInterval||b,i=b.timeStamp-h.timeStamp;if(b.eventType!=yb&&(i>ub||h.velocity===d)){var j=h.deltaX-b.deltaX,k=h.deltaY-b.deltaY,l=F(i,j,k);e=l.x,f=l.y,c=jb(l.x)>jb(l.y)?l.x:l.y,g=G(j,k),a.lastInterval=b}else c=h.velocity,e=h.velocityX,f=h.velocityY,g=h.direction;b.velocity=c,b.velocityX=e,b.velocityY=f,b.direction=g}function D(a){for(var b=[],c=0;c<a.pointers.length;c++)b[c]={clientX:ib(a.pointers[c].clientX),clientY:ib(a.pointers[c].clientY)};return{timeStamp:kb(),pointers:b,center:E(b),deltaX:a.deltaX,deltaY:a.deltaY}}function E(a){var b=a.length;if(1===b)return{x:ib(a[0].clientX),y:ib(a[0].clientY)};for(var c=0,d=0,e=0;b>e;e++)c+=a[e].clientX,d+=a[e].clientY;return{x:ib(c/b),y:ib(d/b)}}function F(a,b,c){return{x:b/a||0,y:c/a||0}}function G(a,b){return a===b?zb:jb(a)>=jb(b)?a>0?Ab:Bb:b>0?Cb:Db}function H(a,b,c){c||(c=Hb);var d=b[c[0]]-a[c[0]],e=b[c[1]]-a[c[1]];return Math.sqrt(d*d+e*e)}function I(a,b,c){c||(c=Hb);var d=b[c[0]]-a[c[0]],e=b[c[1]]-a[c[1]];return 180*Math.atan2(e,d)/Math.PI}function J(a,b){return I(b[1],b[0],Ib)-I(a[1],a[0],Ib)}function K(a,b){return H(b[0],b[1],Ib)/H(a[0],a[1],Ib)}function L(){this.evEl=Kb,this.evWin=Lb,this.allow=!0,this.pressed=!1,x.apply(this,arguments)}function M(){this.evEl=Ob,this.evWin=Pb,x.apply(this,arguments),this.store=this.manager.session.pointerEvents=[]}function N(){this.evTarget=Rb,this.targetIds={},x.apply(this,arguments)}function O(a,b){var c=t(a.touches),d=this.targetIds;if(b&(vb|wb)&&1===c.length)return d[c[0].identifier]=!0,[c,c];var e,f,g=t(a.targetTouches),h=t(a.changedTouches),i=[];if(b===vb)for(e=0,f=g.length;f>e;e++)d[g[e].identifier]=!0;for(e=0,f=h.length;f>e;e++)d[h[e].identifier]&&i.push(h[e]),b&(xb|yb)&&delete d[h[e].identifier];return i.length?[u(g.concat(i),"identifier",!0),i]:void 0}function P(){x.apply(this,arguments);var a=k(this.handler,this);this.touch=new N(this.manager,a),this.mouse=new L(this.manager,a)}function Q(a,b){this.manager=a,this.set(b)}function R(a){if(q(a,Xb))return Xb;var b=q(a,Yb),c=q(a,Zb);return b&&c?Yb+" "+Zb:b||c?b?Yb:Zb:q(a,Wb)?Wb:Vb}function S(a){this.id=w(),this.manager=null,this.options=i(a||{},this.defaults),this.options.enable=m(this.options.enable,!0),this.state=$b,this.simultaneous={},this.requireFail=[]}function T(a){return a&dc?"cancel":a&bc?"end":a&ac?"move":a&_b?"start":""}function U(a){return a==Db?"down":a==Cb?"up":a==Ab?"left":a==Bb?"right":""}function V(a,b){var c=b.manager;return c?c.get(a):a}function W(){S.apply(this,arguments)}function X(){W.apply(this,arguments),this.pX=null,this.pY=null}function Y(){W.apply(this,arguments)}function Z(){S.apply(this,arguments),this._timer=null,this._input=null}function $(){W.apply(this,arguments)}function _(){W.apply(this,arguments)}function ab(){S.apply(this,arguments),this.pTime=!1,this.pCenter=!1,this._timer=null,this._input=null,this.count=0}function bb(a,b){return b=b||{},b.recognizers=m(b.recognizers,bb.defaults.preset),new cb(a,b)}function cb(a,b){b=b||{},this.options=i(b,bb.defaults),this.options.inputTarget=this.options.inputTarget||a,this.handlers={},this.session={},this.recognizers=[],this.element=a,this.input=y(this),this.touchAction=new Q(this,this.options.touchAction),db(this,!0),g(b.recognizers,function(a){var b=this.add(new a[0](a[1]));a[2]&&b.recognizeWith(a[2]),a[3]&&b.requireFailure(a[2])},this)}function db(a,b){var c=a.element;g(a.options.cssProps,function(a,d){c.style[v(c.style,d)]=b?a:""})}function eb(a,c){var d=b.createEvent("Event");d.initEvent(a,!0,!0),d.gesture=c,c.target.dispatchEvent(d)}var fb=["","webkit","moz","MS","ms","o"],gb=b.createElement("div"),hb="function",ib=Math.round,jb=Math.abs,kb=Date.now,lb=1,mb=/mobile|tablet|ip(ad|hone|od)|android/i,nb="ontouchstart"in a,ob=v(a,"PointerEvent")!==d,pb=nb&&mb.test(navigator.userAgent),qb="touch",rb="pen",sb="mouse",tb="kinect",ub=25,vb=1,wb=2,xb=4,yb=8,zb=1,Ab=2,Bb=4,Cb=8,Db=16,Eb=Ab|Bb,Fb=Cb|Db,Gb=Eb|Fb,Hb=["x","y"],Ib=["clientX","clientY"];x.prototype={handler:function(){},destroy:function(){this.evEl&&o(this.element,this.evEl,this.domHandler),this.evTarget&&o(this.target,this.evTarget,this.domHandler),this.evWin&&o(a,this.evWin,this.domHandler)}};var Jb={mousedown:vb,mousemove:wb,mouseup:xb},Kb="mousedown",Lb="mousemove mouseup";j(L,x,{handler:function(a){var b=Jb[a.type];b&vb&&0===a.button&&(this.pressed=!0),b&wb&&1!==a.which&&(b=xb),this.pressed&&this.allow&&(b&xb&&(this.pressed=!1),this.callback(this.manager,b,{pointers:[a],changedPointers:[a],pointerType:sb,srcEvent:a}))}});var Mb={pointerdown:vb,pointermove:wb,pointerup:xb,pointercancel:yb,pointerout:yb},Nb={2:qb,3:rb,4:sb,5:tb},Ob="pointerdown",Pb="pointermove pointerup pointercancel";a.MSPointerEvent&&(Ob="MSPointerDown",Pb="MSPointerMove MSPointerUp MSPointerCancel"),j(M,x,{handler:function(a){var b=this.store,c=!1,d=a.type.toLowerCase().replace("ms",""),e=Mb[d],f=Nb[a.pointerType]||a.pointerType,g=f==qb;e&vb&&(0===a.button||g)?b.push(a):e&(xb|yb)&&(c=!0);var h=s(b,a.pointerId,"pointerId");0>h||(b[h]=a,this.callback(this.manager,e,{pointers:b,changedPointers:[a],pointerType:f,srcEvent:a}),c&&b.splice(h,1))}});var Qb={touchstart:vb,touchmove:wb,touchend:xb,touchcancel:yb},Rb="touchstart touchmove touchend touchcancel";j(N,x,{handler:function(a){var b=Qb[a.type],c=O.call(this,a,b);c&&this.callback(this.manager,b,{pointers:c[0],changedPointers:c[1],pointerType:qb,srcEvent:a})}}),j(P,x,{handler:function(a,b,c){var d=c.pointerType==qb,e=c.pointerType==sb;if(d)this.mouse.allow=!1;else if(e&&!this.mouse.allow)return;b&(xb|yb)&&(this.mouse.allow=!0),this.callback(a,b,c)},destroy:function(){this.touch.destroy(),this.mouse.destroy()}});var Sb=v(gb.style,"touchAction"),Tb=Sb!==d,Ub="compute",Vb="auto",Wb="manipulation",Xb="none",Yb="pan-x",Zb="pan-y";Q.prototype={set:function(a){a==Ub&&(a=this.compute()),Tb&&(this.manager.element.style[Sb]=a),this.actions=a.toLowerCase().trim()},update:function(){this.set(this.manager.options.touchAction)},compute:function(){var a=[];return g(this.manager.recognizers,function(b){l(b.options.enable,[b])&&(a=a.concat(b.getTouchAction()))}),R(a.join(" "))},preventDefaults:function(a){if(!Tb){var b=a.srcEvent,c=a.offsetDirection;if(this.manager.session.prevented)return void b.preventDefault();var d=this.actions,e=q(d,Xb),f=q(d,Zb),g=q(d,Yb);return e||f&&g||f&&c&Eb||g&&c&Fb?this.preventSrc(b):void 0}},preventSrc:function(a){this.manager.session.prevented=!0,a.preventDefault()}};var $b=1,_b=2,ac=4,bc=8,cc=bc,dc=16,ec=32;S.prototype={defaults:{},set:function(a){return h(this.options,a),this.manager&&this.manager.touchAction.update(),this},recognizeWith:function(a){if(f(a,"recognizeWith",this))return this;var b=this.simultaneous;return a=V(a,this),b[a.id]||(b[a.id]=a,a.recognizeWith(this)),this},dropRecognizeWith:function(a){return f(a,"dropRecognizeWith",this)?this:(a=V(a,this),delete this.simultaneous[a.id],this)},requireFailure:function(a){if(f(a,"requireFailure",this))return this;var b=this.requireFail;return a=V(a,this),-1===s(b,a)&&(b.push(a),a.requireFailure(this)),this},dropRequireFailure:function(a){if(f(a,"dropRequireFailure",this))return this;a=V(a,this);var b=s(this.requireFail,a);return b>-1&&this.requireFail.splice(b,1),this},hasRequireFailures:function(){return this.requireFail.length>0},canRecognizeWith:function(a){return!!this.simultaneous[a.id]},emit:function(a){function b(b){c.manager.emit(c.options.event+(b?T(d):""),a)}var c=this,d=this.state;bc>d&&b(!0),b(),d>=bc&&b(!0)},tryEmit:function(a){return this.canEmit()?this.emit(a):void(this.state=ec)},canEmit:function(){for(var a=0;a<this.requireFail.length;a++)if(!(this.requireFail[a].state&(ec|$b)))return!1;return!0},recognize:function(a){var b=h({},a);return l(this.options.enable,[this,b])?(this.state&(cc|dc|ec)&&(this.state=$b),this.state=this.process(b),void(this.state&(_b|ac|bc|dc)&&this.tryEmit(b))):(this.reset(),void(this.state=ec))},process:function(){},getTouchAction:function(){},reset:function(){}},j(W,S,{defaults:{pointers:1},attrTest:function(a){var b=this.options.pointers;return 0===b||a.pointers.length===b},process:function(a){var b=this.state,c=a.eventType,d=b&(_b|ac),e=this.attrTest(a);return d&&(c&yb||!e)?b|dc:d||e?c&xb?b|bc:b&_b?b|ac:_b:ec}}),j(X,W,{defaults:{event:"pan",threshold:10,pointers:1,direction:Gb},getTouchAction:function(){var a=this.options.direction;if(a===Gb)return[Xb];var b=[];return a&Eb&&b.push(Zb),a&Fb&&b.push(Yb),b},directionTest:function(a){var b=this.options,c=!0,d=a.distance,e=a.direction,f=a.deltaX,g=a.deltaY;return e&b.direction||(b.direction&Eb?(e=0===f?zb:0>f?Ab:Bb,c=f!=this.pX,d=Math.abs(a.deltaX)):(e=0===g?zb:0>g?Cb:Db,c=g!=this.pY,d=Math.abs(a.deltaY))),a.direction=e,c&&d>b.threshold&&e&b.direction},attrTest:function(a){return W.prototype.attrTest.call(this,a)&&(this.state&_b||!(this.state&_b)&&this.directionTest(a))},emit:function(a){this.pX=a.deltaX,this.pY=a.deltaY;var b=U(a.direction);b&&this.manager.emit(this.options.event+b,a),this._super.emit.call(this,a)}}),j(Y,W,{defaults:{event:"pinch",threshold:0,pointers:2},getTouchAction:function(){return[Xb]},attrTest:function(a){return this._super.attrTest.call(this,a)&&(Math.abs(a.scale-1)>this.options.threshold||this.state&_b)},emit:function(a){if(this._super.emit.call(this,a),1!==a.scale){var b=a.scale<1?"in":"out";this.manager.emit(this.options.event+b,a)}}}),j(Z,S,{defaults:{event:"press",pointers:1,time:500,threshold:5},getTouchAction:function(){return[Vb]},process:function(a){var b=this.options,c=a.pointers.length===b.pointers,d=a.distance<b.threshold,f=a.deltaTime>b.time;if(this._input=a,!d||!c||a.eventType&(xb|yb)&&!f)this.reset();else if(a.eventType&vb)this.reset(),this._timer=e(function(){this.state=cc,this.tryEmit()},b.time,this);else if(a.eventType&xb)return cc;return ec},reset:function(){clearTimeout(this._timer)},emit:function(a){this.state===cc&&(a&&a.eventType&xb?this.manager.emit(this.options.event+"up",a):(this._input.timeStamp=kb(),this.manager.emit(this.options.event,this._input)))}}),j($,W,{defaults:{event:"rotate",threshold:0,pointers:2},getTouchAction:function(){return[Xb]},attrTest:function(a){return this._super.attrTest.call(this,a)&&(Math.abs(a.rotation)>this.options.threshold||this.state&_b)}}),j(_,W,{defaults:{event:"swipe",threshold:10,velocity:.65,direction:Eb|Fb,pointers:1},getTouchAction:function(){return X.prototype.getTouchAction.call(this)},attrTest:function(a){var b,c=this.options.direction;return c&(Eb|Fb)?b=a.velocity:c&Eb?b=a.velocityX:c&Fb&&(b=a.velocityY),this._super.attrTest.call(this,a)&&c&a.direction&&jb(b)>this.options.velocity&&a.eventType&xb},emit:function(a){var b=U(a.direction);b&&this.manager.emit(this.options.event+b,a),this.manager.emit(this.options.event,a)}}),j(ab,S,{defaults:{event:"tap",pointers:1,taps:1,interval:300,time:250,threshold:2,posThreshold:10},getTouchAction:function(){return[Wb]},process:function(a){var b=this.options,c=a.pointers.length===b.pointers,d=a.distance<b.threshold,f=a.deltaTime<b.time;if(this.reset(),a.eventType&vb&&0===this.count)return this.failTimeout();if(d&&f&&c){if(a.eventType!=xb)return this.failTimeout();var g=this.pTime?a.timeStamp-this.pTime<b.interval:!0,h=!this.pCenter||H(this.pCenter,a.center)<b.posThreshold;this.pTime=a.timeStamp,this.pCenter=a.center,h&&g?this.count+=1:this.count=1,this._input=a;var i=this.count%b.taps;if(0===i)return this.hasRequireFailures()?(this._timer=e(function(){this.state=cc,this.tryEmit()},b.interval,this),_b):cc}return ec},failTimeout:function(){return this._timer=e(function(){this.state=ec},this.options.interval,this),ec},reset:function(){clearTimeout(this._timer)},emit:function(){this.state==cc&&(this._input.tapCount=this.count,this.manager.emit(this.options.event,this._input))}}),bb.VERSION="2.0.2",bb.defaults={domEvents:!1,touchAction:Ub,inputTarget:null,enable:!0,preset:[[$,{enable:!1}],[Y,{enable:!1},["rotate"]],[_,{direction:Eb}],[X,{direction:Eb},["swipe"]],[ab],[ab,{event:"doubletap",taps:2},["tap"]],[Z]],cssProps:{userSelect:"none",touchSelect:"none",touchCallout:"none",contentZooming:"none",userDrag:"none",tapHighlightColor:"rgba(0,0,0,0)"}};var fc=1,gc=2;cb.prototype={set:function(a){return h(this.options,a),this},stop:function(a){this.session.stopped=a?gc:fc},recognize:function(a){var b=this.session;if(!b.stopped){this.touchAction.preventDefaults(a);var c,d=this.recognizers,e=b.curRecognizer;(!e||e&&e.state&cc)&&(e=b.curRecognizer=null);for(var f=0,g=d.length;g>f;f++)c=d[f],b.stopped===gc||e&&c!=e&&!c.canRecognizeWith(e)?c.reset():c.recognize(a),!e&&c.state&(_b|ac|bc)&&(e=b.curRecognizer=c)}},get:function(a){if(a instanceof S)return a;for(var b=this.recognizers,c=0;c<b.length;c++)if(b[c].options.event==a)return b[c];return null},add:function(a){if(f(a,"add",this))return this;var b=this.get(a.options.event);return b&&this.remove(b),this.recognizers.push(a),a.manager=this,this.touchAction.update(),a},remove:function(a){if(f(a,"remove",this))return this;var b=this.recognizers;return a=this.get(a),b.splice(s(b,a),1),this.touchAction.update(),this},on:function(a,b){var c=this.handlers;return g(r(a),function(a){c[a]=c[a]||[],c[a].push(b)}),this},off:function(a,b){var c=this.handlers;return g(r(a),function(a){b?c[a].splice(s(c[a],b),1):delete c[a]}),this},emit:function(a,b){this.options.domEvents&&eb(a,b);var c=this.handlers[a]&&this.handlers[a].slice();if(c&&c.length){b.type=a,b.preventDefault=function(){b.srcEvent.preventDefault()};for(var d=0,e=c.length;e>d;d++)c[d](b)}},destroy:function(){this.element&&db(this,!1),this.handlers={},this.session={},this.input.destroy(),this.element=null}},h(bb,{INPUT_START:vb,INPUT_MOVE:wb,INPUT_END:xb,INPUT_CANCEL:yb,STATE_POSSIBLE:$b,STATE_BEGAN:_b,STATE_CHANGED:ac,STATE_ENDED:bc,STATE_RECOGNIZED:cc,STATE_CANCELLED:dc,STATE_FAILED:ec,DIRECTION_NONE:zb,DIRECTION_LEFT:Ab,DIRECTION_RIGHT:Bb,DIRECTION_UP:Cb,DIRECTION_DOWN:Db,DIRECTION_HORIZONTAL:Eb,DIRECTION_VERTICAL:Fb,DIRECTION_ALL:Gb,Manager:cb,Input:x,TouchAction:Q,Recognizer:S,AttrRecognizer:W,Tap:ab,Pan:X,Swipe:_,Pinch:Y,Rotate:$,Press:Z,on:n,off:o,each:g,merge:i,extend:h,inherit:j,bindFn:k,prefixed:v}),typeof define==hb&&define.amd?define(function(){return bb}):"undefined"!=typeof module&&module.exports?module.exports=bb:a[c]=bb}(window,document,"Hammer");
//# sourceMappingURL=hammer.min.map

/*
 *  Marmottajax 1.0.4
 *  Envoyer et recevoir des informations simplement en JavaScript
 */

var marmottajax = function(options) {

    return marmottajax.get(options);

};

marmottajax.normalize = function(parameters) {

    return parameters ? typeof parameters === "string" ? { url: parameters } : parameters : null;

};

marmottajax.json = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.json = true;

        return new marmottajax.request(parameters);

    }

};

marmottajax.get = function(options) {

    return new marmottajax.request(options);

};

marmottajax.post = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.method = "POST";

        return new marmottajax.request(parameters);

    }

};

marmottajax.put = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.method = "PUT";

        return new marmottajax.request(parameters);

    }

};

marmottajax.destroy = marmottajax.remove = marmottajax.delete_ = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.method = "DELETE";

        return new marmottajax.request(parameters);

    }

};

marmottajax.request = function(options) {

    if (!options) { return false; }

    if (typeof options === "string") {

        options = { url: options };

    }

    if (options.method === "POST" || options.method === "PUT" || options.method === "DELETE") {

        var post = "?";

        for (var key in options.options) {

            post += options.options.hasOwnProperty(key) ? "&" + key + "=" + options.options[key] : "";

        }

    }

    else {

        options.method = "GET";

        options.url += options.url.indexOf("?") < 0 ? "?" : "";

        for (var key in options.options) {

            options.url += options.options.hasOwnProperty(key) ? "&" + key + "=" + options.options[key] : "";

        }

    }

    this.xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

    this.xhr.options = options;

    this.xhr.callbacks = {

        then: [],
        error: []

    };

    this.then = function(callback) {

        this.xhr.callbacks.then.push(callback);

        return this;

    };

    this.error = function(callback) {

        this.xhr.callbacks.error.push(callback);

        return this;

    };

    this.xhr.call = function(categorie, result) {

        for (var i = 0; i < this.callbacks[categorie].length; i++) {

            if (typeof(this.callbacks[categorie][i]) === "function") {

                this.callbacks[categorie][i](result);

            }

        }

    };

    this.xhr.onreadystatechange = function() {

        if (this.readyState === 4 && this.status == 200) {

            var result = this.responseText;

            if (this.options.json) {

                try {

                    result = JSON.parse(result);

                }

                catch (error) {

                    this.call("error", "invalid json");

                    return false;

                }

            }

            this.call("then", result);

        }

        else if (this.readyState === 4 && this.status == 404) {

            this.call("error", "404");

        }

        else if (this.readyState === 4) {

            this.call("error", "unknow");

        }

    };

    this.xhr.open(options.method, options.url, true);
    this.xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    this.xhr.send(typeof post != "undefined" ? post : null);

};

/**
 * core/$.js
 *
 * DOM Content Loaded function
 */

Application.dom_load_event_listeners = [];

function $(callback) {

	if (typeof callback === "function") {

		Application.dom_load_event_listeners.push(callback);

	}

}

Application.dom_content_loaded = false;

Application.on_dom_content_loaded = function(event) {

	if (!Application.dom_content_loaded) {

		Application.dom_content_loaded = true;

		for (var i = 0; i < Application.dom_load_event_listeners.length; i++) {

			var fn = Application.dom_load_event_listeners[i]

			if (typeof fn === "function") {

				fn();

			}
			
		}

	}

};

El(document).on("DOMContentLoaded", Application.on_dom_content_loaded);
El(window).on("load", Application.on_dom_content_loaded);

window.onload = function() {

    Application.on_dom_content_loaded();

};

/**
 * Core/isset.js
 *
 * Test if a variable is not `undefined`
 */

function isset(variable) {

	return typeof variable !== "undefined";

}

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

/**
 * Core/scripts-launch.js
 *
 * SCRIPTS LAUNCH
 */

$(function() {

	for (var i = 0; i < Application.scripts.length; i++) {

		var can_call = false,
			script = Application.scripts[i];

		if (script.pages === "*" || script.pages === "all" || !script.pages) {

			can_call = true;

		}

		else {

			for (var p = 0; p < script.pages.length; p++) {
				
				if (script.pages[p] === _currentpage_) {

					can_call = true;

				}

			}
			
		}

		if (can_call) {

			script.call();

		}

	}

});

/**
 * Core/scripts.js
 *
 * MAIN SCRIPT SCRIPT
 */

Application.scripts = [];

var Script = function(script) {

	this.pages = script.pages;

	this.to_call = script.call;

	Application.scripts.push(this);

};

Script.prototype.call = function() {
	
	this.to_call();

};

/**
 * components/main.js
 *
 * Button component
 */

new Component({

	name: "btn",

	render: function($) {

		var type = $.type === "raised" ? "raised" : "flat",
			color = $.color ? ".btn--" + $.color : "",
			outline_color = $.outline ? ".btn--outline-" + $.outline : "",
			ripple_color = $.ripple ? ".btn--ripple-" + $.ripple : "",
			disabled = isset($.disable) ? ".disabled" : "";
	
		var btn = new Element("div.btn.btn--" + type + color + outline_color + ripple_color + disabled);
	
		if (!disabled) {
	
			btn.tabIndex = 0;
	
		}

		if (typeof $.click === "function") {

			El(btn).on("CLICK", $.click, btn);

		}
	
		if (!$["no-ripple"]) {
	
			El(btn).add(Co('<ripple parent="${parent}"/>', {
	
				parent: btn
	
			}));
	
		}

		return btn;
	
	}

});

/* TEMPLATE

<btn type="flat|raised" color? click? no-ripple?>@{inner}</btn> */

/**
 * Components/card.js
 *
 * Card component
 */

new Co({

	name: "card",

	render: function($) {

		var type = isset($.type) ? $.type : "video";
	
		if (type === "video") {
	
			var card = new El("div.card.video");
	
				var thumbnail = card.add(new El("div.thumbnail"));
				thumbnail.style.backgroundImage = "url(" + $.thumbnail + ")";
	
					var time = thumbnail.add(new El("div.time"));
					time.innerHTML = $.duration;
	
					var overlay = thumbnail.add(new El("a.overlay"));
					overlay.href = "watch/" + $["vid-id"];
	
				var description = card.add(new El("div.description"));
	
					var title = description.add(new El("a"));
					title.href = "watch/" + $["vid-id"];
	
						var title_inner = title.add(new El("h4"));
						title_inner.innerHTML = $.title;
	
					var div = description.add(new El("div"));
	
						var views = div.add(new El("div.view"));
						views.innerHTML = $.views;
	
						var channel = div.add(new El("a.channel"));
						channel.href = "channel/" + $.channel;
						channel.innerHTML = $["channel-name"];
	
		}
	
		else if (type == "plus") {
	
			var card = new El("div.card.plus");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $["vid-id"];
	
					var thumbnail = a.add(new El("div.thumbnail"));
					thumbnail.style.backgroundImage = "url(" + $.thumbnail + ")";
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
	
						p.innerHTML += " a aimé votre vidéo \"<b>" + $["vid-name"] + "</b>\"";
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		else if (type == "comment") {
	
			var card = new El("div.card.comment");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $["vid-id"];
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
	
						p.innerHTML += " a commenté votre vidéo \"<b>" + $["vid-name"] + "</b>\"";
	
					var blockquote = a.add(new El("blockquote"));
					blockquote.innerHTML = $.comment
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		else if (type == "channel") {
	
			var card = new El("div.card.channel");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $.channel;
	
					var avatar = a.add(new El("div.avatar"));
					avatar.style.backgroundImage = "url(" + $.avatar + ")";
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
		
						p.innerHTML += " s'est abonné à votre chaîne \"<b>" + $["my-channel-name"] + "</b>\"";
	
				var subscribers = card.add(new El("span.subscribers"));
				subscribers.innerHTML = "<b>" + $.subscribers + "</b> Abonnés";
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		card.on( "CLICK", $.click, card);

		return card;
	
	}

});

/**
 * Components/channel-post.js
 *
 * Channel social post component
 */

new Co({

	name: "channel-post",

	render: function($) {

		var channel_post = new Element("div.channel-post");
	
			var avatar = channel_post.add(new Element("img"));
			avatar.src = $.avatar;
	
			var p = channel_post.add(new Element("p"));
	
				var channel_name = p.add(new Element("span.channel-name"));
				channel_name.innerHTML = $.channel;
	
			p.innerHTML += " a posté un message :";
	
			var message = channel_post.add(new Element("div.social-message"));
			message.innerHTML = $.message;
	
		return channel_post;
	
	}

});

/* TEMPLATE

<div class="channel-post">

	<img src="${avatar}">
	<p><span class="channel-name">${name}</span> a posté un message :</p>
	<div class="social-message">${message}</div>

</div> */

/**
 * components/comment.js
 *
 * Comment component
 */

new Co({

	name: "comment",

	render: function($) {

		if (!$.data) {

			return;

		}

		var comment = $.data;

		var commentDiv = new El("div.comment");

			var headDiv = commentDiv.add(new El("div.comment-head"));

				var userDiv = headDiv.add(new El("div.user"));

					var avatar = userDiv.add(new El("img"));
					avatar.src = _my_avatar_;

					var a = userDiv.add(new El("a"));
					a.href  = "../channel/" + comment.channelUrl;
					a.innerHTML = comment.author;

				var dateDiv = headDiv.add(new El("div.date"));

					var p = dateDiv.add(new El("p"));
					p.innerHTML = comment.date;

			var textDiv = commentDiv.add(new El("div.comment-text"));

				var p1 = textDiv.add(new El("p"));
				p1.innerHTML = comment.comment;

			var noteDiv = commentDiv.add(new El("div.comment-notation"));

				var ul = noteDiv.add(new El("ul"));

					var li1 = ul.add(new El("li.plus"));
					var li2 = ul.add(new El("li.moins"));

					li1.id = "plus-" + comment.id;
					li2.id = "moins-" + comment.id;

					new Hammer(li1).on("tap", function(commentId) {

						return function() {

							likeComment(commentId);

						}

					}(comment.id));

					new Hammer(li2).on("tap", function(commentId) {

						return function() {

							dislikeComment(commentId)

						}

					}(comment.id));

					li1.innerHTML = "+" + comment.plusNumber;
					li2.innerHTML = "-" + comment.moinsNumber;

		return commentDiv;
	
	}

});

/**
 * components/ripple.js
 *
 * Ripple component
 */

new Component({

	name: "ripple",

	render: function($) {

		var ripple = new Element("div.ripple");
	
		if ($.parent) {

			var event = "ontouchstart" in window ? "touchstart" : "mousedown";
	
			El($.parent).on(event, function(event, elements) {
	
				var ripple = elements.ripple,
					parent = elements.parent;

				if (!El(parent).hasClass("disabled")) {
	
					var circle = ripple.add(new El("div.ripple__circle.ripple__circle--animate"));
	
					var parentOffset = El(parent).offset();
	
					var clickX = event.changedTouches ? event.changedTouches[0].pageX : event.pageX,
						clickY = event.changedTouches ? event.changedTouches[0].pageY : event.pageY;
	
					circle.style.left = clickX - parentOffset.x + "px";
					circle.style.top = clickY - parentOffset.y + "px";
	
				}
	
			}, {
	
				ripple: ripple,
				parent: $.parent
	
			});
	
		}

		return ripple;
	
	}

});

/* TEMPLATE

<ripple parent="${parent-node}"/> */

/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function backgroundLoader(element) {

    this.element = El(element);
    this.src = this.element.getAttribute("data-background");;
    this.element.style.backgroundImage = "url(" + this.src + ")";

    this.imgLoader = new Image();
    this.imgLoader.src = this.src;

    El(this.imgLoader).on("load", function(event, element) {

        element.removeClass("bg-loader");

        element.addClass("bg-loader-transition");
        element.addClass("bg-loaded");

        setTimeout(function(element) {

            return function() {

                element.removeClass("bg-loader-transition");

            }

        }(element), 300);

    }, this.element);

 }

new Script({

	call: function() {

		var elements = document.getElementsByClassName("bg-loader");

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new backgroundLoader(elements[i]);

		    }

		}

	}

});

/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

new Script({

	call: function() {

		/*console.log(El(document.body).add(Co('<card vid-id="${vid_id}" title="${title}" thumbnail="${thumbnail}" duration="${duration}" views="${views}" channel="${channel}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			title: "Très le titre",
			thumbnail: "//lorempicsum.com/up/255/200/2",
			duration: "12:18",
			views: "37",
			channel: "bla",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="plus" vid-id="${vid_id}" thumbnail="${thumbnail}" relative-time="${relative_time}" vid-name="${vid_name}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			thumbnail: "//lorempicsum.com/up/255/200/2",
			relative_time: "il y a 2 minutes",
			vid_name: "Nom",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="comment" vid-id="${vid_id}" comment="${comment}" relative-time="${relative_time}" vid-name="${vid_name}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, laboriosam, nobis mollitia, autem similique atque repellendus beatae qui cum minima voluptas earum aliquid! Possimus aliquid delectus, illum laborum recusandae cum.",
			relative_time: "il y a 2 minutes",
			vid_name: "Nom",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="channel" avatar="${avatar}" subscribers="${subscribers}" relative-time="${relative_time}" my-channel-name="${my_channel_name}" channel="${channel}" channel-name="${channel_name}"/>', {

			avatar: "//lorempicsum.com/up/255/200/2",
			relative_time: "il y a 2 minutes",
			subscribers: 13,
			my_channel_name: "Me",
			channel: "Bla",
			channel_name: "Bla"

		}))[0]);*/

	}

});

/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

function postMessage() {

 	marmottajax.post({

 		url: "../../../posts",
 		json: true,

 		options: {

 			"post-message-submit": "lol",
 			channel: El("#channel-social-message-submit").getAttribute("data-channel-id"),
 			"post-content": El("#post-content").value

 		}

 	}).then(function(channel) {

 		return function(result) {
	
 			El("#channel-posts").addFirst(Co('<channel-post avatar="${avatar}" channel="${channel}" message="${message}"/>', {
	
 				avatar: _my_avatar_,
 				channel: _my_pseudo_,
 				message: result.content
	
 			}));

 		}

 	}(El("#channel-social-message-submit").getAttribute("data-channel-id")));

 	El("#post-content").value = "";

}

new Script({

	pages: ["channel"],

	call: function() {

		new Hammer(El("#channel-social-message-submit")).on("tap", postMessage);

		El("#post-content").on("keydown", function(event) {

		    if (event.keyCode === 13 && event.ctrlKey) {

		        postMessage();

		    }

		});

	}

});

/**
 * scripts/comment.js
 *
 * COMMENT
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#post-comment-button")) {

			return false;

		}

		new Hammer(El("#post-comment-button")).on("tap", function() {

			postComment(El("#post-comment-button").getAttribute("data-vid-id"), El("#textarea-comment").value, El("#channel-selector").value, El("#parent-comment").value);

		});

	}

});

function postComment(vid, commentContent, fromChannel, parent) {

	marmottajax.post({

		url: "../comments/",

		options: {

			commentSubmit: "lol",
			"comment-content": commentContent,
			"from-channel": fromChannel,
			"video-id": vid,
			parent: parent

		}

	}).then(function(fromChannel) {

		return function(result) {

			var comment = JSON.parse(result);

			comment.channelUrl = fromChannel;
			comment.avatar = _my_avatar_;
			comment.plusNumber = 0;
			comment.moinsNumber = 0;
			comment.date = "À l'instant";

			El("#comments-best").addFirst(Co('<comment data="${data}"/>', { data: comment }));

		}

	}(fromChannel));

	El("#textarea-comment").value = "";

}

/**
 * Scripts/embed-video.js
 *
 * SHARE
 */

function setExporterInputValue() {

	if (!document.getElementById("exporter-input")) {

		return false;

	}

	var exporterInput = El("#exporter-input"),

		exporterQuality = El("#exporter-quality"),
		exporterAutoplay = El("#exporter-autoplay"),
		exporterTimeCheckbox = El("#exporter-time-checkbox"),
		exporterTimeInput = El("#exporter-time-input");

	var url = "//dreamvids.fr/embed/" + _VIDEO_ID_;

	var quality = exporterQuality.options[exporterQuality.value].innerHTML || "640x360",
		qualitys = quality.split("x");
		width = qualitys[0],
		height = qualitys[1];

	var autoplay = exporterAutoplay.checked || false;

	if (autoplay) {

		url += "/autoplay";

	}

	var startAt = exporterTimeCheckbox.checked || false;

	if (startAt) {

		var timeUrlFormat = ["s", "m", "h"];

		var startTime = exporterTimeInput.value,
			times = startTime.split(":").reverse();

		for (var i = 0; i < times.length; i++) {

			/*url += i === 0 & !autoplay ? "?" : "&";

			url += timeUrlFormat[i] + "=" + times[i];*/

			url += times[i] + '/';

		}

	}

	exporterInput.value = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"" + url + "\" allowfullscreen frameborder=\"0\"></iframe>";

}

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#embed-video-icon")) {

			return false;

		}

		new Hammer(El("#embed-video-icon")).on("tap", function() {

			var videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("export")) {

				videoInfoDescription.removeClass("export");

			}

			else {

				videoInfoDescription.addClass("export");

				El("#exporter-input").select();

			}

		});

		El("#exporter-quality").on("change", setExporterInputValue),
		El("#exporter-autoplay").on("change", setExporterInputValue),
		El("#exporter-time-checkbox").on("change", setExporterInputValue),
		El("#exporter-time-input").on("change", setExporterInputValue);

		setExporterInputValue();

	}

});

/**
 * Scripts/model.js
 *
 * EXAMPLE SCRIPT
 */

new Script({

	pages: ["default", "watch"], // Pages

	// OU // pages: "all", // OU ne pas spécifier

	call: function() { // Fonction appelée lorsque la page peut être manipulée

		// console.log("Il pleut!", "{example script}");

	}

});

/**
 * scripts/playlist-scroll.js
 *
 * PLAYLIST SCROLL BUTTONS
 */

function playListScroll(data) {

    El("#playlist-videos").scrollLeft += data;

}

new Script({

    pages: ["watch"],

	call: function() {

        if (!document.getElementById("playlist-button-scroll-left")) {

            return false;

        }

		var buttonLeft = El("#playlist-button-scroll-left"),
            buttonRight = El("#playlist-button-scroll-right");

        new Hammer(buttonLeft).on("tap", function() {

            playListScroll(-300);

        });

        new Hammer(buttonRight).on("tap", function() {

            playListScroll(200);

        });

	}

});

/**
 * Scripts/share-video.js
 *
 * SHARE
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#share-video-icon")) {

			return false;

		}

		new Hammer(El("#share-video-icon")).on("tap", function() {

			var shareVideoBlock = El("#share-video-block"),
				videoInfoDescription = El("#video-info-description");

			shareVideoBlock.toggleClass("show");
			videoInfoDescription.toggleClass("little");

		});

	}

});