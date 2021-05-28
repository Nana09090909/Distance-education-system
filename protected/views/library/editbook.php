<h3>Редактирование записи</h3>
Библиографическое описание<br/>
<textarea id="title" >%%title%%</textarea><br/>
Файл<br/>
<input size="150" type="text" value="%%file%%" id="file"/><br/>
<input type="hidden" value="%%id%%" id="id"/><br/>

<button class="save" onclick="var code =$('#title').val()+'%%SEPARATOR%%'+$('#file').val()+'%%SEPARATOR%%'+$('#id').val(); display('saveedit', code);"></button>