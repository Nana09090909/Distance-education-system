
<h2> Перед началом обучения, мы просим, по возможности, сделать пожертвование на развитие дистанционной программы МБС. %%coursename%%</h2>
<h3>Рекомендованная сумма для покрытия стоимости данного курса: %%sum%% рублей.</h3>
<p>Пожертвование является добровольным и не обязательным для начала занятий.</p>
<button style="width:500px; height:100px; font-size: 1.5em; color:red; float:left" onclick="dontpay()">Начать прохождение курса.</button> 




<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/quickpay/shop-widget?account=41001181824116&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=%%urlencode%%&targets-hint=&default-sum=%%priceplus%%&button-text=01&comment=on&hint=&successURL=" width="450" height="290"></iframe>


<div> Переведите деньги на счет вручную. Номер кошелька <span style="font-size:24px; color:red"> 41001181824116</span>.<br/> 
    <a href="https://money.yandex.ru/prepaid/?from=imainprep" target="_blank">Как можно пожертвовать</a>.
    ИЛИ
    <h4>Пожертвовать через PayPal</h4>
    <div id="paypal">Переведите даннуй сумму на адрес paypal@mbis.su.
    </div>
 
            





</div>


<script>
function paywithmy(){
    if(confirm('Вы подтверждаете оплату?')){display('paywithmy','%%sum%%' )}
    
}
function dontpay(){
    display('dontpay')
    
}
</script>