<script>
    
tinyMCE.init({mode : "textareas",oninit: addsaved, language : "ru",theme:"advanced",
plugins : "emotions,spellchecker,advhr,insertdatetime,preview, media", 
                
        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap,|, media",
        theme_advanced_buttons2 : "cut,copy,paste,|,spellchecker,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,forecolor,backcolor",         
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true


});
</script>
<h2>Редактирование информации о курсе</h2>
<textarea id="courseinfo"style="width:700px;heigh:800px;"></textarea>
<br/><button onclick="display('saveinfo',tinyMCE.activeEditor.getContent())">Сохранить</button>
<input type="hidden" id="saveddata" value="%%text%%"/>