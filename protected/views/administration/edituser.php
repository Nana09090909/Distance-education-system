<h3>Редактирование юзера:</h3>
%%fields%%
<div id="addresp"></div>
<script>
$('#editsavechanges').click(function(e){
var data= 'lname='+$('#lname').val()+'&name='+$('#name').val()+'&key='+$('#key').val()+'&info='+$('#info').val()+'&fname='+$('#fname').val()+'&address='+$('#address').val()+'&phone='+$('#phone').val()+'&password='+$('#password').val()+'&skype='+$('#skype').val()+'&status='+$('#status').val()+'&email='+$('#email').val() ;

$.ajax({type: 'POST', url:'index.php?r=administration/saveuserchanges', data:data, success: function (e){
    $('#addresp').html(e);    
    }});

});
</script>