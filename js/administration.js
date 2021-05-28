$(document).ready(function(){
    

$('#newcourse').click(function(){
var what='title='+$('#title').val()+'&desc='+encodeURIComponent($('#desc').val())+'&category='+$('#category').val()+'&code='+$('#coursecode').val();
$.ajax({type: 'POST', url:'index.php?r=administration/newcourse',data:what, success: function (e){
   
    $('#response').html(e);    
    }});

}); 

$('#newframe').click(function(){
var what='title='+$('#newframetitle').val()+'&desc='+encodeURIComponent($('#newframedesc').val())+'&code='+$('#code').val();
$.ajax({type: 'POST', url:'index.php?r=administration/newframe',data:what, success: function (e){
   $('#response').html(e);    
    }});

}); 



$('#coursecode').change(function() 
{ 
    if($('#coursecode').val().length>2){
$.ajax({type: 'POST', url:'index.php?r=administration/checkcoursecode',data:'code='+$('#coursecode').val(), success: function (e){
   
    $('#response').html(e);    
    }});

}
}
);



$('#createnewtype').click(function(){
    
var what='title='+$('#title').val()+'&code='+$('#code').val()+'&html='+encodeURIComponent($('#html').val())+'&params='+$('#params').val();
var where='index.php?r=administration/newatype';
$.ajax({type: 'POST', url:where,data:what, success: function (e){
   $('#response').html(e);    
    }});
    
});
//// Конец тригеров
});
//////////

function display(place,code){
var where=arguments[2]?arguments[2]:'#response';

$.ajax({type: 'POST', url:'index.php?r=administration/'+place, data:'code='+encodeURIComponent(code), success: function (e){
    $(where).html(e);    
    }});

}


   
   