"use strict";

$(document).ready(function() {
    // $("#source_type").attr("disabled", true);
    // $("#article_source").attr("disabled", true);
    $("#several_articles").attr("disabled", true);

    // $('#language').change(function(){
    //     if($('#language').val())
    //         $("#source_type").attr("disabled", false);
    //     else $("#source_type").attr("disabled", true);
    // });

    $('#source_type').change(function(){
        let source_type = $('#source_type').val();
        let article_source = $("#article_source");

        // if(source_type)
        //     article_source.attr("disabled", false);
        // else article_source.attr("disabled", true);

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