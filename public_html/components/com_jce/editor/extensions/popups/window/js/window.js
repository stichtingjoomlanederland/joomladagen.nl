/* jce - 2.6.5 | 2016-12-27 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2016 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
var JCEWindowPopup={setDimensions:function(w,h){Wf.setDimensions(w,h,"window_popup_")}};WFPopups.addPopup("window",{setup:function(){},check:function(n){var ed=tinyMCEPopup.editor,oc=ed.dom.getAttrib(n,"onclick")||ed.dom.getAttrib(n,"data-mce-onclick");return oc&&/window\.open/.test(oc)},remove:function(n){this.check(n)&&(n.removeAttribute("onclick"),n.removeAttribute("data-mce-onclick"))},getAttributes:function(n){var ed=tinyMCEPopup.editor,data={},click=ed.dom.getAttrib(n,"onclick")||ed.dom.getAttrib(n,"data-mce-onclick"),data=click.replace(/window\.open\((.*?)\);(return false;)?/,function(a,b){return b}),parts=data.split(",'"),src=parts[0],query=Wf.String.query(src),title=(parts[1]||"").replace("'",""),features=(parts[2]||"").replace(/'$/,""),data={};query.img&&(data.src=query.img),$("#window_popup_title").val(title),features=Wf.String.query(features.replace(/,/g,"&")),$.each(features,function(k,v){switch(k){case"width":case"height":$("#window_popup_"+k+", #popup_"+k).val(v);break;case"scrollbars":case"resizable":case"location":case"menubar":case"status":case"toolbar":$("#window_popup_"+k).attr("checked","yes"==v);break;case"top":case"left":v=v.indexOf("screen")!==-1?v.indexOf("/2-")!==-1?"center":v.indexOf("Width")!==-1?"right":"bottom":k,0==$('option[value="'+v+'"]',"#window_popup_position_"+k).length&&$("#window_popup_position_"+k).append('<option value="'+v+'">'+v+"</option>"),$("#window_popup_position_"+k).val(v)}})},setAttributes:function(n,args){var ed=tinyMCEPopup.editor,args=args||{};this.remove(n);var src=ed.dom.getAttrib(n,"href"),title=$("#window_popup_title").val()||args.title||"",width=args.width||$("#window_popup_width").val(),height=args.height||$("#window_popup_height").val(),href=src,query="this.href";if(/\.(jpg|jpeg|png|gif|bmp|tiff)$/i.test(src)){var params={img:src,title:title.replace(" ","_","gi")};width&&(params.width=width),height&&(params.height=height),href="index.php?option=com_jce&view=popup&tmpl=component",query="this.href+'&"+decodeURIComponent($.param(params))+"'"}var top=$("#window_popup_position_top").val();switch(top){case"top":top=0;break;case"center":top=height?"'+(screen.availHeight/2-"+height/2+")+'":0;break;case"bottom":top=height?"'+(screen.availHeight-"+height+")+'":0}var left=$("#window_popup_position_left").val();switch(left){case"left":left=0;break;case"center":left=width?"'+(screen.availWidth/2-"+width/2+")+'":0;break;case"right":left=height?"'+(screen.availWidth-"+width+")+'":0}var features={scrollbars:"yes",resizable:"yes",location:"yes",menubar:"yes",status:"yes",toolbar:"yes"};$.each(features,function(k,def){var v=$("#window_popup_"+k).is(":checked")?"yes":"no";v!=def&&(features[k]=v)}),$.extend(features,{left:left,top:top}),width&&(features.width=width),height&&(features.height=height),ed.dom.setAttrib(n,"href",href),ed.dom.setAttrib(n,"data-mce-onclick","window.open("+query+",'"+encodeURIComponent(title)+"','"+decodeURIComponent($.param(features)).replace(/&/g,",")+"');return false;")}});