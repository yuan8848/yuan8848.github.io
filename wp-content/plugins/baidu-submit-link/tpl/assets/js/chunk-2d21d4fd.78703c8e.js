(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d21d4fd"],{d182:function(t,a,s){"use strict";s.r(a);var i=function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"sc-wp wbs-main"},[s("div",{staticClass:"cf"},[s("div",{staticClass:"tab-nav style-b"},[s("a",{staticClass:"tn-item",class:{current:101==t.type},on:{click:function(a){return t.log_type(101)}}},[t._v("所有推送")]),s("a",{staticClass:"tn-item",class:{current:11==t.type},on:{click:function(a){return t.log_type(11)}}},[t._v("Bing手动推送")]),s("a",{staticClass:"tn-item",class:{current:10==t.type},on:{click:function(a){return t.log_type(10)}}},[s("span",[t._v("Bing自动推送")]),t._v(" "),s("i",{staticClass:"tag-pro"},[t._v("Pro")])]),s("el-button",{staticClass:"fr tn-clear-item",attrs:{icon:"el-icon-delete-solid",plain:"",size:"mini"},on:{click:function(a){return t.clean_log(t.type)}}},[s("span",{staticClass:"when-m-hide"},[t._v("清除日志")])])],1)]),s("div",{staticClass:"log-box mt"},[s("el-table",{staticClass:"wbs-table",staticStyle:{width:"100%"},attrs:{data:t.list,"row-key":"id","empty-text":"- 最近7天无推送数据，建议保持每日更新内容 -"}},[s("el-table-column",{attrs:{label:"日期","class-name":"w30"},scopedSlots:t._u([{key:"default",fn:function(a){return[s("div",{staticClass:"data-label",attrs:{"data-label":"发布日期: "}},[t._v(t._s(a.row.date))])]}}])}),s("el-table-column",{attrs:{label:"链接","class-name":"w40"},scopedSlots:t._u([{key:"default",fn:function(a){return[s("div",{staticClass:"url",attrs:{"data-label":"链接: "}},[t._v(t._s(a.row.url))])]}}])}),s("el-table-column",{attrs:{label:"推送状态"},scopedSlots:t._u([{key:"default",fn:function(a){return[s("div",{staticClass:"data-label",attrs:{"data-label":"推送状态: "},domProps:{innerHTML:t._s(1==a.row.s_push?'<span class="suc">成功</span>':"失败")}})]}}])}),s("el-table-column",{attrs:{label:"推送方式"},scopedSlots:t._u([{key:"default",fn:function(a){return[s("div",{staticClass:"data-label",attrs:{"data-label":"推送方式: "}},[t._v(t._s({10:"自动推送",11:"手动推送"}[a.row.type]))])]}}])})],1),s("div",{directives:[{name:"show",rawName:"v-show",value:t.list.length>0,expression:"list.length>0"}],staticClass:"btns-bar"},[s("el-pagination",{attrs:{background:"",layout:t.$cnf.is_mobile?"pager, total, prev, next":"total, prev, pager, next, jumper","page-sizes":[10,30,50,100],"page-size":t.num,total:1*t.total,"pager-count":5},on:{"size-change":t.handleSizeChange,"current-change":t.nav_page}})],1),101==t.type&&"0"==t.opt.bing_auto&&"0"==t.opt.bing_manual?s("div",{staticClass:"getpro-mask"},[s("div",{staticClass:"mask-inner"},[s("router-link",{staticClass:"wbs-btn-primary",attrs:{to:"setting-api"}},[t._v("启用收录查询")]),s("p",{staticClass:"tips"},[t._v("*注意：当前功能依赖Bing推送设置。当前该功能处于关闭状态，需启用后才可使用该功能。")])],1)]):t._e(),10==t.type&&t.is_pro&&"0"==t.opt.bing_auto?s("div",{staticClass:"getpro-mask"},[s("div",{staticClass:"mask-inner"},[s("router-link",{staticClass:"wbs-btn-primary",attrs:{to:"setting-api"}},[t._v("启用收录查询")]),s("p",{staticClass:"tips"},[t._v("*注意：当前功能依赖Bing推送设置。当前该功能处于关闭状态，需启用后才可使用该功能。")])],1)]):t._e(),10!=t.type||t.is_pro?t._e():s("div",{staticClass:"getpro-mask"},[s("div",{staticClass:"mask-inner"},[s("a",{staticClass:"wbs-btn-primary",on:{click:t.aboutPro}},[t._v("获取PRO版本")]),s("p",{staticClass:"tips"},[t._v("* 注意：当前为演示数据，仅供参考")])])]),10==t.type?s("dl",{staticClass:"description pt-l"},[s("dt",[t._v("温馨提示：")]),s("dd",[t._v("推送失败，请检测Bing推送API密钥是否正确及当前站点域名是否在Bing站长平台验证绑定。")]),s("dd",[t._v("Bing自动推送数据类型包括新发布的、更新的及删除的URL数据。")]),s("dd",[t._v("Bing推送URL配额每天为10000个，实质为推送次数，包含自动和手动推送的次数。")]),s("dd",[t._v("Bing站长平台每天在格林尼治标准时间午夜重置配额，这可能与网站本地的时间不一致。")])]):t._e(),11==t.type?s("div",{staticClass:"pt-l"},[s("el-button",{attrs:{plain:"",size:"mini",type:"primary"},on:{click:t.submit_urls}},[t._v("手动提交链接")])],1):t._e(),11==t.type&&"0"==t.opt.bing_manual?s("div",{staticClass:"getpro-mask"},[s("div",{staticClass:"mask-inner"},[s("router-link",{staticClass:"wbs-btn-primary",attrs:{to:"setting-api"}},[t._v("启用Bing手动推送")]),s("p",{staticClass:"tips"},[t._v("*注意：当前功能依赖Bing推送设置。当前该功能处于关闭状态，需启用后才可使用该功能。")])],1)]):t._e(),11==t.type?s("dl",{staticClass:"description mt"},[s("dt",[t._v("温馨提示：")]),s("dd",[t._v("推送失败，请检测Bing推送API密钥是否正确及当前站点域名是否在Bing站长平台验证绑定。")]),t._m(0),s("dd",[t._v("如URL内容发生变化，可通过手动推送将最新的内容推送给Bing")]),s("dd",[t._v("Bing推送URL配额每天为10000个，实质为推送次数，包含自动和手动推送的次数。")]),s("dd",[t._v("Bing站长平台每天在格林尼治标准时间午夜重置配额，这可能与网站本地的时间不一致。")])]):t._e()],1)])},e=[function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("dd",[t._v("可以通过上方"),s("b",[t._v("手动提交链接")]),t._v("按钮批量手动推送URL数据至Bing。或者在Bing站长平台也可以批量手动提交URL，"),s("a",{staticClass:"link",attrs:{target:"_blank","data-wba-campaign":"Setting-Des-txt",href:"https://www.wbolt.com/how-to-submit-bing-urls-manually.html"}},[t._v("查看教程")]),t._v("。")])}],n="WB_BSL_USER_OPT_"+window.uid,l={name:"LogBing",data:function(){var t=this;return{is_pro:t.$cnf.is_pro,opt:t.$opt,type:101,loading_data:-1,list:[],num:10,total:0,page:1}},created:function(){},mounted:function(){var t=this,a=t.$WB.getLocalStorage(n)||{};t.num=a["PAGE_SIZE"]||10,t.list=[],t.load_data()},methods:{log_type:function(t){var a=this;a.type!==t&&(a.type=t,a.page=1,a.total=0,a.list=[],a.load_data())},clean_log:function(t){var a=this;return wbui.open({content:"确定清除所有推送日志?",btn:["确定","取消"],yes:function(){a.$api.saveData({action:a.$cnf.action.act,op:"clean_log",type:t}).then((function(t){wbui.toast("清除成功"),sessionStorage.removeItem("WB_BSL_LOG_BING"),location.reload()}))}}),!1},load_data:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0],a=this,s=a.num||10;if(10==a.type&&!a.is_pro)return[];a.showLoading();var i="WB_BSL_LOG_BING",e=a.$WB.getSessionStorage(i,!0),n=e.data;if(!t&&!a.$WB.updateLocalStorageChecker(e.ver)&&n&&n.num==a.num&&n.list[a.type]&&n.list[a.type][a.page])return a.list=n.list[a.type][a.page],a.total=n.total[a.type],a.closeLoading(),void(a.is_loaded=1);a.$api.getData({action:a.$cnf.action.act,op:"push_log",num:s,page:a.page,type:a.type}).then((function(t){a.list=t.data,a.total=t.total,a.closeLoading(),n=a.$WB.getSessionStorage(i)||{list:{},total:{}};try{var e=n.list[a.type]||{},l=n.total;e[a.page]=t.data,l[a.type]=a.total,n.list[a.type]=e,n.total=l,n.num=s,a.$WB.setSessionStorage(i,n)}catch(o){}})).catch((function(){a.closeLoading()}))},submit_urls:function(){var t=this,a=wbui.loading();t.$api.saveData({action:t.$cnf.action.act,op:"bing_quota"}).then((function(s){if(wbui.close(a),s.code)wbui.toast(s.desc);else if(s.data.DailyQuota)var i='<div class="form-group"><textarea id="url_list" class="wbs-input" rows="8" cols="42" placeholder="每行输入一个 URL"></textarea><div class="align-right mt">* 今天的剩余配额: <span class="hl">'+s.data.DailyQuota+"</span> URLs</div></div>",e=wbui.open({title:"手动提交链接",content:i,btn:["确认","取消"],yes:function(){var a=document.getElementById("url_list").value;if(""===a)return wbui.toast("请输入URL"),!1;t.$api.saveData({action:t.$cnf.action.act,op:"bing_push_manual",url:a}).then((function(a){a.code?wbui.toast(a.desc):(wbui.toast("提交成功"),wbui.close(e),t.list=[],t.type=11,t.load_data())}))}});else wbui.toast("当日配额已经用完")}))},aboutPro:function(){this.$router.push({path:"/pro"})},showLoading:function(){var t=this;wbui.close(t.loading_data),t.loading_data=wbui.loading()},closeLoading:function(){var t=this;wbui.close(t.loading_data),t.loading_data=-1},nav_page:function(t){var a=this;a.page=t,a.load_data()},handleSizeChange:function(t){var a=s.$WB.getLocalStorage(n)||{},s=this;s.num=t,s.page=1,a["PAGE_SIZE"]=t,s.$WB.setLocalStorage(n,a),sessionStorage.clear(),s.load_data()}}},o=l,c=s("2877"),r=Object(c["a"])(o,i,e,!1,null,null,null);a["default"]=r.exports}}]);