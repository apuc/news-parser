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

$('.read').on('click', function () {
    let name = document.querySelector(".read").getAttribute("id");

    $.ajax({
        url: '/api/api/read',
        type: 'POST',
        data: {
            filename: name
        },
        success: function () {
            window.alert('Статьи успешно считаны!');
        },
        error: function () {
            window.alert('Error!');
        }
    });
});

$('.category').on('click', function () {
    let value = [];
    let article_id = $(this).data("id");
    let modal = $("#modalCategory");
    let select2 = $('#category_ids');
    select2.val(value);
    select2.trigger('change');
    modal.attr("data-article-id", article_id);

    $.ajax({
        url: '/api/api/selected',
        type: 'POST',
        data: {
            id: article_id,
        },
        success: function (res) {
            let value = JSON.parse(res);
            console.log(value);

            select2.val(value);
            select2.trigger('change');
        },
        error: function () { }
    });
});

$(document).on("click", "#modalCategoryButton", function () {
    let article_id = document.getElementById('modalCategory').getAttribute("data-article-id");
    let category_ids = $('#category_ids').select2('data');
    category_ids = JSON.stringify(category_ids);

    $.ajax({
        url: '/api/api/category',
        type: 'POST',
        data: {
            category_ids: category_ids,
            article_id: article_id
        },
        success: function () {
            location.reload();
        },
        error: function () {
            location.reload();
        }
    });
});

$('.dcategory').on('click', function () {
    let value = [];
    let destination_id = $(this).data("id");
    let modal = $("#modalDCategory");
    let select2 = $('#dcategory_ids');
    select2.val(value);
    select2.trigger('change');
    modal.attr("data-destination-id", destination_id);

    $.ajax({
        url: '/api/api/dselected',
        type: 'POST',
        data: {
            id: destination_id,
        },
        success: function (res) {
            let value = JSON.parse(res);
            console.log(value);

            select2.val(value);
            select2.trigger('change');
        },
        error: function () { }
    });
});

$(document).on("click", "#modalDCategoryButton", function () {
    let destination_id = document.getElementById('modalDCategory').getAttribute("data-destination-id");
    let category_ids = $('#dcategory_ids').select2('data');
    category_ids = JSON.stringify(category_ids);

    $.ajax({
        url: '/api/api/dcategory',
        type: 'POST',
        data: {
            category_ids: category_ids,
            destination_id: destination_id
        },
        success: function () {
            location.reload();
        },
        error: function () {
            location.reload();
        }
    });
});

$(document).on("change", "#categories", function () {
    let category_ids = $('#categories').select2('data');
    category_ids = JSON.stringify(category_ids);

    $.ajax({
        url: '/api/api/destinations',
        type: 'POST',
        data: {
            category_ids: category_ids,
        },
        success: function (res) {
            if(res) {
                let value = JSON.parse(res);
                let select2 = $('#destinations_ids');
                select2.val(null).trigger('change');
                select2.val(value).trigger('change');
                console.log(value);
            }
        },
        error: function () {
        }
    });
});

$(document).on("click", "#SettingsAjaxButton", function () {
    let arr = [];

    let theme = {};
    theme.key = 'theme';
    theme.value = $('#settingsform-theme').val();
    arr[0] = theme;

    let title = {};
    title.key = 'title';
    title.value = document.getElementById('settingsform-title').getAttribute("value");
    arr[1] = title;

    let keywords = {};
    keywords.key = 'keywords';
    keywords.value = document.getElementById('settingsform-keywords').getAttribute("value");
    arr[2] = keywords;

    let description = {};
    description.key = 'description';
    description.value = document.getElementById('settingsform-description').getAttribute("value");
    arr[3] = description;

    let h1 = {};
    h1.key = 'h1';
    h1.value = document.getElementById('settingsform-h1').getAttribute("value");
    arr[4] = h1;

    let data = {arr};
    data = JSON.stringify(data);

    $.ajax({
        url: 'http://localhost:8000/set-options',
        type: 'POST',
        data: data,

        success: function () {
            location.reload();
        },
        error: function () {
            location.reload();
        }
    });
});