<div  style="margine:150px">
<h2>Для восстановления забытого пароля введите адрес электронной почты</h2>
<input type="text" size="25" id="restorepass" />
<button onclick="restorepass()"> Восстановить пароль</button>
</div>
<div id="wrestorepass"></div>
<script>
function restorepass(){
 $('#wrestorepass').html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=restorepass/sendmail', data:'data='+$('#restorepass').val()
    , success: function (e){
    $('#wrestorepass').html(e);    
    }});

  
}
</script>