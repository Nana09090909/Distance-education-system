
<script>
function savenewass(){
var what='code='+$('#atypefield').val()+'&params='+encodeURIComponent($('#paramsarea').val())+'&frame=%%frame%%'+'&auto='+$('#auto').prop('checked');
$.ajax({type: 'POST', url:'index.php?r=administration/savenewass',data:what, success: function (e){
$('#response').html(e);    
}});
}
</script>
Добавление задания к фрейму номер %%order%%<br/>
<select id="atypefield" onchange="if(this.value !='0'){ $('.save').show();}else{$('.save').hide()}display('chooseparams',this.value, '#paramsfield');"><option value="0">Выберите вид задания</option>%%types%%</select>
<div id="paramsfield"></div>

<br/><br/>
<input style="display:none" type="button" class="save" onclick="savenewass()"/>

