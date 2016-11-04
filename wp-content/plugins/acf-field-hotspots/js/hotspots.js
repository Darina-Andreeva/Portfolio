var css_style_dot = 'width:30px;height:30px;background:#ff9f00;position:absolute;border-radius: 20px;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 25px;z-index: 9999;';
var css_style_textarea = ' padding: 26px; padding-left: 5px; padding-right: 5px;';
var css_style_textarea_container = 'position:absolute;width:200px;height:200px;z-index: 99999;';
var css_style_remove = 'position: absolute;top: 0px;right: 0px;width: 73px;height: 22px;font-size: 16px;font-weight: bolder;display: block;background: red; color: #fff; text-align: center; padding-top: 5px; text-decoration: none;';
var picture;
(function ($) {
    setTimeout(function () {
        $('.hotspots-add').click(function () {
            var state = parseInt($(this).attr('data-state'));
            if (state == 0) {
                $(this).html('Disable Adding');
                $(this).attr('data-state', 1);
            } else {
                $(this).html('Add New Hotspots');
                $(this).attr('data-state', 0);
            }
            return false;
        });
        var picture = $('#acf-' + $('.hotspots-item').attr('data-picture') + ' img');
        if (picture.length > 0) {
            $('.hotspots-size span').text(picture.width() + ' x ' + picture.height());
            generateHotSpotsOnStart(picture);
            hotspotOpen();
            picture.click(function (e) {
                if ($('.hotspots-add').attr('data-state') == 1) {
                    var offset = $(this).offset();
                    var x = (e.pageX - picture.offset().left) - 12;
                    var y = (e.pageY - picture.offset().top) - 12;
                    var newid = 'hotspot-' + x + 'x' + y;
                    generateHotSpot(picture, x, y);
                    $('.hotspots-current').text(x + ' x ' + y);
                    hotspotOpen(newid);
                    hotspotsUpdate(x, y);
                }
                return false;
            });
        }
    }, 3000);
})(jQuery);
function generateHotSpotsOnStart(picture) {
    var field = $('.hotspots-field');
    var fieldData = field.val();
    var positions = {};
    if (typeof fieldData != 'undefined' && fieldData.trim() != '') {
        fieldData = fieldData.split("};");
        $.each(fieldData, function (key, value) {
            value = value.replace('{', '');
            if (!isEmpty(value)) {
                var positionInfo = value.split(";");
                generateHotSpot(picture, positionInfo[0], positionInfo[1], positionInfo[2]);
            }
        });
    }
}
function generateHotSpot(picture, x, y, description) {
    var newid = 'hotspot-' + x + 'x' + y;
    picture.before('<a class="hotspot-dot ' + newid + '" style="' + css_style_dot + 'top:' + y + 'px;left:' + x + 'px;" data-x="' + x + '" data-y="' + y + '"></span>');
    hotspotOpen(newid, description);
}
function hotspotOpen(special, description) {
    if (description == null)
        description = '';
    $('.' + special).click(function () {
        var x = parseInt($('.' + special).attr('data-x'));
        var y = parseInt($('.' + special).attr('data-y'));
        var newid = 'hostspots-d-' + x + 'x' + y;
        if ($('.' + newid).length == 0) {
            $(this).before('<span class="' + newid + '" style="' + css_style_textarea_container + 'top:' + (y + 32) + 'px;left:' + (x - 80) + 'px;" data-x="' + $(this).attr('data-x') + '" data-y="' + $(this).attr('data-y') + '"><a href="javascript:;" class="hotspot-remove" style="' + css_style_remove + '">Remove</a><textarea class="hostspots-description" style="' + css_style_textarea + '">' + description + '</textarea></span>');
        }
        hotspotSave(newid);
        hotspotRemove();
    });
}
function hotspotRemove() {
    $('.hotspot-remove').click(function () {
        var container = $(this).parent();
        var x = container.attr('data-x');
        var y = container.attr('data-y');
        hotspotRemoveField(x, y);
        container.remove();
        $('.hotspot-' + x + 'x' + y).remove();
    });
}
function hotspotRemoveField(x, y) {
    var field = $('.hotspots-field');
    var fieldData = field.val();
    var positions = {};
    if (typeof fieldData != 'undefined') {
        fieldData = fieldData.split("};");
        $.each(fieldData, function (key, value) {
            value = value.replace('{', '');
            if (!isEmpty(value)) {
                var positionInfo = value.split(";");
                positions[positionInfo[0] + 'x' + positionInfo[1]] = {
                    x: positionInfo[0],
                    y: positionInfo[1],
                    description: positionInfo[2]
                };
            }
        });
    }
    delete positions[x + 'x' + y];
    hotspostsFieldConvert(positions);
}
function hotspotSave(newid) {
    var container = $('.' + newid);
    container.show();
    $('textarea', container).focus();
    $(document).mousedown(function (e) {
        var container = $('.' + newid);
        if ($(e.target).parent().hasClass(newid) === false) {
            var x = container.attr('data-x');
            var y = container.attr('data-y');
            if (x != null && y != null) {
                hotspotsUpdate(x, y, $('textarea', container).val());
                container.hide();
            }

        }
    });
}
function hotspotsUpdate(x, y, description) {
    var field = $('.hotspots-field');
    var fieldData = field.val();
    var positions = {};
    if (typeof fieldData != 'undefined') {
        fieldData = fieldData.split("};");
        $.each(fieldData, function (key, value) {
            value = value.replace('{', '');
            if (!isEmpty(value)) {
                var positionInfo = value.split(";");
                positions[positionInfo[0] + 'x' + positionInfo[1]] = {
                    x: positionInfo[0],
                    y: positionInfo[1],
                    description: positionInfo[2]
                };
            }
        });
    }
    positions[x + 'x' + y] = {
        x: x,
        y: y,
        description: description
    };
    hotspostsFieldConvert(positions);
}
function hotspostsFieldConvert(positions) {
    var field = $('.hotspots-field');
    var fieldData = '';
    $.each(positions, function (key, value) {
        fieldData = fieldData + '{' + value.x + ';' + value.y + ';' + value.description + '};';
    });
    field.val(fieldData);
}
function isEmpty(str) {
    return typeof str == 'string' && !str.trim() || typeof str == 'undefined' || str === null;
}