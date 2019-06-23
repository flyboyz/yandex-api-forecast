'use strict';

require('webpack-jquery-ui/autocomplete');

$(function () {
    let $calc = $('.calc');
    let $modal = $calc.find('.modal');
    let $modalDiv = $modal.find('div');

    // Open modal
    $calc.find('.modal-btn').on('click', function (e) {
        $modal.addClass('show').find('.text').text($(e.target).data('modal'));
        e.stopPropagation();
    });

    // Close modal by overlay
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

    $calc.find('.next').on('click', function (e) {
        progressBarChange()
        e.stopPropagation();
    });

    function progressBarChange() {
        let $items = $calc.find('.item');
        let index = $items.index($('.active'));

        if (index + 1 < $items.length) {
            if (index === 0) {
                $calc.find('.poll > p').hide();
            }

            $items.removeClass('active');
            $($items[index + 1]).addClass('active');
        }
    }

    var availableTags = [
        "Java",
        "JavaScript",
        "Java",
        "JavaScript",
        "Java",
        "JavaScript",
        "Java",
        "JavaScript",
    ];
    $('#region').autocomplete({
        source: availableTags,
        position: {
            my: "left top+3",
        }
    });
});