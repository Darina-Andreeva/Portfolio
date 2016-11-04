$.fn.tabs = function (options) {
    var settings = $.extend({
        list: $(this),
        items: '.service-single',
        active: 'active'
    }, options);
    show();

    function show() {
        $('a', settings.list).click(function () {
            settings.current = $(this);
            contentShow();
            listAtive();
            changeUrl();
            return false;
        });
    }
    function contentShow() {
        $(settings.items).removeClass(settings.active);
        $('.' + settings.current.attr('data-target')).addClass(settings.active);
    }
    function listAtive() {
        $('li', settings.list).removeClass(settings.active);
        settings.current.parent().addClass(settings.active);
    }
    function changeUrl() {
        history.pushState({}, '', settings.current.attr('href'));
    }
};
