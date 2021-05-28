
<div class="text">
<select  onchange="limcat($(this).val())"><option value="">Выберите категорию курсов</option>%%options%%</select>    
<h2>Список курсов интернет-семинарии</h2>
<div id="list">%%list%%
<script>
$('.courselist').click(function(e){    
$('.coursedesc').hide();
if($(e.target).next().css('display')=='none'){
$(e.target).next().slideDown('slow');  
 }else{
$(e.target).parent().next().slideDown('slow'); 
}   

});
function limcat(cat){
    var where='#list';
$(where).html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=site/cats', data:'data='+cat, success: function (e){
    $(where).html(e);    
    }});
    }

$('.enrollbut').click(function(e){
   var data=$(e.target).attr('course');
   var warn=$(e.target).attr('warn');
var where='#enr'+data;
$(where).html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=classroom/enroll', data:'data='+encodeURIComponent(data), success: function (e){
    $(where).html(e+'<br/><small>'+warn+'</small>');    
    }});

});


</script>
<div style="float:left; width:100%; height: 20px " >
</div>
</div>

</div>
