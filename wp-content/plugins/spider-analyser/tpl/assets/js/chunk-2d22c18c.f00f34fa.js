(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d22c18c"],{f27a:function(t,e,a){"use strict";a.r(e);var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"wbs-main"},[t.isLoaded?a("div",{staticClass:"log-box with-mask"},[t.$cnf.is_mobile?a("div",{staticClass:"cell-items"},[t.spider_log.length?t._e():a("div",{staticClass:"empty-data align-center"},[t.auto_deny?a("span",[t._v("已启用智能拦截功能，当前列表不记录伪蜘蛛数据。")]):a("span",[t._v("--暂无数据--")])]),t._l(t.spider_log,(function(e,i){return a("div",{key:"item"+i,staticClass:"cell-item with-expand"},[a("div",{staticClass:"cell-hd"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.multipleSelection,expression:"multipleSelection"}],attrs:{type:"checkbox"},domProps:{value:e,checked:Array.isArray(t.multipleSelection)?t._i(t.multipleSelection,e)>-1:t.multipleSelection},on:{change:function(a){var i=t.multipleSelection,s=a.target,l=!!s.checked;if(Array.isArray(i)){var n=e,o=t._i(i,n);s.checked?o<0&&(t.multipleSelection=i.concat([n])):o>-1&&(t.multipleSelection=i.slice(0,o).concat(i.slice(o+1)))}else t.multipleSelection=l}}})]),a("div",{staticClass:"cell-bd primary"},[a("div",[a("span",{staticClass:"wk fz-s"},[t._v("伪装名称: ")]),a("span",[t._v(t._s(e.name))])]),a("div",{staticClass:"wk fz-s"},[t._v(" IP地址: "),a("span",[t._v(t._s(e.ip)+" "),a("a",{attrs:{href:"https://www.wbolt.com/tools-spider?ip="+e.ip+"&utm_source=spider-analyser",target:"_blank",title:"查询"}},[a("i",{staticClass:"el-icon-search el-icon--right"})])])]),a("div",{staticClass:"def-hide"},[a("div",{staticClass:"btns align-right"},[a("el-button",{attrs:{size:"mini",type:"success",plain:""},on:{click:function(a){return t.add(i,e)}}},[t._v("拦截")])],1)])]),a("div",{staticClass:"cell-ft",on:{click:t.$WB.toggleActive}})])}))],2):a("el-table",{staticClass:"wbs-table",staticStyle:{width:"100%"},attrs:{data:t.spider_log},on:{"selection-change":t.handleSelectionChange}},[a("template",{slot:"empty"},[t.auto_deny?a("span",[t._v("已启用智能拦截功能，当前列表不记录伪蜘蛛数据。")]):a("span",[t._v("--暂无数据--")])]),a("el-table-column",{attrs:{type:"selection",width:"55"}}),a("el-table-column",{attrs:{label:"伪装名称"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",{attrs:{"data-label":"伪装名称"}},[a("span",[t._v(t._s(e.row.name))])])]}}],null,!1,1009836744)}),a("el-table-column",{attrs:{label:"IP地址"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",{attrs:{"data-label":"IP地址"}},[a("span",[t._v(t._s(e.row.ip)+" "),a("a",{attrs:{href:"https://www.wbolt.com/tools-spider?ip="+e.row.ip+"&utm_source=spider-analyser",target:"_blank",title:"查询"}},[a("i",{staticClass:"el-icon-search el-icon--right"})])])])]}}],null,!1,2620601810)}),a("el-table-column",{attrs:{label:"操作",align:"right"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{size:"mini",type:"success",plain:""},on:{click:function(a){return t.add(e.$index,e.row)}}},[t._v("拦截")])]}}],null,!1,332013100)})],2),t.is_pro?t._e():a("div",{staticClass:"getpro-mask"},[a("div",{staticClass:"mask-inner"},[a("a",{staticClass:"wbs-btn-primary",on:{click:t.about_pro}},[t._v("获取PRO版本")]),a("p",{staticClass:"tips"},[t._v("* 激活PRO版本即可使用")])])]),a("div",{directives:[{name:"show",rawName:"v-show",value:t.spider_log.length>0,expression:"spider_log.length > 0"}],staticClass:"btns-bar with-ctrl-area"},[a("div",{staticClass:"wb-ctrl-area"},[a("el-select",{attrs:{size:"small",placeholder:"批量操作"},model:{value:t.batch_op,callback:function(e){t.batch_op=e},expression:"batch_op"}},[a("el-option",{attrs:{label:"拦截",value:"stop"}})],1),a("el-button",{staticClass:"ml-s",attrs:{type:"info",plain:"",size:"small"},on:{click:t.batch_apply}},[t._v("应用")])],1),a("el-pagination",{attrs:{background:"",layout:t.$cnf.is_mobile?"pager, total, prev, next":"total, prev, pager, next, jumper","page-size":20,total:1*t.total,"pager-count":5},on:{"current-change":t.nav_page}})],1)],1):t._e(),t._m(0)])},s=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"description mt"},[a("p",[t._v("* 疑似伪蜘蛛数据引自"),a("a",{attrs:{href:"https://www.wbolt.com/tools-spider&utm_source=spider-analyser",target:"_blank"}},[t._v("蜘蛛爬虫查询工具")]),t._v("，仅供参考。")]),a("p",[t._v("* 如果您的网站启用了全站CDN，所有访问都走CDN服务器，真实蜘蛛也可能被判断为伪蜘蛛。全站CDN站点应结合CDN路线IP进一步判断蜘蛛的真伪。")])])}],l=(a("4160"),a("159b"),a("c975"),{name:"ListSuspected",data:function(){var t=this;return{isLoaded:0,is_pro:t.$cnf.is_pro,cnf:{spider:[],code:[]},config:{},spider_log:[],log_loading:1,total:0,page:1,num:20,data:{spider_log:[],log_loading:1,total:0,page:1,num:20},search:{},one:{name:"",ip:""},multipleSelection:[],batch_op:"",auto_deny:window.wb_spider_auto}},mounted:function(){var t=this;t.$verify(t.verify_run)},methods:{handleSelectionChange:function(t){this.multipleSelection=t},batch_apply:function(){var t=this;if(!t.batch_op)return!1;if(t.multipleSelection.length<1)return t.$wbui.toast("未选择项目"),!1;if("stop"==t.batch_op){if(!t.is_pro)return t.$wbui.open({content:"该功能仅Pro版本提供",btn:["激活Pro版"],yes:function(){t.$router.push({path:"/pro"})}}),!1;var e=[];if(t.multipleSelection.forEach((function(t){-1==e.indexOf(t.ip)&&e.push(t.ip)})),e.length<1)return;t.$wbui.confirm("批量拦截所选伪蜘蛛IP？可通过蜘蛛拦截列表移除。",(function(){var a=t.$wbui.toast("执行中...",{time:180});t.$api.saveData({action:t.$cnf.action.act,op:"stop",cid:14,add:["",e]}).then((function(e){t.$wbui.close(a),t.$wbui.toast("已添加所选至蜘蛛拦截清单"),t.page=1,t.load_data()}))}))}return!1},add:function(t,e){var a=this,i={add:["",e.ip],cid:14};Object.assign(i,a.config.param),i.op="stop",a.$wbui.confirm("拦截IP为"+e.ip+"的蜘蛛？可通过蜘蛛拦截列表移除。",(function(){a.$api.saveData(i).then((function(t){a.$wbui.toast("操作成功"),a.page=1,a.load_data()}))}))},nav_page:function(t){this.page=t,this.load_data()},load_data:function(){var t=this,e={status:2,page:t.page,num:t.num};Object.assign(e,t.config.param),e.op="stop",t.log_loading=t.$wbui.loading(),t.$api.getData(e).then((function(e){t.spider_log=e.data,t.total=e.total,t.num=e.num,t.isLoaded=1,t.$wbui.close(t.log_loading)}))},about_pro:function(){this.$router.push({path:"/pro"})},verify_run:function(t,e){t&&this.set_cnf(e),t||(this.isLoaded=1)},set_cnf:function(t){this.config=t,this.is_pro=1,this.load_data()}}}),n=l,o=a("2877"),c=Object(o["a"])(n,i,s,!1,null,null,null);e["default"]=c.exports}}]);