(window.vcvWebpackJsonp4x=window.vcvWebpackJsonp4x||[]).push([[1],{"./3dButton/component.js":function(e,t,o){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=c(o("./node_modules/babel-runtime/helpers/extends.js")),s=c(o("./node_modules/babel-runtime/core-js/object/get-prototype-of.js")),l=c(o("./node_modules/babel-runtime/helpers/classCallCheck.js")),r=c(o("./node_modules/babel-runtime/helpers/createClass.js")),a=c(o("./node_modules/babel-runtime/helpers/possibleConstructorReturn.js")),i=c(o("./node_modules/babel-runtime/helpers/inherits.js")),u=c(o("./node_modules/react/index.js"));function c(e){return e&&e.__esModule?e:{default:e}}var d=function(e){function t(){return(0,l.default)(this,t),(0,a.default)(this,(t.__proto__||(0,s.default)(t)).apply(this,arguments))}return(0,i.default)(t,e),(0,r.default)(t,[{key:"render",value:function(){var e=this.props,t=e.id,o=e.atts,s=e.editor,l=o.buttonUrl,r=o.buttonText,a=o.shape,i=o.alignment,c=o.customHover,d=o.pushAnimation,b=o.customClass,p=o.metaCustomId,v="vce-button--style-3d-container",m="vce-button--style-3d",g={},y="button";if(l&&l.url){y="a";var h=l.url,f=l.title,x=l.targetBlank,C=l.relNofollow;g={href:h,title:f,target:x?"_blank":void 0,rel:C?"nofollow":void 0}}"string"==typeof b&&b&&(v+=" "+b),a&&(m+=" vce-button--style-3d--border-"+a),d&&(m+=" vce-button--style-3d--push-animation"),i&&(v+=" vce-button--style-3d-container--align-"+i);var k=this.getMixinData("titleColor");k&&(m+=" vce-button--style-3d--color-"+k.selector),(k=this.getMixinData("backgroundColor"))&&(m+=" vce-button--style-3d--background-color-"+k.selector),c?(k=this.getMixinData("hoverColor"))&&(m+=" vce-button--style-3d--hover-color-"+k.selector):m+=" vce-button--style-3d--hover-default",p&&(g.id=p);var _=this.applyDO("margin"),w=this.applyDO("padding border background animation");return u.default.createElement("div",(0,n.default)({className:v},s),u.default.createElement("div",(0,n.default)({className:"vce-button--style-3d-wrapper vce",id:"el-"+t},_),u.default.createElement(y,(0,n.default)({className:m},g,w),u.default.createElement("span",{className:"vce-button--style-3d-inner"},r))))}}]),t}(c(o("./node_modules/vc-cake/index.js")).default.getService("api").elementComponent);t.default=d},"./3dButton/index.js":function(e,t,o){"use strict";var n=l(o("./node_modules/vc-cake/index.js")),s=l(o("./3dButton/component.js"));function l(e){return e&&e.__esModule?e:{default:e}}(0,n.default.getService("cook").add)(o("./3dButton/settings.json"),function(e){e.add(s.default)},{css:o("./node_modules/raw-loader/index.js!./3dButton/styles.css"),editorCss:o("./node_modules/raw-loader/index.js!./3dButton/editor.css"),mixins:{titleColor:{mixin:o("./node_modules/raw-loader/index.js!./3dButton/cssMixins/titleColor.pcss")},backgroundColor:{mixin:o("./node_modules/raw-loader/index.js!./3dButton/cssMixins/backgroundColor.pcss")},hoverColor:{mixin:o("./node_modules/raw-loader/index.js!./3dButton/cssMixins/hoverColor.pcss")}}},"")},"./3dButton/settings.json":function(e){e.exports={groups:{type:"string",access:"protected",value:"Buttons"},buttonText:{type:"string",access:"public",value:"Apply Now",options:{label:"Button text"}},buttonUrl:{type:"url",access:"public",value:{url:"",title:"",targetBlank:!1,relNofollow:!1},options:{label:"Link selection"}},alignment:{type:"buttonGroup",access:"public",value:"left",options:{label:"Alignment",values:[{label:"Left",value:"left",icon:"vcv-ui-icon-attribute-alignment-left"},{label:"Center",value:"center",icon:"vcv-ui-icon-attribute-alignment-center"},{label:"Right",value:"right",icon:"vcv-ui-icon-attribute-alignment-right"}]}},shape:{type:"buttonGroup",access:"public",value:"round",options:{label:"Shape",values:[{label:"Square",value:"square",icon:"vcv-ui-icon-attribute-shape-square"},{label:"Rounded",value:"rounded",icon:"vcv-ui-icon-attribute-shape-rounded"},{label:"Round",value:"round",icon:"vcv-ui-icon-attribute-shape-round"}]}},titleColor:{type:"color",access:"public",value:"#fff",options:{label:"Title color",cssMixin:{mixin:"titleColor",property:"titleColor",namePattern:"[\\da-f]+"}}},backgroundColor:{type:"color",access:"public",value:"#fa8740",options:{label:"Background color",cssMixin:{mixin:"backgroundColor",property:"backgroundColor",namePattern:"[\\da-f]+"}}},customHover:{type:"toggle",access:"public",value:!1,options:{label:"Custom hover color"}},hoverColor:{type:"color",access:"public",value:"#EC5418",options:{label:"Hover color",cssMixin:{mixin:"hoverColor",property:"hoverColor",namePattern:"[\\da-f]+"},onChange:{rules:{customHover:{rule:"toggle"}},actions:[{action:"toggleVisibility"}]}}},pushAnimation:{type:"toggle",access:"public",value:!0,options:{label:"Push animation"}},designOptions:{type:"designOptions",access:"public",value:{},options:{label:"Design Options"}},editFormTab1:{type:"group",access:"protected",value:["buttonText","buttonUrl","alignment","shape","titleColor","backgroundColor","customHover","hoverColor","pushAnimation","metaCustomId","customClass"],options:{label:"General"}},metaEditFormTabs:{type:"group",access:"protected",value:["editFormTab1","designOptions"]},relatedTo:{type:"group",access:"protected",value:["General","Buttons"]},assetsLibrary:{access:"public",type:"string",value:["animate"]},customClass:{type:"string",access:"public",value:"",options:{label:"Extra class name",description:"Add an extra class name to the element and refer to it from Custom CSS option."}},metaBackendLabels:{type:"group",access:"protected",value:[{value:["buttonText","buttonUrl"]}]},metaCustomId:{type:"customId",access:"public",value:"",options:{label:"Element ID",description:"Apply unique Id to element to link directly to it by using #your_id (for element id use lowercase input only)."}},tag:{access:"protected",type:"string",value:"3dButton"}}},"./node_modules/raw-loader/index.js!./3dButton/cssMixins/backgroundColor.pcss":function(e,t){e.exports="a, button {\n  &.vce-button--style-3d--background-color-$selector {\n    &, &:link, &:visited, &:active, &:focus {\n      @if $backgroundColor != false {\n        background-color: $backgroundColor;\n        box-shadow: 0 3px 0 0 color($backgroundColor shade(10%));\n      }\n    }\n\n    &.vce-button--style-3d--hover-default {\n      &:hover {\n        @if $backgroundColor != false {\n          background-color: color($backgroundColor shade(10%));\n        }\n      }\n    }\n  }\n}\n"},"./node_modules/raw-loader/index.js!./3dButton/cssMixins/hoverColor.pcss":function(e,t){e.exports="a, button {\n  &.vce-button--style-3d--hover-color-$selector {\n    &:hover {\n      @if $hoverColor != false {\n        background-color: $hoverColor;\n        box-shadow: 0 3px 0 0 color($hoverColor shade(10%));\n      }\n    }\n  }\n}"},"./node_modules/raw-loader/index.js!./3dButton/cssMixins/titleColor.pcss":function(e,t){e.exports="a, button {\n  &.vce-button--style-3d--color-$selector {\n    &, &:link, &:visited, &:active, &:hover, &:focus {\n      @if $titleColor != false {\n        color: $titleColor;\n      }\n    }\n  }\n}\n"},"./node_modules/raw-loader/index.js!./3dButton/editor.css":function(e,t){e.exports=".vce-button--style-3d-container {\n  min-height: 1em;\n}\n"},"./node_modules/raw-loader/index.js!./3dButton/styles.css":function(e,t){e.exports=".vce-button--style-3d-container.vce-button--style-3d-container--align-left {\n  text-align: left;\n}\n.vce-button--style-3d-container.vce-button--style-3d-container--align-center {\n  text-align: center;\n}\n.vce-button--style-3d-container.vce-button--style-3d-container--align-right {\n  text-align: right;\n}\na.vce-button--style-3d,\nbutton.vce-button--style-3d {\n  display: inline-block;\n  border: 0;\n  box-sizing: border-box;\n  font-size: 16px;\n  line-height: normal;\n  cursor: pointer;\n  padding: 18px 43px;\n  margin-bottom: 3px;\n  vertical-align: middle;\n  text-align: center;\n  word-wrap: break-word;\n  text-decoration: none;\n  position: relative;\n  overflow: visible;\n  transition: background-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out, transform 0.2s ease-in-out;\n  max-width: 100%;\n}\na.vce-button--style-3d:focus,\nbutton.vce-button--style-3d:focus {\n  outline: none;\n}\na.vce-button--style-3d-inner,\nbutton.vce-button--style-3d-inner {\n  position: relative;\n}\na.vce-button--style-3d:hover.vce-button--style-3d--push-animation,\nbutton.vce-button--style-3d:hover.vce-button--style-3d--push-animation {\n  transition: background-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out, transform 0.2s ease-in-out;\n}\na.vce-button--style-3d:hover.vce-button--style-3d--push-animation:hover,\nbutton.vce-button--style-3d:hover.vce-button--style-3d--push-animation:hover {\n  box-shadow: none;\n  transform: translateY(3px);\n}\na.vce-button--style-3d--border-square,\nbutton.vce-button--style-3d--border-square {\n  border-radius: 0;\n}\na.vce-button--style-3d--border-rounded,\nbutton.vce-button--style-3d--border-rounded {\n  border-radius: 5px;\n}\na.vce-button--style-3d--border-round,\nbutton.vce-button--style-3d--border-round {\n  border-radius: 4em;\n}\n"}},[["./3dButton/index.js"]]]);