

function display(place,code){
var where=arguments[2]?arguments[2]:'#response';

$.ajax({type: 'POST', url:'index.php?r=library/'+place, data:'code='+encodeURIComponent(code), success: function (e){
    $(where).html(e);    
    }});

}


   
   