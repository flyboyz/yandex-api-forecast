'use strict';

require('webpack-jquery-ui/autocomplete');

$(function () {
    let $calc = $('.calc');
    let $calcTitle = $('.calc').find('.title');
    let $next = $calc.find('.next');
    let $modal = $calc.find('.modal');
    let $modalDiv = $modal.find('div');
    let $items = $calc.find('.item');

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
            $modal.addClass('show').find('.text').text($(e.target).data('modal'));
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
        $calcTitle.text('Создание отчета');

        $.getJSON("/api/createNewForecast.php", {
            phrases: $('#phrases').val(),
            region: $('#region-id').val()
        }, function (data) {
            if (data.hasOwnProperty('data')) {
                getForecast(data.data);
            }
        });
    }

    function getForecast(foreCastId) {
        $calcTitle.text('Загрузка прогноза');

        $.getJSON("/api/getForecast.php", {id: foreCastId}, function (data) {
            calcucating(data.Common);
        });
    }

    function calcucating(data) {
        const CR1 = .05;

        let clicks = data.Clicks * 2;
        let SRS = data.Max * .18 / 4;
        SRS = SRS < 10 ? 10 : SRS;
        let CR2 = 10 * $('#leads').val();
        let money = $('#money').val();
        let SAS = parseInt(SRS / CR1 / CR2);
        let CountOfRequestPerMonth = clicks * CR1;
        let CountOfSalesPerMonth = CountOfRequestPerMonth * CR2;
        let moneyPerLead = money - SAS;
        let moneyPerMonth = moneyPerLead * CountOfSalesPerMonth;

        if (clicks <= 60 ) {
            $calc.find('.result .few-clicks').addClass('active');
        } else if (SAS >= money) {
            $calc.find('.result .unfavorable').addClass('active');
        } else if (money >= 1 && money <= 100) {
            $calc.find('.result .normal').addClass('active');
        } else {
            $('span.money-per-month').text(moneyPerMonth.toString().replace(/(\d)(?=(\d{3})+(\D|$))/g, '$1 '));
            $('span.count-of-request-per-month').text(CountOfRequestPerMonth);
            $('span.count-of-sales-per-month').text(CountOfSalesPerMonth);
            $('span.sas').text(SAS);

            $calc.find('.result .good').addClass('active');
        }
    }
});