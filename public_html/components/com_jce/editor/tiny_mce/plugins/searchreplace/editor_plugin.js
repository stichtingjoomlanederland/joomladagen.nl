/* jce - 2.6.5 | 2016-12-27 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2016 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
!function(){var DOM=tinymce.DOM;tinymce.dom.Event,tinymce.each;tinymce.create("tinymce.plugins.SearchReplacePlugin",{init:function(ed,url){function open(m){ed.windowManager.open({file:ed.getParam("site_url")+"index.php?option=com_jce&view=editor&layout=plugin&plugin=searchreplace",width:420+parseInt(ed.getLang("searchreplace.delta_width",0)),height:200+parseInt(ed.getLang("searchreplace.delta_height",0)),inline:1,overlay:!1},{mode:m,search_string:ed.selection.getContent({format:"text"}),plugin_url:url})}this.bookmark=null,this.editor=ed,ed.addCommand("mceSearch",function(ui,s){function replace(){ed.selection.setContent(rs)}if(ed.getParam("searchreplace_use_dialog",1))return open("find");var r,b,result,se=ed.selection,w=ed.getWin(),ca=s.casesensitive,v=s.value||"",b=s.backwards,fl=0,fo=0,rs=s.replace;if(v){tinymce.isIE&&(r=ed.getDoc().selection.createRange()),ca&&(fl=4|fl);var complete=s.onComplete||function(){},find=s.onFind||function(){};switch(s.mode){case"all":if(ed.execCommand("SelectAll"),ed.selection.collapse(!0),tinymce.isIE)for(ed.focus(),r=ed.getDoc().selection.createRange();r.findText(s,b?-1:1,fl);)r.scrollIntoView(),r.select(),replace(),fo=1,b&&r.moveEnd("character",-rs.length);else for(;w.find(s,ca,b,!1,!1,!1,!1);)replace(),fo=1;complete.call(s.scope||this,!!fo);case"current":ed.selection.isCollapsed()||replace()}se.collapse(b),r=se.getRng(),tinymce.isIE?(ed.focus(),r=ed.getDoc().selection.createRange(),r.findText(v,b?-1:1,fl)?(r.scrollIntoView(),r.select(),result=!0,find.call(s.scope||this)):result=!1):(result=w.find(v,ca,b,!0,!1,!1,!1),result&&find.call(s.scope||this)),complete.call(s.scope||this,result)}}),ed.getParam("searchreplace_use_dialog",1)&&(ed.addCommand("mceReplace",function(){open("replace")}),ed.addButton("search",{title:"searchreplace.search_desc",cmd:"mceSearch"}),ed.addButton("replace",{title:"searchreplace.replace_desc",cmd:"mceReplace"})),ed.addShortcut("ctrl+f","searchreplace.search_desc",function(){if(ed.getParam("searchreplace_use_dialog",1))return ed.execCommand("mceSearch");var cm=ed.controlManager,c=cm.get(cm.prefix+"searchreplace_search");c&&!c.isDisabled()&&c.showDialog()})},createControl:function(n,cm){var self=this,ed=this.editor;switch(n){case"replace":if(ed.getParam("searchreplace_use_dialog",1))return;var content=DOM.create("div"),fieldset=DOM.add(content,"fieldset",{},"<legend>"+ed.getLang("searchreplace.replace_desc","Replace")+"</legend>"),n=DOM.add(fieldset,"div");DOM.add(n,"label",{for:ed.id+"_searchreplace_find"},ed.getLang("searchreplace.find","Find What"));var find=DOM.add(n,"input",{type:"text",id:ed.id+"_searchreplace_find",style:{width:210}});n=DOM.add(fieldset,"div"),DOM.add(n,"label",{for:ed.id+"_searchreplace_replace"},ed.getLang("searchreplace.replace","Replace with"));var replace=DOM.add(n,"input",{type:"text",id:ed.id+"_searchreplace_replace",style:{width:210}});n=DOM.add(fieldset,"div");var casesensitive=DOM.add(n,"input",{type:"checkbox",id:ed.id+"_searchreplace_casesensitive"});DOM.add(n,"label",{for:ed.id+"_searchreplace_casesensitive"},ed.getLang("searchreplace.casesensitive","Match Case"));var c=new tinymce.ui.ButtonDialog(cm.prefix+"searchreplace_search",{title:ed.getLang("searchreplace.replace_desc","Search / Replace"),class:"mce_search",dialog_class:ed.getParam("skin")+"Skin",content:content,width:320,buttons:[{title:ed.getLang("searchreplace.find_next","Next"),id:"searchreplace_find_next",click:function(e){if(!find.value)return!1;DOM.removeClass(find,"search_error");ed.execCommand("mceSearch",!1,{value:find.value,casesensitive:casesensitive.checked,onComplete:function(r){r||DOM.addClass(find,"search_error")},onFind:function(){c.storeSelection()}});return!1},scope:self},{title:ed.getLang("searchreplace.find_previous","Previous"),id:"searchreplace_find_previous",click:function(e){if(!find.value)return!1;DOM.removeClass(find,"search_error");ed.execCommand("mceSearch",!1,{value:find.value,casesensitive:casesensitive.checked,backwards:!0,onComplete:function(r){r||DOM.addClass(find,"search_error")}});return!1},scope:self},{title:ed.getLang("searchreplace.replace","Replace"),id:"searchreplace_replace",click:function(e){if(!find.value||!replace.value)return!1;ed.execCommand("mceSearch",!1,{value:find.value,casesensitive:casesensitive.checked,replace:replace.value,mode:"current"});return!1},scope:self},{title:ed.getLang("searchreplace.replace_all","Replace All"),id:"searchreplace_replace_all",click:function(e){if(!find.value||!replace.value)return!1;ed.execCommand("mceSearch",!1,{value:find.value,casesensitive:casesensitive.checked,replace:replace.value,mode:"all"});return!1},scope:self}]},ed);return c.onShowDialog.add(function(){find.focus()}),c.onHideDialog.add(function(){DOM.removeClass(find,"search_error"),find.value=replace.value="",c.restoreSelection()}),ed.onRemove.add(function(){c.destroy()}),cm.add(c)}return null},getInfo:function(){return{longname:"Search/Replace",author:"Moxiecode Systems AB",authorurl:"http://tinymce.moxiecode.com",infourl:"http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/searchreplace",version:tinymce.majorVersion+"."+tinymce.minorVersion}}}),tinymce.PluginManager.add("searchreplace",tinymce.plugins.SearchReplacePlugin)}();