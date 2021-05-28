<h3>Новое письмо</h3>
Адресат<br/> <select id="stud"><option value="0" >Выбeрите получателя </option> %%students%%</select>
<br/>
<input type="text" id="theme" placeholder="Тема письма"/>
<br/>
<textarea id="letter">
Текст письма
</textarea><br/>
<button <button  onclick="if($('#stud').val()=='0'){return;} var v=$('#letter').val()+'%%SEPARATOR%%'+$('#stud').val()+'%%SEPARATOR%%'+$('#theme').val();  display('sendresponse',v)">Послать</button><br/><hr/>

<h2>Список вопросов пользователей</h2>

%%text%%
<p><button onclick="display('feedbackold','')">История вопросов </button></p>