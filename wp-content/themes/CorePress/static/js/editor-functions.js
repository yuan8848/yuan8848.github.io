function addshortcode(e,t){if(e=="title-plane"){addContentToEditer(1,'[title-plane title="标题"]内容[/title-plane]')}else if(e=="start-plane"){addContentToEditer(1,'[start-plane type="'+t+'"]内容[/start-plane]')}else if(e=="icon-url"){addContentToEditer(1,'[icon-url href="网址" target="_blank"]网址[/icon-url]')}else if(e=="loginshow"){addContentToEditer(1,"[loginshow]登录可见的内容[/loginshow]")}else if(e=="zd-plane"){addContentToEditer(1,'[zd-plane title="折叠标题"]折叠内容[/zd-plane]')}else if(e=="clickshow"){addContentToEditer(1,"[clickshow]点击可见内容[/clickshow]")}else if(e=="c-alert"){addContentToEditer(1,'[c-alert type="'+t+'"]提示面板内容[/c-alert]')}else if(e=="pwdshow"){addContentToEditer(1,'[pwdshow pwd="密码"]密码可见内容[/pwdshow]')}else if(e=="c-downbtn"){addContentToEditer(1,'[c-downbtn type="'+t+'" url="" pwd=""]资源文件下载[/c-downbtn]')}else if(e=="selectbox"){addContentToEditer(1,'[selectbox type="1"]')}else if(e=="replyread"){addContentToEditer(1,"[reply]回复可见内容[/reply]")}else if(e=="bvideo"){addContentToEditer(1,'[bvideo bv="'+t+'"][/bvideo]')}else if(e=="corepress-code"){layer.open({type:1,title:"插入代码",shadeClose:true,shade:false,area:["500px","500px"],content:`<div><div class="corepress-edit-window">
                       <textarea class="corepress-edit-code"></textarea>
                        
                       <button class="el-button el-button--default el-button--small " onclick="corepress_addcode(1)">插入代码</button>
                       <button class="el-button el-button--default el-button--small " onclick="corepress_clearcode()">清空内容</button>
                      </div> </div>
                        `})}else if(e=="corepress-code-line"){layer.open({type:1,title:"行内代码",shadeClose:true,shade:false,area:["500px","300px"],content:`<div><div class="corepress-edit-window">
                       <textarea class="corepress-edit-code-line"></textarea>
                       <button class="el-button el-button--default el-button--small " onclick="corepress_addcode(0)">插入代码</button>
                      </div> </div>
                        `})}}function corepress_clearcode(){jQuery(".corepress-edit-code").val("")}function corepress_addcode(e){if(e==0){var t=jQuery(".corepress-edit-code-line").val();addContentToEditer(1,"<code>"+t+"</code>&nbsp;")}else{var t=jQuery(".corepress-edit-code").val();addContentToEditer(1,'<pre class="corepress-code-pre"><code>'+htmlEncodeByRegExp(t)+"</code></pre>&nbsp;")}}function corepress_updatecode(){window.$codedom.html(htmlEncodeByRegExp(jQuery(".corepress-edit-code").val()));layer.closeAll()}function editcode(e,t){window.$codedom=t;layer.open({type:1,title:"修改代码",shadeClose:true,shade:false,area:["500px","500px"],content:'<div class="corepress-edit-window"><textarea class="corepress-edit-code">'+e+'</textarea><br><button class="el-button el-button--default el-button--small" onclick="corepress_updatecode()">更新</button></div>'})}function addContentToEditer(e,t){parent.tinymce.activeEditor.selection.setContent(t)}