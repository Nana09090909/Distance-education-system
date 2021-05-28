<h3>Редактирование курса </h3>  
<input id="ecode" value="%%code%%" size="70"  type="hidden"/>
Название: <br/><input id="etitle" value="%%title%%" size="70" placeholder="Название" type="text"/><br/>
  Описание: <br/><textarea  id="edesc">%%desc%%</textarea><br/>
  Категория: <br/><select id="ecategory"><option value="none">Добавить категорию</option>%%categories%%</select><br/>
    Учитель:<br/><select id="eteacher"><option value="0">Не назначен</option>%%teacher%%</select><br/>
    Стоимость:<br/><br/><input id="eprice" value="%%price%%" size="70" type="text"/><br/>
    Количество кредитов:<br/><br/><input id="credits" value="%%credits%%" size="70" type="text"/><br/>
    Обязательный: <input id="obligatory" value="obligatory"  %%obligatory%%  type="checkbox"/><br/>
    
  <select id="status">%%status%%</select>
 <br/> <input value="Сохранить изменения" id="editcourse" type="button"/><br/>
 <script>
 $('#editcourse').click(function(){
     var what='title='+encodeURIComponent($('#etitle').val())+'&desc='+encodeURIComponent($('#edesc').val())+'&obligatory='+$('#obligatory').prop('checked')+'&credits='+$('#credits').val()+'&price='+$('#eprice').val()+'&category='+$('#ecategory').val()+'&code='+$('#ecode').val()+'&teacher='+$('#eteacher').val()+'&status='+$('#status').val();
$.ajax({type: 'POST', url:'index.php?r=administration/editcourse',data:what, success: function (e){
   
    $('#response').html(e);    
    }});

}); 
 </script>
