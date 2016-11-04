$.fn.searchform = function (options) {
    var settings = $.extend({
        button: $(this),
        container: $(this).attr('data-container'),
        colapse: $(this).attr('data-colapse'),
        close: $(this).attr('data-close'),
        field: $('.search-field', $($(this).attr('data-container'))),
        active: 'active',
        content: '.input-content',
        tooltip: '.input-tooltip',
        is_active: false
    }, options);
    show();
    close();
    change();
    check();
    function check() {
        if (settings.is_active) {
            settings.button.click();
        }
    }
    function show() {
        settings.button.click(function () {
            $(settings.colapse, $(settings.container)).toggleClass(settings.active);
            $(settings.container).toggleClass(settings.active);
            return false;
        });
    }
    function close() {
        $(settings.close).click(function () {
            $(this).parent().toggleClass(settings.active);
            $(this).parent().parent().toggleClass(settings.active);
        });
    }
    function change() {
        settings.field.keypress(function () {
            $(settings.content, $(settings.container)).html($(this).val());
        });
    }
};
