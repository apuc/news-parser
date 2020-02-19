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