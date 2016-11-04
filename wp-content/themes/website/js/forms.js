$.fn.forms = function (options) {
    var settings = $.extend({
        form: $(this),
        submitUrl: $(this).attr('action'),
        submitBtn: $('#field_submit', $(this)),
        responseTrue: 0,
        responseFalse: 1,
        errorMessage: $('.error-message', $(this)),
        errorFieldClass: 'field-error',
        formField: $('input', $(this)),
        formFieldArea: $('textarea', $(this)),
        addFieldErrorClass: true,
        showFieldErrorMessage: true,
        labels: true,
        fieldSubmited: 'field-onfocus',
        attrSentData: 'data-sent',
        attrSendingData: 'data-sending',
        attrNormalData: 'data-normal',
        modelName: 'field',
        timeout: 3000,
        fieldFilled: 'field-submitted',
        loading: 'loading',
        loadingSuccess: 'submit-success',
        active: 'active',
        sendingForm: false
    }, options);
    submit();
    labels();
    urlData();
    function submit() {
        settings.form.submit(function () {
            if (settings.sendingForm == false) {
                settings.sendingForm = true;
                formDisabled();
                formClear();
                $.post(settings.submitUrl, settings.form.serialize(), function (response) {
                    if (response.state == settings.responseTrue) {
                        if (response.data.type !== 'normal') {
                            if (response.data.type == 'link' || response.data.type == 'page') {
                                document.location.href = response.data.content;
                            } else if (response.data.type == 'popup') {
                                var popup = $('.popup-container').popup();
                                popup.open(response.data.type.content);
                            }
                        }
                        clearForm();
                        formSent();
                    } else {
                        if (settings.addFieldErrorClass)
                            formAddFieldError(response.data);
                        if (settings.showFieldErrorMessage)
                            formAddMessageError(response.data);
                    }
                    formEnabled();
                }, 'json');
            }
            return false;
        });
    }
    function loadingHide() {
        settings.submitBtn.parent().removeClass(settings.loading);
    }
    function formSent() {
        loadingHide();
        settings.submitBtn.parent().addClass(settings.loadingSuccess);
        settings.submitBtn.attr('value', settings.submitBtn.attr(settings.attrSentData));
    }
    function formSending() {
        settings.submitBtn.attr(settings.attrNormalData, settings.submitBtn.attr('value'));
        settings.submitBtn.attr('value', settings.submitBtn.attr(settings.attrSendingData));
    }
    function formDisabled() {
        formSending();
        settings.submitBtn.parent().addClass(settings.loading);
        settings.submitBtn.attr('disabled', 'disabled');
    }
    function formEnabled() {
        setTimeout(function () {
            loadingHide();
            settings.submitBtn.parent().removeClass(settings.loadingSuccess);
            settings.submitBtn.removeAttr('disabled');
            settings.submitBtn.attr('value', settings.submitBtn.attr(settings.attrNormalData));
            settings.sendingForm = false;
        }, settings.timeout);
    }
    function formClear() {
        settings.errorMessage.html('');
        $('.' + settings.modelName, settings.form).removeClass(settings.errorFieldClass);
        settings.formField.parent().removeClass(settings.fieldSubmited);
        settings.formField.removeClass(settings.errorFieldClass);
        settings.formFieldArea.removeClass(settings.fieldSubmited);
        settings.formFieldArea.removeClass(settings.errorFieldClass);
        settings.errorMessage.removeClass(settings.errorMessageClass);
    }
    function formAddFieldError(errors) {
        $.each(errors, function (field, error) {
            $('.field-' + field, settings.form).addClass(settings.errorFieldClass);
        });
    }
    function formAddMessageError(errors) {
        $.each(errors, function (field, error) {
            $('.error-' + field, settings.form).html(String(error));
            $('.error-' + field, settings.form).addClass(settings.errorMessageClass);
        });
    }
    function clearForm() {
        $('input:not([type=submit]):not([type=radio])', settings.form).val('');
        $('textarea', settings.form).val('');
        $('input', settings.form).parent().parent().removeClass(settings.fieldSubmited);
        $('textarea', settings.form).parent().parent().removeClass(settings.fieldSubmited);
    }
    function labels() {
        if (settings.labels === true) {
            $('input', settings.form).focus(function () {
                $(this).parent().parent().addClass(settings.fieldSubmited);
            }).change(function () {
                if ($.trim($(this).val()) == '') {
                    $(this).parent().parent().removeClass(settings.fieldSubmited);
                    $(this).parent().parent().removeClass(settings.fieldFilled);
                } else {
                    $(this).parent().parent().addClass(settings.fieldFilled);
                }
            }).blur(function () {
                if ($.trim($(this).val()) == '') {
                    $(this).parent().parent().removeClass(settings.fieldSubmited);
                } else {
                    $(this).parent().parent().addClass(settings.fieldFilled);
                }
            });
            $('textarea', settings.form).focus(function () {
                $(this).parent().parent().addClass(settings.fieldSubmited);
            }).change(function () {
                if ($.trim($(this).val()) == '') {
                    $(this).parent().parent().removeClass(settings.fieldSubmited);
                    $(this).parent().parent().removeClass(settings.fieldFilled);
                } else {
                    $(this).parent().parent().addClass(settings.fieldFilled);
                }
            }).blur(function () {
                if ($.trim($(this).val()) == '') {
                    $(this).parent().parent().removeClass(settings.fieldSubmited);
                } else {
                    $(this).parent().parent().addClass(settings.fieldFilled);
                }
            });
        }
    }
    function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    }
    function urlData(param) {
        if (param == undefined)
            param = 'subject';
        if (typeof getUrlParameter(param) != 'undefined') {
            $('#field_' + param).parent().parent().addClass(settings.fieldSubmited);
            $('html, body').animate({
                scrollTop: settings.form.offset().top
            }, 2000);
        }
    }
//    function gaSuccess() {
//        return nbGa(document.location.href + '/' + settings.form.attr('id') + '/success/', true);
//    }
};


function success_contact(response) {

}