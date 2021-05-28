
<input type="hidden" id="ecode" value="%%code%%"/><br/>
Название:<br/>
<input type="text" id="etitle" value="%%title%%"/><br/>
HTML:<br/>
<textarea id="ehtml">
%%html%%
</textarea><br/>
<textarea id="eparams">
%%params%%
</textarea><br/>
<input type="button" value="Сохранить изменения" id="editatype"/>
    
<script>
 $('#editatype').click(function(){
var what='title='+$('#etitle').val()+'&html='+encodeURIComponent($('#ehtml').val())+'&params='+$('#eparams').val()+'&code='+$('#ecode').val();
$.ajax({type: 'POST', url:'index.php?r=administration/editatype',data:what, success: function (e){
   
    $('#response').html(e);    
    }});

}); 
 </script>


