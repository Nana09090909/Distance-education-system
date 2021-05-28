function backbiteget(where){
$.ajax({type: 'GET', url:where,success: function (e){location.reload();}});
}
function backbitepost(where, what){ 
$.ajax({type: 'POST', url:where,data:what, success: function (e){location.reload();}});
}
function editprofile(where, proc){
var location= where;
$.ajax({type: 'POST', url:'index.php?r=register/'+proc, success: function (e){

$(e).insertAfter(location);
$(location).hide();

}});

}