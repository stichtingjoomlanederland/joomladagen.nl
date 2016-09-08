/* filemanager - 2.1.9 | 20 April 2016 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2016 Ryan Demmer. All rights reserved | GNU/GPL Version 2 - http://www.gnu.org/licenses/gpl-2.0.html */
(function(){var GoogleDocsRe=/\.(docx|xlsx|pptx|pdf|pages|ai|psd|tiff|dxf|svg|ps|ttf|xps|rar)$/;var FileManager={settings:{text_alert:1},init:function(){tinyMCEPopup.restoreSelection();var ed=tinyMCEPopup.editor,se=ed.selection,n=se.getNode(),el,self=this,href='',alt,sortables=true,ssl=false;$('button#insert').click(function(e){self.insert();e.preventDefault();});tinyMCEPopup.resizeToInnerSize();TinyMCE_Utils.fillClassList('date_class');TinyMCE_Utils.fillClassList('size_class');TinyMCE_Utils.fillClassList('classlist');el=ed.dom.getParent(n,"A")||ed.dom.getParent(n,"IMG");this._setupSortables();$.Plugin.init();WFPopups.setup();$('div.googledocs').toggleClass('hidden',!this.settings.googledocs.enable);$('label, :input','div.googledocs').addClass('disabled').prop('disabled',true);$('#googledocs_type').change(function(){var s=$(this).val()=='embed';$(this).siblings('label, input, select').toggleClass('disabled',!s).prop('disabled',!s);$('label[for="googledocs_ssl"], #googledocs_ssl','div.googledocs').removeClass('disabled').prop('disabled',false);self.toggleLayout(!s);if(s){$('#options_list').sortable('disable');}else{$('#options_list').sortable('enable');}
$('#popup_list').val('').prop('disabled',!!s).change();});if(el&&(ed.dom.is(el,'a.jce_file, a.wf_file')||ed.dom.is(el,'img.mceItemIframe.mceItemGoogleDocs'))){ed.selection.select(el);$('#insert').button('option','label',tinyMCEPopup.getLang('update','Update',true));var cls=ed.dom.getAttrib(el,'class');$('#classes').val(tinymce.trim(cls.replace(/mceItem([a-z]+)/gi,'').replace(/(wf|jce)_file/gi,'')));if(ed.dom.is(el,'img.mceItemIframe.mceItemGoogleDocs')){var data=$.parseJSON(ed.dom.getAttrib(n,'data-mce-json'));if(data&&data.iframe){var ssl=/^https:\/\//.test(v);$.each(data.iframe,function(k,v){if($('#'+k).is(':checkbox')){$('#'+k).prop('checked',!!v);}else{if(k=='src'){v=ed.convertURL(decodeURIComponent(v.replace(/(http(s)?:)?\/\/docs\.google\.com\/viewer\?url=/,'').replace(/&(amp;)?embedded=true/,'')));k='href';}
$('#'+k).val(v);}});}
$.each(['width','height'],function(i,k){var u,v=ed.dom.getAttrib(el,k);switch(k){case'width':case'height':v=ed.dom.getAttrib(el,k)||ed.dom.getStyle(el,k)||'';u=/%/.test(v)?'%':'';v=v.replace(/[^0-9]/g,'');$('#googledocs_'+k).val(v).data('tmp',v);$('#googledocs_'+k+'_unit').val(u);break;}
if($('#googledocs_width_unit').val()!==$('#googledocs_height_unit').val()){$('#constrain').prop('checked',false);}});$('label[for="googledocs_type"], #googledocs_type, label[for="googledocs_ssl"], #googledocs_ssl','div.googledocs').toggleClass('disabled',false).prop('disabled',false);$('#googledocs_type').val('embed').change();$('#googledocs_ssl').prop('checked',ssl);}else{var googledocs=false;href=ed.dom.getAttrib(el,'href');if(/\/\/docs.google.com\/viewer/i.test(href)){var ssl=/^https:\/\//.test(href);href=href.substr(href.indexOf('=')+1);googledocs=true;$('#googledocs_type').val('link').change();$('#googledocs_ssl').prop('checked',ssl);}
if(!$('div.googledocs').hasClass('hidden')){googledocs=googledocs||GoogleDocsRe.test(href);}
$('label[for="googledocs_type"], #googledocs_type, label[for="googledocs_ssl"], #googledocs_ssl','div.googledocs').toggleClass('disabled',!googledocs).prop('disabled',!googledocs);href=ed.convertURL(decodeURIComponent(href));$('#href').val(href);$.each(['title','id','style','dir','lang','tabindex','accesskey','class','charset','hreflang','target','rev'],function(i,k){$('#'+k).val(ed.dom.getAttrib(el,k));});$('#rel').val(function(){var v=ed.dom.getAttrib(n,'rel');if($('option[value="'+v+'"]',this).length==0){$(this).append(new Option(v,v));$(this).val(v);}});var options=$('li','#options_list').get();var ordered=[];$.each(el.childNodes,function(i,n){switch(n.nodeName){case'IMG':if(ed.dom.is(n,'.jce_icon, .wf_file_icon')){$('#option_icon_check').prop('checked',true);ordered.push($('#option_icon').get(0));}
break;case'#text':if(/[\w]+/i.test(n.data)){$('#option_text_check').prop('checked',true);$('#text').val(n.data);ordered.push($('#option_text').get(0));}
break;case'SPAN':var v=tinymce.trim(n.innerHTML);var cls=n.className.replace(/(wf|jce)_(file_)?(text|size|date)/i,'');if(ed.dom.is(n,'.wf_file_text')){$('#option_text_check').prop('checked',true);$('#text').val(v);ordered.push($('#option_text').get(0));}
if(ed.dom.is(n,'.jce_size, .jce_file_size, .wf_file_size')){$('input[type="text"]','#option_size').val(v);$('#option_size_check').prop('checked',true);$('#size_class').val(tinymce.trim(cls));ordered.push($('#option_size').get(0));}
if(ed.dom.is(n,'.jce_date, .jce_file_date, .wf_file_date')){$('input[type="text"]','#option_date').val(v);$('#option_date_check').prop('checked',true);$('#date_class').val(tinymce.trim(cls));ordered.push($('#option_date').get(0));}
break;}
if(n.nodeType==1&&!/(jce|wf)_(file_)?(icon|text|date|size)/.test(n.className)){sortables=false;}});if(ordered.length<options.length){$.each(options,function(i,n){if(ordered.indexOf(n)==-1){ordered.splice(i,0,n);}});}
$('#options_list').append(ordered);}
WFPopups.getPopup(n);}else{var sortables=true;var n=se.getNode();if(!n||n==ed.getBody()){$('#text').val(se.getContent({format:'text'}));}else{while(n&&ed.dom.isBlock(n)){n=n.firstChild;}
if(n){if(n.nodeType==3||(ed.dom.is(n,'img,b,strong,em,i,span')&&ed.schema.isValidChild('a',n.nodeName.toLowerCase()))){if(n.nodeName=='IMG'){sortables=false;}else{var v=se.getContent({format:'text'});$('#text').val(v);}}}}
$.Plugin.setDefaults(this.settings.defaults);$.each(this.settings.googledocs,function(k,v){$('#googledocs_'+k).val(v).change();});}
$('#options_disabled').toggle(!sortables);$('#options_enabled, div.googledocs').toggle(sortables);$('option[value="embed"]','#googledocs_type').prop('disabled',!sortables);if(sortables===false&&$('#googledocs_type').val()=='embed'){$('#googledocs_type').val('');}
WFFileBrowser.init('#href',{onFileClick:function(e,file){self.selectFile(file);},onFileInsert:function(e,file){self.selectFile(file);}});},insert:function(){var ed=tinyMCEPopup.editor;AutoValidator.validate(document);if($('#href').val()==''){$.Dialog.alert(tinyMCEPopup.getLang('filemanager_dlg.no_src','Please select a file or enter a file URL'));return false;}
if($('#text:enabled').val()==''&&$('#options_enabled').is(':visible')){$.Dialog.alert(tinyMCEPopup.getLang('filemanager_dlg.no_text','Text for the file link is required'));return false;}
this.insertAndClose();},insertAndClose:function(){tinyMCEPopup.restoreSelection();var ed=tinyMCEPopup.editor,se=ed.selection,n=se.getNode(),v,el,content,args={},html=[];if(tinymce.isWebKit){ed.getWin().focus();}
content=se.getContent();var ext=$.String.getExt($('#href').val());var options=$('#options_list').sortable('toArray');var format=this.settings.icon_format;var icon=format.replace('{$name}',this.settings.icon_map[ext],'i');icon=$.String.path(this.settings.icon_path,icon);if(icon.charAt(0)=='/'){icon=icon.substring(1);}
var data={icon:'<img class="wf_file_icon" src="'+icon+'" style="border:0px;vertical-align:middle;" alt="'+ext+'" />',date:'<span class="wf_file_date" style="margin-left:5px;">'+$('input:text','#option_date').val()+'</span>',size:'<span class="wf_file_size" style="margin-left:5px;">'+$('input:text','#option_size').val()+'</span>',text:'<span class="wf_file_text">'+$('#text').val()+'</span>'};var attribs=['href','title','target','id','style','class','rel','rev','charset','hreflang','dir','lang','tabindex','accesskey','type'];tinymce.each(attribs,function(k){var v=$('#'+k).val();if(k=='href'){v=$.String.encodeURI(v,true);}
if(k=='class'){v=$('#classes').val()||'';}
args[k]=v;});$.each(options,function(i,v){if($('input:checkbox','#'+v).is(':checked')){html.push(data[v.replace('option_','')]);}});var googledocs=$('#googledocs_type:enabled').val();if(googledocs){var protocol=$('#googledocs_ssl').prop('checked')?'https:':'';args.href=protocol+'//docs.google.com/viewer?url='+encodeURIComponent(decodeURIComponent($.URL.toAbsolute(args.href)));}
if(googledocs=='embed'){args.src=args.href+'&embedded=true';delete args.href;var json=this.serializeParameters(args);var w=$('#googledocs_width').val();var h=$('#googledocs_height').val();if(w){w+=$('#googledocs_width_unit').val();}else{w='100%';}
if(h){h+=$('#googledocs_height_unit').val();}else{h='100%';}
args={src:tinyMCEPopup.getWindowArg('plugin_url')+'/img/trans.gif','data-mce-json':json,width:w,height:h,alt:args.title||''};if(n&&ed.dom.is(n,'img.mceItemIframe.mceItemGoogleDocs')){ed.dom.setAttribs(n,args);}else{ed.execCommand('mceInsertContent',false,'<img id="__mce_tmp" src="javascript:;" />',{skip_undo:1});n=ed.dom.get('__mce_tmp');ed.dom.setAttrib(n,'id','');ed.dom.setAttribs(n,args);ed.dom.addClass(n,'mceItemIframe');ed.dom.addClass(n,'mceItemGoogleDocs');ed.undoManager.add();}}else{if(se.isCollapsed()){ed.execCommand('mceInsertContent',false,'<a href="#" id="__mce_tmp">'+html.join('')+'</a>',{skip_undo:1});el=ed.dom.get('__mce_tmp');}else{if(el=ed.dom.getParent(se.getNode(),"A")){if(!args.href){ed.dom.remove(el,true);}
el.innerHTML=html.join('');}else{var styles;if(tinymce.isWebKit){if(n&&n.nodeName=='IMG'){styles=n.style.cssText;}}
ed.execCommand('mceInsertLink',false,{'href':'#','id':'__mce_tmp'},{skip_undo:1});el=ed.dom.get('__mce_tmp');ed.dom.setAttrib(el,'id','');if(!$('#text').is(':hidden')){el.innerHTML=html.join('');}
if(styles){ed.dom.setAttrib(n,'style',styles);}}}
if(el){ed.dom.setAttribs(el,args);ed.dom.addClass(el,'wf_file');ed.dom.addClass(ed.dom.select('span.wf_file_size',el),$('#size_class').val());ed.dom.addClass(ed.dom.select('span.wf_file_date',el),$('#date_class').val());}}
WFPopups.createPopup(el);tinyMCEPopup.close();},serializeParameters:function(args){var ed=tinyMCEPopup.editor,data={};tinymce.each(args,function(v,k){if(v!==''){if(k=='src'){v=v.replace(/&amp;/gi,'&');}
data[k]=v;}});if(data.style){var style=ed.dom.parseStyle(data.style);style.border='none;';data.style=ed.dom.serializeStyle(style);}else{data.style="border:none;";}
var o={'iframe':data};return $.JSON.serialize(o);},_setupSortables:function(){var enabled=this.sortables;var sortlist=this.sortlist||{};$('li','#options_list').click(function(e){var el=e.target,p=this;var items=WFFileBrowser.get('getSelectedItems');if(el.disabled)
return;if($(el).is(':checkbox:checked, span.option_reload')){if($(el).is(':checkbox')&&$(el).siblings('input:text').val()){return;}
if($(p).is('#option_size, #option_date')&&items.length){$('#insert').prop('disabled',true);$(p).addClass('loading');var type=$(p).data('type');$.JSON.request('getFileDetails',$(items[0]).attr('id'),function(o){if(!o.error){$('input:text',p).val(o[type]);}
$('#insert').prop('disabled',false);$(p).removeClass('loading');});}}});$('#options_list').sortable({axis:'x',placeholder:"ui-state-highlight",start:function(event,ui){$(ui.placeholder).width($(ui.item).width());}});},toggleLayout:function(s){if(s){$('#options_list, #options_list input, #date_class, #size_class, #text, #target').removeClass('disabled').filter('input').not('#option_text_check').prop('disabled',false);}else{$('#options_list, #options_list input, #date_class, #size_class, #text, #target').addClass('disabled').filter('input').not('#option_text_check').prop('disabled',true);}},selectFile:function(file){var self=this;var dir=WFFileBrowser.getCurrentDir();var name=$(file).attr('title');var src=$(file).data('url');src=src.charAt(0)=='/'?src.substring(1):src;$('#href').val(src);var googledocs=false;if(!$('div.googledocs').hasClass('hidden')){googledocs=GoogleDocsRe.test(name);}
if(!googledocs){this.toggleLayout(true);}
$('label, input, select','div.googledocs').removeClass('disabled').prop('disabled',false).toggleClass('disabled',!googledocs).prop('disabled',!googledocs);$('#googledocs_type:enabled').change();$('input:text','#option_size').val($.String.formatSize($(file).data('size')));$('input:text','#option_date').val($.String.formatDate($(file).data('modified'),this.settings.date_format));if($('#googledocs_type:enabled').val()=='embed'){return;}
if(this.settings.replace_text==1){if($('#text').val()!==''&&this.settings.text_alert==1){$.Dialog.confirm(tinyMCEPopup.getLang('filemanager_dlg.replace_text','Replace file link text with file name?'),function(state){if(state){$('#text').val(name);}});}else{$('#text').val(name);}}},setClasses:function(v){$.Plugin.setClasses(v);},setDimensions:function(a,b){var tmp,$a=$('#'+a),av=$a.val(),$b=$('#'+b),bv=$b.val(),au=$('#'+a+'_unit').val(),bu=$('#'+b+'_unit').val();if($('#constrain').is(':checked')){if(av&&bv&&$a.data('tmp')&&$b.data('tmp')){if(au=='%'&&bu=='%'){tmp=av;}else if(au=='%'){tmp=Math.round(bv*av/100);}else{tmp=(bv/$a.data('tmp')*av).toFixed(0);}
$b.val(tmp).data('tmp',tmp);}}
$a.data('tmp',av);},setDimensionUnit:function(a,b){var $a=$('#'+a),av=$a.val(),$b=$('#'+b),bv=$b.val(),au=$('#'+a+'_unit').val(),bu=$('#'+b+'_unit').val();if($('#constrain').is(':checked')){if(av&&bv&&$a.data('tmp')&&$b.data('tmp')){$('#'+b+'_unit').val(au);if(au=='%'){$a.val(Math.round(av/$a.data('tmp')*100));$b.val(Math.round(bv/$b.data('tmp')*100));}else{$a.val(Math.round(av*$a.data('tmp')/100));$b.val(Math.round(bv*$b.data('tmp')/100));}}}}};window.FileManager=FileManager;tinyMCEPopup.onInit.add(FileManager.init,FileManager);})();