<p><b>%%title%%</b><br/>
%%desc%%</p>
<script>
if( $('#gal').attr('pictnum')){
    
var n=$('#gal').attr('pictnum');
var ext=n.charAt(0)==0?'.gif':'.jpg';
var a= $('#gal').attr('address');
var n=n.charAt(0)?n:n.slice(1);
var txt='';
for(i=1; i<=n; i++){
txt+="<a target=\"_blank\" href=\"http://"+a+'/'+i+".jpg\"><img width=\"500\" src=\"http://"+a+'/'+i+ext+"\"></a>";
}
$('#gal').html(txt);
}





$('.submitted').click(function(e){
$(e.target).next().toggle('slow');
});
$('.reveal').click(function(e){
$(e.target).next().toggle('slow');
if($(e.target).text().indexOf('СКРЫТЬ')==-1){$(e.target).html('СКРЫТЬ<br/> <input title="Увеличить" style="background-image: url(\'images/magnifier.png\'); width:38px; height:38px; cursor:pointer"  type="button" value="+" onclick="var sz=0; if($(this).val()==\'-\'){$(this).val(\'+\');sz=16}else{$(this).val(\'-\');sz=24}$(this).parent().next().css(\'font-size\', sz+\'px\');"/><input type="button" style="background-image: url(\'images/printer.png\'); width:38px; height:40px; cursor:pointer" title="Распечатать" onclick="$(this).parent().next().css(\'max-height\', \'100%\'); window.print();$(this).parent().next().css(\'max-height\', \'400px\'); "/>');}
else{$(e.target).text('ПОКАЗАТЬ');}
});
</script>

%%assignments%%

 
             
      

<div id="progress"></div>
