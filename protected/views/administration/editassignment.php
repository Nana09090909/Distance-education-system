<h2 onclick="$(this).next().toggle()">Предпросмотр:</h2>
<div style="display:none">
    %%html%%
</div>
Автозачет<br/>
<input type="checkbox" %%auto%% value="auto"  id="auto"/>
<textarea>
%%params%%
</textarea>
<input type="button" class="save" onclick="var ass=$(this).prev().val()+'/SEPARATOR/%%id%%/SEPARATOR/'+$(this).prev().prev().prop('checked'); display('saveassignment',ass)"/>
<input type="button" class="del" onclick="if(confirm('Подтвердите удаление этого задания')){display('deleteassignment','%%id%%')}"/>
<br/>
<h3>Смена типа задания</h3>
<select id="atypefield" onchange="if(this.value !='0'){ $('.save').show();}else{$('.save').hide()}display('chooseparams',this.value, '#paramsfield');"><option value="0">Выберите вид задания</option>%%types%%</select>
<div id="paramsfield"></div>

<br/><br/>
<input style="display:none" type="button" class="save" onclick="changeasstype()"/>
<script>
function changeasstype(){
var what='code='+$('#atypefield').val()+'&params='+encodeURIComponent($('#paramsarea').val())+'&id=%%id%%'+'&auto='+$('#auto').prop('checked');
$.ajax({type: 'POST', url:'index.php?r=administration/changeasstype',data:what, success: function (e){
$('#response').html(e);    
}});
}
</script>


