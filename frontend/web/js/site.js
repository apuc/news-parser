"use strict";

//region Source
    // add source sites into queue for parsing titles
    $('.title_source').on('click', function () {
        $.ajax({
            url: '/source/source/title-source',
            type: 'POST',
            data: { keys: $('#grid').yiiGridView('getSelectedRows') },
            success: function () { window.alert('Сайты добавлены в очередь на получение заголовка.'); },
            error: function () { window.alert('Error!'); }
        });
    });

    // selected categories for articles
    $('.category_source').on('click', function () {
        let value = [];
        let article_id = $(this).data("id");
        let select2 = $('#category_source_ids');
        select2.val(value);
        select2.trigger('change');
        $("#modalSourceCategory").attr("data-source-id", article_id);

        $.ajax({
            url: '/source/source/selected-source-categories',
            type: 'POST',
            data: { id: article_id, },
            success: function (res) {
                let value = JSON.parse(res);
                select2.val(value);
                select2.trigger('change');
            },
            error: function () { }
        });
    });
    // select categories for articles
    $(document).on("click", "#modalSourceCategoryButton", function () {
        $.ajax({
            url: '/source/source/source-category',
            type: 'POST',
            data: { category_ids: JSON.stringify($('#category_source_ids').select2('data')),
                source_id: document.getElementById('modalSourceCategory').getAttribute("data-source-id") },
            success: function () { location.reload(); },
            error: function () { location.reload(); }
        });
    });
//endregion

//region Destination

    // add destination sites into queue for parsing titles
    $('.title_destination').on('click', function () {
        $.ajax({
            url: '/destination/destination/title-destination',
            type: 'POST',
            data: { keys: $('#grid').yiiGridView('getSelectedRows') },
            success: function () { window.alert('Сайты добавлены в очередь на получение заголовка.'); },
            error: function () { window.alert('Error!'); }
        });
    });

    // selected categories for destinations
    $('.dcategory').on('click', function () {
        let value = [];
        let destination_id = $(this).data("id");
        let select2 = $('#dcategory_ids');
        select2.val(value);
        select2.trigger('change');
        $("#modalDCategory").attr("data-destination-id", destination_id);

        $.ajax({
            url: '/destination/destination/selected-destination-categories',
            type: 'POST',
            data: { id: destination_id },
            success: function (res) {
                let value = JSON.parse(res);
                select2.val(value);
                select2.trigger('change');
            },
            error: function () { }
        });
    });
    // select categories for destinations
    $(document).on("click", "#modalDCategoryButton", function () {
        $.ajax({
            url: '/destination/destination/destination-category',
            type: 'POST',
            data: { category_ids: JSON.stringify($('#dcategory_ids').select2('data')),
                destination_id: document.getElementById('modalDCategory').getAttribute("data-destination-id") },
            success: function () { location.reload(); },
            error: function () { location.reload(); }
        });
    });

    //get title
    $('.modal-title').on('click', function () {
        let site_id = $(this).data("id");
        $("#modalTitle").attr("data-site-id", site_id);

        $.ajax({
            url: '/destination/destination/get-title',
            type: 'POST',
            data: { site_id: site_id },
            success: function (res) { document.getElementById("title").value = res; },
            error: function (res) { console.log(res); }
        });
    });
    //set title
    $('#modalTitleButton').on('click', function () {
        $.ajax({
            url: '/destination/destination/set-title',
            type: 'POST',
            data: { data: document.getElementById('title').value,
                site_id: document.getElementById('modalTitle').getAttribute("data-site-id") },
            success: function () { location.reload(); },
            error: function (res) { console.log(res); }
        });
    });

    //get keywords
    $('.modal-keywords').on('click', function () {
        let site_id = $(this).data("id");
        $("#modalKeywords").attr("data-site-id", site_id);

        $.ajax({
            url: '/destination/destination/get-keywords',
            type: 'POST',
            data: { site_id: site_id },
            success: function (res) { document.getElementById("keywords").value = res; },
            error: function (res) { console.log(res); }
        });
    });
    //set keywords
    $('#modalKeywordsButton').on('click', function () {
        $.ajax({
            url: '/destination/destination/set-keywords',
            type: 'POST',
            data: { data: document.getElementById('keywords').value,
                site_id: document.getElementById('modalKeywords').getAttribute("data-site-id") },
            success: function () { location.reload(); },
            error: function (res) { console.log(res); }
        });
    });

    //get description
    $('.modal-description').on('click', function () {
        let site_id = $(this).data("id");
        $("#modalDescription").attr("data-site-id", site_id);

        $.ajax({
            url: '/destination/destination/get-description',
            type: 'POST',
            data: { site_id: site_id },
            success: function (res) { document.getElementById("description").value = res; },
            error: function (res) { console.log(res); }
        });
    });
    //set description
    $('#modalDescriptionButton').on('click', function () {
        $.ajax({
            url: '/destination/destination/set-description',
            type: 'POST',
            data: { data: document.getElementById('description').value,
                site_id: document.getElementById('modalDescription').getAttribute("data-site-id") },
            success: function () { location.reload(); },
            error: function (res) { console.log(res); }
        });
    });

    //get theme
    $('.modal-theme').on('click', function () {
        let site_id = $(this).data("id");
        $("#modalTheme").attr("data-site-id", site_id);

        $.ajax({
            url: '/destination/destination/get-theme',
            type: 'POST',
            data: { site_id: site_id },
            success: function (res) { document.getElementById("theme").value = res; },
            error: function (res) { console.log(res); }
        });
    });
    //set theme
    $('#modalThemeButton').on('click', function () {
        $.ajax({
            url: '/destination/destination/set-theme',
            type: 'POST',
            data: { data: document.getElementById('theme').value,
                site_id: document.getElementById('modalTheme').getAttribute("data-site-id") },
            success: function () { location.reload(); },
            error: function (res) { console.log(res); }
        });
    });

//endregion

//region Article

    // selected categories for articles
    $('.category').on('click', function () {
        let value = [];
        let article_id = $(this).data("id");
        let select2 = $('#category_ids');
        select2.val(value);
        select2.trigger('change');
        $("#modalCategory").attr("data-article-id", article_id);

        $.ajax({
            url: '/article/article/selected',
            type: 'POST',
            data: { id: article_id },
            success: function (res) {
                let value = JSON.parse(res);
                select2.val(value);
                select2.trigger('change');
            },
            error: function () { }
        });
    });
    // select categories for articles
    $(document).on("click", "#modalCategoryButton", function () {
        $.ajax({
            url: '/article/article/category',
            type: 'POST',
            data: { category_ids: JSON.stringify($('#category_ids').select2('data')),
                article_id: document.getElementById('modalCategory').getAttribute("data-article-id") },
            success: function () { location.reload(); },
            error: function () { location.reload(); }
        });
    });

    // selected destinations for articles
    $('.destination').on('click', function () {
        let value = [];
        let article_id = $(this).data("id");
        let select2 = $('#destination_ids');
        select2.val(value);
        select2.trigger('change');
        $("#modalDestination").attr("data-article-id", article_id);

        $.ajax({
            url: '/article/article/selected-destination',
            type: 'POST',
            data: { id: article_id },
            success: function (res) {
                let value = JSON.parse(res);
                select2.val(value);
                select2.trigger('change');
            },
            error: function () { }
        });
    });
    // select destinations for articles
    $(document).on("click", "#modalDestinationButton", function () {
        $.ajax({
            url: '/article/article/destination',
            type: 'POST',
            data: { destination_ids: JSON.stringify($('#destination_ids').select2('data')),
                article_id: document.getElementById('modalDestination').getAttribute("data-article-id") },
            success: function () { location.reload(); },
            error: function () { location.reload(); }
        });
    });

    // reads articles from file
    $('.read').on('click', function () {
        $.ajax({
            url: '/article/article/read-file',
            type: 'POST',
            data: { filename: document.querySelector(".read").getAttribute("id") },
            success: function () { window.alert('Статьи успешно считаны!'); },
            error: function () { window.alert('Error!'); }
        });
    });

    // auto select destinations when create or update article
    $(document).on("change", "#categories", function () {
        $.ajax({
            url: '/article/article/destinations',
            type: 'POST',
            data: { category_ids: JSON.stringify($('#categories').select2('data')) },
            success: function (res) {
                if(res) {
                    let value = JSON.parse(res);
                    let select2 = $('#destinations_ids');
                    select2.val(null).trigger('change');
                    select2.val(value).trigger('change');
                }
            },
            error: function (res) { console.log(res); }
        });
    });

    // sends articles to destination site
    $('#modalSelectDestinationsButton').on('click', function () {
        $.ajax({
            url: '/article/article/show-destinations',
            type: 'POST',
            data: { articles_ids: $('#grid_articles').yiiGridView('getSelectedRows'),
                destinations_ids: JSON.stringify($('#destinations_idss').select2('data')) },
            success: function () { location.reload(); },
            error: function (res) { console.log(res); }
        });
    });

    //add articles into translate queue
    $('#modalSelectLanguagesButton').on('click', function () {
        let article_id;
        let article_ids;

        try { article_ids = $('#grid_articles').yiiGridView('getSelectedRows'); }
        catch (e) { article_id = document.querySelector(".id").getAttribute("id"); }

        $.ajax({
            url: '/article/article/translate-queue',
            type: 'POST',
            data: {
                article_id: article_id,
                article_ids: article_ids,
                language_ids: JSON.stringify($('#language_ids').select2('data'))
            },
            success: function () { location.reload(); },
            error: function (res) { console.log(res); }
        });
    });

    // add source sites into queue for parsing articles
    $('.parse').on('click', function () {
        $.ajax({
            url: '/article/article/parse',
            type: 'POST',
            data: { keys: $('#grid').yiiGridView('getSelectedRows') },
            success: function () { window.alert('Ссылки добавлены в очередь на парсинг.'); },
            error: function () { window.alert('Error!'); }
        });
    });

//endregion
