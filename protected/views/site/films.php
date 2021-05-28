<div class="text"><h2>Видеотека МБИС</h2>
    <select onchange="limitcat($(this).val())"><option value="0">Все фильмы</option>%%cat%%</select>
    <br/>
    <div>%%text%%</div>
    <div>%%admin%%</div>
    %%jadmin%%
    <script>
function limitcat(cat){
 $('.text').html('<img src="images/progress.gif"/>');
 $.ajax({type: 'POST', url:'index.php?r=site/films', data:'cat='+cat, success: function (e){
 $('.text').html(e); 
  }});   
}
function showfilm(id){
    $('.text').html('<img src="images/progress.gif"/>');  
   $.ajax({type: 'POST', url:'index.php?r=filmshow/start', data:'id='+id, success: function (e){
 $('.text').html(e); 
  }});    
    
}


</script>

</div>