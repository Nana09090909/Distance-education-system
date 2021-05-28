<div class="login">
        <div style="position:absolute; left:20%; width:250px;  top:50px; background-color:#FFFFFF; padding: 50px;"><span style="color:red; font-size:small; position: absolute; top:3px; right:3px; cursor:pointer" id="hidelogin">X</span>
        Авторизация:
    
        <p>
        <input placeholder="Введите email" id="email" type="text"/></p>
       <p>
        <input placeholder="Введите пароль"id="pass" type="password"/></p>
<p style="font-size:8px;">      <input type="checkbox" id="rememberme" checked="checked" value="yes"/> Запомнить меня на этом комьютере   <br/><a href="index.php?r=restorepass">Восстановить пароль</a><br/></p>
       
       <p>
        <input value="Войти" id="login" type="button"/></p>       
       <div style="color: red; font-size: 10px; text-decoration: crimson " id="enterresp"></div>
       <div id="regfromenter" class="enter">Зарегистрироваться</div>
     
        

</div>
               
    </div>
<div class="register">
<div style="position:absolute; right:10px; width:700px;  top:50px; background-color:#FFFFFF; padding: 50px;"><span style="color:red; font-size:small; position: absolute; top:3px; right:3px; cursor:pointer" class="hidereg">X</span>

<div id='quest' >
   <!--   <p style="color:red; font-size:20px"> ВНИМАНИЕ!<br/>РЕГИСТРАЦИЯ НА САЙТЕ ВРЕМЕННО ПРИОСТАНОВЛЕНА! ПОПРОБУЙТЕ ЗАЙТИ ПОЗЖЕ</p>  -->
      <p>
           <div id='regresponse' style="font-size:16px; color:red">Введите свой адрес электронной почты и секретный код<br/></div> 
           <div id="emailkey"><p>
        <input size="80" placeholder="Введите email" id="emailreg" type="text"/><br/> <input placeholder="Введите секретный код (оставьте пустым, если код пока не получен)" id="key" size="80"  type="text"/></p>
       <p>
        <input value="Зарегистрироваться" id="registerbutton" type="button"/><input value="Получить секретный код" id="getkey" type="button"/></p>
           </div>
</div>
</div>
    </div>
