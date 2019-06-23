<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yandex API Forecast</title>
    <link rel="stylesheet" href="/assets/css/main.min.css">
</head>
<body>
<div class="main-back">
    <div class="calc-section">
        <div class="text">
            <img src="/assets/images/num_1.png" alt="num_1">
            <p class="title">Внимание эта методика подходит для 80% бизнесов</p>
            <p>Проверьте, насколько она будет эффективно
                <br>работать именно в вашем случае</p></div>
        <div class="text">
            <img src="/assets/images/num_2.png" alt="num_2">
            <p class="title">Воспользуйтесь калькулятором и определите:</p>
            <p>— Подходит ли вам данный метод
                <br>— Сколько заявок и какую прибыль вы сможете получать</p></div>
        <div class="calc">
            <div class="title">Примерный расчет на основе данных «Прогноз бюджет Я.Директа»</div>
            <div class="content">
                <div class="poll">
                    <div class="items">
                        <div class="item">
                            <p>Фраза по которой могут искать
                                <br>Ваш продукт в интернете</p>
                            <input type="text" id="phrases" placeholder="Цемент оптом">
                        </div>
                        <div class="item active">
                            <p>Регион в котором вы работаете</p>
                            <input type="text" id="region">
                            <input type="hidden" id="region-id">
                        </div>
                        <div class="item">
                            <p>Прибыль которую приносит
                                <br>1 клиент</p>
                            <input type="text" id="money" placeholder="1 000 000">
                        </div>
                        <div class="item">
                            <p>Скольким из 10 потенциальных
                                <br>клиентов обратившихся к вам
                                <br>вы сможете продать свой продукт</p>
                            <input type="text" id="leads" placeholder="5">
                        </div>
                    </div>
                    <div class="bar">
                        <div>
                            <div></div>
                        </div>
                    </div>
                    <p>*Фраза должна состоять из 2 или 3 слов (максимум 4)</p>
                    <div class="buttons">
                        <div class="button help modal-btn" data-modal="Будущая справка">Справка</div>
                        <div class="button next">Далее <img src="/assets/images/arrow_right.png" alt="arrow"></div>
                    </div>
                </div>
                <div class="result">
                    <div class="good">
                        <p>Теоретически в вашей теме, только по одной фразе Цемент оптом
                            возможно получать прибыль около <span>1 234 411 руб. в месяц</span></p>
                        <p>И таких фраз может быть очень много!</p>
                        <p>Ориентировочное кол-во заявок в месяц = <span>7</span></p>
                        <p>Ориентировочное кол-во продаж в месяц = <span>2</span></p>
                        <p>Ориентировочная стоимость клиента = <span>САС</span></p>
                        <div class="button reset">Рассчитать заново</div>
                    </div>
                </div>
            </div>
            <div class="modal">
                <div>
                    <img src="/assets/images/close.png" alt="close">
                    <div class="text"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/app.min.js"></script>
</body>
</html>