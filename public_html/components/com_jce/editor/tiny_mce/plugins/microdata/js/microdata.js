/* jce - 2.6.5 | 2016-12-27 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2016 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
var MicrodataDialog={settings:{},init:function(){function callback(o,parent){if($("#itemtype").removeClass("loading").prop("disabled",!1),!o)return!1;if($.each(o,function(k,v){if(!filter.length||$.inArray(k,filter)!==-1){for(var subClassOf=o[k].subClassOf,ix=[];subClassOf&&subClassOf.length;)$.each(subClassOf,function(i,k){o[k]?(ix.push("-"),subClassOf=o[k].subClassOf):subClassOf=!1});$('<option data-name="'+k+'" title="'+ed.dom.encode(v.comment)+'" value="'+v.resource+'">'+ix.join("")+" "+k+"</option>").appendTo("#itemtype").addClass(function(){return!(ix.length>1)&&"microdata-itemtype"})}}),parent){var itemtype=ed.dom.getAttrib(parent,"data-microdata-itemtype");itemtype=itemtype.replace("http://schema.org/",""),$("#itemtype").val(itemtype).change()}}tinyMCEPopup.restoreSelection();var data,self=this,ed=tinyMCEPopup.editor,se=ed.selection,n=se.getNode(),update=!1;$("#insert").click(function(e){self.insert(),e.preventDefault()}),Wf.init(),$("input, select","#microdata_tab").prop("disabled",!0);var p=ed.dom.getParent(n,"[data-microdata-itemtype],[itemtype]");if(p&&(update=!0,$(".uk-button-text","#insert").text(tinyMCEPopup.getLang("update","Update",!0))),$(".itemtype-options").toggle(update),$("#itemtype-new, #itemtype-replace").prop("disabled",!update),window.sessionStorage){var s=sessionStorage.getItem("wf-microdata-schema");s&&(data=JSON.parse(s))}var filter=ed.getParam("microdata_filter",[]);$("#itemtype").change(function(){if(""===this.value)return void $("#itemprop, #itemid","#microdata_tab").prop("disabled",!0);$("#itemprop, #itemid","#microdata_tab").prop("disabled",!1);var props={},type=$("option:selected",this).data("name");if($(".itemprop").hide(),data){if(data[type]){props[type]=data[type].domainIncludes;for(var subClassOf=data[type].subClassOf;subClassOf.length;)$.each(subClassOf,function(i,k){props[k]=data[k].domainIncludes,subClassOf=data[k].subClassOf})}$("#itemprop").empty().append('<option value=""></option>'),$.each(props,function(k,v){if(v.length){var optgroup=$('<optgroup label="'+k+'" />');$.each(v,function(i,o){var option=new Option(o.label,o.label);$(option).attr("title",ed.dom.encode(o.comment)),$(optgroup).append(option)}),$("#itemprop").append(optgroup)}})}update&&($("#itemprop").val(ed.dom.getAttrib(n,"data-microdata-itemprop")).change(),$("#itemid").val(ed.dom.getAttrib(n,"data-microdata-itemid")).change()),$(".itemprop").show()}),data?callback(data,p):($("#itemtype").addClass("loading").prop("disabled",!0),Wf.JSON.request("getSchema",[],function(o){return!o||o.error||"string"==typeof o?(o.error||Wf.Dialog.alert(o||"Unable to load schema"),void callback(!1)):(callback(o,p),data=o,void(window.sessionStorage&&sessionStorage.setItem("wf-microdata-schema",JSON.stringify(o))))})),window.focus()},insert:function(){var ed=tinyMCEPopup.editor,se=ed.selection,n=se.getNode();tinyMCEPopup.restoreSelection();var isTextSelection=se.getContent()===se.getContent({format:"text"}),itemtype=$("#itemtype").val(),args={"data-microdata-itemprop":itemtype?$("#itemprop").val():null,"data-microdata-itemid":itemtype?$("#itemid").val():null},p=ed.dom.getParent(n,"[data-microdata-itemtype]"),blocks=[];if($.each(ed.schema.getBlockElements(),function(k,v){blocks.push(k.toUpperCase())}),(!p||$("#itemtype-new:visible").is(":checked"))&&(p=ed.dom.getParent(n,blocks.join(",")),!p||ed.dom.is(p,"[data-microdata-itemtype]"))){var fmt=ed.schema.isValidChild(p,"div")?"div":"microdata";ed.formatter.apply(fmt,{id:"__mce_tmp"}),p=ed.dom.get("__mce_tmp"),ed.dom.setAttrib(p,"id",null),p.innerHTML="<span>"+p.innerHTML||"</span>",n=p.firstChild,isTextSelection=!1}isTextSelection?itemtype?ed.formatter.apply("microdata",args):ed.formatter.remove("microdata-remove"):ed.dom.setAttribs(n,args),ed.dom.setAttribs(p,{"data-microdata-itemscope":itemtype?"itemscope":null,"data-microdata-itemtype":"http://schema.org/"+itemtype}),ed.undoManager.add(),tinyMCEPopup.close()}};$(document).ready(function(){MicrodataDialog.init()});