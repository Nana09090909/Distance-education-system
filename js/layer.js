$(document).ready(function(){
/////

$("#pass").keypress(function(event) {
  if ( event.which == 13 ) { $('#login').trigger('click');    }
   });

$('.movable').draggable();


$('#login').click(function(){
$('#enterresp').html('<img src="images/progress.gif"/>');
var remember= $('#rememberme:checked').val()=='yes'?'&remember=yes':'';
var what='email='+$('#email').val()+'&password='+$('#pass').val()+remember;

$.ajax({type: 'POST', url:'index.php?r=enter',data:what, success: function (data){
        $('#enterresp').html(data);
}
    
})
});
/////////
$('#exit').click(function(){
$.ajax({type: 'GET', url:'index.php?r=enter/out',success: function (data){
        location.reload();
}
    
})
});

////////////
$('#enter').click(function(){

$('.login').slideDown('slow');
$('.wrapper').slideUp('slow');

});
////////////
$('#regfromenter').click(function(){

$('.login').slideUp('slow');
$('.register').slideDown('slow');

});

///////////////////
$('#reg').click(function(){
$('.register').slideDown('slow');
$('.wrapper').slideUp('slow');

});
////
$('#hidelogin').click(function(){
$('.login').slideUp();
$('.wrapper').slideDown();
});

$('.hidereg').click(function(){
$('.register').slideUp();
$('.wrapper').slideDown();
});
////////////////////////////////indxex.php?r=enter/out
$('#getkey').click(function(){
    
 var re=/^[ ]*[\w]+([\.\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}[ ]*$/;
 var email=$('#emailreg').val();
 if(!re.test(email)){ alert('Нужно ввести адрес электронной почты');$('#emailreg').focus(); return;}
 $('#regresponse').html('<img src="images/progress.gif"/>');
 $.ajax({type: 'GET', url:'index.php?r=register/prereg',data:'email='+email, success: function (e){
      
    $('#regresponse').html(e); 
    if(newwindow){
    var strUrl='http://mail.'+email.slice(email.indexOf('@')+1);
    window.open(strUrl, 'mail','height=300, width=300, resizable, location');}
 }});
  
});
////////////////////////////////
$('.teasers').click(function(e){
    $('.wrapper').slideUp('slow');
 var data=$(e.target).attr('id');
  display('teaser', data);
  
  $('#data').slideDown('slow');

});
////
if(location.hash){
$(location.hash).trigger('click');
    
}


///
$('#registerbutton').click(function(){

var re=/^[ ]*[\w]+([\.\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}[ ]*$/;
var email=$('#emailreg').val();
var key=$('#key').val();
if(!re.test(email)){ alert('Нужно ввести адрес электронной почты');$('#emailreg').focus(); return;}
$('#regresponse').html('<img src="images/progress.gif"/>');
$.ajax({type: 'GET', url:'index.php?r=register/fillform',data:'email='+email+'&key='+key, success: function (e){$('#regresponse').html(e);  
if(stophere){
    $('#regresponse').text('Вы ввели неправильный код! Попробуйте еще раз');
}else{$('#emailkey').hide();}     

}});
});
////////////////////////



function display(place,data){
var where=arguments[2]?arguments[2]:'#datacontent';
$(where).html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=site/'+place, data:'data='+encodeURIComponent(data), success: function (e){
    $(where).html(e);    
    }});

}



    })
    