<select id="already" onchange="if($(this).val()!=0){display('showstudent',$(this).val(),'#editstudent'); $('#yet').val('0');$('#name').text($('#already option:selected').text())}"><option value="0">Записанные студенты</option>%%in%%</select><select id="yet" onchange="makeenrbut()"><option value="0"> Незаписанные студенты</option>%%out%%</select>
<div id="name" style="font-size: 20px"></div>
<div id="editstudent">
    
    
</div>
<script>
function makeenrbut(){
   if($('#yet').val()=='0'){$('#editstudent').html('');
       $('#name').text('');
       return;
   }

   var but= "<input type=\"button\" onclick=\"enroll('"+$('#yet').val()+"%SEPARATOR%0')\" value=\"Записать без оплаты\"/> <input type=\"button\" onclick=\"enroll('"+$('#yet').val()+"%SEPARATOR%1')\" value=\"Записать с оплатой\"/>";
$('#editstudent').html(but);
$('#already').val('0'); 
$('#name').text($('#yet option:selected').text());
}

function enroll(student){
    display('enroll',student);
}
</script>