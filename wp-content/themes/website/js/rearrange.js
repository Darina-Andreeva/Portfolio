$.fn.rearrange = function (options) {
    var settings = $.extend({
        list: $(this),
        items: '.project-item',
        active: 'active',
        activeParent: 'active-container',
        inactive: 'inactive',
        timeout: 1500
    }, options);
    show();

    function show() {
        $('a', settings.list).click(function () {
            settings.current = $(this);
            filterContent();
            listActive();
            return false;
        });
    }
    function filterContent() {
        settings.filtered = $(settings.items + '.' + settings.active).not($('.service-' + settings.current.attr('data-target')));
        settings.filtered.parent().parent().parent().addClass(settings.activeParent);
        settings.filtered.parent().parent().addClass(settings.inactive);
        setTimeout(function () {
            settings.filtered.parent().parent().removeClass(settings.inactive);
            settings.filtered.parent().parent().parent().removeClass(settings.activeParent);
        }, settings.timeout);
        settings.filtered.parent().parent().removeClass(settings.active);
        $('.service-' + settings.current.attr('data-target')).parent().parent().addClass(settings.active);
    }
    function listActive() {
        $('li', settings.list).removeClass(settings.active);
        settings.current.parent().addClass(settings.active);
    }
};
