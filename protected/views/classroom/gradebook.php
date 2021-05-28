<img class="leadingimg" src="images/%%img%%.jpg"/> 
<table  border="1" class="grb">
<tr><td><h3>Курсы в процессе изучения:</h3>
%%actual%%</td></tr>
</table>
<table class="grb">
<tr><td><h3>Завершенные курсы:</h3>
%%passed%%</td></tr>
</table>
<script>
   
$('.quit').click(function(e){
     if(confirm( "Вы уверены, что хотите удалить данный курс? Все оценки при этом пропадут!")){
   var data=$(e.target).attr('course');
display('quit', data);}
});
    

</script>
