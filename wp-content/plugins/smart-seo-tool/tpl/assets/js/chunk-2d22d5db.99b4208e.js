(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d22d5db"],{f6d9:function(t,e,a){"use strict";a.r(e);var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"steps-card-box"},[a("div",{staticClass:"wbs-main"},[a("div",{staticClass:"step-desc"},[t._v(" 根据实际情况，设置网站的搜索引擎可见性。如果网站正式对外，请选择“搜索引擎可见”；否则请选择“暂不开放索引”。 ")]),a("div",{staticClass:"option-items-selector"},[a("div",{staticClass:"select-item"},[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.opt.public,expression:"opt.public"}],attrs:{type:"radio",value:"1"},domProps:{checked:t._q(t.opt.public,"1")},on:{change:function(e){return t.$set(t.opt,"public","1")}}}),a("span",[t._v("搜索引擎可见（编入索引）")])])]),a("div",{staticClass:"select-item"},[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.opt.public,expression:"opt.public"}],attrs:{type:"radio",value:"0"},domProps:{checked:t._q(t.opt.public,"0")},on:{change:function(e){return t.$set(t.opt,"public","0")}}}),a("span",[t._v("暂不开放索引")])])])])]),a("div",{staticClass:"steps-card-ft"},[a("div",{staticClass:"scft-item primary"}),a("div",{staticClass:"scft-item"},[a("button",{staticClass:"wbs-btn-primary",attrs:{type:"button"},on:{click:t.update_data}},[t._v("下一步 >")])])])])},n=[],s=a("365c"),c={name:"GuideStep1",data:function(){var t=this;return{form_changed:1,is_loaded:0,is_pro:t.$cnf.is_pro,opt:{public:1},cnf:{}}},created:function(){var t=this;t.get_data()},methods:{get_data:function(){var t=this;Object(s["b"])({action:t.$cnf.action.act,op:"get_guide"}).then((function(e){t.opt=e["data"],t.is_loaded=1}))},update_data:function(t){var e=this;e.opt.step=1,Object(s["c"])({action:e.$cnf.action.act,op:"set_guide",opt:e.opt}).then((function(a){e.form_changed=1,e.$emit("next",!0),"function"==typeof t&&t&&t()}))}},watch:{},beforeRouteLeave:function(t,e,a){var i=this;i.form_changed>1?wbui.open({content:"您修改的设置尚未保存，确定离开此页面吗？",btn:["保存并离开","放弃修改"],yes:function(){return a(!1),i.update_data((function(){a()})),!1},no:function(){return a(),!1}}):a()}},o=c,p=a("5d22"),d=Object(p["a"])(o,i,n,!1,null,null,null);e["default"]=d.exports}}]);