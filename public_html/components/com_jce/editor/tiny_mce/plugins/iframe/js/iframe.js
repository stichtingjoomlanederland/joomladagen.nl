/* jce - 2.6.5 | 2016-12-27 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2016 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
var IframeDialog={settings:{},init:function(){var v,self=this,ed=tinyMCEPopup.editor,s=ed.selection,n=s.getNode(),data={};tinyMCEPopup.restoreSelection(),TinyMCE_Utils.fillClassList("classlist"),Wf.init(),this.settings.file_browser&&Wf.createBrowsers($("#src"),function(files,data){file=data[0],$("#src").val(file.url),file.width&&$("#width").val(file.width).data("tmp",file.width).change(),file.height&&$("#height").val(file.height).data("tmp",file.height).change()}),$("#insert").click(function(){self.insert()}),/mceItemIframe/.test(n.className)?(data=$.parseJSON(ed.dom.getAttrib(n,"data-mce-json")),data&&data.iframe&&($(".uk-button-text","#insert").text(tinyMCEPopup.getLang("update","Update",!0)),data=data.iframe,$.each(data,function(k,v){"scrolling"===k&&"auto"===v&&(v=""),$("#"+k).is(":checkbox")?$("#"+k).prop("checked",!!v):("src"==k&&(v=ed.convertURL(v)),$("#"+k).val(v))}),$.each(["class","width","height","style","id","longdesc","align"],function(i,k){switch(v=ed.dom.getAttrib(n,k),k){case"class":v=tinymce.trim(v.replace(/mceItem(\w+)/gi,"").replace(/\s+/g," ")),$("#classes, #classlist").val(v);break;case"width":case"height":v=self.getAttrib(n,k),v=v.replace("px",""),$("#"+k).val(v).data("tmp",v).change();break;case"align":$("#"+k).val(self.getAttrib(n,k));break;default:$("#"+k).val(v)}}),$.each(["top","right","bottom","left"],function(i,k){v=self.getAttrib(n,"margin-"+k),$("#margin_"+k).val(v)}))):Wf.setDefaults(this.settings.defaults),WFAggregator.setup({embed:!1}),$("#src").change(function(){var data={},v=this.value;(s=WFAggregator.isSupported(v))?(data=WFAggregator.getAttributes(s,v),$(".aggregator_option, .options_description","#options_tab").hide().filter("."+s).show()):$(".options_description","#options_tab").show();for(n in data){var $el=$("#"+n),v=data[n];"width"==n||"height"==n?""!==$el.val()&&$el.hasClass("edited")!==!1||$("#"+n).val(data[n]).data("tmp",data[n]).change():$el.is(":checkbox")?(v=parseInt(v),$el.attr("checked",v).prop("checked",v)):$el.val(v)}}).change(),$(".uk-equalize-checkbox").trigger("equalize:update")},getAttrib:function(e,at){return Wf.getAttrib(e,at)},checkPrefix:function(n){var self=this,v=$(n).val();/^\s*www./i.test(v)?Wf.Dialog.confirm(tinyMCEPopup.getLang("iframe_dlg.is_external","The URL you entered seems to be an external link, do you want to add the required http:// prefix?"),function(state){state&&$(n).val("http://"+v),self.insert()}):this.insertAndClose()},insert:function(){tinyMCEPopup.editor;return""===$("#src").val()?(Wf.Dialog.alert(tinyMCEPopup.getLang("iframe_dlg.no_src","Please enter a url for the iframe")),!1):""===$("#width").val()||""===$("#height").val()?(Wf.Dialog.alert(tinyMCEPopup.getLang("iframe_dlg.no_dimensions","Please enter a width and height for the iframe")),!1):this.checkPrefix($("#src"))},insertAndClose:function(){tinyMCEPopup.restoreSelection();var ed=tinyMCEPopup.editor,args={},n=ed.selection.getNode(),attribs=this.getParameters();if(tinymce.each(["classes","style","id","longdesc","title"],function(k){var v=$("#"+k).val();""!==v&&("classes"==k&&(k="class"),args[k]=v)}),tinymce.extend(args,{src:tinyMCEPopup.getWindowArg("plugin_url")+"/img/trans.gif","data-mce-json":this.serializeParameters(),width:$("#width").val(),height:$("#height").val()}),n&&ed.dom.is(n,".mceItemIframe"))"SPAN"===n.nodeName&&delete args.src,ed.dom.setAttribs(n,args),tinymce.each(ed.dom.select("iframe",n),function(ifr){ed.dom.setAttribs(ifr,{src:attribs.src,width:args.width,height:args.height})});else{var html="<iframe";tinymce.extend(args,attribs),delete args["data-mce-json"],tinymce.each(args,function(v,k){""!==v&&"undefined"!=typeof v&&(html+=" "+k+'="'+v+'"')});var innerHTML=$("#html").val();html+=">"+$.trim(innerHTML)+"</iframe>",ed.execCommand("mceInsertContent",!1,html,{skip_undo:1}),ed.undoManager.add()}tinyMCEPopup.close()},getParameters:function(){var s,v,ed=tinyMCEPopup.editor,data={};return tinymce.each(["src","name","scrolling","frameborder","allowtransparency","allowfullscreen","html"],function(k){if(!$("#"+k).prop("disabled")&&(v=$("#"+k).is(":checkbox")?$("#"+k).is(":checked")?1:0:$("#"+k).val(),""!==v)){if("src"==k&&(v=v.replace(/&amp;/gi,"&"),v=ed.convertURL(v)),"html4"!==ed.settings.schema&&"frameborder"===k)return!0;"scrolling"===k&&"auto"===v&&(v=null),null!==v&&(data[k]=v)}}),(s=WFAggregator.isSupported(data.src))&&$.extend(!0,data,WFAggregator.getValues(s,data.src)),data},serializeParameters:function(){var o={iframe:this.getParameters()};return JSON.stringify(o)}};tinyMCEPopup.onInit.add(IframeDialog.init,IframeDialog);