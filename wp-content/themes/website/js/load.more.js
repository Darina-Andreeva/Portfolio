$.fn.loadMore = function (options) {
    var settings = $.extend({
        container: $(this),
        content: '.load-content',
        type: 'button',
        button: '.load-button',
        loading: 'loading',
        delay: 3000,
        location: 0,
        locationUpdate: 500,
        active: true
    }, options);
    setUrl();
    if (settings.type == 'button')
        loadingButton();
    else
        loading();
    function loadingButton() {
        $(settings.button, settings.container).click(function () {
            if (settings.active) {
                settings.active = false;
                $(this).addClass(settings.loading);
                settings.button = $(this);
                settings.page = parseInt(settings.container.attr('data-page'));
                updatePage();
                setUrl2();
                $.post(settings.url, function (response) {
                    $(settings.content, settings.container).append(response);
                    $.post(settings.url2, function (response) {
                        setTimeout(function () {
                            if (response == 'none') {
                                settings.button.remove();
                            }
                            settings.button.removeClass(settings.loading);
                            settings.active = true;
                            setUrl();
                        }, settings.delay);

                    });
                });
            }
            return false;
        });
    }
    function updatePage() {
        settings.page = settings.page + 1;
        settings.container.attr('data-page', settings.page);
    }
    function setUrl() {
        settings.url = settings.container.attr('data-url') + '?service=' + settings.container.attr('data-filter') + '&pagein=' + settings.container.attr('data-page') + '&page=' + settings.container.attr('data-page-slug');
        ;
    }
    function setUrl2() {
        settings.url2 = settings.container.attr('data-url') + '?service=' + settings.container.attr('data-filter') + '&pagein=' + settings.page + '&page=' + settings.container.attr('data-page-slug');
        ;
    }
    function loading() {
        $(window).scroll(function () {
            settings.place = $(this).scrollTop();
            settings.screenHight = $(document).height();
            if (settings.location > 0)
                settings.screenPositionLimit = (settings.screenHight / 4);
            else
                settings.screenPositionLimit = (settings.screenHight / 4);
            if (settings.place >= settings.screenPositionLimit && settings.active) {
                settings.active = false;
                settings.container.addClass(settings.loading);
                settings.page = parseInt(settings.container.attr('data-page'));
                updatePage();
                setUrl2();
                $.post(settings.url, function (response) {
                    $(settings.content, settings.container).append(response);
                    $.post(settings.url2, function (response) {
                        setTimeout(function () {
                            if (response == 'none') {
                                console.log('daaa');

                                settings.active = false;
                            } else {
                                settings.active = true;
                            }
                            setUrl();
                            settings.container.removeClass(settings.loading);
                        }, settings.delay);

                    });
                });
                settings.location++;
            }
        });
    }
};
