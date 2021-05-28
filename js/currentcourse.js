$(document).ready(function(){
$('#question').click(function(){     

   $('#questionbody').toggle();
    }
   );
$('.menu').click(function(e){
    
 var data=$(e.target).attr('id');
 $('.menu').css('color','white');
  $(e.target).css('color','#e8fc08')
  if(data !='mailing'){ display(data, window.location.search ); }else{ window.open('index.php?r=maillist/course')}
});
/////////

$('.draggable').draggable();


});


function display(place,data){
var where=arguments[2]?arguments[2]:'#content';
$(where).html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=currentcourse/'+place, data:'data='+encodeURIComponent(data), success: function (e){
    $(where).html(e);    
    }});

}

function tryme(){
$.ajax({type: 'POST', url:'index.php?r=currentcourse/tryme', data:'', success: function (e){
location.reload();    
}});

}
function showassignment(id){
$('#assignment').slideDown('slow');
$('#visible').slideUp('slow');
$('#assignmentcontent').html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=currentcourse/showassignment', data:'id='+id, success: function (e){
 $('#assignmentcontent').html(e);
    
tinyMCE.init({mode : "exact",elements:"submission", oninit: addsaved, language : "ru",theme:"advanced",
plugins : "autolink,lists,save,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
gecko_spellcheck:true,

                
        /// Theme options
		theme_advanced_buttons1 : "newdocument, |,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
	

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Жирный текст', inline : 'b'},
			{title : 'Красный текст', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Синий заголовок', block : 'h1', styles : {color : '#0000ff'}},
		
		]


});

    }});
}
function addsaved(){
var subss=$('#saveddata').val();
var ini=$('#ini').val();
var ins=subss==''?ini:subss;
tinyMCE.activeEditor.setContent(ins);
}
function allback(){
$('#assignment').slideUp('slow');
$('#visible').slideDown('slow');
$('#assignmentcontent').html('');

}

function save(id){
    $('#progress').html('<img src="images/progress.gif"/>');  
    var r= tinyMCE.activeEditor.getContent()
var d=encodeURIComponent(r);
$.ajax({type: 'POST', url:'index.php?r=currentcourse/savesubmission&id='+id, data:'data='+d, success: function (e){
      tinyMCE.activeEditor.setContent(r+e)
    
    $('#progress').html('');
    }});

}
function submit( id){
$('#progress').html('<img src="images/progress.gif"/>');  
    var d=tinyMCE.activeEditor.getContent();
 d=d.replace(/&nbsp;/,'');   
  d=encodeURIComponent(d);
$.ajax({type: 'POST', url:'index.php?r=currentcourse/submitass&id='+id, data:'data='+d, success: function (e){

$('#submitgroup').html(e+'<br/><button onclick="location.reload()">OK</button>');    
    $('#progress').html('');

    }});

}
function submitfull( what, id){// Только одно задание на странице!
$('#progress').html('<img src="images/progress.gif"/>');  
var d=encodeURIComponent(what);
$.ajax({type: 'POST', url:'index.php?r=currentcourse/submitass&id='+id, data:'data='+d, success: function (e){
$('#submitgroup').html(e);    
    $('#progress').html('');

    }});

}
function kickhim(student){
if(!confirm('Подтвердите исключение студента. При этом пропадут все его задания!')){return;}
display('kickhiim',student);
}
function gradecourse(student){
display('gradecourse',$('#finalgrade').val()+'%%'+student+'%%'+$('#givemoney').prop('checked'),'#response' );
    
}
function grade(assignment, student, place){
var data=assignment+'%%SEPARATOR%%'+student+'%%SEPARATOR%%'+$(place).prev().val()+'%%SEPARATOR%%'+$(place).prev().prev().val();
display('gradeass',data,'#response');

}