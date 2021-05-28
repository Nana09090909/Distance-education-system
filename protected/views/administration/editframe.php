<h3>Редактирование фрейма</h3>

<input type="text" value="%%title%%" id="frametitle"/>
<textarea id="framedesc">
%%desc%%
</textarea>
<input type="hidden" value="%%code%%" id="code"/>
<input type="button" class="save" onclick="var sep='%%SEPARATOR%%'; var what=$(this).prev().val()+sep+$(this).prev().prev().val()+sep+$(this).prev().prev().prev().val(); display('saveedittedframe',what)"/>
