%%list%%
<script>
$('.courselist').click(function(e){    
$('.coursedesc').hide();
$(e.target).parent().next().slideDown('slow');    
});
function limcat(cat){
    var where='#list';
$(where).html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=site/cats', data:'data='+cat, success: function (e){
    $(where).html(e);    
    }});
    }
</script>