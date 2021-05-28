<div  style="margin:150px">
    <h2>Чтобы изменить пароль, введите его здесь</h2>
    <input type="hidden" id="key" value="%%key%%"/>
<input type="text" id="restorepass" placeholder="Введите не менее 7 букв латинского алфавита или цифр" />
<button onclick="restorepass()">Ввести</button>
</div>
<div id="wrestorepass"></div>
<script>
function restorepass(){
    

 $('#wrestorepass').html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=restorepass/setnewpass&key='+$('#key').val(), data:'data='+$('#restorepass').val()
    , success: function (e){
   alert(e);
   location.replace('index.php');
    }});

  
}
</script>