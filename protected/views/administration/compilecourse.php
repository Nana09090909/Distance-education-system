<h3>Тут происходит компиляция курса %%course%%</h3>
<table class="courses">
    %%framelist%%
</table>

<div>
Создать новый фрейм<br/>
<input type="text" placeholder="Название фрейма" id="newframetitle"/><br/>
<input type="hidden" value="%%code%%" id="code"/>
<select onchange="$('#newframedesc').val($(this).val())"><option>Выберите шаблон фрейма</option>%%frametemplates%%</select><br/>
<textarea id="newframedesc">
Описание фрейма
</textarea><br/>
<input type="button" id="newframe" value="Создать новый фрейм"/>
</div>
