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
            <div class="content">
                <div class="poll">
                    <div class="title">Примерный расчет на основе данных «Прогноз бюджет Я.Директа»</div>
                    <div class="items">
                        <div class="item active">
                            <p>Фраза по которой могут искать
                                <br>Ваш продукт в интернете</p>
                            <input type="text" id="phrases" placeholder="Цемент оптом">
                        </div>
                        <div class="item">
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
                        <div class="button help info-btn" data-modal-text="<p>Для определения людей, которым будет показано
                        объявление в РСЯ, Яндекс учитывает историю поисковых запросов. Другими словами, он находит тех,
                        кто вводил те или иные поисковые фразы в поисковике и показывает ваши рекламные баннеры. Поэтому,
                        подумайте, по какой фразе люди могут искать ваш продукт в поисковике.</p>
                        <p>Лучше Не использовать слишком широкие или узкие фразы, выбирайте что-то среднее. Например,
                        если вы продаёте яблоки Голден оптом, то лучше использовать самую очевидную фразу «Яблоки Голден
                        оптом».</p>
                        <p>При этом лучше Не использовать фразу «Яблоки» или «Яблоки купить», потому что это слишком
                        широкие фразы и вы будете получать огромное количество нецелевых переходов. Также лучше Не
                        использовать фразу «Яблоки Голден оптом купить недорого на рынке в Москве», потому что это очень
                        узкая фраза для РСЯ и скорее всего переходов по ней Не будет.</p>">Справка
                        </div>
                        <div class="button next">Далее <img src="/assets/images/arrow_right.png" alt="arrow"></div>
                    </div>
                </div>
                <div class="loading">
                    <p></p>
                    <img src="/assets/images/loader.svg" alt="loading">
                </div>
                <div class="result">
                    <div class="title">Прогнозируемый результат</div>
                    <div class="text">
                        <p>Теоретически в вашей теме, только по одной фразе <span class="phrases"></span>
                            возможно получать прибыль около <span class="money-per-month">0</span> руб. в месяц
                        </p>
                        <p>И таких фраз может быть очень много!</p>
                        <p>Ориентировочное кол-во заявок в месяц = <span class="count-of-request-per-month">0</span></p>
                        <p>Ориентировочное кол-во продаж в месяц = <span class="count-of-sales-per-month">0</span></p>
                        <p>Ориентировочная стоимость клиента = <span class="sas">0</span></p>
                        <div class="button reset">Рассчитать заново</div>
                    </div>
                    <div class="buttons hide">
                        <div class="button info-btn hide"
                             data-modal-text="Тогда рекомендую Вам продолжить<br> изучение сайта">Ничего страшного
                        </div>
                        <div class="button show-feedback">Что мне делать?</div>
                    </div>
                    <div class="modal feedback" id="Feedback">
                        <div>
                            <img src="/assets/images/close.png" alt="close">
                            <div class="text">Если хотите узнать какая методика подходит
                                для вашего случая просто заполните форму ниже
                            </div>
                            <div class="flex-line">
                                <input type="text" id="Name" placeholder="Ваше имя">
                                <input type="text" id="Email" placeholder="Ваш email">
                            </div>
                            <textarea name="question" id="Message" rows="4" placeholder="Введите вопрос"></textarea>
                            <div class="button submit">Узнать методику</div>
                        </div>
                    </div>
                </div>
                <div class="error">
                    <p></p>
                </div>
            </div>
            <div class="modal" id="InfoModal">
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