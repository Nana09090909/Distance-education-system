$(document).ready(function(){ 
$('.pics1').hover( function(){$(this).animate({width:'250px'},'slow')},function(){$(this).animate({width:'50px'},'slow')});
$("#newlist").keypress(function(event) {
  if ( event.which == 13 ) {     location.replace('index.php?newlist='+$("#newlist").val());}
   });

									
									})
function start(a){
var mes=tinyMCE.activeEditor.getContent();

var sub=$('#theme').val();
if( mes==''){ alert('Надо что-то написать в послании'); return false;}
if( sub==''){ alert('Надо указать тему послания'); return false;}

var values = $('input:checkbox:checked').map(function (){return this.value;}).get();
var attach='';
if(values.length > 0){

for(i=0; i<=values.length-1; i++){
attach +=values[i]+'/';
}
}
switch(a){
case 'trythis':
address=new Array();
address[0]=document.getElementById('tempaddress').value;
var re = /^[ ]*[\w]+([\.\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}[ ]*$/
if(!re.test(address[0])){ alert('Адрес электронной почты введен неверно'); return;}else{sendmail(address,1, attach);}

break;
case 'dothis':
$.ajax({url:'getlist.php' , success:function(e){var address=e.split('^%%%%%%%^');	sendmail(address, address.length, attach);
}})
break;
case 'repeatthis':
$.ajax({url:'getlist.php?r=r' , success:function(e){var address=e.split('^%%%%%%%^');	sendmail(address, address.length, attach);
}})

break;

}
}

function sendmail(address, n, attach ){
var mes=tinyMCE.activeEditor.getContent();
mes=encodeURIComponent(mes);
var sub=$('#theme').val();
if(n== address.length){$('.sender').fadeIn('slow');  $('.editor').fadeOut('slow'); $.ajax({type:'POST', url:'hist.php?act=start', data:'message='+mes+'&sub='+sub});}
if( n > 0){ $('#message').text('Отсылается письмо по адресу: '+address[n-1]); var progr=100-n*100/ address.length; progr = Math.round(progr); $('#diagram').text('Задание выполнено на : '+progr+'%');	$(function() {$( "#progressbar" ).progressbar({value: progr});});
$.ajax({type: 'POST', url:'mail.php', data:'to='+address[n-1]+'&message='+mes+'&sub='+sub+'&attach='+attach, success:function(e){$('#message').text(e); n=n-1; sendmail(address, n, attach)}});
   }
if(n==0){
	$.ajax( {url:'hist.php?act=finish', success:function(e){$('#diagram').text('Задание выполнено на : 100%'); $(function() {$( "#progressbar" ).progressbar({value: 100});}); n=n-1; sendmail(address, n, attach);}}); 
}
if(n < 0){
	var finish ="<button onclick='shutdown()'>Рассылка завершена успешно</button>"
	$('#message').html(finish);
}

}

function shutdown(){
	$('.sender').fadeOut('slow'); 
	 $('.editor').fadeIn('slow');
	}
	
	
	function save(){
		var mes=tinyMCE.activeEditor.getContent();
		mes=encodeURIComponent(mes);
var sub=$('#theme').val();
		$.ajax({type: 'POST', data:'message='+mes+'&sub='+sub, url:'hist.php?act=save', success:function(e){ location.reload()}});
		
		}


function delattach(elem){
location.replace('index.php?delete='+elem);
		}
		function delpics(elem){
location.replace('index.php?deletepic='+elem);
		}
function managelist(todo){
$.ajax( {type: 'POST', url:'managelist.php?act='+todo, data:'newlist='+$('#addresses').val(),  success:function(e){ $('#addresses').val(e)  }}); 
}

function addill(name, address){
var scr= "<img  width=\"100px\" src=\""+address+"/mailpics/"+name+"\"/>";
var cont=tinyMCE.activeEditor.getContent();
tinyMCE.activeEditor.setContent(cont+scr);

}
function shownewlist(){
$('#newlistbutton').hide();
$('#newlist').show();

	
	}