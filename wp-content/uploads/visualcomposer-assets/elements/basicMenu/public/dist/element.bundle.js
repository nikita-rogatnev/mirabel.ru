(window.vcvWebpackJsonp4x=window.vcvWebpackJsonp4x||[]).push([[0],{"./basicMenu/component.js":function(e,n,o){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var s=d(o("./node_modules/babel-runtime/helpers/extends.js")),t=d(o("./node_modules/babel-runtime/core-js/object/get-prototype-of.js")),i=d(o("./node_modules/babel-runtime/helpers/classCallCheck.js")),u=d(o("./node_modules/babel-runtime/helpers/createClass.js")),a=d(o("./node_modules/babel-runtime/helpers/possibleConstructorReturn.js")),c=d(o("./node_modules/babel-runtime/helpers/get.js")),l=d(o("./node_modules/babel-runtime/helpers/inherits.js")),r=d(o("./node_modules/react/index.js")),m=d(o("./node_modules/vc-cake/index.js"));function d(e){return e&&e.__esModule?e:{default:e}}var b=m.default.getService("cook"),p=function(e){function n(){return(0,i.default)(this,n),(0,a.default)(this,(n.__proto__||(0,t.default)(n)).apply(this,arguments))}return(0,l.default)(n,e),(0,u.default)(n,[{key:"componentDidMount",value:function(){(0,c.default)(n.prototype.__proto__||(0,t.default)(n.prototype),"updateShortcodeToHtml",this).call(this,'[vcv_menu key="'+this.props.atts.menuSource+'"]',this.ref),m.default.env("iframe").vcv.trigger("basicMenuReady")}},{key:"componentWillUnmount",value:function(){this.ajax&&(this.ajax.cancelled=!0)}},{key:"componentDidUpdate",value:function(e){var o=this.props.atts.menuSource;o!==e.atts.menuSource&&((0,c.default)(n.prototype.__proto__||(0,t.default)(n.prototype),"updateShortcodeToHtml",this).call(this,'[vcv_menu key="'+o+'"]',this.ref),m.default.env("iframe").vcv.trigger("basicMenuReady"))}},{key:"validateSize",value:function(e){var n=new RegExp("^-?\\d*(\\.\\d{0,9})?("+["px","em","rem","%","vw","vh"].join("|")+")?$");return""===e||e.match(n)?e:null}},{key:"render",value:function(){var e=this,n=this.props,o=n.id,t=n.atts,i=n.editor,u=t.menu,a=t.fontSize,c=t.toggleMenuCustomHover,l=t.toggleCustomHoverUnderline,m=t.toggleSubmenuCustomHover,d=t.toggleSubmenuCustomBackgroundHover,p=t.toggleSubmenuSeparator,v=t.toggleSandwichMenu,g=t.menuSource,x=t.alignment,f=t.customClass,y=t.metaCustomId,h="vce-basic-menu-container",C="vce-basic-menu-inner",M="vce-basic-menu-wrapper",w={},_={};"string"==typeof f&&f&&(h+=" "+f),y&&(w.id=y);var j=this.getMixinData("menuTextColor");j&&(C+=" vce-basic-menu--style-text--color-"+j.selector),c&&(j=this.getMixinData("menuTextHoverColor"))&&(C+=" vce-basic-menu--style-text--hover-color-"+j.selector),l&&(j=this.getMixinData("underlineColor"))&&(C+=" vce-basic-menu--style-underline--color-"+j.selector),(j=this.getMixinData("submenuTextColor"))&&(C+=" vce-basic-menu--style-sub-menu-text--color-"+j.selector),m&&(j=this.getMixinData("submenuTextHoverColor"))&&(C+=" vce-basic-menu--style-sub-menu-text--hover-color-"+j.selector),(j=this.getMixinData("submenuBackgroundColor"))&&(C+=" vce-basic-menu--style-sub-menu-background--color-"+j.selector),d&&(j=this.getMixinData("submenuBackgroundHoverColor"))&&(C+=" vce-basic-menu--style-sub-menu-background--hover-color-"+j.selector),(j=this.getMixinData("submenuOutlineColor"))&&(C+=" vce-basic-menu--style-sub-menu-outline--color-"+j.selector),a&&(a=this.validateSize(a))&&(a=/^\d+$/.test(a)?a+"px":a,_.style={fontSize:a}),M+=" vce-basic-menu--alignment-"+x,p&&(C+=" vce-basic-menu--style-sub-menu-separator");var k="";if(v){var S=b.get(u);k=r.default.createElement("div",{className:"vce-basic-menu-sandwich-container"},S?S.render(null,!1):null)}var H=this.applyDO("margin padding border background animation");return r.default.createElement("div",(0,s.default)({className:h},i,{id:"el-"+o,"data-vce-basic-menu":!0,"data-vce-basic-menu-to-sandwich":v}),r.default.createElement("div",(0,s.default)({className:C},w),r.default.createElement("div",(0,s.default)({className:"vce-basic-menu vce"},H,_),r.default.createElement("div",{className:M},r.default.createElement("div",{className:"vcvhelper",ref:function(n){e.ref=n},"data-vcvs-html":'[vcv_menu key="'+g+'"]'})),r.default.createElement("div",{className:"vcvhelper vce-basic-menu-resize-helper-container"})),k))}}]),n}(m.default.getService("api").elementComponent);n.default=p},"./basicMenu/index.js":function(e,n,o){"use strict";var s=i(o("./node_modules/vc-cake/index.js")),t=i(o("./basicMenu/component.js"));function i(e){return e&&e.__esModule?e:{default:e}}(0,s.default.getService("cook").add)(o("./basicMenu/settings.json"),function(e){e.add(t.default)},{css:o("./node_modules/raw-loader/index.js!./basicMenu/styles.css"),editorCss:o("./node_modules/raw-loader/index.js!./basicMenu/editor.css"),mixins:{menuTextColor:{mixin:o("./node_modules/raw-loader/index.js!./basicMenu/cssMixins/menuTextColor.pcss")},menuTextHoverColor:{mixin:o("./node_modules/raw-loader/index.js!./basicMenu/cssMixins/menuTextHoverColor.pcss")},submenuBackgroundColor:{mixin:o("./node_modules/raw-loader/index.js!./basicMenu/cssMixins/submenuBackgroundColor.pcss")},submenuBackgroundHoverColor:{mixin:o("./node_modules/raw-loader/index.js!./basicMenu/cssMixins/submenuBackgroundHoverColor.pcss")},submenuOutlineColor:{mixin:o("./node_modules/raw-loader/index.js!./basicMenu/cssMixins/submenuOutlineColor.pcss")},submenuTextColor:{mixin:o("./node_modules/raw-loader/index.js!./basicMenu/cssMixins/submenuTextColor.pcss")},submenuTextHoverColor:{mixin:o("./node_modules/raw-loader/index.js!./basicMenu/cssMixins/submenuTextHoverColor.pcss")},underlineColor:{mixin:o("./node_modules/raw-loader/index.js!./basicMenu/cssMixins/underlineColor.pcss")}}},"")},"./basicMenu/settings.json":function(e){e.exports={groups:{type:"string",access:"protected",value:"Content"},menuSource:{type:"dropdown",access:"public",value:"",options:{label:"Menu source",global:"vcvWpMenus"}},fontSize:{type:"string",access:"public",value:"16px",options:{label:"Font size"}},alignment:{type:"buttonGroup",access:"public",value:"left",options:{label:"Alignment",values:[{label:"Left",value:"left",icon:"vcv-ui-icon-attribute-alignment-left"},{label:"Center",value:"center",icon:"vcv-ui-icon-attribute-alignment-center"},{label:"Right",value:"right",icon:"vcv-ui-icon-attribute-alignment-right"}]}},menuTextColor:{type:"color",access:"public",value:"#3E3D3D",options:{label:"Menu text color",cssMixin:{mixin:"menuTextColor",property:"color",namePattern:"[\\da-f]+"}}},toggleMenuCustomHover:{type:"toggle",access:"public",value:!1,options:{label:"Enable custom menu text hover color"}},menuTextHoverColor:{type:"color",access:"public",value:"#4A90E2",options:{label:"Custom menu text hover color",cssMixin:{mixin:"menuTextHoverColor",property:"color",namePattern:"[\\da-f]+"},onChange:{rules:{toggleMenuCustomHover:{rule:"toggle"}},actions:[{action:"toggleVisibility"}]}}},toggleCustomHoverUnderline:{type:"toggle",access:"public",value:!1,options:{label:"Enable hover underline"}},underlineColor:{type:"color",access:"public",value:"#4A90E2",options:{label:"Underline color",cssMixin:{mixin:"underlineColor",property:"color",namePattern:"[\\da-f]+"},onChange:{rules:{toggleCustomHoverUnderline:{rule:"toggle"}},actions:[{action:"toggleVisibility"}]}}},submenuTextColor:{type:"color",access:"public",value:"#3E3D3D",options:{label:"Submenu text color",cssMixin:{mixin:"submenuTextColor",property:"color",namePattern:"[\\da-f]+"}}},toggleSubmenuCustomHover:{type:"toggle",access:"public",value:!1,options:{label:"Enable custom submenu text hover color"}},submenuTextHoverColor:{type:"color",access:"public",value:"#4A90E2",options:{label:"Custom submenu text hover color",cssMixin:{mixin:"submenuTextHoverColor",property:"color",namePattern:"[\\da-f]+"},onChange:{rules:{toggleSubmenuCustomHover:{rule:"toggle"}},actions:[{action:"toggleVisibility"}]}}},submenuBackgroundColor:{type:"color",access:"public",value:"#ffffff",options:{label:"Submenu background color",cssMixin:{mixin:"submenuBackgroundColor",property:"color",namePattern:"[\\da-f]+"}}},toggleSubmenuCustomBackgroundHover:{type:"toggle",access:"public",value:!1,options:{label:"Enable custom submenu background hover color"}},submenuBackgroundHoverColor:{type:"color",access:"public",value:"#4A90E2",options:{label:"Custom submenu background hover color",cssMixin:{mixin:"submenuBackgroundHoverColor",property:"color",namePattern:"[\\da-f]+"},onChange:{rules:{toggleSubmenuCustomBackgroundHover:{rule:"toggle"}},actions:[{action:"toggleVisibility"}]}}},submenuOutlineColor:{type:"color",access:"public",value:"#EDEDED",options:{label:"Submenu outline color",cssMixin:{mixin:"submenuOutlineColor",property:"color",namePattern:"[\\da-f]+"}}},toggleSubmenuSeparator:{type:"toggle",access:"public",value:!1,options:{label:"Enable custom submenu separator"}},toggleSandwichMenu:{type:"toggle",access:"public",value:!1,options:{label:"Enable sandwich menu",description:"Manage sandwich menu source and design in sandwich menu settings below."}},menu:{type:"element",access:"public",value:{tag:"sandwichMenu"},options:{category:"",tabLabel:"Sandwich menu",onChange:{rules:{toggleSandwichMenu:{rule:"toggle"}},actions:[{action:"toggleSectionVisibility"}]}}},customClass:{type:"string",access:"public",value:"",options:{label:"Extra class name",description:"Add an extra class name to the element and refer to it from Custom CSS option."}},metaCustomId:{type:"customId",access:"public",value:"",options:{label:"Element ID",description:"Apply unique Id to element to link directly to it by using #your_id (for element id use lowercase input only)."}},designOptions:{type:"designOptions",access:"public",value:{},options:{label:"Design Options"}},editFormTab1:{type:"group",access:"protected",value:["menuSource","fontSize","alignment","menuTextColor","toggleMenuCustomHover","menuTextHoverColor","toggleCustomHoverUnderline","underlineColor","submenuTextColor","toggleSubmenuCustomHover","submenuTextHoverColor","submenuBackgroundColor","toggleSubmenuCustomBackgroundHover","submenuBackgroundHoverColor","submenuOutlineColor","toggleSubmenuSeparator","toggleSandwichMenu","sandwichStyle","sandwichShape","metaCustomId","customClass"],options:{label:"General"}},metaEditFormTabs:{type:"group",access:"protected",value:["editFormTab1","menu","designOptions"]},relatedTo:{type:"group",access:"protected",value:["General"]},tag:{access:"protected",type:"string",value:"basicMenu"},metaPublicJs:{access:"protected",type:"string",value:{libraries:[{rules:{toggleSandwichMenu:{rule:"toggle"}},libPaths:"public/dist/basicMenu.min.js"}]}}}},"./node_modules/babel-runtime/core-js/object/get-own-property-descriptor.js":function(e,n,o){e.exports={default:o("./node_modules/babel-runtime/node_modules/core-js/library/fn/object/get-own-property-descriptor.js"),__esModule:!0}},"./node_modules/babel-runtime/helpers/get.js":function(e,n,o){"use strict";n.__esModule=!0;var s=i(o("./node_modules/babel-runtime/core-js/object/get-prototype-of.js")),t=i(o("./node_modules/babel-runtime/core-js/object/get-own-property-descriptor.js"));function i(e){return e&&e.__esModule?e:{default:e}}n.default=function e(n,o,i){null===n&&(n=Function.prototype);var u=(0,t.default)(n,o);if(void 0===u){var a=(0,s.default)(n);return null===a?void 0:e(a,o,i)}if("value"in u)return u.value;var c=u.get;return void 0!==c?c.call(i):void 0}},"./node_modules/babel-runtime/node_modules/core-js/library/fn/object/get-own-property-descriptor.js":function(e,n,o){o("./node_modules/babel-runtime/node_modules/core-js/library/modules/es6.object.get-own-property-descriptor.js");var s=o("./node_modules/babel-runtime/node_modules/core-js/library/modules/_core.js").Object;e.exports=function(e,n){return s.getOwnPropertyDescriptor(e,n)}},"./node_modules/raw-loader/index.js!./basicMenu/cssMixins/menuTextColor.pcss":function(e,n){e.exports=".vce-basic-menu--style-text--color-$selector {\n  .vce-basic-menu nav > ul > li > a {\n    @if $color != false {\n      color: $color;\n    }\n    &:hover {\n      color: color($color tint(15%));\n    }\n  }\n}"},"./node_modules/raw-loader/index.js!./basicMenu/cssMixins/menuTextHoverColor.pcss":function(e,n){e.exports=".vce-basic-menu-inner.vce-basic-menu--style-text--hover-color-$selector {\n  .vce-basic-menu nav > ul > li > a {\n    &:hover {\n      color: $color;\n    }\n  }\n}"},"./node_modules/raw-loader/index.js!./basicMenu/cssMixins/submenuBackgroundColor.pcss":function(e,n){e.exports=".vce-basic-menu--style-sub-menu-background--color-$selector {\n  .vce-basic-menu .sub-menu {\n    background-color: $color;\n  }\n}"},"./node_modules/raw-loader/index.js!./basicMenu/cssMixins/submenuBackgroundHoverColor.pcss":function(e,n){e.exports=".vce-basic-menu--style-sub-menu-background--hover-color-$selector {\n  .vce-basic-menu  .sub-menu a:hover {\n    background: $color;\n\n    &::before {\n     opacity: 1;\n     border-color: $color;\n    }\n  }\n}"},"./node_modules/raw-loader/index.js!./basicMenu/cssMixins/submenuOutlineColor.pcss":function(e,n){e.exports=".vce-basic-menu--style-sub-menu-outline--color-$selector {\n  .vce-basic-menu  .sub-menu {\n    @if $color != false {\n      border-color: $color;\n    }\n  }\n\n  .vce-basic-menu ul .menu-item .sub-menu a {\n    border-color: $color;\n  }\n}"},"./node_modules/raw-loader/index.js!./basicMenu/cssMixins/submenuTextColor.pcss":function(e,n){e.exports=".vce-basic-menu--style-sub-menu-text--color-$selector {\n  .vce-basic-menu .sub-menu a {\n    @if $color != false {\n      color: $color;\n    }\n    &:hover {\n      color: color($color tint(15%));\n    }\n  }\n}"},"./node_modules/raw-loader/index.js!./basicMenu/cssMixins/submenuTextHoverColor.pcss":function(e,n){e.exports=".vce-basic-menu-inner.vce-basic-menu--style-sub-menu-text--hover-color-$selector {\n  .vce-basic-menu .sub-menu a {\n    @if $color != false {\n      &:hover {\n        color: $color;\n      }\n    }\n  }\n}"},"./node_modules/raw-loader/index.js!./basicMenu/cssMixins/underlineColor.pcss":function(e,n){e.exports=".vce-basic-menu--style-underline--color-$selector {\n  .vce-basic-menu nav > ul > li {\n    &:hover {\n      &::before {\n        @if $color != false {\n          background-color: $color;\n        }\n      }\n    }\n  }\n}"},"./node_modules/raw-loader/index.js!./basicMenu/editor.css":function(e,n){e.exports=""},"./node_modules/raw-loader/index.js!./basicMenu/styles.css":function(e,n){e.exports='/* ----------------------------------------------\n * Basic Button\n * ---------------------------------------------- */\n/* Basic Menu basic menu styles*/\n.vce-basic-menu-container .vce-basic-menu nav > ul > li::before {\n  content: \'\';\n  position: absolute;\n  left: 26px;\n  bottom: 10px;\n  width: calc(100% - (26px * 2));\n  height: 3px;\n}\n.vce-basic-menu-container .vce-basic-menu nav > ul.menu > li.menu-item > a {\n  width: auto;\n}\n.vce-basic-menu-container .vce-basic-menu ul {\n  display: -ms-flexbox;\n  display: flex;\n  -ms-flex-wrap: wrap;\n      flex-wrap: wrap;\n  margin: 0;\n}\n.vce-basic-menu-container .vce-basic-menu ul .menu-item {\n  position: relative;\n  padding: 0;\n  list-style: none;\n}\n.vce-basic-menu-container .vce-basic-menu ul .menu-item:hover > .sub-menu {\n  visibility: visible;\n  max-width: 10000px;\n  transition-delay: 0s;\n}\n.vce-basic-menu-container .vce-basic-menu ul .menu-item:hover > .sub-menu > li > a {\n  width: 16em;\n  transition-delay: 0s;\n  padding: 16px 26px;\n}\n.vce-basic-menu-container .vce-basic-menu ul .menu-item > .sub-menu > li > a {\n  width: 0;\n  overflow: hidden;\n  padding: 0;\n  transition: padding 0s ease 0.25s, width 0s ease 0.25s, color 0.2s ease-in-out;\n}\n.vce-basic-menu-container .vce-basic-menu ul .menu-item > .sub-menu > li > a:hover {\n  overflow: visible;\n}\n.vce-basic-menu-container .vce-basic-menu ul .menu-item a {\n  display: inline-block;\n  position: relative;\n  padding: 16px 26px;\n  border: none;\n  box-shadow: none;\n  text-decoration: none;\n  text-transform: uppercase;\n  font-size: 1em;\n  font-weight: 600;\n  line-height: 1;\n  transition: color 0.2s ease-in-out;\n}\n.vce-basic-menu-container .vce-basic-menu ul .sub-menu {\n  visibility: hidden;\n  max-width: 0;\n  position: absolute;\n  top: 100%;\n  left: 26px;\n  z-index: 99999;\n  margin: 0;\n  padding: 0;\n  border-width: 1px;\n  border-style: solid;\n  transition: all 0s ease .25s;\n}\n.vce-basic-menu-container .vce-basic-menu ul .sub-menu a {\n  display: block;\n  font-size: .75em;\n}\n.vce-basic-menu-container .vce-basic-menu ul .sub-menu a::before {\n  content: \'\';\n  position: absolute;\n  top: -1px;\n  right: -1px;\n  bottom: -1px;\n  left: -1px;\n  background: transparent;\n  border: 1px solid transparent;\n  opacity: 0;\n  transition: opacity 0.2s ease-in-out;\n}\n.vce-basic-menu-container .vce-basic-menu ul .sub-menu .menu-item::before {\n  display: none;\n}\n.vce-basic-menu-container .vce-basic-menu ul .sub-menu .menu-item a {\n  padding: 16px 18px;\n}\n.vce-basic-menu-container .vce-basic-menu ul .sub-menu .sub-menu {\n  top: -1px;\n  left: 100%;\n}\n.vce-basic-menu-container .vce-basic-menu .vce-basic-menu-wrapper.vce-basic-menu--alignment-left .menu {\n  -ms-flex-pack: start;\n      justify-content: flex-start;\n}\n.vce-basic-menu-container .vce-basic-menu .vce-basic-menu-wrapper.vce-basic-menu--alignment-center .menu {\n  -ms-flex-pack: center;\n      justify-content: center;\n}\n.vce-basic-menu-container .vce-basic-menu .vce-basic-menu-wrapper.vce-basic-menu--alignment-right .menu {\n  -ms-flex-pack: end;\n      justify-content: flex-end;\n}\n.vce-basic-menu--style-sub-menu-separator .vce-basic-menu ul .sub-menu a {\n  border-bottom-width: 1px;\n  border-bottom-style: solid;\n}\n.vce-basic-menu--style-sub-menu-separator .vce-basic-menu ul .sub-menu .menu-item:last-child a {\n  border-bottom: none;\n}\n[data-vce-basic-menu-to-sandwich="true"] .vce-basic-menu,\n[data-vce-basic-menu-to-sandwich="true"] .vce-basic-menu-sandwich-container {\n  opacity: 0;\n}\n[data-vcv-basic-menu-collapsed="true"] .vce-basic-menu {\n  position: absolute;\n  pointer-events: none;\n  visibility: hidden;\n  opacity: 0;\n  height: 0;\n}\n[data-vcv-basic-menu-collapsed="true"] .vce-basic-menu-sandwich-container {\n  display: block;\n  opacity: 1;\n}\n[data-vcv-basic-menu-collapsed="false"] .vce-basic-menu {\n  position: relative;\n  pointer-events: auto;\n  visibility: visible;\n  opacity: 1;\n  height: auto;\n}\n[data-vcv-basic-menu-collapsed="false"] .vce-basic-menu-sandwich-container {\n  display: none;\n}\n'}},[["./basicMenu/index.js"]]]);