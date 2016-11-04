$.fn.langSwitch = function (options) {
    var settings = $.extend({
        container: $(this),
        switcher: $('.switcher', $(this)),
        languages: $('ul li a', $(this)),
        active: 'active'
    }, options);
    show();
    function show() {
        settings.switcher.click(function () {
            settings.container.toggleClass(settings.active);
            return false;
        });
        $(document).click(function (event) {
            if (settings.container.hasClass(settings.active) && !$(event.target).closest(settings.container).length) {
                settings.container.removeClass(settings.active);
            }
        });
    }
};
