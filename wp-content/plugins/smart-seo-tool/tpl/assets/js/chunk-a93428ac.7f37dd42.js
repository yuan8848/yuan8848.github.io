(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-a93428ac"],{6006:function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"wbs-content-inner"},[a("div",{staticClass:"wbs-main"},[t.is_loaded?a("div",[t._m(0),a("table",{staticClass:"wbs-form-table"},[a("tbody",[a("tr",[a("th",{staticClass:"row w8em"},[t._v("索引")]),a("td",{staticClass:"selector-bar"},[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.search_noindex,expression:"search_noindex"}],attrs:{type:"radio",value:"0"},domProps:{checked:t._q(t.search_noindex,"0")},on:{click:function(e){return t.set_noindex(e,"search")},change:function(e){t.search_noindex="0"}}}),t._v(" 索引")]),a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.search_noindex,expression:"search_noindex"}],attrs:{type:"radio",value:"1"},domProps:{checked:t._q(t.search_noindex,"1")},on:{click:function(e){return t.set_noindex(e,"search")},change:function(e){t.search_noindex="1"}}}),t._v(" 不索引")])])])])]),a("wbs-tdk-setter",{attrs:{cnf:{separator:t.opt.separator,titleVariables:t.title_variables.search,kwMode:1},opt:t.opt.search},on:{change:function(e){t.opt.search=e}}}),t._m(1),a("table",{staticClass:"wbs-form-table"},[a("tbody",[a("tr",[a("th",{staticClass:"row w8em"},[t._v("索引")]),a("td",{staticClass:"selector-bar"},[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.tag_noindex,expression:"tag_noindex"}],attrs:{type:"radio",value:"0"},domProps:{checked:t._q(t.tag_noindex,"0")},on:{click:function(e){return t.set_noindex(e,"tag")},change:function(e){t.tag_noindex="0"}}}),t._v(" 索引")]),a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.tag_noindex,expression:"tag_noindex"}],attrs:{type:"radio",value:"1"},domProps:{checked:t._q(t.tag_noindex,"1")},on:{click:function(e){return t.set_noindex(e,"tag")},change:function(e){t.tag_noindex="1"}}}),t._v(" 不索引")])])])])]),a("wbs-tdk-setter",{attrs:{cnf:{separator:t.opt.separator,titleVariables:t.title_variables.tag,kwMode:1},opt:t.opt.tag},on:{change:function(e){t.opt.tag=e}}}),t._m(2),a("table",{staticClass:"wbs-form-table"},[a("tbody",[a("tr",[a("th",{staticClass:"row w8em"},[t._v("索引")]),a("td",{staticClass:"selector-bar"},[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.author_noindex,expression:"author_noindex"}],attrs:{type:"radio",value:"0"},domProps:{checked:t._q(t.author_noindex,"0")},on:{click:function(e){return t.set_noindex(e,"author")},change:function(e){t.author_noindex="0"}}}),t._v(" 索引")]),a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.author_noindex,expression:"author_noindex"}],attrs:{type:"radio",value:"1"},domProps:{checked:t._q(t.author_noindex,"1")},on:{click:function(e){return t.set_noindex(e,"author")},change:function(e){t.author_noindex="1"}}}),t._v(" 不索引")])])])])]),a("wbs-tdk-setter",{attrs:{cnf:{separator:t.opt.separator,titleVariables:t.title_variables.author,kwMode:1},opt:t.opt.author},on:{change:function(e){t.opt.author=e}}})],1):t._e(),a("wbs-var-doc",{directives:[{name:"show",rawName:"v-show",value:t.is_loaded,expression:"is_loaded"}]})],1),t.is_pro?t._e():a("wbs-more-sources"),a("wbs-ctrl-bar",{on:{submit:t.update_data}})],1)},o=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("h3",{staticClass:"sc-title-sub"},[a("span",[t._v("搜索结果页")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("h3",{staticClass:"sc-title-sub"},[a("span",[t._v("标签列表")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("h3",{staticClass:"sc-title-sub"},[a("span",[t._v("作者归档")])])}],r=(a("bf2f"),a("365c")),s=a("46d5"),i=a("6bd9"),c={name:"TdkMore",components:{"wbs-tdk-setter":s["a"],"wbs-var-doc":i["a"]},data:function(){var t=this;return{form_changed:0,is_loaded:0,is_pro:t.$cnf.is_pro,opt:{},search_noindex:0,tag_noindex:0,author_noindex:0,separator:[],title_variables:{}}},created:function(){var t=this;t.get_data()},methods:{set_noindex:function(t,e){var a=this,n=a.opt.noindex.indexOf(e),o=1*t.target.value;o&&n<0?a.opt.noindex.push(e):!o&&n>-1&&a.opt.noindex.splice(n,1)},get_data:function(){var t=this;Object(r["b"])({action:t.$cnf.action.act,op:"get_options",key:"tdk",type:"tag,search,author"}).then((function(e){var a=e.data;t.opt=a.opt,t.opt.noindex?(t.opt.noindex.indexOf("search")>-1&&(t.search_noindex=1),t.opt.noindex.indexOf("tag")>-1&&(t.tag_noindex=1),t.opt.noindex.indexOf("author")>-1&&(t.author_noindex=1)):t.opt.noindex=[],t.separator=a.separator,t.title_variables=a.title_variables,t.is_loaded=1}))},update_data:function(t){var e=this;Object(r["c"])({action:e.$cnf.action.act,op:"update_options",opt:e.opt,key:"tdk",type:"more"}).then((function(a){wbui.toast("设置保存成功"),e.form_changed=1,t&&t()}))}},computed:{},watch:{opt:{handler:function(){this.form_changed++},deep:!0}},beforeRouteLeave:function(t,e,a){var n=this;n.form_changed>1?wbui.open({content:"您修改的设置尚未保存，确定离开此页面吗？",btn:["保存并离开","放弃修改"],yes:function(){return a(!1),n.update_data((function(){a()})),!1},no:function(){return a(),!1}}):a()}},d=c,l=a("5d22"),u=Object(l["a"])(d,n,o,!1,null,null,null);e["default"]=u.exports},"6bd9":function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"mt"},[a("table",{staticClass:"wbs-form-table"},[a("tbody",[a("tr",[a("th",{staticClass:"row w8em"}),a("td",[a("el-button",{attrs:{size:"medium",type:"primary",plain:"",icon:"el-icon-collection"},on:{click:function(e){t.unfold=!t.unfold}}},[t._v("变量注释")]),a("table",{directives:[{name:"show",rawName:"v-show",value:t.unfold,expression:"unfold"}],staticClass:"wbs-table wbs-table-doc table-hover mt"},[t._m(0),a("tbody",t._l(t.doc_items,(function(e){return a("tr",{key:e.name},[a("td",[a("b",[t._v(t._s(e.name))])]),a("td",{domProps:{innerHTML:t._s(e.desc)}})])})),0)]),t._m(1)],1)])])])])},o=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("td",[t._v("变量名称")]),a("td",[t._v("变量说明")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"description mt"},[t._v(" SEO本身不是一件容易的事情，但当您深入了解其中的所有要点，也没有想象中那么深奥。"),a("br"),t._v("阅读"),a("a",{attrs:{href:"https://www.wbolt.com/learn/wp-seo",target:"_blank",rel:"noopener noreferrer nofollow"}},[t._v("WordPress SEO相关文章")]),t._v("(特别是"),a("a",{attrs:{href:"https://www.wbolt.com/wordpress-seo-tips.html",target:"_blank",rel:"noopener noreferrer nofollow"}},[t._v("WordPress终极SEO优化方案")]),t._v(")，并逐一摸透，相信您最终有所收获。 ")])}],r=a("365c"),s={name:"comVariableDoc",props:{type:{type:String,value:""}},data:function(){return{doc_items:[],unfold:!1}},created:function(){var t=this,e="WB_SST_DOC"+(t.type?"_"+t.type:""),a=localStorage.getItem(e);a=a?JSON.parse(a):null,a&&a.ver==t.$cnf.pd_version?t.doc_items=a.data:Object(r["b"])({action:t.$cnf.action.act,op:"doc",type:t.type?t.type:""}).then((function(a){t.doc_items=a["data"],localStorage.setItem(e,JSON.stringify({ver:t.$cnf.pd_version,data:a["data"]}))}))}},i=s,c=a("5d22"),d=Object(c["a"])(i,n,o,!1,null,null,null);e["a"]=d.exports}}]);