'use strict';

require('webpack-jquery-ui/autocomplete');

$(function () {
    let $calc = $('.calc');
    let $modal = $calc.find('.modal');
    let $modalDiv = $modal.find('div');
    let $items = $calc.find('.item');

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

    // Buttons
    $calc.find('.button').on('click', function (e) {
        if ($(e.target).hasClass('next')) {
            changeItem();
        } else if ($(e.target).hasClass('modal-btn')) {
            $modal.addClass('show').find('.text').text($(e.target).data('modal'));
        } else if ($(e.target).hasClass('reset')) {
            location.reload();
        }
        e.stopPropagation();
    });

    function changeItem() {
        let index = $items.index($('.active'));

        if (index + 1 < $items.length) {
            if (index === 0) {
                $calc.find('.poll > p').css('opacity', 0);
            }

            $items.removeClass('active');
            $($items[index + 1]).addClass('active');

            let width = (100 / $items.length) * (index + 1);
            $calc.find('.bar div div').css('width', `${width}%`);
        } else {
            $calc.find('.poll').hide();
            $items.removeClass('active');
            $calc.find('.result .good').addClass('active');
        }
    }

    var regions = [];
    $.getJSON( "/api/getRegions.php", function( data ) {
        regions = data;
        console.log (regions);

        $('#region').autocomplete({
            source: regions,
            focus: function( event, ui ) {
                $( "#region" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#region" ).val( ui.item.label );
                $( "#region-id" ).val( ui.item.value );

                return false;
            },
            position: {
                my: "left top+3",
            }
        });
    });
});