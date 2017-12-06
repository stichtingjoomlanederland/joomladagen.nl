/* jce - 2.6.21 | 2017-11-29 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2017 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
!function(){var each=tinymce.each,Node=(tinymce.extend,tinymce.html.Node),tags=["a","abbr","acronym","address","applet","area","article","aside","audio","b","base","basefont","bdi","bdo","bgsound","big","blink","blockquote","body","br","button","canvas","caption","center","cite","code","col","colgroup","command","content","data","datalist","dd","del","details","dfn","dialog","dir","div","dl","dt","element","em","embed","fieldset","figcaption","figure","font","footer","form","frame","frameset","h1","h2","h3","h4","h5","h6","head","header","hgroup","hr","html","i","iframe","image","img","input","ins","isindex","kbd","keygen","label","legend","li","link","listing","main","map","mark","marquee","menu","menuitem","meta","meter","multicol","nav","nobr","noembed","noframes","noscript","object","ol","optgroup","option","output","p","param","picture","plaintext","pre","progress","q","rp","rt","rtc","ruby","s","samp","script","section","select","shadow","slot","small","source","spacer","span","strike","strong","style","sub","summary","sup","table","tbody","td","template","textarea","tfoot","th","thead","time","title","tr","track","tt","u","ul","var","video","wbr","xmp"],fontIconRe=/<([a-z0-9]+)([^>]+)class="([^"]*)(glyph|uk-)?(fa|icon)-([\w-]+)([^"]*)"([^>]*)>(&nbsp;|\u00a0)?<\/\1>/gi,paddedRx=/<(p|h1|h2|h3|h4|h5|h6|pre|div|address|caption)\b([^>]+)>(&nbsp;|\u00a0)<\/\1>/gi;tinymce.create("tinymce.plugins.CleanupPlugin",{init:function(ed,url){var self=this;this.editor=ed,ed.settings.verify_html===!1&&(ed.settings.validate=!1),ed.onPreInit.add(function(){function attrFilter(value,expr,check){return expr?"="===expr?value===check:"*="===expr?value.indexOf(check)>=0:"~="===expr?(" "+value+" ").indexOf(" "+check+" ")>=0:"!="===expr?value!=check:"^="===expr?0===value.indexOf(check):"$="===expr&&value.substr(value.length-check.length)===check:!!check}function replaceAttributeValue(nodes,name,expr,check){for(var node,i=nodes.length;i--;){node=nodes[i];var value=node.attr(name);value&&(expr&&!attrFilter(value,expr,check)||(node.attr(name,null),"src"!==name&&"href"!==name&&"style"!==name||node.attr("data-mce-"+name,null),"a"!==node.name||node.attributes.length||node.unwrap()))}}if(ed.settings.verify_html!==!1){var elements=ed.schema.elements;ed.getParam("pad_empty_tags",!0)||each(elements,function(v,k){v.paddEmpty&&(v.paddEmpty=!1)}),ed.getParam("table_pad_empty_cells",!0)||(elements.th.paddEmpty=!1,elements.td.paddEmpty=!1),each(elements,function(v,k){tinymce.inArray(tags,k)===-1&&ed.schema.addCustomElements(k)})}if(ed.settings.verify_html!==!1){var invalidAttribValue=ed.getParam("invalid_attribute_values","");invalidAttribValue&&each(tinymce.explode(invalidAttribValue),function(item){var matches=/([a-z0-9\*]+)\[([a-z0-9-]+)([\^\$\!~]?=)?["']?([^"']+)?["']?\]/i.exec(item);if(matches&&5==matches.length){var tag=matches[1],attrib=matches[2],expr=matches[3],value=matches[4];!attrib||expr||value||(expr=""),"undefined"!=typeof expr&&("*"==tag?ed.parser.addAttributeFilter(attrib,function(nodes,name){replaceAttributeValue(nodes,name,expr,value)}):ed.parser.addNodeFilter(tag,function(nodes,name){replaceAttributeValue(nodes,attrib,expr,value)}))}})}else ed.serializer.addNodeFilter(ed.settings.invalid_elements,function(nodes,name){var node,i=nodes.length;if(ed.schema.isValidChild("body",name))for(;i--;)node=nodes[i],node.remove()}),ed.parser.addNodeFilter(ed.settings.invalid_elements,function(nodes,name){var node,i=nodes.length;if(ed.schema.isValidChild("body",name))for(;i--;)node=nodes[i],"span"===name&&node.attr("data-mce-type")||node.unwrap()});ed.parser.addNodeFilter("a,i,span",function(nodes,name){for(var node,cls,i=nodes.length;i--;)node=nodes[i],cls=node.attr("class"),cls&&!node.firstChild&&(node.attr("data-mce-bootstrap","1"),node.append(new Node("#text","3")).value=" ")}),ed.serializer.addAttributeFilter("data-mce-bootstrap",function(nodes,name){for(var node,fc,i=nodes.length;i--;)node=nodes[i],fc=node.firstChild,node.attr("data-mce-bootstrap",null),!fc||" "!==fc.value&&"&nbsp;"!==fc.value||fc.remove()}),ed.parser.addAttributeFilter("onclick,ondblclick",function(nodes,name){for(var node,i=nodes.length;i--;)node=nodes[i],node.attr("data-mce-"+name,node.attr(name)),node.attr(name,"return false;")}),ed.serializer.addAttributeFilter("data-mce-onclick,data-mce-ondblclick",function(nodes,name){for(var node,k,i=nodes.length;i--;)node=nodes[i],k=name.replace("data-mce-",""),node.attr(k,node.attr(name)),node.attr(name,null)}),ed.serializer.addNodeFilter("br",function(nodes,name){var node,i=nodes.length;if(i)for(;i--;)node=nodes[i],node.parent&&"body"===node.parent.name&&!node.prev&&node.remove()}),ed.parser.addNodeFilter("br",function(nodes,name){var node,i=nodes.length;if(i)for(;i--;)node=nodes[i],node.parent&&"body"===node.parent.name&&!node.prev&&node.remove()})}),ed.settings.verify_html===!1&&ed.addCommand("mceCleanup",function(){var bm,s=ed.settings,se=ed.selection;bm=se.getBookmark();var content=ed.getContent({cleanup:!0});s.verify_html=!0;var schema=new tinymce.html.Schema(s);content=new tinymce.html.Serializer({validate:!0},schema).serialize(new tinymce.html.DomParser({validate:!0},schema).parse(content)),ed.setContent(content,{cleanup:!0}),se.moveToBookmark(bm)}),ed.onBeforeSetContent.add(function(ed,o){if(o.content=o.content.replace(/^<br>/,""),o.content=self.convertFromGeshi(o.content),ed.settings.validate&&ed.getParam("invalid_attributes")){var s=ed.getParam("invalid_attributes","");o.content=o.content.replace(new RegExp("<([^>]+)("+s.replace(/,/g,"|")+')="([^"]+)"([^>]*)>',"gi"),"<$1$4>")}o.content=o.content.replace(fontIconRe,'<$1$2class="$3$4$5-$6$7"$8>&nbsp;</$1>'),o.content=o.content.replace(/<(a|i|span)\b([^>]+)><\/\1>/gi,"<$1$2>&nbsp;</$1>")}),ed.onPostProcess.add(function(ed,o){o.set&&(o.content=self.convertFromGeshi(o.content)),o.get&&(o.content=self.convertToGeshi(o.content),o.content=o.content.replace(/<a([^>]*)class="jce(box|popup|lightbox|tooltip|_tooltip)"([^>]*)><\/a>/gi,""),o.content=o.content.replace(/<span class="jce(box|popup|lightbox|tooltip|_tooltip)">(.*?)<\/span>/gi,"$2"),o.content=o.content.replace(/_mce_(src|href|style|coords|shape)="([^"]+)"\s*?/gi,""),ed.settings.validate===!1&&(o.content=o.content.replace(/<body([^>]*)>([\s\S]*)<\/body>/,"$2"),ed.getParam("remove_tag_padding")||(o.content=o.content.replace(/<(p|h1|h2|h3|h4|h5|h6|th|td|pre|div|address|caption)\b([^>]*)><\/\1>/gi,"<$1$2>&nbsp;</$1>"))),ed.getParam("table_pad_empty_cells",!0)||(o.content=o.content.replace(/<(th|td)([^>]*)>(&nbsp;|\u00a0)<\/\1>/gi,"<$1$2></$1>")),o.content=o.content.replace(fontIconRe,'<$1$2class="$3$4$5-$6$7"$8></$1>'),o.content=o.content.replace(/<(a|i|span)([^>]+)>(&nbsp;|\u00a0)<\/\1>/gi,"<$1$2></$1>"),ed.getParam("remove_div_padding")&&(o.content=o.content.replace(/<div([^>]*)>(&nbsp;|\u00a0)<\/div>/g,"<div$1></div>")),ed.getParam("pad_empty_tags",!0)===!1&&(o.content=o.content.replace(paddedRx,"<$1$2></$1>")),ed.getParam("keep_nbsp",!0)&&"raw"===ed.settings.entity_encoding&&(o.content=o.content.replace(/\u00a0/g,"&nbsp;")))}),ed.onSaveContent.add(function(ed,o){if(ed.getParam("cleanup_pluginmode")){var entities={"&#39;":"'","&amp;":"&","&quot;":'"',"&apos;":"'"};o.content=o.content.replace(/&(#39|apos|amp|quot);/gi,function(a){return entities[a]})}}),ed.addButton("cleanup",{title:"advanced.cleanup_desc",cmd:"mceCleanup"})},convertFromGeshi:function(h){return h=h.replace(/<pre xml:lang="([^"]+)"([^>]*)>(.*?)<\/pre>/g,function(a,b,c,d){var attr="";return c&&/\w/.test(c)&&(attr=c.split(" ").join(" data-geshi-")),'<pre data-geshi-lang="'+b+'"'+attr+">"+d+"</pre>"})},convertToGeshi:function(h){return h=h.replace(/<pre([^>]+)data-geshi-lang="([^"]+)"([^>]*)>(.*?)<\/pre>/g,function(a,b,c,d,e){var s=b+d;return s=s.replace(/data-geshi-/gi,"").replace(/\s+/g," ").replace(/\s$/,""),'<pre xml:lang="'+c+'"'+s+">"+e+"</pre>"})}}),tinymce.PluginManager.add("cleanup",tinymce.plugins.CleanupPlugin)}();