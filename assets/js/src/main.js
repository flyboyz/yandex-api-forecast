'use strict';

require('webpack-jquery-ui/autocomplete');

$(function () {
    let $calc = $('.calc');
    let $calcTitle = $('.calc').find('.title');
    let $next = $calc.find('.next');
    let $modal = $calc.find('.modal');
    let $modalDiv = $modal.find('div');
    let $items = $calc.find('.item');
    let $loading = $('.calc').find('.loading');
    let $result = $calc.find('.result');

    // Close modal by click on overlay
    $(document).on('click', function (e) {
        if ($modalDiv.has(e.target).length === 0) {
            $modal.removeClass('show');
        }
        e.stopPropagation();
    });

    // Close modal by close button
    $modal.find('img').on('click', () => {
        $modal.removeClass('show');
    });

    // Buttons bind
    $calc.find('.button').on('click', (e) => {
        if ($(e.target).hasClass('next') && !$(e.target).hasClass('disabled')) {
            changeItem();
        } else if ($(e.target).hasClass('modal-btn')) {
            $modal.addClass('show').find('.text').text($(e.target).data('modal-text'));
        } else if ($(e.target).hasClass('reset')) {
            location.reload();
        }
        e.stopPropagation();
    });

    // Change poll items
    function changeItem() {
        let index = $items.index($('.active'));

        if (index + 1 < $items.length) {
            if (index === 0) {
                // Validate count of phrases
                let re = /^\S+\s+(?:\S+\s*){1,3}$/u;
                let $p = $calc.find('.poll > p');

                if (!re.test($('#phrases').val())) {
                    $p.addClass('flash');
                    setTimeout(() => {
                        $p.removeClass('flash');
                    }, 1500);
                    return false;
                }
                // Hide paragraph on others poll items
                $p.css('opacity', 0);
            }

            // Other item logic
            $next.addClass('disabled');

            $items.removeClass('active');
            $($items[index + 1]).addClass('active');

            let width = 100 / $items.length * (index + 1);
            $calc.find('.bar div div').css('width', `${width}%`);
        } else {
            $calc.find('.poll').hide();
            $items.removeClass('active');

            createNewForecast();
        }
    }

    $('#money').on('keyup', (e) => {
        let re = /^\d(?:\d| )*$/;
        re.test($(e.target).val())
            ? $next.removeClass('disabled')
            : $next.addClass('disabled');
    });

    $('#leads').on('keyup', (e) => {
        let re = /^(?:[1-9]|10)$/;
        re.test($(e.target).val())
            ? $next.removeClass('disabled')
            : $next.addClass('disabled');
    });

    $.getJSON("/api/getRegions.php", function (regions) {
        $('#region').autocomplete({
            source: regions,
            focus: function (event, ui) {
                $("#region").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#region").val(ui.item.label);
                $("#region-id").val(ui.item.value);
                $next.removeClass('disabled');

                return false;
            },
            position: {
                my: "left top+3",
            }
        });
    });

    function createNewForecast() {
        showLoading('Отправка запроса');

        $.getJSON("/api/createNewForecast.php", {
            phrases: $('#phrases').val(),
            region: $('#region-id').val()
        }, function (foreсastId) {
            if (parseInt(foreсastId) > 0) {
                getForecast(foreсastId);
            } else {
                console.log('Error: createNewForecast');
                showError('Ошибка создания отчёта');
            }
        });
    }

    function getForecast(foreсastId) {
        showLoading('Создание отчета');

        $.getJSON("/api/getForecast.php", {id: foreсastId}, function (foreсastData) {
            if (foreсastData === '0') {
                console.log('Error: getForecast');
                showError(`Ошибка загрузки отчёта ${foreсastId}`);
            } else {
                calcucating(foreсastData);
                $.getJSON("/api/deleteForecastReport.php", {id: foreсastId}, function (isDeleted) {
                    if (parseInt(isDeleted) === 0) {
                        console.log('Error: deleteForecastReport');
                    }
                });
            }
        });
    }

    function calcucating(data) {
        let vars = {};

        vars.CR1 = .05;
        vars.clicks = Math.round(data.shows * .17); // shows * 85% * 10% * 2
        vars.SRS = data.price * .045 < 10 ? 10 : data.price * .045;
        vars.CR2 = 10 * $('#leads').val();
        vars.money = $('#money').val();
        vars.SAS = Math.round(vars.SRS / vars.CR1 / vars.CR2);
        vars.CountOfRequestPerMonth = Math.round(vars.clicks * vars.CR1);
        vars.CountOfSalesPerMonth = Math.round(vars.CountOfRequestPerMonth * vars.CR2);
        vars.moneyPerLead = vars.money - vars.SAS;
        vars.moneyPerMonth = vars.moneyPerLead * vars.CountOfSalesPerMonth;

        // TODO remove it
        console.log(vars.clicks, vars.SRS);

        showResult(generateResultText(vars), vars);
    }

    function generateResultText(vars) {
        const lowCountOfClicks = vars.clicks <= 60;
        const highCost = vars.SAS >= vars.money;
        const lowProfitFromClient = vars.money >= 1 && vars.money <= 100;

        let resultText = '';

        if (lowCountOfClicks) {
            resultText = `В вашей теме слишком мало запросов по данной ключевой фразе.
            <br>Не  рекомендую использовать данный метод для запуска вашего проекта`;
        }

        if (highCost) {
            resultText = `В вашей теме по данной ключевой фразе, стоимость привлечения клиента превышает сумму,
            которую вы с него зарабатываете.
            <br>Данный канал привлечения будет убыточным для Вас`;
        }

        if (lowProfitFromClient) {
            resultText = `В вашей теме используя данную ключевую фразу, ваш заработок с одного клиента составит 
            <span>${vars.moneyPerLead} руб.</span>
            <br>Данный канал привлечения является высокорисковым и низкомаржинальным для Вас`;
            $result.find('.scroll').removeClass('hide');
        }

        if (lowCountOfClicks && highCost) {
            resultText = `В вашей теме слишком мало запросов по данной ключевой фразе и стоимость привлечения клиента
            превышает сумму, которую вы с него зарабатываете.
            <br>Данный канал привлечения будет убыточным для Вас`;
        }

        if (lowCountOfClicks && lowProfitFromClient) {
            resultText = `В вашей теме слишком мало запросов по данной ключевой фразе. Ваш заработок с одного клиента
            составит <span>${vars.moneyPerLead} руб.</span>
            <br>Данный канал привлечения является высокорисковым и низкомаржинальным для Вас`;
        }

        return resultText;
    }

    function showLoading(titleText, vars) {
        if (!$loading.hasClass('load')) {
            $loading.addClass('load');
        }

        $loading.find('p').text(titleText);
    }

    function showResult(resultText, vars) {
        if (resultText) {
            $result.find('.text').html(`<p class="centered">${resultText}</p>`);
            $result.find('.buttons').removeClass('hide');
        } else {
            $result.find('.phrases').text($calc.find('#phrases').val());
            $result.find('.money-per-month').text(vars.moneyPerMonth.toString()
                .replace(/(\d)(?=(\d{3})+(\D|$))/g, '$1 '));
            $result.find('.count-of-request-per-month').text(vars.CountOfRequestPerMonth);
            $result.find('.count-of-sales-per-month').text(vars.CountOfSalesPerMonth);
            $result.find('.sas').text(vars.SAS);
        }

        $calc.find('.loading').removeClass('load');
        $calc.find('.result').addClass('active');
    }

    function showError(errorText) {
        $modal.addClass('show').find('.text').text(errorText);

        if ($loading.hasClass('load')) {
            $loading.removeClass('load');
        }
    }
});