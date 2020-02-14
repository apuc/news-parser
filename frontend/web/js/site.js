"use strict";

$(document).ready(function() {
    $('#source_type').change(function(){
        let source_type = $('#source_type').val();
        let article_source = $("#article_source");

        article_source.empty();

        $.ajax({
            url: '/api/api/type',
            type: 'POST',
            data: {
                value: source_type,
            },
            success: function (res) {
                let value = JSON.parse(res);

                if(source_type === 'Получено с сайта' || source_type === 'Автоматический перевод') {
                    let option = $("<option />");
                    option.html('...');
                    option.val();
                    article_source.append(option);
                }

                for(let key in value) {
                    let option = $("<option />");
                    option.html(value[key]);
                    option.val(key);
                    article_source.append(option);
                }
            },
            error: function (res) {
                console.log(res);
            }
        });
    });
});

$('.title_source').on('click', function () {
    let keys = $('#grid').yiiGridView('getSelectedRows');
    $.ajax({
        url: '/api/api/titlesource',
        type: 'POST',
        data: {
            keys: keys
        },
        success: function () {
            window.alert('Сайты добавлены в очередь на получение заголовка.');
        },
        error: function () {
            window.alert('Error!');
        }
    });
});

$('.title_destination').on('click', function () {
    let keys = $('#grid').yiiGridView('getSelectedRows');
    $.ajax({
        url: '/api/api/titledestination',
        type: 'POST',
        data: {
            keys: keys
        },
        success: function () {
            window.alert('Сайты добавлены в очередь на получение заголовка.');
        },
        error: function () {
            window.alert('Error!');
        }
    });
});