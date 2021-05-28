<h2>Поданы следующие заявки на оплату</h2>

<table class="courses">
    %%payments%%
</table>
<input id="givethem"  type="text" placeholder="Положить всем деньги"/><input type="button" value="да"/>
<div id="given"></div>
<script>
$('#givethem').next().click(
function (e){
    var sum=$('#givethem').val();
if(confirm('Действительно положить '+sum+' рублей на все счета')){
 
  display('givethem',sum,'#given');
    
}    
    
}

);
</script>