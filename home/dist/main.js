"use strict";

/**
 *  每次載入頁面都要呼叫該程式
 */
function everyLoadPage()
{
    // clean all pre code "\n" and space
    $(".js-return code").each(function(){
        var text = $(this).text();
        $(this).text(
            collocateSourceCode(text)
        );
    });

    // render
    // 先保留 source code, 免得上色後被污染, 就無法使用了
    $(".js-return").each(function(){
        var sourceCode = $(this).children("code").text();
        $(this).append('<p></p>');
        $(this).append('<input style="float:right" type="button" class="js_button" value="return" />');
        $(this).children('.js_button').on('click', function(){
            //var run = new Function(sourceCode);
            //run();
            babel.run(sourceCode)
        });
    });

    // 程式碼上色
    $('.js-return code').each(function(i, block) {
        hljs.highlightBlock(block);
    });

}

function collocateSourceCode(text)
{
    var items = text.trim().split("\n");
    var result = [];
    for ( var i in items ) {
        var item = items[i];
        if ("    "===item.substr(0,4)) {
            item = item.substr(4);
        }
        result.push(item);
    }
    return result.join("\n");
}

function toLight(tag, template)
{
    if (!tag) {
        return;
    }

    if (tag.substr(0,1)=="#") {
        tag = tag.substr(1);
    }

    $(".js-light").each(function(){
        if ( $(this).attr('data-id') == tag ) {
            $(this).addClass("active");
        }
        else {
            $(this).removeClass("active");
        }
    });

}
