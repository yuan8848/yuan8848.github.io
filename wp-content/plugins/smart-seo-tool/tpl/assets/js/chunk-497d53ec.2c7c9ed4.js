(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-497d53ec"],{"24a8":function(t,e,a){"use strict";var i=a("8fe5"),n=a("f14a"),s=a("dd95"),r=a("bbee"),c=a("2ccf"),l=a("36b2"),o=a("83d4"),u=a("3de9"),p=a("7ce6"),d=a("a447"),f=a("a34a").f,_=a("38e3").f,b=a("d320").f,v=a("f8d5").trim,h="Number",m=n[h],w=m.prototype,g=l(d(w))==h,k=function(t){var e,a,i,n,s,r,c,l,o=u(t,!1);if("string"==typeof o&&o.length>2)if(o=v(o),e=o.charCodeAt(0),43===e||45===e){if(a=o.charCodeAt(2),88===a||120===a)return NaN}else if(48===e){switch(o.charCodeAt(1)){case 66:case 98:i=2,n=49;break;case 79:case 111:i=8,n=55;break;default:return+o}for(s=o.slice(2),r=s.length,c=0;c<r;c++)if(l=s.charCodeAt(c),l<48||l>n)return NaN;return parseInt(s,i)}return+o};if(s(h,!m(" 0o1")||!m("0b1")||m("+0x1"))){for(var y,C=function(t){var e=arguments.length<1?0:t,a=this;return a instanceof C&&(g?p((function(){w.valueOf.call(a)})):l(a)!=h)?o(new m(k(e)),a,C):k(e)},S=i?f(m):"MAX_VALUE,MIN_VALUE,NaN,NEGATIVE_INFINITY,POSITIVE_INFINITY,EPSILON,isFinite,isInteger,isNaN,isSafeInteger,MAX_SAFE_INTEGER,MIN_SAFE_INTEGER,parseFloat,parseInt,isInteger,fromString,range".split(","),I=0;S.length>I;I++)c(m,y=S[I])&&!c(C,y)&&b(C,y,_(m,y));C.prototype=w,w.constructor=C,r(n,h,C)}},"6a8c":function(t,e){t.exports="\t\n\v\f\r                　\u2028\u2029\ufeff"},"83d4":function(t,e,a){var i=a("97f5"),n=a("721d");t.exports=function(t,e,a){var s,r;return n&&"function"==typeof(s=e.constructor)&&s!==a&&i(r=s.prototype)&&r!==a.prototype&&n(t,r),t}},8856:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"wbs-custom-links"},[a("label",{staticClass:"wb-links-input-box"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.cur_input,expression:"cur_input"}],staticClass:"wbs-input wbs-input-short",attrs:{type:"text",placeholder:t.placeholder},domProps:{value:t.cur_input},on:{keyup:t.wbTagInput,input:function(e){e.target.composing||(t.cur_input=e.target.value)}}}),a("a",{staticClass:"ml link",on:{click:t.wbTagPush}},[t._v("添加 +")])]),t.items.length?a("div",{staticClass:"links-items"},t._l(t.items,(function(e,i){return a("div",{key:i,staticClass:"link-item"},[a("span",{staticClass:"item-value",domProps:{innerHTML:t._s(t.displayFormat(e))}}),a("span",{staticClass:"del",attrs:{"data-del-val":e},on:{click:function(e){return t.delItem(i)}}},[a("i",{staticClass:"el-icon-delete"})])])})),0):t._e()])},n=[],s=(a("24a8"),a("fc13"),a("9b5f"),a("ea94"),a("bf2f"),{name:"comCustomLinks",props:{items:Array,mode:Number,placeholder:String},data:function(){return{cur_input:"",taglist:[],keycode:null}},created:function(){this.taglist=this.items?this.items:[]},methods:{wbTagInput:function(t){var e=this,a=t.keyCode;188===a&&(e.cur_input=e.cur_input.replace(/(^,)|(,$)/,"")),13===a&&(e.wbTagPush(),event.stopPropagation())},wbTagPush:function(t){var e=this;return""!=e.cur_input&&(e.taglist.indexOf(e.cur_input.trim())>-1?(wbui.toast("已存在"),e.cur_input="",!1):(e.taglist.push(e.cur_input),e.$emit("set-tags",e.taglist),e.cur_input="",!1))},delItem:function(t){var e=this;wbui.confirm("确认删除？",(function(){e.taglist.splice(t,1),e.$emit("set-tags",e.taglist),wbui.toast("已移除")}))},displayFormat:function(t){return t}}}),r=s,c=a("5d22"),l=Object(c["a"])(r,i,n,!1,null,null,null);e["a"]=l.exports},c41f:function(t,e,a){"use strict";a.r(e);var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"wbs-content-inner"},[a("div",{staticClass:"wbs-main"},[t.is_loaded?a("table",{staticClass:"wbs-form-table"},[a("tbody",[a("tr",[a("th",{staticClass:"row w8em"},[t._v("404监测开关")]),a("td",{staticClass:"info"},[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.opt.active,expression:"opt.active"}],staticClass:"wb-switch",attrs:{type:"checkbox","true-value":"1","false-value":"0"},domProps:{checked:Array.isArray(t.opt.active)?t._i(t.opt.active,null)>-1:t._q(t.opt.active,"1")},on:{click:function(e){return t.set_active(e)},change:function(e){var a=t.opt.active,i=e.target,n=i.checked?"1":"0";if(Array.isArray(a)){var s=null,r=t._i(a,s);i.checked?r<0&&t.$set(t.opt,"active",a.concat([s])):r>-1&&t.$set(t.opt,"active",a.slice(0,r).concat(a.slice(r+1)))}else t.$set(t.opt,"active",n)}}})])])])])]):t._e(),a("div",{staticClass:"sc-body log-box"},[t.spider_install&&t.spider_active?t._e():a("div",{staticClass:"getpro-mask"},[a("div",{staticClass:"mask-inner"},[t.spider_install?t.spider_active?t._e():a("div",{staticClass:"tips"},[a("p",[t._v("* 当前功能依赖Spider Analyser-蜘蛛分析插件。")]),a("div",{staticClass:"wb-hl mt"},[a("svg",{staticClass:"wb-icon wbsico-notice"},[a("use",{attrs:{"xlink:href":"#wbsico-notice"}})]),a("span",[t._v("检测到未启用，去")]),a("a",{staticClass:"link",attrs:{href:t.admin_url("plugin-install.php?s=Wbolt+Spider+Analyser&tab=search&type=term")}},[t._v("启用")])])]):a("div",{staticClass:"tips"},[a("p",[t._v("* 当前功能依赖Spider Analyser-蜘蛛分析插件。")]),a("div",{staticClass:"wb-hl mt"},[a("svg",{staticClass:"wb-icon wbsico-notice"},[a("use",{attrs:{"xlink:href":"#wbsico-notice"}})]),a("span",[t._v("未检测到安装，去")]),a("a",{staticClass:"link",attrs:{href:t.admin_url("plugin-install.php?s=Wbolt+Spider+Analyser&tab=search&type=term")}},[t._v("安装")])])])])]),a("el-table",{staticClass:"wbs-table mt",staticStyle:{width:"100%"},attrs:{data:t.url_404},on:{"selection-change":t.handleSelectionChange}},[a("el-table-column",{attrs:{type:"selection",name:"id",width:"55"}}),a("el-table-column",{attrs:{label:"URL地址","class-name":"w40"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("a",{staticClass:"url",attrs:{"data-label":"URL",href:e.row.url,target:"_blank"}},[t._v(t._s(e.row.url))])]}}])}),a("el-table-column",{attrs:{label:"响应码","class-name":"w15"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",{attrs:{"data-label":"响应码"}},[a("span",[t._v(t._s(e.row.code))])])]}}])}),a("el-table-column",{attrs:{label:"反馈蜘蛛","class-name":"w15"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",{attrs:{"data-label":"反馈蜘蛛"}},[a("span",[t._v(t._s(e.row.spider))])])]}}])}),a("el-table-column",{attrs:{label:"访问时间","class-name":"w15"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",{attrs:{"data-label":"访问时间"}},[a("span",[t._v(t._s(e.row.visit_date))])])]}}])}),a("el-table-column",{attrs:{label:"操作",align:"right"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{plain:"",size:"mini",type:"success"},on:{click:function(a){return t.refresh_404(e.row)}}},[t._v("刷新状态")]),a("el-button",{attrs:{size:"mini",type:"danger",plain:""},on:{click:function(a){return t.remove_404(e.row)}}},[t._v("忽略")])]}}])})],1),a("div",{directives:[{name:"show",rawName:"v-show",value:t.url_404.length>0,expression:"url_404.length>0"}],staticClass:"btns-bar with-ctrl-area"},[a("div",{staticClass:"wb-ctrl-area"},[a("el-select",{attrs:{size:"small",placeholder:"批量操作"},model:{value:t.batch_op,callback:function(e){t.batch_op=e},expression:"batch_op"}},[a("el-option",{attrs:{label:"刷新状态",value:"check"}}),a("el-option",{attrs:{label:"忽略",value:"del"}})],1),a("el-button",{staticClass:"ml-s",attrs:{type:"info",plain:"",size:"small"},on:{click:t.batch_apply}},[t._v("应用")])],1),a("el-pagination",{attrs:{background:"",layout:"total, prev, pager, next, jumper","page-size":30,total:1*t.total,"current-page":t.page},on:{"current-change":t.nav_page}})],1),t._m(0)],1)]),t.is_pro?t._e():a("wbs-more-sources")],1)},n=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("dl",{staticClass:"description mt"},[a("dt",[t._v("温馨提示：")]),a("dd",[t._v("404响应码不代表网站一定存在该链接，可能是安全扫描、爬虫等程序导致。")]),a("dd",[t._v("为协助您更好地判断404错误，建议安装"),a("a",{attrs:{href:"https://www.wbolt.com/plugins/spider-analyser"}},[t._v("蜘蛛分析插件")]),t._v("。")]),a("dd",[t._v("对于真实的404状态链接，可以安装"),a("a",{attrs:{href:"https://www.wbolt.com/plugins/bsl-pro"}},[t._v("搜索推送插件")]),t._v("生成404链接集URL，提交通知搜索引擎。")])])}],s=(a("3bae"),a("55cf"),a("365c")),r=a("8856"),c={name:"UrlMonitor",components:{"wbs-custom-links":r["a"]},data:function(){var t=this;return{is_loaded:0,form_changed:1,is_pro:t.$cnf.is_pro,opt:{},cnf:{},spider_install:0,spider_active:0,total:0,page:1,page_num:20,url_404:[],multipleSelection:[],batch_op:""}},created:function(){var t=this;t.get_data()},methods:{handleSelectionChange:function(t){this.multipleSelection=t},batch_apply:function(){var t=this;if(!t.batch_op)return!1;if(t.multipleSelection.length<1)return wbui.toast("未选择项目"),!1;if("del"==t.batch_op){var e=[];if(t.multipleSelection.forEach((function(t){e.push(t.id)})),e.length<1)return;wbui.confirm("确认忽略所选链接？",(function(){var a=wbui.toast("执行中...",{time:180});Object(s["b"])({action:t.$cnf.action.act,op:"remove_404",id:e}).then((function(e){wbui.close(a),wbui.toast("已忽略所选链接"),t.page=1,t.load_data()}))}))}else if("check"==t.batch_op){var a=[];if(t.multipleSelection.forEach((function(t){a.push(t.id)})),a.length<1)return;var i=wbui.toast("检测中...",{time:180});Object(s["b"])({action:t.$cnf.action.act,op:"refresh_404",id:a}).then((function(e){wbui.close(i),wbui.toast("已全部检测状态"),t.load_data()}))}return!1},set_active:function(){var t=this;setTimeout((function(){Object(s["c"])({action:t.$cnf.action.act,op:"update_options",opt:t.opt,key:"url_404"}).then((function(t){}))}),250)},get_data:function(){var t=this;Object(s["b"])({action:t.$cnf.action.act,op:"get_options",key:"url_404",page:t.page}).then((function(e){var a=e.data;t.opt=a.opt,t.cnf=a.cnf,t.total=a.total,t.spider_install=a.spider_install,t.spider_active=a.spider_active,a.spider_install&&a.spider_active&&t.load_data(),t.is_loaded=1}))},load_data:function(){var t=this;Object(s["a"])({action:t.$cnf.action.act,op:"404_url",page:t.page}).then((function(e){t.url_404=e.data}))},admin_url:function(t){return this.$cnf.base_url+t},nav_page:function(t){this.page=t,this.load_data()},remove_404:function(t){var e=this;return wbui.confirm("确认忽略链接？",(function(){var a=wbui.toast("执行中...",{time:180});Object(s["b"])({action:e.$cnf.action.act,op:"remove_404",id:t.id}).then((function(t){wbui.close(a),wbui.toast("已忽略链接"),e.load_data()}))})),!1},refresh_404:function(t){var e=this,a=wbui.toast("检测中...",{time:180});return Object(s["b"])({action:e.$cnf.action.act,op:"refresh_404",id:t.id}).then((function(t){wbui.close(a),wbui.toast("已检测更新完"),e.load_data()})),!1}}},l=c,o=a("5d22"),u=Object(o["a"])(l,i,n,!1,null,null,null);e["default"]=u.exports},ea94:function(t,e,a){"use strict";var i=a("1f04"),n=a("f8d5").trim,s=a("ed58");i({target:"String",proto:!0,forced:s("trim")},{trim:function(){return n(this)}})},ed58:function(t,e,a){var i=a("7ce6"),n=a("6a8c"),s="​᠎";t.exports=function(t){return i((function(){return!!n[t]()||s[t]()!=s||n[t].name!==t}))}},f8d5:function(t,e,a){var i=a("4023"),n=a("6a8c"),s="["+n+"]",r=RegExp("^"+s+s+"*"),c=RegExp(s+s+"*$"),l=function(t){return function(e){var a=String(i(e));return 1&t&&(a=a.replace(r,"")),2&t&&(a=a.replace(c,"")),a}};t.exports={start:l(1),end:l(2),trim:l(3)}}}]);