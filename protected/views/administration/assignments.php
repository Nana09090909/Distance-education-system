<h3>Список видов заданий</h3>
<table class="courses">%%assignments%%
</table>
<div id="response"></div>
<b>Добавить новый вид</b><br/>
<input id="title" placeholder="Название типа задания" size="70" type="text"/><br/>
<input id="code" placeholder="Код типа" size="70" type="text"/><br/>
<textarea id="html" cols="70" rows="10">
Введите сюда html код задания. Параметры вставлять в виде %%param%%. 
Отредактируйте следующий код. Не меняйте расположение блоков и функцию submit!
 <div id="submitgroup">
 &#060;textarea id="submission"&#062; &#060;/textarea&#062;
  <input type="button" id="submit" onclick="if(confirm('Вы уверены, что заканчиваете задание? Материал задания после сдачи станет недоступным!')){submit('%%thisassignment%%')}" value="Сдать задание"/>
<input type="button" id="save" onclick="save('%%thisassignment%%')" value="Сохранить, но не сдавать"/>
</div>


</textarea><br/>
<textarea id="params" cols="70" rows="10">
Введите сюда параметры задания в формате содержания массива:
'сигнификатор'=>'Название',

</textarea><br/>
<input value="Создать" type="button" id="createnewtype"/>


