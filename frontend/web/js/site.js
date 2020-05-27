"use strict";

//region Queue

    // add source sites into queue for parsing titles
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
    // add destination sites into queue for parsing titles
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
    //add articles into translate queue
    $('#modalSelectLanguagesButton').on('click', function () {
        let article_id;
        let article_ids;

        try {
            article_ids = $('#grid_articles').yiiGridView('getSelectedRows');
        } catch (e) {
            article_id = document.querySelector(".id").getAttribute("id");
        }

        let language_ids = $('#language_ids').select2('data');
        language_ids = JSON.stringify(language_ids);

        $.ajax({
            url: '/article/article/translate-queue',
            type: 'POST',
            data: {
                article_id: article_id,
                article_ids: article_ids,
                language_ids: language_ids
            },
            success: function () {
                location.reload();
            },
            error: function (res) {
                console.log(res);
            }
        });
    });
    // add source sites into queue for parsing titles
    $('.parse').on('click', function () {
        let keys = $('#grid').yiiGridView('getSelectedRows');
        $.ajax({
            url: '/api/api/parse',
            type: 'POST',
            data: {
                keys: keys
            },
            success: function () {
                window.alert('Ссылки добавлены в очередь на парсинг.');
            },
            error: function () {
                window.alert('Error!');
            }
        });
    });

//endregion

//region Source

    // selected categories for articles
    $('.category_source').on('click', function () {
        let value = [];
        let article_id = $(this).data("id");
        let modal = $("#modalSourceCategory");
        let select2 = $('#category_source_ids');
        select2.val(value);
        select2.trigger('change');
        modal.attr("data-source-id", article_id);

        $.ajax({
            url: '/api/api/selected-source-categories',
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
    // select categories for articles
    $(document).on("click", "#modalSourceCategoryButton", function () {
        let article_id = document.getElementById('modalSourceCategory').getAttribute("data-source-id");
        let category_ids = $('#category_source_ids').select2('data');
        category_ids = JSON.stringify(category_ids);

        $.ajax({
            url: '/api/api/source-category',
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

//endregion

//region Destination

    // selected categories for destinations
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
    // select categories for destinations
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

    //get title
    $('.modal-title').on('click', function () {
        let site_id = $(this).data("id");
        $("#modalTitle").attr("data-site-id", site_id);

        $.ajax({
            url: '/destination/destination/get-title',
            type: 'POST',
            data: {
                site_id: site_id,
            },
            success: function (res) {
                document.getElementById("title").value = res;
            },
            error: function (res) {
                console.log(res);
            }
        });
    });
    //set title
    $('#modalTitleButton').on('click', function () {
        let data = document.getElementById('title').value;
        let site_id = document.getElementById('modalTitle').getAttribute("data-site-id");

        $.ajax({
            url: '/destination/destination/set-title',
            type: 'POST',
            data: {
                data: data,
                site_id: site_id
            },
            success: function () {
                location.reload();
            },
            error: function (res) {
                console.log(res);
            }
        });
    });

    //get keywords
    $('.modal-keywords').on('click', function () {
        let site_id = $(this).data("id");
        $("#modalKeywords").attr("data-site-id", site_id);

        $.ajax({
            url: '/destination/destination/get-keywords',
            type: 'POST',
            data: {
                site_id: site_id,
            },
            success: function (res) {
                document.getElementById("keywords").value = res;
            },
            error: function (res) {
                console.log(res);
            }
        });
    });
    //set keywords
    $('#modalKeywordsButton').on('click', function () {
        let data = document.getElementById('keywords').value;
        let site_id = document.getElementById('modalKeywords').getAttribute("data-site-id");

        $.ajax({
            url: '/destination/destination/set-keywords',
            type: 'POST',
            data: {
                data: data,
                site_id: site_id
            },
            success: function () {
                location.reload();
            },
            error: function (res) {
                console.log(res);
            }
        });
    });

    //get description
    $('.modal-description').on('click', function () {
        let site_id = $(this).data("id");
        $("#modalDescription").attr("data-site-id", site_id);

        $.ajax({
            url: '/destination/destination/get-description',
            type: 'POST',
            data: {
                site_id: site_id,
            },
            success: function (res) {
                document.getElementById("description").value = res;
            },
            error: function (res) {
                console.log(res);
            }
        });
    });
    //set description
    $('#modalDescriptionButton').on('click', function () {
        let data = document.getElementById('description').value;
        let site_id = document.getElementById('modalDescription').getAttribute("data-site-id");

        $.ajax({
            url: '/destination/destination/set-description',
            type: 'POST',
            data: {
                data: data,
                site_id: site_id
            },
            success: function () {
                location.reload();
            },
            error: function (res) {
                console.log(res);
            }
        });
    });

    //get theme
    $('.modal-theme').on('click', function () {
        let site_id = $(this).data("id");
        $("#modalTheme").attr("data-site-id", site_id);

        $.ajax({
            url: '/destination/destination/get-theme',
            type: 'POST',
            data: {
                site_id: site_id,
            },
            success: function (res) {
                document.getElementById("theme").value = res;
            },
            error: function (res) {
                console.log(res);
            }
        });
    });
    //set theme
    $('#modalThemeButton').on('click', function () {
        let data = document.getElementById('theme').value;
        let site_id = document.getElementById('modalTheme').getAttribute("data-site-id");

        $.ajax({
            url: '/destination/destination/set-theme',
            type: 'POST',
            data: {
                data: data,
                site_id: site_id
            },
            success: function () {
                location.reload();
            },
            error: function (res) {
                console.log(res);
            }
        });
    });

//endregion

//region Article

    // selected categories for articles
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
    // select categories for articles
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

    // selected destinations for articles
    $('.destination').on('click', function () {
        let value = [];
        let article_id = $(this).data("id");
        let modal = $("#modalDestination");
        let select2 = $('#destination_ids');
        select2.val(value);
        select2.trigger('change');
        modal.attr("data-article-id", article_id);

        $.ajax({
            url: '/api/api/selecteddestination',
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
    // select destinations for articles
    $(document).on("click", "#modalDestinationButton", function () {
        let article_id = document.getElementById('modalDestination').getAttribute("data-article-id");
        let destination_ids = $('#destination_ids').select2('data');
        destination_ids = JSON.stringify(destination_ids);

        $.ajax({
            url: '/api/api/destination',
            type: 'POST',
            data: {
                destination_ids: destination_ids,
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

    // reads articles from file
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

    // auto select destinations when create or update article
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
                }
            },
            error: function (res) {
                console.log(res);
            }
        });
    });

    // sends articles to destination site
    $('#modalSelectDestinationsButton').on('click', function () {
        let articles_ids = $('#grid_articles').yiiGridView('getSelectedRows');
        let destinations_ids = $('#destinations_idss').select2('data');
        destinations_ids = JSON.stringify(destinations_ids);

        $.ajax({
            url: '/article/article/show-destinations',
            type: 'POST',
            data: {
                articles_ids: articles_ids,
                destinations_ids: destinations_ids
            },
            success: function () {
                location.reload();
            },
            error: function (res) {
                console.log(res);
            }
        });
    });

//endregion