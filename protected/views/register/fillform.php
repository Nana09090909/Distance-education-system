<script> var stophere=false;</script>
<style type="text/css">
    #ireg:hover{
        color:red;
    }
</style>
<div style="position:fixed; top:400px; left:20px; width: 400px; "><p style="color:white; font-size:16px; font-weight: bold; cursor: pointer" onclick="$('#promotionperson').slideDown('slow'); $('#promotioninvite').slideUp('slow'); " id="promotioninvite"><span id="ireg"> Я регистрируюсь по рекоммендации <br/> студента программы</span></p>
    <!--<div id="promotionperson" style="display: none; background-color: white; padding: 20px; color:black">
        <p style="text-align: right; color:red;  margin:20px;  cursor: pointer" onclick="$('#promotioninvite').slideDown('slow'); $('#promotionperson').slideUp('slow'); ">X</p>
        <p style="color:black">Введите адрес элекстронной почты студента, который вас пригласил, чтобы получить 100 руб. на счет.</p>
        <input placeholder="Email приглашающего студента" style="width:300px" id="inviteremail" type="text"/>
        
    </div> 
-->


</div>
<div id='quest'>
 <div style="color:red; font-weight: bold; font-size: 16px;">Внимание! Регистрация на данном сайте временно приостановлена. </div>
 <!--
<h2>Регистрация:</h2>
        <p>
        <input placeholder="Фамилия" id="lname" type="text"/><span style="color:red">*</span>
        <input placeholder="Имя" id="name" type="text"/><span style="color:red">*</span>
        <input placeholder="Отчество" id="fname" type="text"/><span style="color:red">*</span></p>
       <p> <input placeholder="Страна" id="country" type="text"/><span style="color:red">*</span>
        <input placeholder="Индекс" id="zip" type="text"/><span style="color:red">*</span>
        <input placeholder="Полный адрес" id="address" type="text"/><span style="color:red">*</span></p>
        <p>
        <input placeholder="Телефон (межд. формат)" id="phone" type="text"/><span style="color:red">*</span>
        <input placeholder="Скайп" id="skype" type="text"/><span style="color:red">*</span></p>
        <p> Расскажите немного о себе: <br/>
        <textarea id="info" cols="50" rows="5" >образование, членство в церкви, семейное положение и.т.п.</textarea>
        </p>
        
       <p>
        <input placeholder="Пароль(мин.7 знаков)" id="passreg" type="password"/><span style="color:red">*</span>
       <input placeholder="Повторите пароль" id="passreg1" type="password"/><span style="color:red">*</span></p>
      <p style="font-size:10px">Нажимая кнопку "Зарегистрироваться", я принимаю условия <a href="assets/agreement.htm" target="_blank">Пользовательского соглашения</a></p>
        <input value="Зарегистрироваться" onclick="checkreg()" type="button"/></p>
</div>
        
      </div>  
    </div>
 -->
    <script>
    
function checkreg(){
var re=/^[ ]*[\w]+([\.\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}[ ]*$/;
if($('#lname').val()==''){ alert('Нужно ввести фамилию');$('#lname').focus(); return;}
if($('#name').val()==''){ alert('Нужно ввести имя'); $('#name').focus(); return;}
if($('#fname').val()==''){ alert('Нужно ввести отчество'); $('#fname').focus(); return;}
if($('#country').val()==''){ alert('Нужно ввести страну'); $('#country').focus(); return;}
if($('#zip').val()==''){ alert('Нужно ввести индекс'); $('#zip').focus(); return;}
if($('#address').val()==''){ alert('Нужно ввести адрес'); $('#address').focus(); return;}
if($('#phone').val()==''){ alert('Нужно ввести номер телефона'); $('#phone').focus(); return;}
if($('#skype').val()==''){ alert('Нужно ввести номер скайпа'); $('#skype').focus(); return;}
if($('#passreg').val()<=6){ alert('Пароль должен быть больше 7 знаков'); $('#passreg').focus(); return;}
if($('#passreg1').val()!=$('#passreg').val()){ alert('Пароли не совпадают'); $('#passreg').focus(); return;}
var what='email='+$('#emailreg').val()+'&pass='+ $('#passreg').val()+'&lname='+ encodeURIComponent($('#lname').val())+'&name='+$('#name').val()+'&fname='+ $('#fname').val()+'&address=Страна: '+ $('#country').val()+', индекс: '+ $('#zip').val()+', адрес: '+ encodeURIComponent($('#address').val())+'&phone='+ $('#phone').val()+'&skype='+ $('#skype').val()+'&info='+ $('#info').val()+'&promo='+ $('#inviteremail').val();
$('#regresponse').html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=register/finish',data:what, success: function (data){
$('#regresponse').html(data);
}});
}



</script>