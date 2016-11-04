$.fn.dinamic = function (options) {
    var settings = $.extend({
        list: $(this),
        items: '.post-item',
        active: 'active'
    }, options);
    show();

    function show() {
        $('a', settings.list).click(function () {
            settings.current = $(this);
            filterContent();
            listActive();
            changeUrl();
            return false;
        });
    }
    function filterContent() {
        $(settings.items).removeClass(settings.active);
        console.log('.service-' + settings.current.attr('data-target'), $('.service-' + settings.current.attr('data-target')).length);
        $('.service-' + settings.current.attr('data-target')).addClass(settings.active);
    }
    function listActive() {
        $('li', settings.list).removeClass(settings.active);
        settings.current.parent().addClass(settings.active);
    }
    function changeUrl() {
        history.pushState({}, '', settings.current.attr('href'));
    }
};

