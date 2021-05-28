<h2>Библиотека для ДО</h2>
%%list%%
<h3>Новая книга</h3>
Библиографическое описание книги<br/>
<textarea id="bookdesc" style="width:500px; heigh:350px"></textarea><br/>
Файл<br/>
<input type="text" id="bookfile"/><br/>
<input type="button" value="Ввести новую книгу" onclick="var code =$('#bookdesc').val()+'%%SEPARATOR%%'+$('#bookfile').val(); display('newbook', code);"/><br/>

