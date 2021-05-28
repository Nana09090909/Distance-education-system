<?php
$filmtempl=<<<a
<option value="<iframe width='840' height='560' src='http://www.youtube.com/embed/AhRtvUdzZXc?feature=player_detailpage' frameborder='0' allowfullscreen></iframe>">youtube</option>
<option value="<iframe id='moses' ser='1' width='840' height='560' src='http://www.youtube.com/embed/iRFjQftd7yw?feature=player_detailpage' frameborder='0' allowfullscreen></iframe>
<br/>
<div id='ser' style='color:red; font-size:18px; background:color:#EEEEEE; cursor:pointer'  onclick='moses()'>2 серия</div> 
<script>
function moses(){
if($('#moses').attr('ser')=='1'){
$('#ser').text('1 серия');
$('#moses').attr('ser','2');
$('#moses').attr('src','http://www.youtube.com/embed/LzysS72eoj8?feature=player_detailpage');
} else{
$('#ser').text('2 серия');
$('#moses').attr('ser','1');
$('#moses').attr('src','http://www.youtube.com/embed/iRFjQftd7yw?feature=player_detailpage');
}
}
</script>">youtube 2 серии</option>
<option value="<object width='650' height='452'><param name='video' value='http://static.video.yandex.ru/lite/faat-janbulat/3xujudwm37.4506/'></param><param name='allowFullScreen' value='true'></param><param name='scale' value='noscale'></param><embed src='http://static.video.yandex.ru/lite/faat-janbulat/3xujudwm37.4506/' type='application/x-shockwave-flash' width='650' height='452' allowFullScreen='true' scale='noscale' ></embed></object>">Яндекс-видео</option>
<option value="<object type='application/x-shockwave-flash' data='http://img.mail.ru/r/video2/uvpv3.swf?3' height='567' width='826' id='lecteur' align='middle'><param name='allowScriptAccess' value='always' /><param name='allowFullScreen' value='true' /><param name='flashvars' value='orig=2&movieSrc=mail/tanjashmykova/495/608' /><param name='scale' value='noscale' /><param name='menu' value='false' /><param name='movie' value='http://img.mail.ru/r/video2/uvpv3.swf?3' /></object>">mail.ru</option>
   

a;

?>
