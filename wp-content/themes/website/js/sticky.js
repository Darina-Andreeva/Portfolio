$.fn.sticky = function (options) {
    var settings = $.extend({
        container: $(this),
        fixedClass: 'header-fixed',
        activeFixedClass: 'header-sticky',
        rules: {
            800: 50,
            2500: 100
        },
        scrolling: $(window).scrollTop()
    }, options);
    if (isFixed()) {
        updateStiky();
    }
    function updateStiky() {
        $(window).scroll(function () {
            updateWidth();
            getAfter();
            updateScroll();
            if (settings.scrolling >= settings.after) {
                $('body').addClass(settings.activeFixedClass);
            } else {
                $('body').removeClass(settings.activeFixedClass);
            }
        });
    }
    function getAfter() {
        $.each(settings.rules, function (width, after) {
            if (width > settings.width) {
                settings.after = after;
                return false;
            }
        });
        return settings.rules[settings.width];
    }
    function isFixed() {
        return $('body').hasClass(settings.fixedClass);
    }
    function updateScroll() {
        settings.scrolling = $(window).scrollTop();
    }
    function updateWidth() {
        settings.width = $("body").prop("clientWidth");
        ;
    }
};
